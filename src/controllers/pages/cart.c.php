<?php

	global $db, $home_dir, $globals, $path, $custAuth;
	require_once $home_dir . 'models/product.m.php';
	
	if (isset($custAuth) && $custAuth->isAuth()) {
		echo $custAuth->customer->val('customer_email');
		
		$products = Product::loadCart($db, $custAuth->customer->val('customer_id'));
		$total = count($products);
	}