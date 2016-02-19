<?php

	require_once $home_dir . 'models/order.m.php';
	require_once $home_dir . 'classes/forms.php';
	
	$form = new AdminForm('order');

	$form->add([
		[
			'name' => 'order_id',
			'label' => 'Order ID',
			'type' => 'hidden'
		],
		[
			'name' => 'order_created',
			'label' => 'Date',
			'type' => 'static',
			'disabled' => 'disabled'
		],
		[
			'name' => 'order_order_state_id',
			'label' => 'Status',
			'type' => 'select',
			'select_table' => 'order_states',
			'select_id_field' => 'order_state_id',
			'select_label_field' => 'order_state_name'
		],
		[
			'name' => 'order_customer_id',
			'label' => 'Customer',
			'type' => 'foreign_key_link',
			'link_table' => 'customers',
			'link_template' => '/admin/customer/edit/%d',
			'link_id_field' => 'customer_id',
			'link_label_field' => 'customer_name'
		],
		[
			'name' => 'order_payment_code',
			'label' => 'Payment Code',
			'type' => 'text',
			'disabled' => 'disabled'
		],
		[
			'name' => 'order_ship_name',
			'label' => 'Name',
			'type' => 'text',
			'validations' => [['type' => 'length', 'param' => 1]]
		],
		[
			'name' => 'order_ship_city',
			'label' => 'City',
			'type' => 'text'		
		],
		[
			'name' => 'order_ship_street',
			'label' => 'Street',
			'type' => 'text'			
		],
		[
			'name' => 'order_ship_zip',
			'label' => 'ZIP',
			'type' => 'text'			
		],
		
	]);
	
	if (isset($_POST['order_id'])) {
		if ($_POST['order_id'] > 0) {
			$order = new Order($db, intval($_POST['order_id']));
		} else {
			$order = new Order($db);
		}
		$order->setData($form->processInput($_POST));		
		if ($order->save()) {
			$messages->add('Order saved');
			//redirect($form->ret);
		}
	} elseif (isset($path[2]) && $path[2] == 'edit') {		
		$order = new Order($db, intval($path[3]));
		$page_title	= t('Editing Order');
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		$order = new Order($db);
		$order->deleteById(intval($path[3]));
		redirect($form->ret);
	} else {
		$order = new Order($db);
		$page_title	= t('New Order');
	}
	
	$form->prepare($db, $order);
