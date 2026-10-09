<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table            = 'tasks';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['title', 'status', 'task_date', 'created_at', 'is_archived'];
    protected $useTimestamps    = false; // created_at is written explicitly (see seeder)

    /** Tasks scheduled for today's date only. */
    public function getTodayTasks(): array
    {
        return $this->where('is_archived', false)
                    ->where('task_date', date('Y-m-d'))
                    ->orderBy('created_at', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

    /** Every task, ordered by date with id as a stable tie-breaker. */
    public function getAllTasksOrderedByDate(): array
    {
        return $this->where('is_archived', false)
                    ->orderBy('task_date', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

    /** A single active task, or null when it is missing or archived. */
    public function findActive(int $id): ?array
    {
        return $this->where('is_archived', false)->find($id);
    }

    /** Count tasks per status for the summary cards. */
    public function countByStatus(array $tasks): array
    {
        $counts = ['pending' => 0, 'in progress' => 0, 'completed' => 0];
        foreach ($tasks as $task) {
            if (isset($counts[$task['status']])) {
                $counts[$task['status']]++;
            }
        }
        return $counts;
    }
}
