<?php

	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Roles');
	$page = 'admin/table';
	
	$table = new AdminTable(
		'roles', 		
		'role'
	);
	
	$table->add([		
		[
			'name' => 'role_name',
			'label' => 'Name'			
		],
		[
			'name' => 'role_description',
			'label' => 'Description'
		]
	]);
	
	$table->prepare($db);