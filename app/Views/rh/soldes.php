<?php
$pendingCount = (int) ($pending_count ?? 0);
$rows = '';
foreach (($soldes ?? []) as $solde) {
    $nom = trim(($solde['prenom_emp'] ?? '') . ' ' . ($solde['nom_emp'] ?? ''));
    $restant = (int) ($solde['solde'] ?? 0);
    $attribues = (int) ($solde['jours_attribues'] ?? 0);
    $prises = (int) ($solde['jour_prises'] ?? 0);
    $pct = $attribues > 0 ? min(100, max(0, round(($prises / $attribues) * 100))) : 0;
    $rows .= '<tr>';
    $rows .= '<td>' . esc($nom !== '' ? $nom : ('#' . ($solde['employe_id'] ?? '?'))) . '</td>';
    $rows .= '<td>' . esc($solde['type_nom'] ?? 'N/A') . '</td>';
    $rows .= '<td>' . $attribues . '</td>';
    $rows .= '<td>' . $prises . '</td>';
    $rows .= '<td>' . $restant . '</td>';
    $rows .= '<td><div class="solde-bar" style="height:10px;background:var(--border);border-radius:8px;overflow:hidden"><div style="width:' . $pct . '%;height:100%;background:var(--forest)"></div></div></td>';
    $rows .= '</tr>';
}

$content = '
    <div class="data-card">
        <div class="data-card-head"><h3>Soldes par employé</h3></div>
        <table class="tbl"><thead><tr><th>Employé</th><th>Type</th><th>Attribués</th><th>Pris</th><th>Restants</th><th>Progression</th></tr></thead><tbody>' .
        ($rows !== '' ? $rows : '<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--muted)">Aucun solde disponible</td></tr>') .
        '</tbody></table>
    </div>
';

echo view('layout/main', [
    'user_nom' => $user_nom,
    'user_role' => $user_role ?? 'Responsable RH',
    'page_title' => 'Soldes employés',
    'breadcrumb' => 'Accueil > Soldes',
    'sidebar_subtitle' => 'Espace responsable',
    'sidebar_links' => '
        <li><a href="' . route_to('rh_dashboard') . '"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
        <li><a href="' . route_to('rh_demandes') . '"><i class="bi bi-inbox"></i> Demandes à traiter <span class="nav-badge alert">' . $pendingCount . '</span></a></li>
        <li><a href="' . route_to('rh_soldes') . '" class="active"><i class="bi bi-archive"></i> Soldes employés</a></li>
    ',
    'topbar_actions' => '',
    'content' => $content,
]);
