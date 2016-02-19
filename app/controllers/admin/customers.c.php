<?php
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Customers');
		
	$table = new AdminTable(
		'customers', 		
		'customer'
	);
	$table->new_link_label = t('New Customer');
	
	$table->add([		
		[
			'name' => 'customer_name',
			'label' => 'Name'			
		],
		[
			'name' => 'customer_email',
			'label' => 'E-mail'			
		],
		[
			'name' => 'customer_failed_attempts',
			'label' => 'Failed Logins'
		]		
	]);
	
	$table->prepare($db);
	