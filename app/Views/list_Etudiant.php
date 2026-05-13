<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GradeBook - Liste des étudiants</title>
  <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>

<div class="app">

  <!-- ── Sidebar ──────────────────────────────────────────────────────────── -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div style="font-size:18px">📚</div>
      <div>
        <div class="brand-name">GradeBook</div>
        <div class="brand-sub">v1.0</div>
      </div>
    </div>

    <div class="sidebar-section">Navigation</div>

    <a href="<?= site_url('/notes') ?>" class="nav-item">
      📝 Saisie de note
    </a>
    <a href="<?= site_url('/list_Etudiant') ?>" class="nav-item active">
      👥 Étudiants
    </a>

    <div class="sidebar-bottom">
      <div class="user-row">
        <span>👤</span>
        <div class="user-info">
          <div class="name">Gestionnaire</div>
          <div class="role">Admin</div>
        </div>
      </div>
    </div>
  </aside>

  <!-- ── Main ─────────────────────────────────────────────────────────────── -->
  <div class="main">

    <div class="topbar">
      <div class="topbar-title">Gestion des étudiants</div>
      <div class="topbar-actions">
        <button class="btn btn-primary btn-sm">
          ➕ Nouvel étudiant
        </button>
      </div>
    </div>

    <div class="content">

      <div class="page-header">
        <div>
          <h2>Liste des étudiants</h2>
          <div class="breadcrumb">Accueil / <span>Étudiants</span></div>
        </div>
      </div>

      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Niveau</th>
              <th>Parcours</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($etudiants as $etudiant): ?>
                <tr>
                    <td><?= esc($etudiant['id']) ?></td>
                    <td><?= esc($etudiant['nom']) ?></td>
                    <td><?= esc($etudiant['prenom']) ?></td>
                    <td><?= esc($etudiant['niveau']) ?></td>
                    <td><?= esc($etudiant['parcours']) ?></td>
                    <td>
                      <div class="td-actions">
                        <a href="<?= site_url('/notes/etudiant?id_etudiant=' . $etudiant['id']) ?>" 
                           class="action-btn" title="Voir les notes">
                          👁️
                        </a>
                        <button class="action-btn" title="Éditer">
                          ✏️
                        </button>
                        <button class="action-btn del" title="Supprimer">
                          🗑️
                        </button>
                      </div>
                    </td>
                </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>

  </div>

</div>

</body>
</html>