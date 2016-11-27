<?php

	require_once $home_dir . 'models/alias.m.php';
	require_once $home_dir . 'classes/forms.php';
	
	$form = new AdminForm('alias');
	$page_template = 'admin/form';
	
	$form->add([		
		[
			'name' => 'alias_url',
			'label' => 'URL',
			'type' => 'text',
			'validations' => [['type' => 'length', 'param' => 1]]
		],
		[
			'name' => 'alias_path',
			'label' => 'Path',
			'type' => 'text',
			'validations' => [['type' => 'length', 'param' => 1]]
		]		
		
	]);
	
	Alias::process($db, $form);