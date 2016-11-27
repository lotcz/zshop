<?php
	
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Delivery types');
	$page_template = 'admin/table';
	
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