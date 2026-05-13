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
    }

    /**
     * Dashboard principal de la RH
     */
    public function dashboard()
    {
        $this->checkAuth();

        $data = [
            'user_nom' => $this->session->get('user_prenom') . ' ' . $this->session->get('user_nom'),
            'user_role' => 'Responsable RH',
            'page' => 'dashboard',
        ];

        return view('rh/dashboard', $data);
    }

    /**
     * Afficher les demandes en attente
     */
    public function demandes()
    {
        $this->checkAuth();

        $data = [
            'user_nom' => $this->session->get('user_prenom') . ' ' . $this->session->get('user_nom'),
            'user_role' => 'Responsable RH',
            'page' => 'demandes',
        ];

        return view('rh/demandes', $data);
    }

    /**
     * Afficher les soldes des employés
     */
    public function soldes()
    {
        $this->checkAuth();

        $data = [
            'user_nom' => $this->session->get('user_prenom') . ' ' . $this->session->get('user_nom'),
            'user_role' => 'Responsable RH',
            'page' => 'soldes',
        ];

        return view('rh/soldes', $data);
    }
}
