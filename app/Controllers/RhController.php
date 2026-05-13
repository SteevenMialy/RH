<?php

namespace App\Controllers;
use App\Models\RhModel;
use App\Models\CongerModel;

class RhController extends BaseController
{

    protected $rhModel;
    protected $congerModel;
    public function __construct()
    {
        $this->rhModel = new RhModel();
        $this->congerModel = new CongerModel();
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');
        $verification = $this->rhModel->verificationLogin($email, $password);
        if ($verification) {
            session()->set('rh_id', $verification['id']);
            session()->set('role', $verification['role']);
            return view('DemandeConge', ['success' => 'Connexion réussie']);
        } else {
            return view('loginRh', ['error' => 'Email ou mot de passe incorrect']);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function confirmationconger()
    {
        $congerId = $this->request->getPost('conger_id');
        $rhId = session()->get('rh_id');
        $valeur = $this->request->getPost('valeur');
        $commentaire = $this->request->getPost('commentaire');
        $data = [
            'conger_id' => $congerId,
            'rh_id' => $rhId,
            'valeur' => $valeur,
            'commentaire' => $commentaire
        ];
        if ($valeur === 'Approuve') {
            $conger = $this->congerModel->find($congerId);
            if ($conger) {
                $jours_prises = $this->congerModel->jourprise($congerId)[0]['jours_prises'] ?? 0;
                $this->congerModel->update($congerId, ['jour_prises' => $jours_prises]);
            }
            $this->rhModel->insert($data);
        }
    }
}