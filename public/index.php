<?php

	require_once __DIR__ . '/../../zEngine/src/z.php';

	$z = new zEngine('../app/');
	$z->enableModule('app');
	$z->run();
