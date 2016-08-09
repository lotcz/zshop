<?php
	global $db, $messages, $home_dir, $globals, $path, $custAuth;
	require_once $home_dir . 'models/cart.m.php';
	require_once $home_dir . 'models/delivery_type.m.php';
	require_once $home_dir . 'models/payment_type.m.php';
	require_once $home_dir . 'models/currency.m.php';
	$page_title = t('Order');

	$products = Cart::loadCart($db, $custAuth->customer->val('customer_id'));
	$totals = Cart::loadCartTotals($db, $custAuth->customer->val('customer_id'));
	
	$total_cart_value = $totals['p'];
	
	$delivery_types = DeliveryType::all($db);
	$delivery_type = DeliveryType::find($delivery_types, 'delivery_type_id', _g('delivery_type_id'));
	if (!isset($delivery_type)) {
		$delivery_type = DeliveryType::getDefault($delivery_types);
	}
	
	$payment_types = PaymentType::all($db);
	$payment_type = PaymentType::find($payment_types, 'payment_type_id', _g('payment_type_id'));
	if (!isset($payment_type)) {
		$payment_type = PaymentType::getDefault($payment_types);
	}

	$currency = Currency::getSelectedCurrency($db);
	$total_order_value = $total_cart_value + $currency->convert($delivery_type->fval('delivery_type_price')) + $currency->convert($delivery_type->fval('payment_type_price'));