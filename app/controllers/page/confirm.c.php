<?php
	$customer = $this->getCustomer();
	$render_page = true;
	
	if (isPost()) {		
		$order = OrderModel::createOrder($this->db, $customer);
		if ($order) {
			$this->redirect(sprintf('order/%s', $order->val('order_id')));
			$render_page = false;			
		}
	}

	if ($render_page) {
		$this->setPageTitle('Confirm order');
		$this->setMainTemplate('nocats');
	
		$this->setData('products', $this->z->cart->loadCartProducts());

		$delivery_type = new DeliveryTypeModel($this->db, $customer->val('customer_delivery_type_id'));
		$this->setData('delivery_type', $delivery_type);
		$payment_type = new PaymentTypeModel($this->db, $customer->val('customer_payment_type_id'));			
		$this->setData('payment_type', $payment_type);
		$total_cart_value = $this->getData('cart_totals')['total_cart_price'];
		$this->setData('total_cart_value', $total_cart_value);
		$this->setData('total_order_value_formatted', $this->formatMoney($this->convertMoney($total_cart_value) + $this->convertMoney($delivery_type->fval('delivery_type_price')) + $this->convertMoney($payment_type->fval('payment_type_price'))));
	
	}