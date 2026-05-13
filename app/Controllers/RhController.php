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
        // Valider l'existence de la demande
        $conger = $this->congerModel->find($congerId);
        if (!$conger) {
            return $this->response->setStatusCode(404)->setBody('Demande introuvable');
        }

        $db = \Config\Database::connect();
        $congerBuilder = $db->table('conger');
        $conger = $congerBuilder->select('conger.*, employes.departement_id')->join('employes', 'employes.id = conger.employe_id', 'left')->where('conger.id', $congerId)->get()->getRowArray();

        // Calculer les jours pris à partir des dates de la demande
        $jours_prises = 0;
        if ($conger) {
            $debut = strtotime($conger['date_debut']);
            $fin = strtotime($conger['date_fin']);
            if ($debut !== false && $fin !== false && $fin >= $debut) {
                $jours_prises = (int) floor(($fin - $debut) / 86400) + 1;
            }
        }

        // Approuver ou refuser
        $approved = in_array(strtolower((string) $valeur), ['approuve', 'approuvé', 'approve', '1', 'oui'], true);

        if ($approved) {
            // Mettre à jour le statut de la demande en approuvée (2)
            $this->congerModel->update($congerId, ['id_status' => 2]);

            // Déduire du solde de l'employé pour le type concerné
            if ($conger) {
                $solde = $db->table('Soldes_emp')
                    ->where('employe_id', $conger['employe_id'])
                    ->where('type_conger_id', $conger['type_conger_id'])
                    ->get()
                    ->getRowArray();

                if ($solde) {
                    $nouveauSolde = max(0, (int) $solde['solde'] - $jours_prises);
                    $nouveauPrises = (int) $solde['jour_prises'] + $jours_prises;
                    $db->table('Soldes_emp')->where('id', $solde['id'])->update([
                        'solde' => $nouveauSolde,
                        'jour_prises' => $nouveauPrises,
                    ]);
                }
            }
        } else {
            // Refuser -> statut 3
            $this->congerModel->update($congerId, ['id_status' => 3]);
        }

        // Tenter d'insérer un enregistrement de validation si la table existe (Validation_rh)
        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('Validation_rh')) {
                $db->table('Validation_rh')->insert([
                    'conger_id' => $congerId,
                    'rh_id' => $rhId,
                    'valeur' => $valeur,
                    'commentaire' => $commentaire,
                    'date_validation' => date('Y-m-d H:i:s')
                ]);
            }
        } catch (\Exception $e) {
            // Ne pas bloquer l'utilisateur si la table n'existe pas ou autre erreur
        }

        return redirect()->back()->with('success', 'Action enregistrée');
    }
}