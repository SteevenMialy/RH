<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>TechMada RH — Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <style>
        :root{
            --ink:      #1c2b1e;
            --forest:   #2d5a3d;
            --forest2:  #3d7a52;
            --leaf:     #5fa876;
            --mint:     #d4ede0;
            --cream:    #f8f6f1;
            --white:    #ffffff;
            --border:   #dde8e1;
            --muted:    #7a8f80;
            --danger:   #c0392b;
            --danger-bg:#fdf0ee;
            --danger-br:#f0b8b2;
            --warn:     #b8750a;
            --warn-bg:  #fef9ee;
            --warn-br:  #f5d98a;
            --success:  #1e6b3f;
            --success-bg:#edf7f2;
            --success-br:#8fd4aa;
            --info:     #1a4f7a;
            --info-bg:  #eaf2fb;
            --info-br:  #8fbde8;
            --sidebar-w:240px;
            --topbar-h: 62px;
        }
        *{box-sizing:border-box}
        body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--ink);margin:0;font-size:15px}
        h1,h2,h3,.brand-name{font-family:'Playfair Display',serif}
        code,pre,.mono{font-family:'DM Mono',monospace}

        .app-wrap{display:flex;min-height:100vh}
        .sidebar{width:var(--sidebar-w);background:var(--ink);display:flex;flex-direction:column;flex-shrink:0;position:sticky;top:0;height:100vh;overflow-y:auto}
        .sidebar-brand{padding:1.4rem 1.2rem 1rem;display:flex;align-items:center;gap:10px;border-bottom:1px solid rgba(255,255,255,.06)}
        .sidebar-logo-icon{width:34px;height:34px;background:var(--forest);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .sidebar-logo-icon i{color:var(--white);font-size:1.1rem}
        .sidebar-brand-name{font-family:'Playfair Display',serif;font-size:1rem;color:var(--white);line-height:1.2}
        .sidebar-brand-name span{display:block;font-size:.65rem;font-family:'DM Sans',sans-serif;font-weight:400;color:rgba(255,255,255,.35);letter-spacing:.05em;text-transform:uppercase}
        .sidebar-section{padding:.75rem 1.1rem .3rem;font-size:.62rem;font-weight:500;letter-spacing:1.4px;text-transform:uppercase;color:rgba(255,255,255,.25);margin-top:.25rem}
        .sidebar-nav{list-style:none;padding:0 .75rem;margin:0}
        .sidebar-nav li{margin-bottom:2px}
        .sidebar-nav li a{display:flex;align-items:center;gap:9px;padding:9px 11px;border-radius:7px;color:rgba(255,255,255,.55);text-decoration:none;font-size:.85rem;font-weight:400;transition:all .15s}
        .sidebar-nav li a:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.9)}
        .sidebar-nav li a.active{background:var(--forest);color:var(--white)}
        .sidebar-nav li a i{font-size:1.05rem;flex-shrink:0}
        .nav-badge{margin-left:auto;font-size:.65rem;padding:2px 7px;border-radius:10px;background:rgba(255,255,255,.12);color:var(--white)}
        .nav-badge.alert{background:var(--danger);color:var(--white)}
        .sidebar-user{padding:.85rem .75rem;border-top:1px solid rgba(255,255,255,.06);margin-top:auto}
        .s-user-row{display:flex;align-items:center;gap:9px;padding:9px 11px;border-radius:7px;cursor:pointer;transition:background .15s}
        .s-user-row:hover{background:rgba(255,255,255,.06)}
        .avatar{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:500;color:var(--white);flex-shrink:0;font-family:'DM Mono',monospace}
        .av-green{background:var(--forest2)}
        .av-blue{background:#1a4f7a}
        .av-amber{background:#b8750a}
        .user-name{font-size:.825rem;font-weight:500;color:var(--white);line-height:1.2}
        .user-role{font-size:.65rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.06em}

        .main{flex:1;min-width:0;display:flex;flex-direction:column}
        .topbar{height:var(--topbar-h);background:var(--white);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 1.75rem;gap:1rem;position:sticky;top:0;z-index:10}
        .topbar-title{font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:600;color:var(--ink)}
        .topbar-breadcrumb{font-size:.78rem;color:var(--muted);display:flex;align-items:center;gap:5px}
        .topbar-breadcrumb a{color:var(--muted);text-decoration:none}
        .topbar-breadcrumb a:hover{color:var(--forest)}
        .topbar-actions{margin-left:auto;display:flex;align-items:center;gap:8px}
        .icon-btn{width:34px;height:34px;border:1.5px solid var(--border);background:var(--white);border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);transition:all .15s;text-decoration:none}
        .icon-btn:hover{border-color:var(--forest);color:var(--forest)}
        .content{padding:1.75rem;flex:1}

        .flash{padding:11px 14px;border-radius:8px;font-size:.85rem;font-weight:500;display:flex;align-items:center;gap:9px;margin-bottom:1.25rem;border:1px solid transparent}
        .flash-success{background:var(--success-bg);color:var(--success);border-color:var(--success-br)}
        .flash-error{background:var(--danger-bg);color:var(--danger);border-color:var(--danger-br)}
        .flash-info{background:var(--info-bg);color:var(--info);border-color:var(--info-br)}
        .flash-warn{background:var(--warn-bg);color:var(--warn);border-color:var(--warn-br)}

        .metrics{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:1rem;margin-bottom:1.75rem}
        .metric{background:var(--white);border:1px solid var(--border);border-radius:12px;padding:1.1rem 1.25rem}
        .metric-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem}
        .metric-icon{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem}
        .mi-green{background:var(--success-bg);color:var(--success)}
        .mi-amber{background:var(--warn-bg);color:var(--warn)}
        .mi-red{background:var(--danger-bg);color:var(--danger)}
        .mi-blue{background:var(--info-bg);color:var(--info)}
        .mi-forest{background:var(--mint);color:var(--forest)}
        .metric-val{font-family:'DM Mono',monospace;font-size:1.75rem;font-weight:500;color:var(--ink);line-height:1}
        .metric-label{font-size:.775rem;color:var(--muted);margin-top:4px}

        .data-card{background:var(--white);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:1.5rem}
        .data-card-head{padding:.9rem 1.25rem;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap}
        .data-card-head h3{font-family:'Playfair Display',serif;font-size:.95rem;margin:0;font-weight:600;color:var(--ink)}
        .tbl{width:100%;border-collapse:collapse;font-size:.85rem}
        .tbl thead th{padding:9px 14px;font-size:.68rem;font-weight:500;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);background:var(--cream);border-bottom:1px solid var(--border);text-align:left;white-space:nowrap}
        .tbl tbody tr{border-bottom:1px solid var(--border);transition:background .1s}
        .tbl tbody tr:last-child{border-bottom:none}
        .tbl tbody tr:hover{background:var(--cream)}
        .tbl td{padding:12px 14px;color:var(--ink);vertical-align:middle}

        .footer-app{padding:.75rem 1.75rem;border-top:1px solid var(--border);font-size:.75rem;color:var(--muted);background:var(--white);display:flex;align-items:center;gap:6px}
        .footer-app span{color:var(--forest);font-weight:500}

        .btn-forest{background:var(--forest);color:var(--white);border:none;border-radius:8px;padding:9px 16px;font-size:.85rem;font-weight:500;cursor:pointer;font-family:'DM Sans',sans-serif;display:inline-flex;align-items:center;gap:6px;text-decoration:none;transition:background .15s}
        .btn-forest:hover{background:var(--forest2)}
    </style>
</head>
<body>
    <?php
    // Ensure user display variables exist (fallback to session values)
    $user_nom = $user_nom ?? ($employe_nom ?? (session()->get('user_prenom') ? trim(session()->get('user_prenom') . ' ' . session()->get('user_nom')) : null));
    $user_role = $user_role ?? (session()->get('user_role') ?? '');
    if (empty($user_nom)) {
        $user_nom = 'Utilisateur';
    }
    ?>
    <div class="app-wrap">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
                <div class="sidebar-brand-name">TechMada RH<span><?= $sidebar_subtitle ?? 'Dashboard' ?></span></div>
            </div>
            
            <div class="sidebar-section">Menu</div>
            <ul class="sidebar-nav">
                <?= $sidebar_links ?? '' ?>
            </ul>

            <div class="sidebar-user">
                <div class="s-user-row">
                    <div class="avatar av-green"><?= substr($user_nom, 0, 2) ?></div>
                    <div>
                        <div class="user-name"><?= $user_nom ?></div>
                        <div class="user-role"><?= $user_role ?></div>
                    </div>
                    <a href="<?= route_to('auth_logout') ?>" style="margin-left:auto;color:rgba(255,255,255,.25);font-size:1.1rem" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></a>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main">
            <!-- TOPBAR -->
            <div class="topbar">
                <div>
                    <div class="topbar-title"><?= $page_title ?? 'Dashboard' ?></div>
                    <div class="topbar-breadcrumb"><?= $breadcrumb ?? 'Accueil' ?></div>
                </div>
                <div class="topbar-actions">
                    <?= $topbar_actions ?? '' ?>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="content">
                <?= $content ?? '' ?>
            </div>

            <!-- FOOTER -->
            <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span> — Projet CodeIgniter 4</div>
        </div>
    </div>
</body>
</html>
