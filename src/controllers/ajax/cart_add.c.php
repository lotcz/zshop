<?php
	global $home_dir, $db, $custAuth;
	require_once $home_dir . 'models/cart.m.php';	
			
	$product_id = intval(_g('product_id'));
	$count = intval(_g('count'));
	
	if (isset($custAuth) && $custAuth->isAuth()) {
		$cart = new Cart($db);
		$cart->load($product_id, $custAuth->customer_id);
		if ($cart->is_loaded) {			
			$cart->data['cart_count'] = $cart->val('cart_count') + $count;
		} else {
			$cart->data['cart_product_id'] = $product_id;
			$cart->data['cart_customer_id'] = $custAuth->customer_id;
			$cart->data['cart_count'] = $count;
		}		
		$cart->save();	
		$data = Cart::loadCartTotals($db, $custAuth->customer_id);
	}