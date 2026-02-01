<?php
header("Content-Type: application/json");
$date = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'] ?? 'err';
$team = "team chris";
$language = "PHP";
echo json_encode([
    "team" => $team,
    "language" => $language,
    "datetime" => $date,
    "ip" => $ip
]);

