<?php
	require_once $home_dir . 'models/translation.m.php';
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Translations');
	$page = 'admin/table';
	
	$table = new AdminTable(
		'translations', 		
		'translation'
	);
	
	$table->addLink('admin/trans_import', 'Import');
	
	$table->add([		
		[
			'name' => 'translation_name',
			'label' => 'Name'		
		],
		[
			'name' => 'translation_translation',
			'label' => 'Translation'			
		]	
	]);
	
	$table->prepare($db);