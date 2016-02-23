<?php
	
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Products');
	$page = 'admin/table';
	
	$table = new AdminTable(
		'viewProducts', 		
		'product'
	);
	
	$table->add([		
		[
			'name' => 'product_id',
			'label' => 'ID'			
		],
		[
			'name' => 'product_name',
			'label' => 'Name'			
		],
		[
			'name' => 'category_name',
			'label' => 'Category'
		]
	]);
	
	$table->prepare($db);