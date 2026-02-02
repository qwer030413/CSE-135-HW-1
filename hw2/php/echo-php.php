<?php
header("Content-Type: text/html");

$host = gethostname();
$date = date("Y-m-d H:i:s");
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$method = $_SERVER['REQUEST_METHOD'];
$query_string = $_SERVER['QUERY_STRING'] ?? '';
$body = file_get_contents('php://input');
$protocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'err';

?>
<!DOCTYPE html>
<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DW8W4JLZ2W"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-DW8W4JLZ2W');
    </script>
    <title>General Request Echo PHP</title>
</head>

<body>
    <h1>General Request Echo PHP</h1>
    <p>HTTP Protocol: <?php echo $protocol; ?></p>
    <p>HTTP Method:<?php echo $method; ?></p>
    <p>Query String: <?php echo $query_string; ?></p>
    <p>Message Body: <?php echo $body; ?></p>
    <p>Host Name: <?php echo $host; ?></p>
    <p>date: <?php echo $date; ?></p>
    <p>ip: <?php echo $ip; ?></p>
</body>
</html>