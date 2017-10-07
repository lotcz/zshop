<?php
	$product_id = z::getInt('product_id');
	$count = z::getInt('count');
	$action = $this->getPath(-1);

	if (!$this->isCustAuth()) {
		$this->z->custauth->createAnonymousSession();
	}

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
		if ($cart->ival('cart_count') > 0) {
			$cart->save();
		} else {
			$cart->deleteById();
		}
		$data = $this->z->cart->loadCartTotals($customer_id);
		if ($action == 'update') {
			$product = new ProductModel($this->db, $product_id);
			$data['item_price_formatted'] = $this->convertAndFormatMoney($cart->ival('cart_count') * $product->fval('product_price'));
		}
		$data['product_id'] = $product_id;
		$this->setData('json', $data);
	} else {
		$this->message('Cannot authenticate customer!', 'error');
	}
