<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard: Calendrier & Graphique</title>
    
    <!-- Liens CDN pour les styles et les bibliothèques -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f4f6f9;
        }
        .container {
            display: flex;
            flex-direction: column;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Section Graphique -->
        <div class="card">
            <h2>Statistiques d'activités</h2>
            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    
    <?php 
    // Initialisation pour éviter les erreurs "undefined variable"
    $events = []; 

    if (!empty($conges)) {
        $events = array_map(function ($conge) {
            $debut = strtotime($conge['date_debut']);
            $fin = strtotime($conge['date_fin']);
            
            $jours = (int) floor(($fin - $debut) / 86400) + 1;
            
            $fin_calendar = strtotime("+1 day", $fin);

            return [
                'id' => $conge['id'],
                'title' => $conge['type_nom'] . ' (' . $jours . 'j)',
                'start' => date('Y-m-d', $debut),
                'end' => date('Y-m-d', $fin_calendar), 
                'color' => match ((int)$conge['id_status']) {
                    1 => '#f39c12', // En attente - orange
                    2 => '#27ae60', // Approuvée - vert
                    3 => '#c0392b', // Refusée - rouge
                    default => '#7f8c8d' // Autre - gris
                },
                // On passe ces infos en plus pour pouvoir construire le graphique en JS
                'extendedProps' => [
                    'type_nom' => $conge['type_nom'],
                    'jours' => $jours
                ]
            ];
        }, $conges);
    } 
    ?>


 <script>
    // Récupération des données injectées par PHP
    const dataFromAPI = <?php echo json_encode($events ?? []); ?>;

    document.addEventListener('DOMContentLoaded', function() {
        // --- PREPARATION DES DONNEES ---
        const structureGraphique = {};
        
        dataFromAPI.forEach(event => {
            const type = event.extendedProps.type_nom;
            const nbJours = event.extendedProps.jours;
            
            if (structureGraphique[type]) {
                structureGraphique[type] += nbJours;
            } else {
                structureGraphique[type] = nbJours;
            }
        });

        const labelsX = Object.keys(structureGraphique);
        const dataY = Object.values(structureGraphique);

        // --- CONFIGURATION ET RENDU DU GRAPHIQUE ---
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar', // Graphique en bâtons (barres verticales)
            data: {
                labels: labelsX,
                datasets: [{
                    label: 'Nombre de jours cumulés', // Correction du texte de la légende
                    data: dataY,
                    // Palette de couleurs modernes pour différencier les bâtons
                    backgroundColor: [
                        '#3b82f6', // Bleu
                        '#10b981', // Vert
                        '#f59e0b', // Orange
                        '#8b5cf6', // Violet
                        '#ec4899'  // Rose
                    ],
                    borderWidth: 0, // Supprimé la bordure pour un look plus "flat design"
                    borderRadius: 6  // Arrondit légèrement le haut des bâtons
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Force l'affichage de nombres entiers uniquement (pas de 1.5, 2.5...)
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
</body>
</html>