<?php

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Tasks extends BaseController
{
    public function index(): string
    {
        $model = new TaskModel();
        $tasks = $model->getAllTasksOrderedByDate();

        return view('tasks/index', [
            'title'  => 'All Tasks',
            'tasks'  => $tasks,
            'counts' => $model->countByStatus($tasks),
        ]);
    }

    public function new(): string
    {
        return view('tasks/new', [
            'title'       => 'New Task',
            'task'        => ['title' => '', 'status' => 'pending', 'task_date' => date('Y-m-d')],
            'action'      => site_url('tasks'),
            'submitLabel' => 'Create task',
        ]);
    }

    public function create(): RedirectResponse
    {
        if (! $this->validateTask()) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new TaskModel())->insert([
            'title'       => trim((string) $this->request->getPost('title')),
            'status'      => (string) $this->request->getPost('status'),
            'task_date'   => (string) $this->request->getPost('task_date'),
            'created_at'  => date('Y-m-d H:i:s'),
            'is_archived' => false,
        ]);

        return redirect()->to(site_url('tasks'))->with('success', 'Task created.');
    }

    public function edit(int $id): string
    {
        return view('tasks/edit', [
            'title'       => 'Edit Task',
            'task'        => $this->getActiveTask($id),
            'action'      => site_url('tasks/' . $id),
            'submitLabel' => 'Save changes',
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $this->getActiveTask($id);

        if (! $this->validateTask()) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new TaskModel())->update($id, [
            'title'     => trim((string) $this->request->getPost('title')),
            'status'    => (string) $this->request->getPost('status'),
            'task_date' => (string) $this->request->getPost('task_date'),
        ]);

        return redirect()->to(site_url('tasks'))->with('success', 'Task updated.');
    }

    public function delete(int $id): RedirectResponse
    {
        $this->getActiveTask($id);
        (new TaskModel())->update($id, ['is_archived' => true]);

        return redirect()->to(site_url('tasks'))->with('success', 'Task archived.');
    }

    private function validateTask(): bool
    {
        return $this->validateData($this->request->getPost(), [
            'title'     => 'required|max_length[150]',
            'task_date' => 'required|valid_date[Y-m-d]',
            'status'    => 'required|in_list[pending,in progress,completed]',
        ], [
            'title' => ['required' => 'The title field is required.'],
            'task_date' => ['required' => 'The task date field is required.'],
        ]);
    }

    private function getActiveTask(int $id): array
    {
        $task = (new TaskModel())->findActive($id);

        if ($task === null) {
            throw PageNotFoundException::forPageNotFound('Task not found.');
        }

        return $task;
    }
}
