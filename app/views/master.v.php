<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">		
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<meta name="description" content="">
		<meta name="author" content="Karel Zavadil">
		<link rel="icon" href="/favicon.ico">

		<title><?=$globals['site_title'] ?> - <?=$page_title ?></title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		
		<link href="/css/style.css" rel="stylesheet">
		<?php
			if (isset($theme)) {
				?>
					<link href="/css/<?=$theme ?>.css" rel="stylesheet">
				<?php
			}
		?>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="<?= $auth->isAuth() ? 'admin' : '' ?>">		
		<?php		
			
			renderBlock('cookies');
			
			if ($auth->isAuth()) {
				renderBlock('adm-top');
			}
		
			include $home_dir . 'views/' . $main_template . '.v.php';
			
		?>	
		
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

		<script src="/js/tools.js"></script>		
		<script src="/js/forms.js"></script>

		<!--script src="/js/devejs.js"></script-->		

	</body>
</html>