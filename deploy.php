<?php
$repo_dir = '/var/www/chrisp.site';
$output = shell_exec("cd $repo_dir && git pull origin main 2>&1");
file_put_contents('deploy_log.txt', date('Y-m-d H:i:s') . "\n" . $output . "\n---\n", FILE_APPEND);

echo "finished deploying";
?>