<?php
	
	require_once $home_dir . 'models/delivery_type.m.php';	
	require_once $home_dir . 'classes/forms.php';

	$form = new AdminForm('delivery_type');
	$page = 'admin/form';

	$form->add([		
		[
			'name' => 'delivery_type_name',
			'label' => 'Name',
			'type' => 'text',
			'validations' => [['type' => 'length', 'param' => 1]]
		],
		[
			'name' => 'delivery_type_price',
			'label' => 'Price',
			'type' => 'text',
			'validations' => [['type' => 'price']]		
		],		
		[
			'name' => 'delivery_type_min_order_cost',
			'label' => 'Min. order cost',
			'type' => 'text',
			'validations' => [['type' => 'price']]		
		]	
	]);
	
	DeliveryType::process($db, $form);