<?php
declare(strict_types=1);
session_start();
// so that people cant just type url and bypass login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$db = new PDO(
    "mysql:host=localhost;dbname=CSE135;charset=utf8mb4",
    "chris",
    "1234!Apple"
);
// get data rows
$rows = $db->query("
    SELECT id, sid, event_type, url, title, created_at
    FROM event
    ORDER BY created_at DESC
    LIMIT 200
")->fetchAll();
// data for chart
$chartData = $db->query("
  SELECT DATE(created_at) AS day, COUNT(*) AS count
  FROM event
  WHERE created_at >= (NOW() - INTERVAL 30 DAY)
  GROUP BY DATE(created_at)
  ORDER BY day ASC
")->fetchAll();
?>


<!-- just put chart and graph in same page -->
<!doctype html>
<html>
    <body>
        <a href="logout.php">Logout</a>
        <h1>Dashboard</h1>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <canvas id="chart" height="120"></canvas>
        <script>
            // get the graph(or chart idk) data
            const data = <?php echo json_encode($chartData); ?>;
            
            // its just how many events in general per day
            const labels = data.map(r => r.day);
            const values = data.map(r => Number(r.count));
            new Chart(document.getElementById('chart'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'events per day',
                        data: values,
                        fill: false
                    }]
                }
            });
        </script>
        <h3>(data)</h1>

        <!-- table or data idk -->
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
    </body>

</html>