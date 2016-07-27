<?php
	global $db, $home_dir, $globals, $path, $custAuth;	
	require_once $home_dir . 'models/cart.m.php';
	require_once $home_dir . 'models/delivery_type.m.php';
	require_once $home_dir . 'models/payment_type.m.php';
	
	$page_title = t('Shopping Cart');
	
	if (isset($custAuth) && $custAuth->isAuth()) {		
		$products = Cart::loadCart($db, $custAuth->customer->val('customer_id'));
		$totals = Cart::loadCartTotals($db, $custAuth->customer->val('customer_id'));		
	} else {
		$messages->add(t('You cannot be logged in'));
	}
	
	$data['products'] = $products;
	$data['totals'] = $totals;