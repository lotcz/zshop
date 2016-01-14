<?php
	
	global $db, $home_dir;
	require_once $home_dir . 'models/customer.m.php';
	require_once $home_dir . 'classes/custauth.php';
		
	if (isset($_POST['customer_id'])) {
		if ($_POST['customer_id'] > 0) {
			$customer = new Customer($db, $_POST['customer_id']);
		} else {
			$customer = new Customer($db);
		}
		$customer->setData($_POST);
		unset($customer->data['customer_password']);		
		if (isset($_POST['customer_password']) && strlen($_POST['customer_password']) > 0) {
			$customer->data['customer_password_hash'] = CustomerAuthentication::hashPassword($_POST['customer_password']);
		}
		$customer->save();
		redirect('/admin/customers');
	} elseif (isset($path[2]) && $path[2] == 'edit') {		
		$customer = new Customer($db, $path[3]);
		$page_title	= t('Editing Customer');
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		$customer = new Customer($db);
		$customer->deleteById($path[3]);
		redirect('/admin/customers');
	} else {
		$customer = new Customer($db);
		$page_title	= t('New Customer');
	}
	
	$data = $customer;