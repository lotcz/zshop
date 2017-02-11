<?php
	global $db, $messages, $home_dir, $globals, $path, $custAuth;
	require_once $home_dir . 'models/cart.m.php';
	require_once $home_dir . 'models/delivery_type.m.php';
	require_once $home_dir . 'models/payment_type.m.php';
	require_once $home_dir . 'models/currency.m.php';
	require_once $home_dir . 'models/order.m.php';

	$render_page = true;
	
	if (isPost()) {		
		$order = Order::createOrder($db, $custAuth->customer);
		if ($order) {
			redirect(sprintf('order/%s',$order->val('order_id')));
			$render_page = false;			
		}
	}

	if ($render_page) {
		$page_title = t('Confirm order');
		$main_template = 'nocats';

		$products = Cart::loadCart($db, $custAuth->customer->val('customer_id'));
		$totals = Cart::loadCartTotals($db, $custAuth->customer->val('customer_id'));
		
		$total_cart_value = $totals['p'];
		
		$delivery_type = new DeliveryType($db, $custAuth->customer->val('customer_delivery_type_id'));	
		$payment_type = new PaymentType($db, $custAuth->customer->val('customer_payment_type_id'));
			
		$currency = Currency::getSelectedCurrency($db);
		$total_order_value = $currency->format($currency->convert($total_cart_value) + $currency->convert($delivery_type->fval('delivery_type_price')) + $currency->convert($payment_type->fval('payment_type_price')));
	
	}