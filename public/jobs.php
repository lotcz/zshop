<?php

	require_once __DIR__ . '/../../zEngine/src/zengine.php';

	$z = new zEngine('../app/');
	$z->enableModule('jobs');

	$z->run();
