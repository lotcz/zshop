<?php
	
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Delivery types');
	$page = 'admin/table';
	
	$table = new AdminTable(
		'delivery_types', 		
		'delivery_type'
	);
	
	$table->add([		
		[
			'name' => 'delivery_type_name',
			'label' => 'Name'			
		]
	]);
	
	$table->prepare($db);