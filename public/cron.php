<?php

	$config = require 'config.php';	
	$home_dir = $config['home_dir'];	

	require_once $home_dir . 'classes/functions.php';	
	require_once $home_dir . 'classes/log.php';
	require_once $home_dir . 'models/base.m.php';
	
	if (_g('security_token') == $config['security_token']) {
		$db = new mysqli($config['db_host'], $config['db_login'], $config['db_password'], $config['db_name']);
		$db->set_charset('utf8');
		$job = _g('job');
		if ($db->connect_errno == 0) {
			include $home_dir . 'cron/' . $job . '.j.php';
		} else {
			dbErr($db->erorr);
		}
	} else {
		die('Wrong security token.');
	}