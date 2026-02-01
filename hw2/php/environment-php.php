<?php
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Environment PHP</title>
</head>
<body>
	<h1>Environment Variables (PHP)</h1>
    	<ul>
        	<?php foreach ($_SERVER as $key => $value): ?>
            		<li><strong><?php echo htmlspecialchars($key); ?>:</strong> <?php echo htmlspecialchars($value); ?></li>
        	<?php endforeach; ?>
    	</ul>
</body>
</html>
