<?php
session_start();
$date = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
// we need another page for form brah
$page = $_GET['page'] ?? 'form';

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
<?php if ($page === 'form'): ?>
    <h1>State (PHP)</h1>
    <!-- <p>
        Saved Data: <?php echo $_SESSION['data'] ?? 'nothing'; ?>
    </p> -->
    <form method="POST">
        <input type="text" name="newData">
        <button type="submit">Save</button>
    </form>
    <p>
        <a href="state-php.php?page=view">View Saved Data</a>
    </p>

<?php elseif ($page === 'view'): ?>
    <h1>State (PHP) viewing data</h1>
    <p>
        Saved Data: <?php echo $_SESSION['data'] ?? 'nothing'; ?>
    </p>
    <a href="?wipe">Clear Data</a>
    <a href="state-php.php?page=form">Back to Form</a>
<?php endif; ?>
</body>
</html>