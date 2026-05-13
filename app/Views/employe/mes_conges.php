<?php

$sidebar_subtitle = 'Espace employé';
$page_title = 'Mes demandes de congé';
$breadcrumb = 'Accueil > Mes demandes';

$sidebar_links = '
    <li><a href="' . route_to('employe_dashboard') . '"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
    <li><a href="' . route_to('employe_form_conge') . '"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
    <li><a href="' . route_to('employe_mes_conges') . '" class="active"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
    <li><a href="' . route_to('employe_profil') . '"><i class="bi bi-person"></i> Mon profil</a></li>
';

$topbar_actions = '<a href="' . route_to('employe_form_conge') . '" class="btn-forest" style="padding:7px 14px;font-size:.82rem">
    <i class="bi bi-plus-lg"></i> Nouvelle demande
</a>';

$content = '
    <!-- Tableau des demandes -->
    <div class="data-card">
        <div class="data-card-head">
            <h3>Toutes mes demandes</h3>
        </div>
        <table class="tbl">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Du</th>
                    <th>Au</th>
                    <th>Durée</th>
                    <th>Statut</th>
                    <th style="text-align:center">Actions</th>
                </tr>
            </thead>
            <tbody>';

if (empty($conges)) {
    $content .= '
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--muted)">
                        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
                        Aucune demande de congé
                    </td>
                </tr>';
} else {
    foreach ($conges as $conge) {
        $start = strtotime($conge['date_debut']);
        $end = strtotime($conge['date_fin']);
        $duration = (($end - $start) / 86400) + 1;

        $status_class = match($conge['id_status']) {
            1 => 's-attente',
            2 => 's-approuvee',
            3 => 's-refusee',
            default => 's-annulee'
        };

        $content .= '
                <tr>
                    <td><span style="background:var(--mint);color:var(--forest);font-size:.7rem;font-weight:500;padding:4px 9px;border-radius:12px">';
        $content .= htmlspecialchars($conge['type_nom']) . '</span></td>
                    <td style="color:var(--muted)">' . $conge['date_debut'] . '</td>
                    <td style="color:var(--muted)">' . $conge['date_fin'] . '</td>
                    <td style="font-family:DM Mono,monospace;font-size:.8rem">' . intval($duration) . ' j</td>
                    <td><span class="statut ' . $status_class . '">' . htmlspecialchars($conge['status_nom']) . '</span></td>
                    <td style="text-align:center;font-size:.8rem">';

        if ($conge['id_status'] == 1) { // En attente - permettre l'annulation
            $content .= '
                        <form method="POST" action="' . route_to('employe_cancel_conge', $conge['id']) . '" style="display:inline-block" onsubmit="return confirm(\'Êtes-vous sûr ?\')">
                            ' . csrf_field() . '
                            <button type="submit" style="background:none;border:none;color:var(--danger);cursor:pointer;text-decoration:underline;font-size:.8rem">Annuler</button>
                        </form>';
        } else {
            $content .= '<span style="color:var(--muted)">—</span>';
        }

        $content .= '
                    </td>
                </tr>';
    }
}

$content .= '
            </tbody>
        </table>
    </div>

    <style>
    .statut {
        font-size:.7rem;
        font-weight:500;
        padding:4px 9px;
        border-radius:12px;
        display:inline-block;
    }
    .s-attente {
        background:rgba(255, 193, 7, 0.15);
        color:#f39c12;
    }
    .s-approuvee {
        background:rgba(46, 213, 115, 0.15);
        color:#2ed573;
    }
    .s-refusee {
        background:rgba(255, 75, 75, 0.15);
        color:#ff4b4b;
    }
    .s-annulee {
        background:rgba(108, 117, 125, 0.15);
        color:#6c757d;
    }
    </style>
';

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
