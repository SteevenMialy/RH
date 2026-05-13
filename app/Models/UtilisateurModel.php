<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeModel extends Model
{
    protected $table = 'employes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'departement_id',
        'date_embauche',
        'actif'
    ];

    protected $useTimestamps = false;

    /**
     * Authentifier un employé
     */
    public function authentifier($email, $password)
    {
        $employe = $this->where('email', $email)
            ->where('actif', 1)
            ->first();

        if ($employe && password_verify($password, $employe['password'])) {
            return $employe;
        }

        return false;
    }

    /**
     * Récupérer un employé par email
     */
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Vérifier si un email existe
     */
    public function emailExists($email)
    {
        return $this->where('email', $email)->first() !== null;
    }

    /**
     * Récupérer le département de l'employé
     */
    public function getDepartement($employe_id)
    {
        return $this->select('employes.*, departements.nom as dept_nom')
            ->join('departements', 'departements.id = employes.departement_id')
            ->where('employes.id', $employe_id)
            ->first();
    }
}
