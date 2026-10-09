<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAuthenticationAndArchiving extends Migration
{
    private const DEMO_PASSWORD = 'DemoPassword123!';

    public function up(): void
    {
        $this->forge->addColumn('users', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'default'    => '',
                'null'       => false,
                'after'      => 'email',
            ],
        ]);

        $this->forge->addColumn('tasks', [
            'is_archived' => [
                'type'    => 'BOOLEAN',
                'default' => false,
                'null'    => false,
            ],
        ]);

        $users = $this->db->table('users');
        $demo  = $users->where('username', 'demo.student')->get()->getRowArray();
        $data  = ['password' => password_hash(self::DEMO_PASSWORD, PASSWORD_DEFAULT)];

        if ($demo === null) {
            $users->insert($data + [
                'username'   => 'demo.student',
                'full_name'  => 'Demo Student',
                'email'      => 'demo.student@example.com',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $users->where('id', $demo['id'])->update($data);
        }
    }

    public function down(): void
    {
        $this->forge->dropColumn('tasks', 'is_archived');
        $this->forge->dropColumn('users', 'password');
    }
}
