<?php	
	
	$config = include 'config.php';

	$home_dir = $config['home_dir'];
	$base_url = $config['base_url'];

	require_once $home_dir . 'classes/functions.php';
	require_once $home_dir . 'classes/localization.php';
	require_once $home_dir . 'classes/messages.php';
	require_once $home_dir . 'models/base.m.php';
	require_once $home_dir . 'classes/globals.php';
	require_once $home_dir . 'classes/authentication.php';
	require_once $home_dir . 'classes/custauth.php';
	require_once $home_dir . 'classes/images.php';
	
	// rendering globals
	$theme = null;
	$master_template = 'master';
	$main_template = 'main';
	$page_template = 'pages/front'; // path to view AND controller
	$page_title = null; // set this in controller
	$messages = new Messages();
	$data = [];
	$images = new Images($config['images_dir'], $config['images_url']);
	
	$localization = new Localization($home_dir . 'lang/');
	$db = new mysqli($config['db_host'], $config['db_login'], $config['db_password'], $config['db_name']);
	$db->set_charset('utf8');
	
	if ($db->connect_errno > 0) {
		$page_template = 'pages/error';
		if ($config['debug_mode']) {
			$messages->error('Database connection error:' . $db->error_message);
		}
	} else {
		$globals = new SiteGlobals($db);
		$auth = new Authentication($db);
		$path = [''];
		$raw_path = '';
		
		if (isset($_GET['path'])) {
			$path = explode('/', trimSlashes(strtolower($_GET['path'])));
			$raw_path = implode('/', $path);
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
						$page_template = 'admin/forgot';
						break;
					case 'reset-password' :
						$page_template = 'admin/reset';
						break;
					default:
						if ($auth->isAuth()) {							
							$page_template = 'admin/' . $path[1];							
						} else {				
							$page_template = 'admin/login';
						}
				}
				
				break;				
			
			case 'ajax' :
				$master_template = 'ajax';
				$custAuth = new CustomerAuthentication($db);
				$page_template = 'ajax/' . $path[1];
				break;

			case 'partials' :
				$master_template = 'partials/' . $path[1];
				$page_template = 'partials/' . $path[1];
				break;
				
			// CUSTOMER SECTION
			default :
				$theme = 'parfumerie';
				$custAuth = new CustomerAuthentication($db);
				$pg = $path[0];				
				if (strlen($pg) > 0) {
					if (file_exists($home_dir . 'views/pages/' . $pg . '.v.php') || file_exists($home_dir . 'controllers/pages/' . $pg . '.c.php')) {
						$page_template = 'pages/' . $pg;
					} else {
						require_once $home_dir . 'models/alias.m.php';
						$alias = new Alias($db);
						$alias->loadByUrl($raw_path);
						if ($alias->is_loaded) {
							$path = explode('/', $alias->val('alias_path'));
							$page_template = 'pages/' . $path[0];
							$raw_path = $alias->val('alias_path');
							
						} else {
							$page_template = 'pages/notfound';
						}
					}
													
				} else {
					$page_template = 'pages/front';
				}
		}

	}

	// run controller code if exists
	$controller_path = $page_template . '.c.php';	
	if (file_exists($home_dir . 'controllers/' . $controller_path)) {			
		include $home_dir . 'controllers/' . $controller_path;
	}
		
	// render page
	include $home_dir . 'views/' . $master_template . '.v.php';		
		
	$db->close();