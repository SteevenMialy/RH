<?php

// Préparation des données pour le layout
$sidebar_subtitle = 'Espace employé';
$page_title = 'Tableau de bord';
$breadcrumb = 'Accueil';

// Liens de la sidebar
$sidebar_links = '
    <li><a href="' . route_to('employe_dashboard') . '" class="active"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
    <li><a href="' . route_to('employe_form_conge') . '"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
    <li><a href="' . route_to('employe_mes_conges') . '"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
    <li><a href="' . route_to('employe_profil') . '"><i class="bi bi-person"></i> Mon profil</a></li>
';

// Actions topbar
$topbar_actions = '<a href="' . route_to('employe_form_conge') . '" class="btn-forest" style="padding:7px 14px;font-size:.82rem">
    <i class="bi bi-plus-lg"></i> Nouvelle demande
</a>';

// Contenu principal
$content = '
    <!-- Flash succès -->
    <div class="flash flash-success">
        <i class="bi bi-check-circle-fill"></i>
        Bienvenue ' . htmlspecialchars($employe_nom) . ' ! Votre tableau de bord est à jour.
    </div>

    <!-- Métriques -->
    <div class="metrics">
        <div class="metric">
            <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
            <div class="metric-val">' . count(array_filter($conges, fn($c) => $c['id_status'] == 1)) . '</div>
            <div class="metric-label">En attente</div>
        </div>
        <div class="metric">
            <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-check-circle"></i></div></div>
            <div class="metric-val">' . count(array_filter($conges, fn($c) => $c['id_status'] == 2)) . '</div>
            <div class="metric-label">Approuvées</div>
        </div>
        <div class="metric">
            <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-calendar-check"></i></div></div>
            <div class="metric-val">' . (count($soldes) > 0 ? $soldes[0]['solde'] : 0) . '</div>
            <div class="metric-label">Jours restants</div>
        </div>
        <div class="metric">
            <div class="metric-top"><div class="metric-icon mi-red"><i class="bi bi-x-circle"></i></div></div>
            <div class="metric-val">' . count(array_filter($conges, fn($c) => $c['id_status'] == 3)) . '</div>
            <div class="metric-label">Refusée</div>
        </div>
    </div>

    <!-- Mes soldes -->
    <div class="data-card">
        <div class="data-card-head"><h3>Mes soldes de congés</h3></div>
        <div style="padding:1rem 1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem">';

foreach ($soldes as $solde) {
    $percentage = ($solde['jour_prises'] / $solde['jours_attribues']) * 100;
    $color = $percentage > 80 ? 'danger' : ($percentage > 50 ? 'warn' : '');
    $content .= '
        <div class="solde-card" style="margin:0">
            <div class="solde-header">
                <span class="solde-type">' . htmlspecialchars($solde['type_nom']) . '</span>
                <span class="solde-nums"><strong>' . $solde['solde'] . '</strong> / ' . $solde['jours_attribues'] . ' j</span>
            </div>
            <div class="solde-bar"><div class="solde-fill ' . $color . '" style="width:' . $percentage . '%"></div></div>
            <div class="solde-label">' . $solde['solde'] . ' jours restants · ' . $solde['jour_prises'] . ' pris</div>
        </div>';
}

$content .= '
        </div>
    </div>

    <!-- Dernières demandes -->
    <div class="data-card">
        <div class="data-card-head">
            <h3>Mes dernières demandes</h3>
            <a href="' . route_to('employe_mes_conges') . '" style="font-size:.8rem;color:var(--forest);text-decoration:none">Voir tout →</a>
        </div>
        <table class="tbl">
            <thead>
                <tr><th>Type</th><th>Du</th><th>Au</th><th>Durée</th><th>Statut</th></tr>
            </thead>
            <tbody>';

if (empty($conges)) {
    $content .= '<tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--muted)"><i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>Aucune demande de congé</td></tr>';
} else {
    foreach (array_slice($conges, 0, 3) as $conge) {
        $status_class = match($conge['id_status']) {
            1 => 's-attente',
            2 => 's-approuvee',
            3 => 's-refusee',
            default => 's-annulee'
        };
        $content .= '
            <tr>
                <td><span style="background:var(--mint);color:var(--forest);font-size:.7rem;font-weight:500;padding:4px 9px;border-radius:12px">' . htmlspecialchars($conge['type_nom']) . '</span></td>
                <td style="color:var(--muted)">' . $conge['date_debut'] . '</td>
                <td style="color:var(--muted)">' . $conge['date_fin'] . '</td>
                <td style="font-family:DM Mono,monospace;font-size:.8rem">5 j</td>
                <td><span class="statut ' . $status_class . '">' . $conge['status_nom'] . '</span></td>
            </tr>';
    }
}

$content .= '
            </tbody>
        </table>
    </div>
';

// Rendu final
echo view('layout/main', [
    'employe_nom' => $employe_nom,
    'employe_role' => $employe_role ?? 'Employé',
    'page_title' => $page_title,
    'breadcrumb' => $breadcrumb,
    'sidebar_subtitle' => $sidebar_subtitle,
    'sidebar_links' => $sidebar_links,
    'topbar_actions' => $topbar_actions,
    'content' => $content,
]);
