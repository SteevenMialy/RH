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
        if ($this->session->get('employe_id')) {
            return redirect()->to(route_to('employe_dashboard'));
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

        // Authentification
        $employe = $this->employeModel->authentifier($email, $password);

        if ($employe) {
            // Vérifier que c'est bien un employé
            if ($employe['role'] !== 'employe') {
                return redirect()->back()
                    ->with('error', 'Accès réservé aux employés.')
                    ->withInput();
            }

            // Stocker les données en session
            $this->session->set([
                'employe_id' => $employe['id'],
                'employe_email' => $employe['email'],
                'employe_nom' => $employe['nom'],
                'employe_prenom' => $employe['prenom'],
                'employe_departement_id' => $employe['departement_id'],
                'is_logged_in' => true,
            ]);

            // Message de succès
            $this->session->setFlashdata('success', 'Connexion réussie !');

            // Redirection au dashboard
            return redirect()->to(route_to('employe_dashboard'));

        } else {
            // Erreur d'authentification
            return redirect()->back()
                ->with('error', 'Identifiants incorrects. Veuillez réessayer.')
                ->withInput();
        }
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
}
