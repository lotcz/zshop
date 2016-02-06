<?php

	$globals = [];
	require_once 'config.php';	
	$home_dir = $globals['home_dir'];	

	require_once $home_dir . 'classes/functions.php';	
	require_once $home_dir . 'classes/log.php';
	require_once $home_dir . 'models/base.m.php';
	
	if (_g('security_token') == $globals['security_token']) {
		$db = new mysqli($globals['db_host'], $globals['db_login'], $globals['db_password'], $globals['db_name']);
		$job = _g('job');
		if ($db->connect_errno == 0) {
			include $home_dir . 'cron/' . $job . '.j.php';
		} else {
			die('DB error:' . $db->erorr);
		}
	} else {
		die('Wrong security token.');
	}