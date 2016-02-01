<?php

	global $db, $home_dir, $globals, $path, $custAuth;
	
	require_once $home_dir . 'models/cart.m.php';
	
	$page_title = t('Shopping Cart');
	
	if (isset($custAuth) && $custAuth->isAuth()) {		
		$products = Cart::loadCart($db, $custAuth->customer->val('customer_id'));
		$totals = Cart::loadCartTotals($db, $custAuth->customer->val('customer_id'));		
	}
	
	$data['products'] = $products;
	$data['totals'] = $totals;