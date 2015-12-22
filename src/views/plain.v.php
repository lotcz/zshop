<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=$page_title ?></title>
	</head>

	<body>
		
		<?php
			renderBlock('messages');
			include $home_dir . 'views/' . $page . '.v.php';
		?>		

	</body>
</html>