<?php
	global $db, $messages, $home_dir;
	require_once $home_dir . 'models/delivery_type.m.php';
	require_once $home_dir . 'models/payment_type.m.php';
		
	$selected_delivery = new DeliveryType($db, $custAuth->val('customer_delivery_type_id'));
	if (!isset($selected_delivery)) {
		redirect('delivery');
	}

	$payment_types = $selected_delivery->loadAllowedPaymentTypes();	
	$selected_payment = PaymentType::find($payment_types, 'payment_type_id', $custAuth->val('customer_payment_type_id'));
	
	if (!isset($selected_payment)) {
		$selected_payment = $payment_types[0];
	}
	
	$render_page = true;
	
	if (isPost()) {
		$customer = new Customer($db);
		$customer->data['customer_id'] = $custAuth->val('customer_id');
		$customer->data['customer_payment_type_id'] = _g('payment_type_id');		
		if ($customer->save()) {
			redirect('confirm');
			$render_page = false;			
		}
	}

	if ($render_page) {
		$page_title = t('Payment Type');
		$main_template = 'nocats';		
	}