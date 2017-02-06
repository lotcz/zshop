<?php
	global $db, $messages, $home_dir;
	require_once $home_dir . 'models/delivery_type.m.php';
			
	$delivery_types = DeliveryType::all($db);
	$selected_delivery = DeliveryType::getDefault($delivery_types);
	
	require_once $home_dir . 'classes/forms.php';

	$form = new Form('address');
	
	$form->add([		
		[
			'name' => 'currency_name',
			'label' => 'Name',
			'type' => 'text',
			'validations' => [
				['type' => 'length', 'param' => 1],
			]
		],
		[
			'name' => 'currency_format',
			'label' => 'Street',
			'type' => 'text',
			'hint' => 'This specifies how prices will be displayed in this currency. Put token %s where you want amount to be.'
		],
		[
			'name' => 'currency_value',
			'label' => 'City',
			'type' => 'text',
			'hint' => 'Put value 1 for default currency.',
			'validations' => [
				['type' => 'price'],
				['type' => 'min', 'param' => 0],
			]
		],
		[
			'name' => 'currency_decimals',
			'label' => 'Country',
			'type' => 'text',
			'hint' => 'This specifies how many decimal places will be displayed for prices in this currency.',
			'validations' => [['type' => 'integer']]
		]
		
	]);
	