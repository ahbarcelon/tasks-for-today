<?php

namespace App\Controllers;

use App\Models\TaskModel;

class Pages extends BaseController
{
    /**
     * >>> REPLACE THIS VALUE with your full name before submitting. <<<
     * It is displayed on the About page.
     */
    private const DEVELOPER_NAME = '[BARCELON, AARON H.]';

    public function welcome(): string
    {
        $model = new TaskModel();
        $tasks = $model->getTodayTasks();

        return view('pages/welcome', [
            'title'  => 'Today',
            'tasks'  => $tasks,
            'counts' => $model->countByStatus($tasks),
            'today'  => date('l, F j, Y'),
        ]);
    }

    public function about(): string
    {
        return view('pages/about', [
            'title'     => 'About',
            'developer' => self::DEVELOPER_NAME,
            'course'    => 'IT0049 Web System Technologies',
        ]);
    }
}
