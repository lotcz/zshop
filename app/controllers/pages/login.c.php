<?php
	global $custAuth, $home_dir;
	require_once $home_dir . 'models/cart.m.php';
	
	if (isset($_POST['email'])) {
		$cart_products = null;
		$cart_totals = null;
		
		if ($custAuth->isAuth()) {		
			$cart_products = Cart::loadCart($db, $custAuth->customer->val('customer_id'));
			$cart_totals = Cart::loadCartTotals($db, $custAuth->customer->val('customer_id'));		
		}
		
		if ($custAuth->login($_POST['email'], $_POST['password'])) {
			
			if (isset($cart_totals) && $cart_totals['p'] > 0) {
				foreach ($cart_products as $product) {
					$cart = new Cart($db);
					$cart->data['cart_product_id'] = $product->ival('product_id');
					$cart->data['cart_customer_id'] = $custAuth->customer->ival('customer_id');
					$cart->save();
				}
			} 
			
			redirect(_g('r', 'front'));
			
		} else {
			$messages->error(t('Login incorrect!'));
		}
	}
	
	$page_title	= t('Sign In');