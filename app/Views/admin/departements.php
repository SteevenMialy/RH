<?php
echo view('layout/main', [
    'user_nom' => $user_nom,
    'user_role' => $user_role ?? 'Admin',
    'page_title' => 'Gestion des départements',
    'breadcrumb' => 'Admin > Départements',
    'sidebar_subtitle' => 'Administration',
    'sidebar_links' => '
        <li><a href="' . route_to('admin_dashboard') . '"><i class="bi bi-speedometer2"></i> Vue d\'ensemble</a></li>
        <li><a href="' . route_to('admin_demandes') . '"><i class="bi bi-inbox"></i> Toutes les demandes</a></li>
        <li><a href="' . route_to('admin_employes') . '"><i class="bi bi-people"></i> Employés</a></li>
        <li><a href="' . route_to('admin_departements') . '" class="active"><i class="bi bi-building"></i> Départements</a></li>
        <li><a href="' . route_to('admin_types_conge') . '"><i class="bi bi-tags"></i> Types de congé</a></li>
    ',
    'topbar_actions' => '',
    'content' => '<div style="text-align: center; padding: 2rem;"><i class="bi bi-building" style="font-size: 3rem; color: var(--muted); opacity: 0.3;"></i><p style="color: var(--muted); margin-top: 1rem;">Gestion des départements — À développer</p></div>',
]);
