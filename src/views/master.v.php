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

		<title><?=$globals['shop_title'] ?></title>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">		
		<!--link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-xWeRKjzyg6bep9D1AsHzUPEWHbWMzlRc84Z0aG+tyms= sha512-mGIRU0bcPaVjr7BceESkC37zD6sEccxE+RJyQABbbKNe83Y68+PyPM5nrE1zvbQZkSHDCJEtnAcodbhlq2/EkQ==" crossorigin="anonymous"-->
		
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"-->
		<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap-theme.min.css"-->

		<!-- Custom styles for this template -->
		<link href="/css/style.css" rel="stylesheet">
		<?php
			if (isset($theme)) {
				?>
					<link href="/css/<?=$theme ?>.css" rel="stylesheet">
				<?php
			}
		?>
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="<?= $auth->isAuth() ? 'admin' : '' ?>">
	
		<?php		
			
			if ($auth->isAuth()) {
				renderBlock('adm-top');
			}
		
			include $home_dir . 'views/' . $main_template . '.v.php';
			
		?>
		
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha256-GMscmjNs6MbZvXG2HRjP3MpdOGmXv078SRgH7M723Mc= sha512-1wnhBRtA+POGVA0yREk2RlDbJEdkNvMuRBGjT1FCI5wXmpiQHZWDIB8MpANBWM/GKSPDgCA/7HTrAIFgv70/Jw==" crossorigin="anonymous"></script-->

		<script src="/js/tools.js"></script>
		<script src="/js/forms.js"></script>		

	</body>
</html>