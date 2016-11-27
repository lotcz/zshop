<?php
		
	require_once $home_dir . 'models/customer.m.php';
	require_once $home_dir . 'classes/forms.php';

	$form = new AdminForm('customer');
	$page_template = 'admin/form';

	$form->add([
		[
			'name' => 'customer_created',
			'label' => 'Date',
			'type' => 'static'
		],
		[
			'name' => 'customer_last_access',
			'label' => 'Last visited',
			'type' => 'static'
		],
		[
			'name' => 'customer_deleted',
			'label' => 'Deleted',
			'type' => 'bool'
		],
		[
			'name' => 'customer_anonymous',
			'label' => 'Anonymous',
			'type' => 'bool'
		],
		[
			'label' => 'Login',
			'type' => 'begin_group'
		],
		[
			'name' => 'customer_email',
			'label' => 'E-mail',
			'type' => 'text',
			'validations' => [['type' => 'email']]
		],
		[
			'name' => 'customer_password',
			'label' => 'Password',
			'type' => 'password',
			'validations' => [['type' => 'password']]
		],
		[
			'name' => 'customer_password_confirm',
			'label' => 'Confirm Password',
			'type' => 'password',
			'validations' => [['type' => 'confirm', 'param' => 'customer_password']]
		],
		[
			'type' => 'end_group'
		],
		[
			'label' => 'Address',
			'type' => 'begin_group'
		],		
		[
			'name' => 'customer_name',
			'label' => 'Name',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_address_city',
			'label' => 'City',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_address_street',
			'label' => 'Street with house n.',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_address_zip',
			'label' => 'ZIP',
			'type' => 'text',
			'validations' => [
				['type' => 'integer', 'param' => true]
			]
		],
		[
			'type' => 'end_group'
		],
		[
			'label' => 'Shipping Address',
			'type' => 'begin_group'
		],
		[
			'name' => 'customer_ship_name',
			'label' => 'Name',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_ship_city',
			'label' => 'City',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_ship_street',
			'label' => 'Street',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_ship_zip',
			'label' => 'ZIP',
			'type' => 'text',
			'validations' => [
				['type' => 'integer', 'param' => true]
			]
		],
		[
			'type' => 'end_group'
		],		
		[
			'name' => 'customer_failed_attempts',
			'label' => 'Failed attempts',
			'type' => 'text',
			'validations' => [['type' => 'integer']]
		],
		
		[
			'name' => 'customer_delivery_type_id',
			'label' => 'Delivery Type',
			'type' => 'select',
			'select_table' => 'delivery_types',
			'select_id_field' => 'delivery_type_id',
			'select_label_field' => 'delivery_type_name'
		],  
		[
			'name' => 'customer_payment_type_id',
			'label' => 'Payment Type',
			'type' => 'select',
			'select_table' => 'payment_types',
			'select_id_field' => 'payment_type_id',
			'select_label_field' => 'payment_type_name'
		]
		
	]);
		
	if (isset($_POST['customer_id'])) {
		if ($_POST['customer_id'] > 0) {
			$customer = new Customer($db, $_POST['customer_id']);
		} else {
			$customer = new Customer($db);
		}
		$customer->setData($form->processInput($_POST));
		unset($customer->data['customer_password']);		
		unset($customer->data['customer_password_confirm']);		
		if (isset($_POST['customer_password']) && strlen($_POST['customer_password']) > 0) {
			$customer->data['customer_password_hash'] = CustomerAuthentication::hashPassword($_POST['customer_password']);
		}
		if ($customer->save()) {
			redirect(_g('r','/admin/customers'));
		}
	} elseif (isset($path[2]) && $path[2] == 'edit') {		
		$customer = new Customer($db, $path[3]);
		$page_title	= t('Editing Customer');
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		if (Customer::del($db, $path[3])) {
			redirect(_g('r', '/admin/customers'));
		}
	} else {
		$customer = new Customer($db);
		$page_title	= t('New Customer');
	}
	
	$form->prepare($db, $customer);