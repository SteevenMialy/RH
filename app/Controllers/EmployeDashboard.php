<?php

namespace App\Controllers;

use App\Models\EmployeModel;

class EmployeDashboard extends BaseController
{
    protected $session;
    protected $employeModel;

    public function __construct()
    {
        $this->session = session();
        $this->employeModel = new EmployeModel();
    }

    /**
     * Vérifier que l'employé est connecté
     */
    protected function checkAuth()
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to(route_to('auth_login'));
        }
    }

    /**
     * Dashboard principal de l'employé
     */
    public function dashboard()
    {
        $this->checkAuth();

        $db = \Config\Database::connect();
        $employe_id = $this->session->get('employe_id');

        // Récupérer les demandes de congé de l'employé
        $conges = $db->table('conger')
            ->select('conger.*, tc.nom as type_nom, s.nom as status_nom')
            ->join('TypeConger as tc', 'conger.type_conger_id = tc.id', 'left')
            ->join('Status as s', 'conger.id_status = s.id', 'left')
            ->where('conger.employe_id', $employe_id)
            ->orderBy('conger.date_debut', 'DESC')
            ->get()
            ->getResultArray();

        // Récupérer les soldes de congés
        $soldes = $db->table('Soldes_emp')
            ->select('Soldes_emp.*, tc.nom as type_nom')
            ->join('TypeConger as tc', 'Soldes_emp.type_conger_id = tc.id', 'left')
            ->where('Soldes_emp.employe_id', $employe_id)
            ->get()
            ->getResultArray();

        // Calculer les soldes restants
        foreach ($soldes as &$solde) {
            $jours_prises = 0;
            foreach ($conges as $conge) {
                if ($conge['type_conger_id'] == $solde['type_conger_id'] && in_array($conge['id_status'], [2])) { // 2 = approuvée
                    $start = strtotime($conge['date_debut']);
                    $end = strtotime($conge['date_fin']);
                    $jours_prises += (($end - $start) / 86400) + 1;
                }
            }
            $solde['jour_prises'] = $jours_prises;
            $solde['solde'] = $solde['jours_attribues'] - $jours_prises;
        }

        $data = [
            'employe_nom' => $this->session->get('employe_prenom') . ' ' . $this->session->get('employe_nom'),
            'employe_role' => 'Employé',
            'soldes' => $soldes,
            'conges' => $conges,
        ];

        return view('employe/dashboard', $data);
    }

    /**
     * Afficher le formulaire de demande de congé
     */
    public function formCongé()
    {
        $this->checkAuth();

        $db = \Config\Database::connect();
        
        // Récupérer les types de congés
        $types_conger = $db->table('TypeConger')->get()->getResultArray();

        $data = [
            'employe_nom' => $this->session->get('employe_prenom') . ' ' . $this->session->get('employe_nom'),
            'employe_role' => 'Employé',
            'types_conger' => $types_conger,
        ];

        return view('employe/form_conge', $data);
    }

    /**
     * Stocker une nouvelle demande de congé
     */
    public function storeConge()
    {
        $this->checkAuth();

        $rules = [
            'id_type' => 'required|integer',
            'date_debut' => 'required|valid_date[Y-m-d]',
            'date_fin' => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $employe_id = $this->session->get('employe_id');
        $id_type = $this->request->getPost('id_type');
        $date_debut = $this->request->getPost('date_debut');
        $date_fin = $this->request->getPost('date_fin');

        // Vérifier que les dates sont valides
        if (strtotime($date_debut) > strtotime($date_fin)) {
            return redirect()->back()->with('error', 'La date de fin doit être après la date de début');
        }

        // Vérifier qu'il n'y a pas de chevauchement
        $existing = $db->table('conger')
            ->where('employe_id', $employe_id)
            ->whereIn('id_status', [1, 2]) // En attente ou approuvée
            ->where('date_debut <=', $date_fin)
            ->where('date_fin >=', $date_debut)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Une demande chevauchante existe déjà');
        }

        // Insérer la demande
        $db->table('conger')->insert([
            'employe_id' => $employe_id,
            'type_conger_id' => $id_type,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'id_status' => 1, // En attente
        ]);

        return redirect()->to('/employe')->with('success', 'Demande de congé créée avec succès');
    }

    /**
     * Afficher mes demandes de congé
     */
    public function mesCongés()
    {
        $this->checkAuth();

        $db = \Config\Database::connect();
        $employe_id = $this->session->get('employe_id');

        $conges = $db->table('conger')
            ->select('conger.*, tc.nom as type_nom, s.nom as status_nom')
            ->join('TypeConger as tc', 'conger.type_conger_id = tc.id', 'left')
            ->join('Status as s', 'conger.id_status = s.id', 'left')
            ->where('conger.employe_id', $employe_id)
            ->orderBy('conger.date_debut', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'employe_nom' => $this->session->get('employe_prenom') . ' ' . $this->session->get('employe_nom'),
            'employe_role' => 'Employé',
            'conges' => $conges,
        ];

        return view('employe/mes_conges', $data);
    }

    /**
     * Annuler une demande de congé
     */
    public function cancelConge($id)
    {
        $this->checkAuth();

        $db = \Config\Database::connect();
        $employe_id = $this->session->get('employe_id');

        // Vérifier que la demande appartient à l'employé
        $conge = $db->table('conger')
            ->where('id', $id)
            ->where('employe_id', $employe_id)
            ->where('id_status', 1) // Seulement les en attente
            ->first();

        if (!$conge) {
            return redirect()->back()->with('error', 'Demande introuvable ou non modifiable');
        }

        // Annuler la demande (statut 4 = annulée)
        $db->table('conger')
            ->where('id', $id)
            ->update(['id_status' => 4]);

        return redirect()->back()->with('success', 'Demande annulée');
    }

    /**
     * Afficher le profil de l'employé
     */
    public function profil()
    {
        $this->checkAuth();

        $db = \Config\Database::connect();
        $employe_id = $this->session->get('employe_id');
        
        $employe = $this->employeModel->find($employe_id);

        // Récupérer le département
        $departement = $db->table('departements')
            ->where('id', $employe['departement_id'])
            ->first();

        $data = [
            'employe_nom' => $this->session->get('employe_prenom') . ' ' . $this->session->get('employe_nom'),
            'employe_role' => 'Employé',
            'employe' => $employe,
            'departement' => $departement ? $departement['nom'] : 'Non spécifié',
        ];

        return view('employe/profil', $data);
    }
}
