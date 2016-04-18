<?php
	
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Payment types');
	$page = 'admin/table';
	
	$table = new AdminTable(
		'payment_types', 		
		'payment_type'
	);
	
	$table->add([		
		[
			'name' => 'payment_type_name',
			'label' => 'Name'			
		]
	]);
	
	$table->prepare($db);