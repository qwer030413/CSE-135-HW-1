<?php
declare(strict_types=1);
session_start();
// so that people cant just type url and bypass login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!doctype html>
<html>
  <body>
    <h1>im a dash</h1>
    <a href="logout.php">Logout</a>
  </body>

</html>