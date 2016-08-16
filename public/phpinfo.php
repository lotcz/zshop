<?php

	$config = require 'config.php';	

	if ($_GET['security_token'] == $config['security_token']) {
		phpinfo();
	} else {
		die('Wrong security token.');
	}