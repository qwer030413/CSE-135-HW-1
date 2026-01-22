<?php
$output = shell_exec('cd /var/www/html && git pull 2>&1');

file_put_contents('deploy_log.txt', date('Y-m-d H:i:s') . "\n" . $output . "\n---\n", FILE_APPEND);

echo "finished: \n" . $output;
?>