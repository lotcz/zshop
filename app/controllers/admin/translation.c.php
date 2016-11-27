<?php	
	require_once $home_dir . 'models/language.m.php';
	require_once $home_dir . 'models/translation.m.php';
	require_once $home_dir . 'classes/forms.php';

	$form = new AdminForm('translation');
	$page_template = 'admin/form';

	$form->add([
		[
			'name' => 'translation_language_id',
			'label' => 'Language',
			'type' => 'select',
			'select_table' => 'languages',
			'select_data' => Language::all($db),
			'select_id_field' => 'language_id',
			'select_label_field' => 'language_name'
		],
		[
			'name' => 'translation_name',
			'label' => 'Name',
			'type' => 'text',
			'validations' => [
				['type' => 'length', 'param' => 1],
				['type' => 'maxlen', 'param' => 255]
			]
		],
		[
			'name' => 'translation_translation',
			'label' => 'Translation',
			'type' => 'text',
			'validations' => [
				['type' => 'length', 'param' => 1]
			]
		]
	]);
	
	Translation::process($db, $form);	