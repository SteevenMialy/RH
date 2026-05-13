<?php
$employeeRows = '';
foreach (($employes ?? []) as $employe) {
    $employeeRows .= '<tr>';
    $employeeRows .= '<td>' . esc($employe['id']) . '</td>';
    $employeeRows .= '<td>' . esc(trim($employe['prenom'] . ' ' . $employe['nom'])) . '</td>';
    $employeeRows .= '<td>' . esc($employe['email']) . '</td>';
    $employeeRows .= '<td>' . esc($employe['departement_nom'] ?? 'Non spécifié') . '</td>';
    $employeeRows .= '<td>' . esc($employe['role']) . '</td>';
    $employeeRows .= '<td>' . ($employe['actif'] ? 'Actif' : 'Inactif') . '</td>';
    $employeeRows .= '<td>';
    // Toggle active/inactive
    $employeeRows .= '<form method="post" action="' . route_to('admin_toggle_employe', $employe['id']) . '" style="display:inline-block;margin-right:.5rem">' . csrf_field() . '<button class="btn-forest" type="submit">' . ($employe['actif'] ? 'Désactiver' : 'Réactiver') . '</button></form>';
    // Keep existing toggle/delete action for backward compatibility
    $employeeRows .= '<form method="post" action="' . route_to('admin_delete_employe', $employe['id']) . '" style="display:inline-block;margin-right:.5rem">' . csrf_field() . '<button type="submit" class="btn" style="border:1px solid var(--border);background:#fff;color:var(--danger)">Basculer statut</button></form>';
    // Permanent remove (only allowed if no dependent requests)
    $employeeRows .= '<form method="post" action="' . route_to('admin_remove_employe', $employe['id']) . '" style="display:inline-block" onsubmit="return confirm(\'Supprimer cet employé ?\')">' . csrf_field() . '<button type="submit" class="btn" style="border:1px solid var(--border);background:#fff;color:var(--danger)">Supprimer</button></form>';
    $employeeRows .= '</td>';
    $employeeRows .= '</tr>';
}

$rhRows = '';
foreach (($rh_accounts ?? []) as $rh) {
    $rhRows .= '<tr>';
    $rhRows .= '<td>' . esc($rh['id']) . '</td>';
    $rhRows .= '<td>' . esc($rh['username']) . '</td>';
    $rhRows .= '<td>' . esc($rh['email']) . '</td>';
    $rhRows .= '<td>' . esc($rh['role']) . '</td>';
    $rhRows .= '<td><form method="post" action="' . route_to('admin_delete_rh', $rh['id']) . '" onsubmit="return confirm(\'Supprimer ce compte RH ?\')">' . csrf_field() . '<button type="submit" class="btn" style="border:1px solid var(--border);background:#fff;color:var(--danger)">Supprimer</button></form></td>';
    $rhRows .= '</tr>';
}

$departementOptions = '';
foreach (($departements ?? []) as $departement) {
    $departementOptions .= '<option value="' . esc($departement['id']) . '">' . esc($departement['nom']) . '</option>';
}

$content = '
    <div class="data-card">
        <div class="data-card-head"><h3>Ajouter un employé</h3></div>
        <div style="padding:1.25rem">
            <form method="post" action="' . route_to('admin_store_employe') . '" style="display:grid;gap:1rem;grid-template-columns:repeat(auto-fit,minmax(220px,1fr))">
                ' . csrf_field() . '
                <input class="form-control" name="nom" placeholder="Nom" required>
                <input class="form-control" name="prenom" placeholder="Prénom" required>
                <input class="form-control" name="email" type="email" placeholder="Email" required>
                <input class="form-control" name="password" type="password" placeholder="Mot de passe" required>
                <select class="form-control" name="departement_id">' . $departementOptions . '</select>
                <input class="form-control" name="date_embauche" type="date">
                <div style="grid-column:1/-1"><button class="btn-forest" type="submit">Ajouter l\'employé</button></div>
            </form>
        </div>
    </div>

    <div class="data-card">
        <div class="data-card-head"><h3>Ajouter un RH</h3></div>
        <div style="padding:1.25rem">
            <form method="post" action="' . route_to('admin_store_rh') . '" style="display:grid;gap:1rem;grid-template-columns:repeat(auto-fit,minmax(220px,1fr))">
                ' . csrf_field() . '
                <input class="form-control" name="username" placeholder="Nom RH" required>
                <input class="form-control" name="email" type="email" placeholder="Email RH" required>
                <input class="form-control" name="password" type="password" placeholder="Mot de passe RH" required>
                <div style="grid-column:1/-1"><button class="btn-forest" type="submit">Ajouter le RH</button></div>
            </form>
        </div>
    </div>

    <div class="data-card">
        <div class="data-card-head"><h3>Liste des employés</h3></div>
        <table class="tbl"><thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Département</th><th>Rôle</th><th>Statut</th><th>Action</th></tr></thead><tbody>' .
        ($employeeRows !== '' ? $employeeRows : '<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--muted)">Aucun employé</td></tr>') .
        '</tbody></table>
    </div>

    <div class="data-card">
        <div class="data-card-head"><h3>Liste des RH</h3></div>
        <table class="tbl"><thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Action</th></tr></thead><tbody>' .
        ($rhRows !== '' ? $rhRows : '<tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--muted)">Aucun RH</td></tr>') .
        '</tbody></table>
    </div>
';

echo view('layout/main', [
    'user_nom' => $user_nom,
    'user_role' => $user_role ?? 'Admin',
    'page_title' => 'Gestion des employés',
    'breadcrumb' => 'Admin > Employés',
    'sidebar_subtitle' => 'Administration',
    'sidebar_links' => '
        <li><a href="' . route_to('admin_dashboard') . '"><i class="bi bi-speedometer2"></i> Vue d\'ensemble</a></li>
        <li><a href="' . route_to('admin_demandes') . '"><i class="bi bi-inbox"></i> Toutes les demandes</a></li>
        <li><a href="' . route_to('admin_employes') . '" class="active"><i class="bi bi-people"></i> Employés</a></li>
        <li><a href="' . route_to('admin_departements') . '"><i class="bi bi-building"></i> Départements</a></li>
        <li><a href="' . route_to('admin_types_conge') . '"><i class="bi bi-tags"></i> Types de congé</a></li>
    ',
    'topbar_actions' => '',
    'content' => $content,
]);
