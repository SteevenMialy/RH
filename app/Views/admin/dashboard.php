<?php
echo view('layout/main', [
    'user_nom' => $user_nom,
    'user_role' => $user_role ?? 'Admin',
    'page_title' => 'Dashboard administrateur',
    'breadcrumb' => 'Administration',
    'sidebar_subtitle' => 'Administration',
    'sidebar_links' => '
        <li><a href="' . route_to('admin_dashboard') . '" class="active"><i class="bi bi-speedometer2"></i> Vue d\'ensemble</a></li>
        <li><a href="' . route_to('admin_demandes') . '"><i class="bi bi-inbox"></i> Toutes les demandes <span class="nav-badge alert">4</span></a></li>
        <li><a href="' . route_to('admin_employes') . '"><i class="bi bi-people"></i> Employés</a></li>
        <li><a href="' . route_to('admin_departements') . '"><i class="bi bi-building"></i> Départements</a></li>
        <li><a href="' . route_to('admin_types_conge') . '"><i class="bi bi-tags"></i> Types de congé</a></li>
    ',
    'topbar_actions' => '<a href="' . route_to('admin_employes') . '" class="btn-forest" style="padding:7px 14px;font-size:.82rem"><i class="bi bi-person-plus"></i> Ajouter employé</a>',
    'content' => '
        <div class="metrics">
            <div class="metric">
                <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-people"></i></div></div>
                <div class="metric-val">24</div>
                <div class="metric-label">Employés actifs</div>
            </div>
            <div class="metric">
                <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
                <div class="metric-val">4</div>
                <div class="metric-label">Demandes en attente</div>
            </div>
            <div class="metric">
                <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-calendar-check"></i></div></div>
                <div class="metric-val">31</div>
                <div class="metric-label">Approuvées ce mois</div>
            </div>
            <div class="metric">
                <div class="metric-top"><div class="metric-icon mi-blue"><i class="bi bi-building"></i></div></div>
                <div class="metric-val">4</div>
                <div class="metric-label">Départements</div>
            </div>
        </div>
        <div style="text-align: center; padding: 2rem;"><i class="bi bi-shield-check" style="font-size: 3rem; color: var(--muted); opacity: 0.3;"></i><p style="color: var(--muted); margin-top: 1rem;">Dashboard Admin — À développer</p></div>
    ',
]);
