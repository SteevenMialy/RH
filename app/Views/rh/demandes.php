<?php
// Génère le contenu de la liste de demandes
$content = '';
$pendingCount = (int) ($pending_count ?? 0);

$content .= '<h2>Demandes en attente</h2>';
if (! empty($conges)) {
    $content .= '<table class="table">';
    $content .= '<thead><tr><th>ID</th><th>Employé</th><th>Type</th><th>Début</th><th>Fin</th><th>Action</th></tr></thead><tbody>';
    foreach ($conges as $c) {
        $employe = trim(($c['prenom_emp'] ?? '') . ' ' . ($c['nom_emp'] ?? '')) ?: ('#' . ($c['employe_id'] ?? '?'));
        $content .= '<tr>';
        $content .= '<td>' . esc($c['id']) . '</td>';
        $content .= '<td>' . esc($employe) . '</td>';
        $content .= '<td>' . esc($c['type_nom'] ?? 'N/A') . '</td>';
        $content .= '<td>' . esc($c['date_debut']) . '</td>';
        $content .= '<td>' . esc($c['date_fin']) . '</td>';
        $content .= '<td>';
        $content .= '<form method="post" action="' . site_url('/rh/confirmationconger') . '" style="display:inline-block; margin-right:.5rem;">';
        $content .= '<input type="hidden" name="conger_id" value="' . esc($c['id']) . '">';
        $content .= '<input type="hidden" name="valeur" value="Approuve">';
        $content .= '<button class="btn btn-success" type="submit">Approuver</button>';
        $content .= '</form>';
        $content .= '<form method="post" action="' . site_url('/rh/confirmationconger') . '" style="display:inline-block;">';
        $content .= '<input type="hidden" name="conger_id" value="' . esc($c['id']) . '">';
        $content .= '<input type="hidden" name="valeur" value="Refuse">';
        $content .= '<button class="btn btn-danger" type="submit">Refuser</button>';
        $content .= '</form>';
        $content .= '</td>';
        $content .= '</tr>';
    }
    $content .= '</tbody></table>';
} else {
    $content .= '<div class="alert alert-info">Aucune demande en attente pour le moment.</div>';
}

echo view('layout/main', [
    'user_nom' => $user_nom,
    'user_role' => $user_role ?? 'Responsable RH',
    'page_title' => 'Demandes à traiter',
    'breadcrumb' => 'Accueil > Demandes',
    'sidebar_subtitle' => 'Espace responsable',
    'sidebar_links' => '
        <li><a href="' . route_to('rh_dashboard') . '"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
        <li><a href="' . route_to('rh_demandes') . '" class="active"><i class="bi bi-inbox"></i> Demandes à traiter <span class="nav-badge alert">' . $pendingCount . '</span></a></li>
        <li><a href="' . route_to('rh_soldes') . '"><i class="bi bi-archive"></i> Soldes employés</a></li>
    ',
    'topbar_actions' => '',
    'content' => $content,
]);
