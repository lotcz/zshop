<?php
	global $db, $messages, $home_dir;
	require_once $home_dir . 'models/payment_type.m.php';
			
	$payment_types = PaymentType::all($db);
	$selected_payment = PaymentType::getDefault($payment_types);
