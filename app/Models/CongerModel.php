<?php

namespace App\Models;

use CodeIgniter\Model;

class CongerModel extends Model
{
    protected $table = 'conger';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'employe_id',
        'type_conger',
        'date_debut',
        'date_fin',
        'id_status'
    ];
    

    public function getCongerById(int $id): array
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

    public function jourprise(int $congerId): array
    {
    $db = \Config\Database::connect();
    $builder= $db->table('CalculeJourprise');
    $builder->where('conger_id', $congerId);
    return $builder->get()->getResultArray();
    }
  
   
}