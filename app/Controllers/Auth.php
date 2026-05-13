<?php

namespace App\Controllers;

use App\Models\EmployeModel;

class Auth extends BaseController
{
    protected $session;
    protected $employeModel;

    public function __construct()
    {
        $this->session = session();
        $this->employeModel = new EmployeModel();
    }

    /**
     * Afficher la page de login
     */
    public function login()
    {
        // Si l'utilisateur est déjà connecté, rediriger vers le dashboard
        if ($this->session->get('is_logged_in')) {
            $role = $this->session->get('user_role');
            return $this->redirectByRole($role);
        }

        return view('auth/login');
    }

    /**
     * Traiter la connexion
     */
    public function doLogin()
    {
        // Récupérer les données du formulaire
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ]);

        if (!$validation->run(['email' => $email, 'password' => $password])) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        // Authentification employé
        $employe = $this->employeModel->authentifier($email, $password);

        if ($employe && $employe['role'] === 'employe') {
            $this->session->set([
                'user_id' => $employe['id'],
                'user_email' => $employe['email'],
                'user_nom' => $employe['nom'],
                'user_prenom' => $employe['prenom'],
                'user_role' => 'employe',
                'is_logged_in' => true,
                'employe_id' => $employe['id'],
                'employe_email' => $employe['email'],
                'employe_nom' => $employe['nom'],
                'employe_prenom' => $employe['prenom'],
                'employe_departement_id' => $employe['departement_id'],
            ]);

            $this->session->setFlashdata('success', 'Connexion réussie !');
            return $this->redirectByRole('employe');
        }

        // Authentification RH / Admin
        $db = \Config\Database::connect();

        $rh = $db->table('rh')
            ->where('email', $email)
            ->get()
            ->getRowArray();

        if ($rh && password_verify($password, $rh['password'])) {
            $this->session->set([
                'user_id' => $rh['id'],
                'user_email' => $rh['email'],
                'user_nom' => $rh['username'],
                'user_prenom' => '',
                'user_role' => 'rh',
                'is_logged_in' => true,
            ]);

            $this->session->setFlashdata('success', 'Connexion réussie !');
            return $this->redirectByRole('rh');
        }

        $admin = $db->table('admin')
            ->where('email', $email)
            ->get()
            ->getRowArray();

        if ($admin && password_verify($password, $admin['password'])) {
            $this->session->set([
                'user_id' => $admin['id'],
                'user_email' => $admin['email'],
                'user_nom' => $admin['username'],
                'user_prenom' => '',
                'user_role' => 'admin',
                'is_logged_in' => true,
            ]);

            $this->session->setFlashdata('success', 'Connexion réussie !');
            return $this->redirectByRole('admin');
        }

        return redirect()->back()
            ->with('error', 'Identifiants incorrects. Veuillez réessayer.')
            ->withInput();
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        $this->session->destroy();
        $this->session->setFlashdata('success', 'Vous avez été déconnecté.');
        return redirect()->to(route_to('auth_login'));
    }

    /**
     * Rediriger vers le dashboard selon le role
     */
    private function redirectByRole(?string $role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->to(route_to('admin_dashboard'));
            case 'rh':
                return redirect()->to(route_to('rh_dashboard'));
            case 'employe':
            default:
                return redirect()->to(route_to('employe_dashboard'));
        }
    }
}
