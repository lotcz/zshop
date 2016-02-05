<?php

	require_once $home_dir . 'models/category.m.php';
	require_once $home_dir . 'models/product.m.php';
	
	$data['categories'] = Category::all($db);
	$data['categories'] = Category::all($db);
	$data['categories'] = Category::all($db);