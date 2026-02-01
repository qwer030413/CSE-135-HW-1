<!-- IMPORTANT: 
to future self, you always have to do chmod 755 /var/www/chrisp.site/hw2/nodejs/hello-json-node.js  or something so it actually works on website
 -->

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
