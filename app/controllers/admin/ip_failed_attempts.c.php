<?php
	
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Failed Attempts');
	$page = 'admin/table';
	
	$table = new AdminTable(
		'ip_failed_attempts', 		
		'ip_failed_attempt'
	);
	
	$table->add([		
		[
			'name' => 'ip_failed_attempt_ip',
			'label' => 'IP',
		],
		[
			'name' => 'ip_failed_attempt_count',
			'label' => 'Counter'			
		],
		[
			'name' => 'ip_failed_attempt_first',
			'label' => 'First failed attempt'
		],
		[
			'name' => 'ip_failed_attempt_last',
			'label' => 'Last failed attempt'			
		]
	]);
	
	$table->prepare($db);