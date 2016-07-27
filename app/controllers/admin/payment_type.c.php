<?php
	
	require_once $home_dir . 'models/payment_type.m.php';	
	require_once $home_dir . 'classes/forms.php';

	$form = new AdminForm('payment_type');
	$page = 'admin/form';

	$form->add([		
		[
			'name' => 'payment_type_name',
			'label' => 'Name',
			'type' => 'text',
			'validations' => [['type' => 'length', 'param' => 1]]
		],
		[
			'name' => 'payment_type_price',
			'label' => 'Price',
			'type' => 'text',
			'validations' => [['type' => 'price']]		
		],		
		[
			'name' => 'payment_type_min_order_cost',
			'label' => 'Min. order cost',
			'type' => 'text',
			'validations' => [['type' => 'price']]		
		],
		[
			'name' => 'payment_type_is_default',
			'label' => 'Is Default',
			'type' => 'bool'			
		]			
	]);
	
	PaymentType::process($db, $form);