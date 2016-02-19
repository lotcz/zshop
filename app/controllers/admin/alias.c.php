<?php

	require_once $home_dir . 'models/alias.m.php';
	require_once $home_dir . 'classes/forms.php';
	
	$form = new AdminForm('alias');
	$page = 'admin/form';
	
	$form->add([
		[
			'name' => 'alias_id',
			'label' => 'Alias ID',
			'type' => 'hidden'
		],
		[
			'name' => 'alias_url',
			'label' => 'URL',
			'type' => 'text'
		],
		[
			'name' => 'alias_path',
			'label' => 'Path',
			'type' => 'text'
		]		
		
	]);
	
	if (isset($_POST['alias_id'])) {
		if ($_POST['alias_id'] > 0) {
			$alias = new Alias($db, intval($_POST['alias_id']));
		} else {
			$alias = new Alias($db);
		}
		$alias->setData($form->processInput($_POST));		
		if ($alias->save()) {
			$messages->add('Alias saved');
			//redirect($form->ret);
		}
	} elseif (isset($path[2]) && $path[2] == 'edit') {		
		$alias = new Alias($db, intval($path[3]));
		$page_title	= t('Editing Alias');
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		$alias = new Alias($db);
		$alias->deleteById(intval($path[3]));
		redirect($form->ret);
	} else {
		$alias = new Alias($db);
		$page_title	= t('New Alias');
	}
	
	$form->prepare($db, $alias);
