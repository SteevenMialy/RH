<?= $this->extend('admin/layout') ?> <!-- Ou le nom de votre fichier layout -->

<?= $this->section('content') ?> <!-- Vérifiez ce nom de section dans votre fichier layout -->

    <!-- VOS STATS EXISTANTES -->
    <div class="stats-grid">
        <div class="stat-card"><h4>Employés</h4><p><?= $employees_active ?></p></div>
        <div class="stat-card"><h4>En Attente</h4><p><?= $pending_count ?></p></div>
        <div class="stat-card"><h4>Approuvés</h4><p><?= $approved_count ?></p></div>
    </div>

    <!-- VOS GRAPHIQUES -->
    <div style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center;">
        <canvas id="chartMois"></canvas>
        <canvas id="chartJours"></canvas>
    </div>

    <!-- LE SCRIPT (Graphiques hors ligne simples) -->
    <script src="<?= base_url('assets/js/simple-charts.js') ?>"></script>
    <script>
        const donneesMois = <?= json_encode($donnees_mois) ?>;
        const donneesJours = <?= json_encode($donnees_jours) ?>;

        // Graphique des congés par mois
        drawBarChart(
            document.getElementById('chartMois'),
            donneesMois,
            ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Déc'],
            'Congés par mois'
        );

        // Graphique des congés par jour de la semaine
        drawLineChart(
            document.getElementById('chartJours'),
            donneesJours,
            ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            'Congés par jour de la semaine'
        );
    </script>

<?= $this->endSection() ?>