<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateurs';
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
     * Authentifier un utilisateur (tous rôles)
     */
    public function authentifier($email, $password)
    {
        $user = $this->where('email', $email)
            ->where('actif', 1)
            ->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function emailExists($email)
    {
        return $this->where('email', $email)->first() !== null;
    }

    public function getDepartement($user_id)
    {
        return $this->select('utilisateurs.*, departements.nom as dept_nom')
            ->join('departements', 'departements.id = utilisateurs.departement_id')
            ->where('utilisateurs.id', $user_id)
            ->first();
    }
}
