<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'nama'];
    protected $useTimestamps = false;

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getUserById($id)
    {
        return $this->find($id);
    }
} 