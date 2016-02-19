<?php
	
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Aliases');
	$page = 'admin/table';
	
	$table = new AdminTable(
		'aliases', 		
		'alias'
	);
	
	$table->add([		
		[
			'name' => 'alias_url',
			'label' => 'URL'			
		],
		[
			'name' => 'alias_path',
			'label' => 'Path'
		],
	]);
	
	$table->prepare($db);