<?php
$rows = '';
foreach (($types_conge ?? []) as $type) {
    $rows .= '<tr>';
    $rows .= '<td>' . esc($type['id']) . '</td>';
    $rows .= '<td>' . esc($type['nom']) . '</td>';
    $rows .= '<td>' . esc($type['description'] ?? '') . '</td>';
    $rows .= '<td><form method="post" action="' . route_to('admin_delete_type_conge', $type['id']) . '" onsubmit="return confirm(\'Supprimer ce type de congé ?\')">' . csrf_field() . '<button type="submit" class="btn" style="border:1px solid var(--border);background:#fff;color:var(--danger)">Supprimer</button></form></td>';
    $rows .= '</tr>';
}

$content = '
    <div class="data-card">
        <div class="data-card-head"><h3>Ajouter un type de congé</h3></div>
        <div style="padding:1.25rem">
            <form method="post" action="' . route_to('admin_store_type_conge') . '" style="display:grid;gap:1rem">
                ' . csrf_field() . '
                <input class="form-control" name="nom" placeholder="Nom du type de congé" required>
                <textarea class="form-control" name="description" placeholder="Description"></textarea>
                <button class="btn-forest" type="submit">Ajouter</button>
            </form>
        </div>
    </div>
    <div class="data-card">
        <div class="data-card-head"><h3>Liste des types de congé</h3></div>
        <table class="tbl"><thead><tr><th>ID</th><th>Nom</th><th>Description</th><th>Action</th></tr></thead><tbody>' .
        ($rows !== '' ? $rows : '<tr><td colspan="4" style="text-align:center;padding:2rem;color:var(--muted)">Aucun type de congé</td></tr>') .
        '</tbody></table>
    </div>
';

echo view('layout/main', [
    'user_nom' => $user_nom,
    'user_role' => $user_role ?? 'Admin',
    'page_title' => 'Gestion des types de congé',
    'breadcrumb' => 'Admin > Types de congé',
    'sidebar_subtitle' => 'Administration',
    'sidebar_links' => '
        <li><a href="' . route_to('admin_dashboard') . '"><i class="bi bi-speedometer2"></i> Vue d\'ensemble</a></li>
        <li><a href="' . route_to('admin_demandes') . '"><i class="bi bi-inbox"></i> Toutes les demandes</a></li>
        <li><a href="' . route_to('admin_employes') . '"><i class="bi bi-people"></i> Employés</a></li>
        <li><a href="' . route_to('admin_departements') . '"><i class="bi bi-building"></i> Départements</a></li>
        <li><a href="' . route_to('admin_types_conge') . '" class="active"><i class="bi bi-tags"></i> Types de congé</a></li>
    ',
    'topbar_actions' => '',
    'content' => $content,
]);
