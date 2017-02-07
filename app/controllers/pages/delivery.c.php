<?php
	global $db, $messages, $home_dir;
	require_once $home_dir . 'models/delivery_type.m.php';
	require_once $home_dir . 'classes/forms.php';
	
	
	$form = new Form('address');

	$form->add([
		[
			'name' => 'delivery_type_id',
			'type' => 'hidden'
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
		]		
	]);

	$render_page = true;
	
	if (isPost()) {
		redirect('payment');
		$render_page = false;
	}
		
	if ($render_page) {
		$page_title = t('Invoicing address');
		$main_template = 'nocats';
		
		$delivery_types = DeliveryType::all($db);
		$selected_delivery = DeliveryType::getDefault($delivery_types);

		$form->prepare($db, $custAuth->customer);
	}