<?php
	global $db, $home_dir, $globals, $path, $custAuth;	
	require_once $home_dir . 'models/cart.m.php';

	$page_title = t('Shopping Cart');
	$main_template = 'nocats';
	
	if (isset($custAuth) && $custAuth->isAuth()) {		
		$products = Cart::loadCart($db, $custAuth->customer->val('customer_id'));
		$totals = Cart::loadCartTotals($db, $custAuth->customer->val('customer_id'));		
	} else {
		$messages->add(t('You cannot be logged in'));
	}
	
	$data['products'] = $products;
	$data['totals'] = $totals;