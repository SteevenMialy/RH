<?php
$pendingCount = (int) ($pending_count ?? 0);
$rows = '';

foreach (($conges ?? []) as $conge) {
    $employe = trim(($conge['prenom_emp'] ?? '') . ' ' . ($conge['nom_emp'] ?? ''));
    $rows .= '<tr>';
    $rows .= '<td>' . esc($conge['id']) . '</td>';
    $rows .= '<td>' . esc($employe !== '' ? $employe : ('#' . ($conge['employe_id'] ?? '?'))) . '</td>';
    $rows .= '<td>' . esc($conge['type_nom'] ?? 'N/A') . '</td>';
    $rows .= '<td>' . esc($conge['date_debut'] ?? '') . '</td>';
    $rows .= '<td>' . esc($conge['date_fin'] ?? '') . '</td>';
    $rows .= '<td>' . esc($conge['status_nom'] ?? 'N/A') . '</td>';
    $rows .= '</tr>';
}

$content = '';
if ($rows !== '') {
    $content = '<div class="data-card"><div class="data-card-head"><h3>Toutes les demandes</h3></div><table class="tbl"><thead><tr><th>ID</th><th>Employé</th><th>Type</th><th>Début</th><th>Fin</th><th>Statut</th></tr></thead><tbody>' . $rows . '</tbody></table></div>';
} else {
    $content = '<div style="text-align: center; padding: 2rem;"><i class="bi bi-inbox" style="font-size: 3rem; color: var(--muted); opacity: 0.3;"></i><p style="color: var(--muted); margin-top: 1rem;">Aucune demande trouvée en base.</p></div>';
}

echo view('layout/main', [
    'user_nom' => $user_nom,
    'user_role' => $user_role ?? 'Admin',
    'page_title' => 'Toutes les demandes',
    'breadcrumb' => 'Admin > Demandes',
    'sidebar_subtitle' => 'Administration',
    'sidebar_links' => '
        <li><a href="' . route_to('admin_dashboard') . '"><i class="bi bi-speedometer2"></i> Vue d\'ensemble</a></li>
        <li><a href="' . route_to('admin_demandes') . '" class="active"><i class="bi bi-inbox"></i> Toutes les demandes <span class="nav-badge alert">' . $pendingCount . '</span></a></li>
        <li><a href="' . route_to('admin_employes') . '"><i class="bi bi-people"></i> Employés</a></li>
        <li><a href="' . route_to('admin_departements') . '"><i class="bi bi-building"></i> Départements</a></li>
        <li><a href="' . route_to('admin_types_conge') . '"><i class="bi bi-tags"></i> Types de congé</a></li>
    ',
    'topbar_actions' => '',
    'content' => $content,
]);
