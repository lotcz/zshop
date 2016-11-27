<?php

	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Categories');
	$page_template = 'admin/table';
	
	$table = new AdminTable(
		'categories', 		
		'category'
	);
	
	$table->add([		
		[
			'name' => 'category_name',
			'label' => 'Name'			
		]
	]);
	
	$table->prepare($db);