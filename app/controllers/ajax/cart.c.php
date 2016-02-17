<?php
	global $home_dir, $db, $custAuth;
	require_once $home_dir . 'models/cart.m.php';	
			
	$product_id = intval(_g('product_id'));
	$count = intval(_g('count'));
	$action = $path[2];
	
	if (isset($custAuth) && $custAuth->isAuth()) {
		$cart = new Cart($db);
		$cart->load($product_id, $custAuth->customer_id);
		if ($cart->is_loaded) {
			if ($action == 'add') {
				$cart->data['cart_count'] = $cart->val('cart_count') + $count;
			} elseif ($action == 'update') {
				$cart->data['cart_count'] = $count;
			}
		} else {
			$cart->data['cart_product_id'] = $product_id;
			$cart->data['cart_customer_id'] = $custAuth->customer_id;
			$cart->data['cart_count'] = $count;
		}
		if ($cart->val('cart_count') > 0) {
			$cart->save();
		} else {
			$cart->deleteById();
		}
		$data = Cart::loadCartTotals($db, $custAuth->customer_id);
		if ($action == 'update') {
			$data['ii'] = $product_id;
			$product = new Product($db, $product_id);
			$data['ip'] = formatPrice($cart->ival('cart_count') * $product->ival('product_price'));
		}
	} else {
		echo 'Cannot authenticate customer';
	}