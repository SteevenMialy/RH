<?php
$pendingCount = (int) ($pending_count ?? 0);
$employeesActive = (int) ($employees_active ?? 0);
$approvedCount = (int) ($approved_count ?? 0);

echo view('layout/main', [
    'user_nom' => $user_nom,
    'user_role' => $user_role ?? 'Responsable RH',
    'page_title' => 'Tableau de bord RH',
    'breadcrumb' => 'Accueil',
    'sidebar_subtitle' => 'Espace responsable',
    'sidebar_links' => '
        <li><a href="' . route_to('rh_dashboard') . '" class="active"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
        <li><a href="' . route_to('rh_demandes') . '"><i class="bi bi-inbox"></i> Demandes à traiter <span class="nav-badge alert">' . $pendingCount . '</span></a></li>
        <li><a href="' . route_to('rh_soldes') . '"><i class="bi bi-archive"></i> Soldes employés</a></li>
    ',
    'topbar_actions' => '',
    'content' => '
        <div class="metrics">
            <div class="metric">
                <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-people"></i></div></div>
                <div class="metric-val">' . $employeesActive . '</div>
                <div class="metric-label">Employés actifs</div>
            </div>
            <div class="metric">
                <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
                <div class="metric-val">' . $pendingCount . '</div>
                <div class="metric-label">Demandes en attente</div>
            </div>
            <div class="metric">
                <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-calendar-check"></i></div></div>
                <div class="metric-val">' . $approvedCount . '</div>
                <div class="metric-label">Demandes approuvées</div>
            </div>
        </div>
        <div style="text-align: center; padding: 2rem;"><i class="bi bi-graph-up" style="font-size: 3rem; color: var(--muted); opacity: 0.3;"></i><p style="color: var(--muted); margin-top: 1rem;">Dashboard RH — données réelles</p></div>
    ',
]);
