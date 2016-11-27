<?php
	require_once $home_dir . 'models/translation.m.php';
	require_once $home_dir . 'classes/tables.php';
	
	$page_title	= t('Translations');
	$page_template = 'admin/table';
	
	$table = new AdminTable(
		'viewTranslations', 		
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
		],
		[
			'name' => 'language_name',
			'label' => 'Language'			
		]
	]);
	
	$table->prepare($db);