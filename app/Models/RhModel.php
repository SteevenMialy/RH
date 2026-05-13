<?php

namespace App\Models;

use CodeIgniter\Model;

class RhModel extends Model
{
    protected $table = 'rh';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role'
    ];
    

    public function getRhById(int $id): array
    {
        return $this->where('id', $id)->first();
    }

    public function verificationLogin(string $email, string $password): ?array
    {
        $rh = $this->where('email', $email)->first();
        if ($rh && password_verify($password, $rh['password'])) {
            return $rh;
        }
        return null;
    }

}