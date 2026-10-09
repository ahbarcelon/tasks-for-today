<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['username', 'full_name', 'email', 'password', 'created_at'];
    protected $useTimestamps = false;

    /** The single demo user (null when the table is empty). */
    public function getDemoUser(): ?array
    {
        return $this->orderBy('id', 'ASC')->first();
    }

    public function findByUsername(string $username): ?array
    {
        return $this->where('username', $username)->first();
    }
}
