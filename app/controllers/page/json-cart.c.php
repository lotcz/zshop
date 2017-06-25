<?php
	$product_id = intval(get('product_id'));
	$count = intval(get('count'));
	$action = $this->getPath(-1);
	
	if ($this->isCustAuth()) {
		$cart = new CartModel($this->db);
		$customer_id = $this->z->custauth->customer->ival('customer_id');
		$cart->load($product_id, $customer_id);
		if ($cart->is_loaded) {
			if ($action == 'add') {
				$cart->data['cart_count'] = $cart->ival('cart_count') + $count;
			} elseif ($action == 'update') {
				$cart->data['cart_count'] = $count;
			}
		} else {
			$cart->data['cart_product_id'] = $product_id;
			$cart->data['cart_customer_id'] = $customer_id;
			$cart->data['cart_count'] = $count;
		}
		if ($cart->val('cart_count') > 0) {
			$cart->save();
		} else {
			$cart->deleteById();
		}
		$data = $this->z->cart->loadCartTotals($customer_id);
		if ($action == 'update') {
			$data['ii'] = $product_id;
			$product = new ProductModel($this->db, $product_id);
			$data['ip'] = $this->formatMoney($cart->ival('cart_count') * $product->fval('product_price'));
		}
		$this->setData('json', $data);
	} else {
		echo 'Cannot authenticate customer';
	}