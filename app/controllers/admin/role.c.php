<?php
	
	require_once $home_dir . 'models/role.m.php';	
	require_once $home_dir . 'classes/forms.php';

	$form = new AdminForm('role');
	$page = 'admin/form';

	$form->add([		
		[
			'name' => 'role_name',
			'label' => 'Name',
			'type' => 'text',
			'validations' => [['type' => 'length', 'param' => 1]]
		],
		[
			'name' => 'role_description',
			'label' => 'Description',
			'type' => 'text'			
		]		
	]);
	
	Role::process($db, $form);