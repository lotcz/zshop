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
	
	if (isset($_POST['role_id'])) {
		if ($_POST['role_id'] > 0) {
			$role = new Role($db, intval($_POST['role_id']));
		} else {
			$role = new Role($db);
		}
		$role->setData($form->processInput($_POST));
		if ($role->save()) {
			redirect('/admin/roles');
		}
	} elseif (isset($path[2]) && $path[2] == 'edit') {		
		$role = new Role($db, intval($path[3]));
		$page_title	= t('Editing role');
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		$role = new Role($db);
		$role->deleteById(intval($path[3]));
		redirect('/admin/roles');
	} else {
		$role = new Role($db);
		$page_title	= t('New Role');
	}
		
	$form->prepare($db, $role);