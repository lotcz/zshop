<?php
	
	require_once '../models/customer.m.php';
	
	global $db;
	
	if (isset($_POST['customer_id'])) {
		if ($_POST['customer_id'] > 0) {
			$customer = new Customer($db, $_POST['customer_id']);
		} else {
			$customer = new Customer($db);
		}
		$customer->setData($_POST);		
		if (isset($_POST['user_password']) && strlen($_POST['user_password']) > 0) {
			$user->user_password_hash = Authentication::hashPassword($_POST['user_password']);
		}
		$customer->save();
		redirect('/admin/customers');
	} elseif (isset($path[2]) && $path[2] == 'edit') {		
		$customer = new Customer($db, $path[3]);		
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		$customer = new Customer($db);
		$customer->deleteById($path[3]);
		redirect('/admin/customers');
	} else {
		$customer = new Customer($db);
	}
	
	$data = $customer;