<?php

$sidebar_subtitle = 'Espace employé';
$page_title = 'Mon profil';
$breadcrumb = 'Accueil > Profil';

$sidebar_links = '
    <li><a href="' . route_to('employe_dashboard') . '"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
    <li><a href="' . route_to('employe_form_conge') . '"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
    <li><a href="' . route_to('employe_mes_conges') . '"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
    <li><a href="' . route_to('employe_profil') . '" class="active"><i class="bi bi-person"></i> Mon profil</a></li>
';

$topbar_actions = '';

$content = '
    <!-- Carte profil -->
    <div class="data-card" style="max-width:600px">
        <div class="data-card-head"><h3>Informations personnelles</h3></div>
        <div style="padding:1.25rem;display:grid;gap:1.5rem">
            
            <!-- Nom complet -->
            <div>
                <label style="display:block;font-size:.8rem;font-weight:600;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase">Nom complet</label>
                <div style="font-size:.95rem;color:var(--ink);font-weight:500">' . htmlspecialchars($employe['nom'] . ' ' . $employe['prenom']) . '</div>
            </div>

            <!-- Email -->
            <div>
                <label style="display:block;font-size:.8rem;font-weight:600;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase">Adresse email</label>
                <div style="font-size:.95rem;color:var(--ink);font-family:DM Mono,monospace;word-break:break-all">' . htmlspecialchars($employe['email']) . '</div>
            </div>

            <!-- Département -->
            <div>
                <label style="display:block;font-size:.8rem;font-weight:600;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase">Département</label>
                <div style="font-size:.95rem;color:var(--ink)">' . htmlspecialchars($departement ?? 'Non spécifié') . '</div>
            </div>

            <!-- Date d\'embauche -->
            <div>
                <label style="display:block;font-size:.8rem;font-weight:600;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase">Date d\'embauche</label>
                <div style="font-size:.95rem;color:var(--ink)">' . htmlspecialchars($employe['date_embauche'] ?? 'Non spécifié') . '</div>
            </div>

            <!-- Statut -->
            <div>
                <label style="display:block;font-size:.8rem;font-weight:600;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase">Statut</label>
                <div style="font-size:.95rem;color:var(--ink)">
                    <span style="background:' . ($employe['actif'] ? 'rgba(46, 213, 115, 0.15)' : 'rgba(255, 75, 75, 0.15)') . ';color:' . ($employe['actif'] ? '#2ed573' : '#ff4b4b') . ';font-size:.8rem;font-weight:500;padding:4px 9px;border-radius:12px;display:inline-block">
                        ' . ($employe['actif'] ? 'Actif' : 'Inactif') . '
                    </span>
                </div>
            </div>

            <!-- Rôle -->
            <div>
                <label style="display:block;font-size:.8rem;font-weight:600;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase">Rôle</label>
                <div style="font-size:.95rem;color:var(--ink);background:var(--mint);padding:4px 9px;border-radius:12px;display:inline-block;font-weight:500">' . htmlspecialchars($employe['role']) . '</div>
            </div>

        </div>
    </div>

    <!-- Bouton de déconnexion -->
    <div style="margin-top:2rem">
        <a href="' . route_to('auth_logout') . '" class="btn-logout" style="display:inline-block;padding:.6rem 1rem;background:var(--cream);color:var(--forest);border:1px solid var(--border);border-radius:4px;text-decoration:none;font-weight:500;font-size:.85rem">
            <i class="bi bi-box-arrow-right"></i> Se déconnecter
        </a>
    </div>
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
