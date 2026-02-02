<?php
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html>
<head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DW8W4JLZ2W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-DW8W4JLZ2W');
</script>
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
