<?php
header("Content-Type: text/html");
$date = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'] ?? 'err';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>HELLO HTML PHP</title>
    </head>
    <body>
        <h1>Hello from Team Chris</h1>
        <p>Language: PHP</p>
        <p>Date-Time: <?php echo $date; ?></p>
        <p>Your IP: <?php echo $ip; ?></p>
    </body>
</html>
