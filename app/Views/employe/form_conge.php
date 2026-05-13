<?php

$sidebar_subtitle = 'Espace employé';
$page_title = 'Nouvelle demande de congé';
$breadcrumb = 'Accueil > Demande';

$sidebar_links = '
    <li><a href="' . route_to('employe_dashboard') . '"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
    <li><a href="' . route_to('employe_form_conge') . '" class="active"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
    <li><a href="' . route_to('employe_mes_conges') . '"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
    <li><a href="' . route_to('employe_profil') . '"><i class="bi bi-person"></i> Mon profil</a></li>
';

$topbar_actions = '';

$content = '
    <!-- Formulaire de demande -->
    <div class="data-card" style="max-width:600px">
        <div class="data-card-head"><h3>Soumettre une nouvelle demande</h3></div>
        <form method="POST" action="' . route_to('employe_store_conge') . '" style="padding:1.25rem">
            ' . csrf_field() . '

            <!-- Type de congé -->
            <div style="margin-bottom:1.5rem">
                <label style="display:block;font-size:.85rem;font-weight:500;margin-bottom:.5rem;color:var(--ink)">Type de congé</label>
                <select name="id_type" required style="width:100%;padding:.6rem;border:1px solid var(--border);border-radius:4px;font-size:.85rem">
                    <option value="">-- Sélectionner un type --</option>';

foreach ($types_conger as $type) {
    $content .= '<option value="' . htmlspecialchars($type['id']) . '">' . htmlspecialchars($type['nom']) . '</option>';
}

$content .= '
                </select>
            </div>

            <!-- Date de début -->
            <div style="margin-bottom:1.5rem">
                <label style="display:block;font-size:.85rem;font-weight:500;margin-bottom:.5rem;color:var(--ink)">Date de début</label>
                <input type="date" name="date_debut" required style="width:100%;padding:.6rem;border:1px solid var(--border);border-radius:4px;font-size:.85rem" onchange="updateDuration()" id="date_debut">
                <small style="display:block;margin-top:.3rem;color:var(--muted)">La date ne peut pas être dans le passé</small>
            </div>

            <!-- Date de fin -->
            <div style="margin-bottom:1.5rem">
                <label style="display:block;font-size:.85rem;font-weight:500;margin-bottom:.5rem;color:var(--ink)">Date de fin</label>
                <input type="date" name="date_fin" required style="width:100%;padding:.6rem;border:1px solid var(--border);border-radius:4px;font-size:.85rem" onchange="updateDuration()" id="date_fin">
                <small style="display:block;margin-top:.3rem;color:var(--muted)">Doit être après la date de début</small>
            </div>

            <!-- Durée calculée -->
            <div style="background:rgba(95, 168, 118, 0.08);padding:1rem;border-radius:4px;margin-bottom:1.5rem;font-size:.85rem">
                <div>Durée estimée: <strong id="duration">0</strong> jour(s)</div>
                <small style="color:var(--muted);display:block;margin-top:.5rem">Cette durée sera confirmée après approbation</small>
            </div>

            <!-- Boutons -->
            <div style="display:flex;gap:1rem">
                <button type="submit" class="btn-forest" style="flex:1">Soumettre la demande</button>
                <a href="' . route_to('employe_dashboard') . '" class="btn-cancel" style="flex:1;text-align:center;padding:.6rem">Annuler</a>
            </div>
        </form>
    </div>

    <script>
    function updateDuration() {
        const start = document.getElementById("date_debut").value;
        const end = document.getElementById("date_fin").value;
        if (start && end) {
            const startDate = new Date(start);
            const endDate = new Date(end);
            const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
            document.getElementById("duration").textContent = days > 0 ? days : 0;
        }
    }
    </script>

    <style>
    .btn-forest { background:var(--forest);color:white;border:none;border-radius:4px;cursor:pointer;font-weight:500;padding:.6rem 1rem;font-size:.85rem;transition:background 200ms }
    .btn-forest:hover { background:var(--forest);opacity:0.9 }
    .btn-cancel { background:var(--cream);color:var(--ink);border:1px solid var(--border);border-radius:4px;cursor:pointer;font-weight:500;padding:.6rem 1rem;font-size:.85rem;text-decoration:none;transition:background 200ms }
    .btn-cancel:hover { background:var(--mint);color:var(--forest) }
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
