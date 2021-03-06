<!DOCTYPE html>
<html lang="<?=$this->z->i18n->selected_language->val('language_code') ?>">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<meta name="description" content="">
		<meta name="author" content="Karel Zavadil">
		<link rel="icon" href="/favicon.ico">

		<title><?=$this->getFullPageTitle() ?></title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

		<?php
			$this->renderCSSIncludes();
			$this->renderLESSIncludes();
			$this->renderJSIncludes_head();
		?>

		<link href="/css/style.css" rel="stylesheet">
		<link href="/css/parfumerie.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<?php

			$this->renderPartialView('cookies');

			if ($this->isAuth()) {
				$this->renderAdminMenu();
			}

			$this->renderMainView();

		?>

		<?php
			$this->renderJSIncludes();
		?>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="<?=$this->url('js/zshop.js')?>"></script>
	
	</body>
</html>
