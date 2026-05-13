<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relevé de notes - <?= esc($etudiant['nom'] ?? 'Étudiant') ?></title>
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
      <div class="topbar-title">Relevé de notes</div>
      <div class="topbar-actions">
        <a href="<?= site_url('/list_Etudiant') ?>" class="btn btn-secondary btn-sm" style="margin-right: 10px;">
          ← Retour
        </a>
        <button class="btn btn-primary btn-sm" onclick="window.print()">
          🖨️ Imprimer
        </button>
      </div>
    </div>

    <div class="content">

      <!-- Info étudiant -->
      <?php if (!empty($etudiant)): ?>
      <div class="releve-card">
        <div class="releve-header">
          <div class="releve-title">Relevé de notes</div>
        </div>
        
        <div class="releve-student">
          <div class="releve-student-info">
            <div class="releve-student-name"><?= esc($etudiant['nom'] . ' ' . $etudiant['prenom']) ?></div>
            <div class="releve-student-level">
              📚 <?= esc($etudiant['niveau'] ?? 'N/A') ?> — 
              🎯 <?= esc($etudiant['parcours'] ?? 'N/A') ?>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <!-- Affichage des notes par niveau/semestre -->
      <?php if (!empty($releveParNiveau)): ?>
        <?php 
          $totalCreditsGlobal = 0;
          $totalPondereGlobal = 0;
          $compteurSemestres = 0;
        ?>
        
        <?php foreach ($releveParNiveau as $semestre): ?>
          <div class="releve-card">
            <div class="releve-header">
              <div class="releve-title"><?= esc($semestre['niveau_nom']) ?></div>
              <div style="text-align: right; font-size: 12px; color: var(--c-muted);">
                Crédits : <strong><?= $semestre['total_credits'] ?></strong> — 
                Moyenne : <strong><?= number_format($semestre['moyenne'], 2) ?>/20</strong>
              </div>
            </div>

            <table class="releve-table">
              <thead>
                <tr>
                  <th>UE</th>
                  <th>Intitulé</th>
                  <th style="text-align: center;">Crédits</th>
                  <th style="text-align: center;">Note/20</th>
                  <th style="text-align: center;">Résultat</th>
                  <th style="text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($semestre['notes'] as $note): ?>
                  <tr>
                    <td><?= esc($note['code'] ?? '-') ?></td>
                    <td><?= esc($note['nom']) ?></td>
                    <td style="text-align: center;"><?= (int)$note['credits'] ?></td>
                    <td style="text-align: center;">
                      <strong><?= number_format((float)$note['note'], 2) ?></strong>
                    </td>
                    <td style="text-align: center;">
                      <?php if ((float) $note['note'] > 0): ?>
                        <?php 
                          $noteVal = (float)$note['note'];
                          $badge_class = 'badge-gray';
                          $resultat = 'Ajourné';
                          
                          if ($noteVal >= 12) {
                            $badge_class = 'badge-green';
                            $resultat = 'Bien';
                          } elseif ($noteVal >= 10) {
                            $badge_class = 'badge-blue';
                            $resultat = 'Passable';
                          }
                        ?>
                        <span class="badge <?= $badge_class ?>"><?= $resultat ?></span>
                      <?php else: ?>
                        <span class="badge badge-red">Sans note</span>
                      <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                      <div class="td-actions" style="justify-content:center;">
                        <?php if (! empty($note['note_id'])): ?>
                          <a href="<?= site_url('/notes/modifier/' . $note['note_id']) ?>" class="action-btn" title="Modifier">✏️</a>
                          <form action="<?= site_url('/notes/supprimer/' . $note['note_id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Supprimer cette note ?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="action-btn del" title="Supprimer">🗑️</button>
                          </form>
                        <?php else: ?>
                          <a href="<?= site_url('/notes?id_etudiant=' . $etudiant['id'] . '&id_matier=' . $note['matier_id']) ?>" class="action-btn" title="Ajouter">➕</a>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

            <div class="releve-summary">
              <div class="releve-sum-item">
                <div class="releve-sum-label">Crédits</div>
                <div class="releve-sum-value"><?= $semestre['total_credits'] ?></div>
              </div>
              <div class="releve-sum-item">
                <div class="releve-sum-label">Moyenne</div>
                <div class="releve-sum-value"><?= number_format($semestre['moyenne'], 2) ?></div>
              </div>
              <div class="releve-sum-item">
                <div class="releve-sum-label">Résultat</div>
                <div class="releve-sum-value" style="color: <?= $semestre['moyenne'] >= 10 ? 'var(--c-success)' : 'var(--c-danger)' ?>">
                  <?= $semestre['resultat'] ?>
                </div>
              </div>
              <div class="releve-sum-item">
                <div class="releve-sum-label">Mention</div>
                <div class="releve-sum-value">
                  <?php 
                    $moyenne = $semestre['moyenne'];
                    $mention = $moyenne >= 14 ? 'Excellente' : ($moyenne >= 12 ? 'Très bien' : ($moyenne >= 10 ? 'Bien' : 'Ajourné'));
                  ?>
                  <?= $mention ?>
                </div>
              </div>
            </div>
          </div>

          <?php 
            $totalCreditsGlobal += $semestre['total_credits'];
            $totalPondereGlobal += $semestre['moyenne'] * $semestre['total_credits'];
            $compteurSemestres++;
          ?>
        <?php endforeach; ?>

        <!-- Résumé global (si plusieurs semestres) -->
        <?php if ($compteurSemestres > 1): ?>
          <div class="releve-card">
            <div class="releve-header">
              <div class="releve-title">Résultat Global</div>
            </div>

            <div class="releve-summary">
              <div class="releve-sum-item">
                <div class="releve-sum-label">Crédits totaux</div>
                <div class="releve-sum-value"><?= $totalCreditsGlobal ?></div>
              </div>
              <div class="releve-sum-item">
                <div class="releve-sum-label">Moyenne générale</div>
                <div class="releve-sum-value">
                  <?php 
                    $moyenneGlobale = $totalCreditsGlobal > 0 ? $totalPondereGlobal / $totalCreditsGlobal : 0;
                  ?>
                  <?= number_format($moyenneGlobale, 2) ?>
                </div>
              </div>
              <div class="releve-sum-item">
                <div class="releve-sum-label">Mention</div>
                <div class="releve-sum-value">
                  <?php 
                    $mention = $moyenneGlobale >= 14 ? 'Excellente' : ($moyenneGlobale >= 12 ? 'Très bien' : ($moyenneGlobale >= 10 ? 'Bien' : 'Ajourné'));
                  ?>
                  <?= $mention ?>
                </div>
              </div>
              <div class="releve-sum-item">
                <div class="releve-sum-label">Décision</div>
                <div class="releve-sum-value" style="color: <?= $moyenneGlobale >= 10 ? 'var(--c-success)' : 'var(--c-danger)' ?>;">
                  <?= $moyenneGlobale >= 10 ? 'ADMIS(E)' : 'AJOURNÉ(E)' ?>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

      <?php else: ?>
        <div class="alert alert-info">
          <span>ℹ️ Aucune note enregistrée pour cet étudiant.</span>
        </div>
      <?php endif; ?>

      <div style="margin-top: 20px; text-align: center;">
        <a href="<?= site_url('/list_Etudiant') ?>" class="btn btn-secondary">
          ← Retour à la liste
        </a>
      </div>

    </div>

  </div>

</div>

</body>
</html>