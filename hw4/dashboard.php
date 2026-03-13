<?php
declare(strict_types=1);
require_once "auth.php";
Role(['analyst','super_admin', 'viewer']);
// session_start();
// so that people cant just type url and bypass login
// if (!isset($_SESSION['user'])) {
//     header("Location: login.php");
//     exit;
// }
$db = new PDO(
    "mysql:host=localhost;dbname=CSE135;charset=utf8mb4",
    "chris",
    "1234!Apple"
);
// get data rows
// $rows = $db->query("
//     SELECT id, sid, event_type, url, title, created_at
//     FROM event
//     ORDER BY created_at DESC
//     LIMIT 200
// ")->fetchAll();
// data for chart
// $chartData = $db->query("
//   SELECT DATE(created_at) AS day, COUNT(*) AS count
//   FROM event
//   WHERE created_at >= (NOW() - INTERVAL 30 DAY)
//   GROUP BY DATE(created_at)
//   ORDER BY day ASC
// ")->fetchAll();
// 
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

$comments_data = $db->query("
SELECT title, category, analyst_comment
FROM reports
ORDER BY created_at DESC
")->fetchAll();

$comments = [];
foreach ($comments_data as $row) {
    $comments[$row['category']][] = [
        'title' => $row['title'],
        'analyst_comment' => $row['analyst_comment'] ?? ''
    ];
}

?>


<!-- just put chart and graph in same page -->
<!doctype html>
<html>
    <body>
        <h1>Dashboard</h1>
        <div style = "display:flex; gap:20px; padding:10px; background-color: #4f69fa;">
            <a href="logout.php" style = "padding: 10px; border-radius:5px; background-color:lightblue;">Logout</a>
            <a href="users.php" style = "padding: 10px; border-radius:5px; background-color:lightblue;">manage users(only super_admins)</a>
            <!-- <a href="reports.php">reports</a> -->
            <a href="create_reports.php" style = "padding: 10px; border-radius:5px; background-color:lightblue;">create reports</a>
            <button onclick="window.print()" style = "padding: 10px; border-radius:5px; background-color:lightblue;">Export PDF</button>
        </div>
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
        <?php if (!empty($comments['all_events'])): ?>
            <?php foreach ($comments['all_events'] as $c): ?>
                <div style="background-color: #8A9DF2; padding:2px; border-radius:5px;">
                    <h4>Title: <?= htmlspecialchars($c['title']) ?></h4>
                    <p>Comment: <?= htmlspecialchars($c['analyst_comment']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No analyst comment yet.</p>
        <?php endif; ?>
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
        
        <?php if (!empty($comments['mouse_events'])): ?>
            <?php foreach ($comments['mouse_events'] as $c): ?>
                <div style="background-color: #8A9DF2; padding:2px; border-radius:5px;">
                    <h4>Title: <?= htmlspecialchars($c['title']) ?></h4>
                    <p>Comment: <?= htmlspecialchars($c['analyst_comment']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No analyst comment yet.</p>
        <?php endif; ?>

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
        
        <?php if (!empty($comments['event_type'])): ?>
            <?php foreach ($comments['event_type'] as $c): ?>
                <div style="background-color: #8A9DF2; padding:2px; border-radius:5px;">
                    <h4>Title: <?= htmlspecialchars($c['title']) ?></h4>
                    <p>Comment: <?= htmlspecialchars($c['analyst_comment']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No analyst comment yet.</p>
        <?php endif; ?>

        <hr>

        <h2>data table</h2>
        <div style="max-height: 400px; overflow-y: auto; border: 1px solid">
            <table style = "padding: 15px; border-spacing: 30px; border: 1px solid black; border-collapse: collapse;">
                <thead>
                    <tr  style="background-color: #a5afe8; color: black; text-align: left;">
                    <th style = "border: 1px solid black; padding: 10px;">id</th>
                    <th style = "border: 1px solid black; padding: 10px;">sid</th>
                    <th style = "border: 1px solid black; padding: 10px;">event_type</th>
                    <th style = "border: 1px solid black; padding: 10px;">url</th>
                    <th style = "border: 1px solid black; padding: 10px;">title</th>
                    <th style = "border: 1px solid black; padding: 10px;">created_at</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
        </div>
        <h3>Analyst Comment</h3>
        <?php if (!empty($comments['data_table'])): ?>
            <?php foreach ($comments['data_table'] as $c): ?>
                <div style="background-color: #8A9DF2; padding:2px; border-radius:5px;">
                    <h4>Title: <?= htmlspecialchars($c['title']) ?></h4>
                    <p>Comment: <?= htmlspecialchars($c['analyst_comment']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No analyst comment yet.</p>
        <?php endif; ?>
    </body>

</html>