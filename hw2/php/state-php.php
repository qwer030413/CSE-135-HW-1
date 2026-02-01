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