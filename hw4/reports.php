<!-- I just moved everyhting to dashboard, this page is not used -->


<?php
require_once "auth.php";
Role(['analyst','super_admin', 'viewer']);
$db = new PDO(
    "mysql:host=localhost;dbname=CSE135;charset=utf8mb4",
    "chris",
    "1234!Apple"
);


$chartData = $db->query("
  SELECT DATE(created_at) AS day, COUNT(*) AS count
  FROM event
  WHERE created_at >= (NOW() - INTERVAL 30 DAY)
  GROUP BY DATE(created_at)
  ORDER BY day ASC
")->fetchAll(PDO::FETCH_ASSOC);

$Mouse = $db->query("
  SELECT DATE(created_at) AS day, COUNT(*) AS count
  FROM event
  WHERE event_type = 'mousemove'
  AND created_at >= (NOW() - INTERVAL 30 DAY)
  GROUP BY DATE(created_at)
  ORDER BY day ASC
")->fetchAll(PDO::FETCH_ASSOC);
$EventType = $db->query("
  SELECT event_type, COUNT(*) AS count
  FROM event
  WHERE created_at >= (NOW() - INTERVAL 30 DAY)
  GROUP BY event_type
  ORDER BY count DESC
")->fetchAll(PDO::FETCH_ASSOC);

// we normalize the event type thing bc most of them is mouse movement LOL
$total = array_sum(array_column($EventType, 'count'));

foreach ($EventType as &$e) {
    $e['percentage'] = $total > 0 ? ($e['count'] / $total) * 100 : 0;
}


$rows = $db->query("
    SELECT id, sid, event_type, url, title, created_at
    FROM event
    ORDER BY created_at DESC
    LIMIT 50
")->fetchAll();
?>

<!doctype html>
<html>
    <body>
        <h1>Reports</h1>
        <a href="dashboard.php">Dashboard</a>
        <h2>All events</h2>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <canvas id="allEvents" style="width: 500px; height: 100px;"></canvas>
        <script>
            // get the graph(or chart idk) data
            const allEventsData  = <?php echo json_encode($chartData); ?>;
            
            // its just how many events in general per day
            const allLabels = allEventsData.map(r => r.day);
            const allValues = allEventsData.map(r => Number(r.count));
            new Chart(document.getElementById('allEvents'), {
                type: 'line',
                data: {
                    labels: allLabels,
                    datasets: [{
                        label: 'events per day',
                        data: allValues,
                        fill: false
                    }]
                }
            });
        </script>
        <h3>Analyst Comment</h3>
        <p>
        The total number of events has increased drastically in 3/11. this indicates the website has been visited much more frequently that day
        </p>
        <hr>
        <h2>mouse movements</h2>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <canvas id="mouseEvents" style="width: 500px; height: 100px;"></canvas>
        <script>
            // get the graph(or chart idk) data
            const mouseData  = <?php echo json_encode($Mouse); ?>;
            
            // its just how many events in general per day
            const mouseLabels = mouseData.map(r => r.day);
            const mouseValues = mouseData.map(r => Number(r.count));
            new Chart(document.getElementById('mouseEvents'), {
                type: 'line',
                data: {
                    labels: mouseLabels,
                    datasets: [{
                        label: 'mouse movements per day',
                        data: mouseValues,
                        fill: false
                    }]
                }
            });
        </script>
        <h3>Analyst Comment</h3>
        <p>
            A lot of mouse movement was seen in 3/11, which means some users must have been playing around with the site and moving their mouse frantically
        </p>
        <hr>
        <h2>Event type</h2>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <canvas id="EventType" style="width: 100px; height: 40px;"></canvas>
        <script>
            // get the graph(or chart idk) data
            const EventTypeData  = <?php echo json_encode($EventType); ?>;
            
            // its just how many events in general per day
            const EventTypeLabels = EventTypeData.map(r => `${r.event_type}`);
            const EventTypeValues = EventTypeData.map(r => Number(r.percentage));
            new Chart(document.getElementById('EventType'), {
            type: 'bar',
            // the data
            data: {
                labels: EventTypeLabels,
                datasets: [{
                    label: 'Percentage',
                    data: EventTypeValues,
                }]
            },
            // custom options
            options: {
                responsive: true,
                plugins: {
                    // info
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'event Type Distribution for last 30 days'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.parsed.toFixed(1)}%`;
                            }
                        }
                    }
                }
            }
        });
        </script>
        <h3>Analyst Comment</h3>
        <p>
            it seems like most events that are being recorded are mouse movements, which makes sense since just moving the mouse accross the screen will log it 10ish times.
        </p>
        <hr>
        <table style = "padding: 15px; border-spacing: 30px; border: 1px solid black; border-collapse: collapse;">
            <tr>
            <th style = "border: 1px solid black; padding: 10px;">id</th>
            <th style = "border: 1px solid black; padding: 10px;">sid</th>
            <th style = "border: 1px solid black; padding: 10px;">event_type</th>
            <th style = "border: 1px solid black; padding: 10px;">url</th>
            <th style = "border: 1px solid black; padding: 10px;">title</th>
            <th style = "border: 1px solid black; padding: 10px;">created_at</th>
            </tr>
            <?php foreach ($rows as $r): ?>
            <tr>
                <td style = "border: 1px solid black; padding: 10px;"><?= (int)$r['id'] ?></td>
                <td style = "border: 1px solid black; padding: 10px;"><?= htmlspecialchars($r['sid'] ?? '') ?></td>
                <td style = "border: 1px solid black; padding: 10px;"><?= htmlspecialchars($r['event_type'] ?? '') ?></td>
                <td style = "border: 1px solid black; padding: 10px;"><?= htmlspecialchars($r['url'] ?? '') ?></td>
                <td style = "border: 1px solid black; padding: 10px;"><?= htmlspecialchars($r['title'] ?? '') ?></td>
                <td style = "border: 1px solid black; padding: 10px;"><?= htmlspecialchars($r['created_at'] ?? '') ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <p>
            We can clearly see from the table that the user mostly moved their mouse around and clicked while viewing the page.
        </p>
    </body>

</html>