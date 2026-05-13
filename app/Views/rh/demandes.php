<?php
echo view('layout/main', [
    'user_nom' => $user_nom,
    'user_role' => $user_role ?? 'Responsable RH',
    'page_title' => 'Demandes à traiter',
    'breadcrumb' => 'Accueil > Demandes',
    'sidebar_subtitle' => 'Espace responsable',
    'sidebar_links' => '
        <li><a href="' . route_to('rh_dashboard') . '"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
        <li><a href="' . route_to('rh_demandes') . '" class="active"><i class="bi bi-inbox"></i> Demandes à traiter <span class="nav-badge alert">4</span></a></li>
        <li><a href="' . route_to('rh_soldes') . '"><i class="bi bi-archive"></i> Soldes employés</a></li>
    ',
    'topbar_actions' => '',
    'content' => '<div style="text-align: center; padding: 2rem;"><i class="bi bi-inbox" style="font-size: 3rem; color: var(--muted); opacity: 0.3;"></i><p style="color: var(--muted); margin-top: 1rem;">Demandes à traiter — À développer</p></div>',
]);
