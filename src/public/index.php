<?php	
	
	$globals = [];
	require_once 'config.php';	
	$home_dir = $globals['home_dir'];
	$base_url = $globals['base_url'];

	require_once $home_dir . 'classes/functions.php';
	require_once $home_dir . 'classes/localization.php';
	require_once $home_dir . 'classes/messages.php';
	require_once $home_dir . 'models/base.m.php';
	require_once $home_dir . 'classes/authentication.php';
	
	// rendering globals
	$master_template = 'master';
	$main_template = 'default';
	$page = 'pages/front'; // path to view AND controller
	$page_title = null; // set this in controller
	$messages = new Messages();
	$data = [];
	
	$localization = new Localization($home_dir . 'lang/');
	$db = new mysqli($globals['db_host'], $globals['db_login'], $globals['db_password'], $globals['db_name']);
	
	if ($db->connect_errno > 0) {
		$page = 'pages/error';
		if ($globals['debug_mode']) {
			$messages->error('Database connection error:' . $db->error_message);
		}
	} else {
		
		$auth = new Authentication($db);
		$path = [''];

		if (isset($_GET['path'])) {
			$path = explode('/', trimSlashes(strtolower($_GET['path'])));
		}

		// select page to display
		switch ($path[0]) {	
			
			// ADMIN SECTION
			case 'admin' :
				$main_template = 'admin';
				if (!isset($path[1])) {
					$path[1] = 'dashboard';
				}
				
				switch ($path[1]) {	
					case 'forgotten-password' :				
						$page = 'admin/forgot';
						break;
					case 'reset-password' :
						$page = 'admin/reset';
						break;
					default:
						if ($auth->isAuth()) {							
							$page = 'admin/' . $path[1];							
						} else {				
							$page = 'admin/login';
						}
				}
				
				break;
				
			case 'import' :
				$page = 'import/abx';
				break;
				
			// CUSTOMER SECTION
			default :
				if (strlen($path[0]) > 0) {
					$page = 'pages/' . $path[0];
				} else {
					$page = 'pages/front';
				}
		}

	}

	// run controller code if exists
	$controller_path = $page . '.c.php';	
	if (file_exists($home_dir . 'controllers/' . $controller_path)) {			
		include $home_dir . 'controllers/' . $controller_path;
	}
		
	// render page
	include $home_dir . 'views/' . $master_template . '.v.php';		
		
	$db->close();