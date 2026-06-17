<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard: Calendrier & Graphique</title>

    <!-- Liens CDN pour les styles et les bibliothèques -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
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
        <!-- Section Calendrier -->
        <div class="card">
            <h2>Mon Agenda</h2>
            <div id="calendar"></div>
        </div>
    </div>

    <?php
    // Initialisation pour éviter les erreurs "undefined variable"
    $events = [];

    if (!empty($conges)) {
        $events = array_map(function ($conge) {
            $debut = strtotime($conge['date_debut']);
            $fin = strtotime($conge['date_fin']);

            // Calcul de la durée réelle
            $jours = (int) floor(($fin - $debut) / 86400) + 1;

            // CORRECTION 2 : Ajouter 1 jour à la date de fin pour FullCalendar (Exclusif)
            $fin_calendar = strtotime("+1 day", $fin);

            return [
                'id' => $conge['id'],
                'title' => $conge['type_nom'] . ' (' . $jours . 'j)',
                'start' => date('Y-m-d', $debut),
                'end' => date('Y-m-d', $fin_calendar),
                'color' => match ((int) $conge['id_status']) {
                    1 => '#f39c12', // En attente - orange
                    2 => '#27ae60', // Approuvée - vert
                    3 => '#c0392b', // Refusée - rouge
                    default => '#7f8c8d' // Autre - gris
                },
            ];
        }, $conges);
    }
    ?>

    <script>
        // 1. Simulation du retour d'une API (Données mockées)
        // Imagine que c'est le résultat d'un fetch('https://api.mon-site.com/events')
        const dataFromAPI = <?php echo json_encode($events ?? []); ?>;

        document.addEventListener('DOMContentLoaded', function () {

            // --- INITIALISATION DU CALENDRIER ---
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: dataFromAPI
            });
            calendar.render();
        });
    </script>
</body>

</html>