<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GradeBook - Saisie de note</title>
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

    <a href="<?= site_url('/notes') ?>" class="nav-item active">
      📝 Saisie de note
    </a>
    <a href="<?= site_url('/list_Etudiant') ?>" class="nav-item">
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
      <div class="topbar-title">Saisie de note</div>
    </div>

    <div class="content">

      <div class="page-header">
        <div>
          <h2>Formulaire de saisie de note</h2>
          <div class="breadcrumb">Accueil / <span>Saisie de note</span></div>
        </div>
      </div>

      <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success">
            ✅ <?= esc(session()->getFlashdata('success')) ?>
          </div>
      <?php endif; ?>

      <?php $errors = session()->getFlashdata('errors') ?? []; ?>
      <?php if (! empty($errors)): ?>
          <div class="alert alert-error">
            ❌ Erreur dans le formulaire :
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
          </div>
      <?php endif; ?>

      <div class="card">
        <form action="<?= site_url('/notes/enregistrer') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-grid cols-1">
              <div>
                <label class="field-label">Étudiant <span style="color: var(--c-danger);">*</span></label>
                <select id="id_etudiant" name="id_etudiant" required>
                    <option value="">-- Sélectionner un étudiant --</option>
                    <?php foreach ($etudiants as $etudiant): ?>
                    <option value="<?= esc($etudiant['id']) ?>" <?= ((int) old('id_etudiant', $selectedEtudiant) === (int) $etudiant['id']) ? 'selected' : '' ?>>
                            <?= esc($etudiant['nom'] . ' ' . $etudiant['prenom'] . ' - ' . ($etudiant['niveau'] ?? 'N/A') . ' / ' . ($etudiant['parcours'] ?? 'N/A')) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="form-grid cols-1">
              <div>
                <label class="field-label">Matière <span style="color: var(--c-danger);">*</span></label>
                <select id="id_matier" name="id_matier" required>
                    <option value="">-- Sélectionner une matière --</option>
                    <?php foreach ($matieres as $matiere): ?>
                    <option value="<?= esc($matiere['id']) ?>" <?= ((int) old('id_matier', $selectedMatier) === (int) $matiere['id']) ? 'selected' : '' ?>>
                            <?= esc(($matiere['code'] ? $matiere['code'] . ' - ' : '') . $matiere['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="form-grid cols-1">
              <div>
                <label class="field-label">Note (sur 20) <span style="color: var(--c-danger);">*</span></label>
                <input
                    type="number"
                    id="note"
                    name="note"
                    min="0"
                    max="20"
                    step="0.01"
                    value="<?= esc(old('note')) ?>"
                    placeholder="Ex : 15.5"
                    required
                />
              </div>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
              <a href="<?= site_url('/list_Etudiant') ?>" class="btn btn-secondary">
                Annuler
              </a>
              <button type="submit" class="btn btn-primary">
                ✅ Enregistrer la note
              </button>
            </div>
        </form>
      </div>

    </div>

  </div>

</div>

</body>
</html>