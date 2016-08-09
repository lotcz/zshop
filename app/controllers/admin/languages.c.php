<?php
	
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Languages');
	$page = 'admin/table';
	
	$table = new AdminTable(
		'languages', 		
		'language'
	);
	
	$table->add([		
		[
			'name' => 'language_name',
			'label' => 'Name'		
		],
		[
			'name' => 'language_code',
			'label' => 'Code'			
		]
	]);
	
	$table->prepare($db);