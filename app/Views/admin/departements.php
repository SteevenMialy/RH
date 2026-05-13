<?php
$rows = '';
foreach (($departements ?? []) as $departement) {
    $rows .= '<tr>';
    $rows .= '<td>' . esc($departement['id']) . '</td>';
    $rows .= '<td>' . esc($departement['nom']) . '</td>';
    $rows .= '<td>' . esc($departement['description'] ?? '') . '</td>';
    $rows .= '<td>' . ($departement['deductible'] ? 'Oui' : 'Non') . '</td>';
    $rows .= '<td><form method="post" action="' . route_to('admin_delete_departement', $departement['id']) . '" onsubmit="return confirm(\'Supprimer ce département ?\')">' . csrf_field() . '<button type="submit" class="btn" style="border:1px solid var(--border);background:#fff;color:var(--danger)">Supprimer</button></form></td>';
    $rows .= '</tr>';
}

$content = '
    <div class="data-card">
        <div class="data-card-head"><h3>Ajouter un département</h3></div>
        <div style="padding:1.25rem">
            <form method="post" action="' . route_to('admin_store_departement') . '" style="display:grid;gap:1rem">
                ' . csrf_field() . '
                <input class="form-control" name="nom" placeholder="Nom du département" required>
                <textarea class="form-control" name="description" placeholder="Description"></textarea>
                <label style="display:flex;align-items:center;gap:.5rem"><input type="checkbox" name="deductible" value="1"> Congés déductibles</label>
                <button class="btn-forest" type="submit">Ajouter</button>
            </form>
        </div>
    </div>
    <div class="data-card">
        <div class="data-card-head"><h3>Liste des départements</h3></div>
        <table class="tbl"><thead><tr><th>ID</th><th>Nom</th><th>Description</th><th>Déductible</th><th>Action</th></tr></thead><tbody>' .
        ($rows !== '' ? $rows : '<tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--muted)">Aucun département</td></tr>') .
        '</tbody></table>
    </div>
';

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
    'content' => $content,
]);
