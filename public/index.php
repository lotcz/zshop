<?php	
	
	require_once __DIR__ . '/../../zEngine/src/z.php';
	
	$z = new zEngine('../app/');
	$z->enableModule('mysql');
	$z->enableModule('i18n');
	$z->enableModule('admin');
	$z->enableModule('images');
	$z->enableModule('shop');	
	
	$z->run();