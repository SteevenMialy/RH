<?php

namespace App\Controllers;

class RhDashboard extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }

    /**
     * Vérifier que l'utilisateur est connecté et a le rôle RH
     */
    protected function checkAuth()
    {
        if (!$this->session->get('is_logged_in') || $this->session->get('user_role') !== 'rh') {
            return redirect()->to(route_to('auth_login'));
        }

        return null;
    }

    /**
     * Récupérer les statistiques RH depuis la base.
     */
    protected function getStats(): array
    {
        $db = \Config\Database::connect();

        return [
            'employees_active' => (int) $db->table('employes')->where('actif', 1)->countAllResults(),
            'pending_requests' => (int) $db->table('conger')->where('id_status', 1)->countAllResults(),
            'approved_requests' => (int) $db->table('conger')->where('id_status', 2)->countAllResults(),
        ];
    }

    /**
     * Dashboard principal de la RH
     */
    public function dashboard()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $stats = $this->getStats();

        $data = [
            'user_nom' => trim($this->session->get('user_prenom') . ' ' . $this->session->get('user_nom')),
            'user_role' => 'Responsable RH',
            'page' => 'dashboard',
            'pending_count' => $stats['pending_requests'],
            'employees_active' => $stats['employees_active'],
            'approved_count' => $stats['approved_requests'],
        ];

        return view('rh/dashboard', $data);
    }

    /**
     * Afficher les demandes en attente
     */
    public function demandes()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $stats = $this->getStats();

        // Récupérer les demandes en attente (id_status = 1)
        $conges = $db->table('conger')
            ->select('conger.id, conger.employe_id, conger.type_conger_id, conger.date_debut, conger.date_fin, conger.id_status, employes.nom as nom_emp, employes.prenom as prenom_emp, TypeConger.nom as type_nom')
            ->join('employes', 'employes.id = conger.employe_id', 'left')
            ->join('TypeConger', 'TypeConger.id = conger.type_conger_id', 'left')
            ->where('conger.id_status', 1)
            ->orderBy('conger.date_debut', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'user_nom' => trim($this->session->get('user_prenom') . ' ' . $this->session->get('user_nom')),
            'user_role' => 'Responsable RH',
            'page' => 'demandes',
            'conges' => $conges,
            'pending_count' => $stats['pending_requests'],
        ];

        return view('rh/demandes', $data);
    }

    /**
     * Afficher les soldes des employés
     */
    public function soldes()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $stats = $this->getStats();

        $soldes = $db->table('Soldes_emp')
            ->select('Soldes_emp.*, employes.nom as nom_emp, employes.prenom as prenom_emp, employes.actif, TypeConger.nom as type_nom')
            ->join('employes', 'employes.id = Soldes_emp.employe_id', 'left')
            ->join('TypeConger', 'TypeConger.id = Soldes_emp.type_conger_id', 'left')
            ->orderBy('employes.nom', 'ASC')
            ->orderBy('TypeConger.nom', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'user_nom' => trim($this->session->get('user_prenom') . ' ' . $this->session->get('user_nom')),
            'user_role' => 'Responsable RH',
            'page' => 'soldes',
            'pending_count' => $stats['pending_requests'],
            'soldes' => $soldes,
        ];

        return view('rh/soldes', $data);
    }
}
