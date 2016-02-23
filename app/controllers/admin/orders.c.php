<?php
	
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Orders');
	$page = 'admin/table';
	
	$table = new AdminTable(
		'viewOrders', 		
		'order'
	);
	
	$table->add([		
		[
			'name' => 'order_created',
			'label' => 'Date',
			'type' => 'date'			
		],
		[
			'name' => 'order_state_name',
			'label' => 'Status'			
		],
		[
			'name' => 'customer_name',
			'label' => 'Customer'
		],
		[
			'name' => 'order_payment_code',
			'label' => 'Payment Code'			
		]
	]);
	
	$table->prepare($db);