<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TasksTodaySeeder extends Seeder
{
    public function run(): void
    {
        // Dates are generated relative to the day the seeder runs,
        // so the Welcome page always has tasks for "today".
        $day = static fn (int $offset): string => date('Y-m-d', strtotime("{$offset} days"));
        $now = date('Y-m-d H:i:s');

        $tasks = [
            ['title' => 'Review the IT0049 course syllabus and project requirements', 'status' => 'completed',   'task_date' => $day(-2)],
            ['title' => 'Install XAMPP and confirm the MySQL module starts',           'status' => 'completed',   'task_date' => $day(-2)],
            ['title' => 'Design the tasks and users database tables',                  'status' => 'completed',   'task_date' => $day(-1)],
            ['title' => 'Write the TaskModel and UserModel classes',                   'status' => 'in progress', 'task_date' => $day(-1)],
            ['title' => 'Build the Welcome page with today\'s task list',              'status' => 'in progress', 'task_date' => $day(0)],
            ['title' => 'Test every route in the browser on desktop and mobile widths', 'status' => 'pending',    'task_date' => $day(0)],
            ['title' => 'Read the CodeIgniter 4 documentation on models and views',    'status' => 'completed',   'task_date' => $day(0)],
            ['title' => 'Prepare the weekly progress report for the instructor',       'status' => 'pending',     'task_date' => $day(1)],
            ['title' => 'Push the finished project to GitHub',                         'status' => 'pending',     'task_date' => $day(2)],
            ['title' => 'Deploy the system to a hosting provider and verify the database connection', 'status' => 'pending', 'task_date' => $day(3)],
        ];
        foreach ($tasks as &$task) {
            $task['created_at']  = $now;
            $task['is_archived'] = false;
        }
        unset($task);

        $this->db->disableForeignKeyChecks();
        $this->db->table('tasks')->truncate();
        $this->db->table('users')->truncate();
        $this->db->enableForeignKeyChecks();

        $this->db->table('tasks')->insertBatch($tasks);
        $this->db->table('users')->insert([
            'username'   => 'demo.student',
            'full_name'  => 'Demo Student',
            'email'      => 'demo.student@example.com',
            'password'   => password_hash('DemoPassword123!', PASSWORD_DEFAULT),
            'created_at' => $now,
        ]);
    }
}
