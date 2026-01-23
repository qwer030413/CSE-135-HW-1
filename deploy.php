<?php
$output = shell_exec('cd /var/www/chrisp.site/CSE-135-HW-1 && git pull 2>&1');

file_put_contents('deploy_log.txt', date('Y-m-d H:i:s') . "\n" . $output . "\n---\n", FILE_APPEND);

echo "finished: \n" . $output;
?>