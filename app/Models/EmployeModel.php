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

    /**
     * Récupérer les soldes d'un employé
     */
    public function getSoldes($employe_id)
    {
        $db = \Config\Database::connect();
        return $db->table('Soldes_emp')
            ->select('Soldes_emp.*, TypeConger.nom as type_nom')
            ->join('TypeConger', 'TypeConger.id = Soldes_emp.type_conger_id')
            ->where('Soldes_emp.employe_id', $employe_id)
            ->get()
            ->getResultArray();
    }

    /**
     * Récupérer les congés d'un employé
     */
    public function getCongés($employe_id)
    {
        $db = \Config\Database::connect();
        return $db->table('conger')
            ->select('conger.*, TypeConger.nom as type_nom, Status.nom as status_nom')
            ->join('TypeConger', 'TypeConger.id = conger.type_conger_id')
            ->join('Status', 'Status.id = conger.id_status')
            ->where('conger.employe_id', $employe_id)
            ->orderBy('conger.date_debut', 'DESC')
            ->get()
            ->getResultArray();
    }
}
