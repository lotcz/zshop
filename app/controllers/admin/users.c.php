<?php

	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Administrators');
	$page = 'admin/table';
	
	$table = new AdminTable(
		'users', 		
		'user'
	);
	
	$table->add([		
		[
			'name' => 'user_login',
			'label' => 'Login'			
		],
		[
			'name' => 'user_email',
			'label' => 'E-mail'			
		],
		[
			'name' => 'user_last_login',
			'label' => 'Last Login'
		]
	]);
	
	$table->prepare($db);