<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la note</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
<div class="app">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div style="font-size:18px">📚</div>
      <div>
        <div class="brand-name">GradeBook</div>
        <div class="brand-sub">v1.0</div>
      </div>
    </div>
    <div class="sidebar-section">Navigation</div>
    <a href="<?= site_url('/notes') ?>" class="nav-item active">📝 Saisie de note</a>
    <a href="<?= site_url('/list_Etudiant') ?>" class="nav-item">👥 Étudiants</a>
  </aside>

  <div class="main">
    <div class="topbar">
      <div class="topbar-title">Modifier la note</div>
    </div>

    <div class="content">
      <div class="page-header">
        <div>
          <h2>Modification de la note</h2>
          <div class="breadcrumb">Accueil / <span>Modifier note</span></div>
        </div>
      </div>

      <?php $errors = session()->getFlashdata('errors') ?? []; ?>
      <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
          <?php foreach ($errors as $error): ?>
            <div><?= esc($error) ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="card">
        <form action="<?= site_url('/notes/modifier/' . $note['id']) ?>" method="post">
          <?= csrf_field() ?>

          <div class="form-grid cols-1">
            <div>
              <label class="field-label">Étudiant</label>
              <input type="text" value="<?= esc($note['etudiant_nom'] . ' ' . $note['etudiant_prenom']) ?>" disabled>
            </div>
          </div>

          <div class="form-grid cols-1">
            <div>
              <label class="field-label">Matière</label>
              <input type="text" value="<?= esc(($note['matiere_code'] ? $note['matiere_code'] . ' - ' : '') . $note['matiere_nom']) ?>" disabled>
            </div>
          </div>

          <div class="form-grid cols-1">
            <div>
              <label class="field-label">Note (sur 20)</label>
              <input type="number" name="note" min="0" max="20" step="0.01" value="<?= esc($note['note']) ?>" required>
            </div>
          </div>

          <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:20px;">
            <a href="<?= site_url('/notes/etudiant?id_etudiant=' . $note['id_etudiant']) ?>" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>