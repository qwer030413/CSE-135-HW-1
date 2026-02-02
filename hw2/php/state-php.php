<?php
session_start();
$date = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'] ?? '';

if (isset($_POST['newData'])) {
    $_SESSION['data'] = $_POST['newData'];
}


if (isset($_GET['wipe'])) {
    session_destroy();
    header("Location: state-php.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.logr-in.com/LogRocket.min.js" crossorigin="anonymous"></script>
<script>window.LogRocket && window.LogRocket.init('mb3hyj/chrispsite');</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DW8W4JLZ2W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-DW8W4JLZ2W');
</script>
    <title>state-php</title>
</head>

<body>
    <h1>State (PHP)</h1>
    <p>
        Saved Data: <?php echo $_SESSION['data'] ?? 'nothing'; ?>
    </p>
    <form method="POST">
        <input type="text" name="newData">
        <button type="submit">Save</button>
    </form>

    <a href="?wipe">Clear Data</a>
</body>
</html>