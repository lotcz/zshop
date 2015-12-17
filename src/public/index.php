<?php	
	
	$globals = [];
	require_once 'config.php';	
	$home_dir = $globals['home_dir'];
	$base_url = $globals['base_url'];

	require_once $home_dir . 'classes/functions.php';
	require_once $home_dir . 'classes/localization.php';
	require_once $home_dir . 'models/base.m.php';
	require_once $home_dir . 'classes/authentication.php';
	
	// rendering globals
	$master_template = 'master';
	$main_template = 'default';
	$page = 'pages/front'; // path to view AND controller
	$messages = [];
	$data = [];
	
	$db = new mysqli($globals['db_host'], $globals['db_login'], $globals['db_password'], $globals['db_name']);
	$localization = new Localization($home_dir . 'lang/');
	
	if ($db->connect_errno > 0) {
		$page = 'pages/error';
		$messages[] = 'Database connection error:' . $db->error_message;
	} else {		
		$auth = new Authentication($db);
		
		if (isset($_GET['path'])) {
			$path = explode('/',trimSlashes(strtolower($_GET['path'])));
		} else {
			$path = [''];
		}

		// select page to display
		switch ($path[0]) {	
			
			// ADMIN SECTION
			case 'admin' :
				if ($auth->isAuth()) {
					if (isset($path[1])) {
						$page = 'admin/' . $path[1];
					} else {
						$page = 'admin/dashboard';
					}				
				} else {				
					$page = 'admin/login';
				}
				break;
			
			// CUSTOMER SECTION
			default :
				$page = 'pages/front';
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