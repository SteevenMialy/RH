<?php

namespace App\Controllers;

class AdminDashboard extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }

    /**
     * Vérifier que l'utilisateur est connecté et a le rôle admin
     */
    protected function checkAuth()
    {
        if (!$this->session->get('is_logged_in') || $this->session->get('user_role') !== 'admin') {
            return redirect()->to(route_to('auth_login'));
        }
    }

    /**
     * Dashboard administrateur
     */
    public function dashboard()
    {
        $this->checkAuth();

        $data = [
            'user_nom' => 'Administrateur',
            'user_role' => 'Admin système',
            'page' => 'dashboard',
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Gestion des employés
     */
    public function employes()
    {
        $this->checkAuth();

        $data = [
            'user_nom' => 'Administrateur',
            'user_role' => 'Admin système',
            'page' => 'employes',
        ];

        return view('admin/employes', $data);
    }

    /**
     * Gestion des départements
     */
    public function departements()
    {
        $this->checkAuth();

        $data = [
            'user_nom' => 'Administrateur',
            'user_role' => 'Admin système',
            'page' => 'departements',
        ];

        return view('admin/departements', $data);
    }

    /**
     * Gestion des types de congé
     */
    public function typesConge()
    {
        $this->checkAuth();

        $data = [
            'user_nom' => 'Administrateur',
            'user_role' => 'Admin système',
            'page' => 'types_conge',
        ];

        return view('admin/types_conge', $data);
    }

    /**
     * Afficher toutes les demandes
     */
    public function demandesAll()
    {
        $this->checkAuth();

        $data = [
            'user_nom' => 'Administrateur',
            'user_role' => 'Admin système',
            'page' => 'demandes',
        ];

        return view('admin/demandes', $data);
    }
}
