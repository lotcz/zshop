<?php
	
	require_once $home_dir . 'models/ip_failed.m.php';
	require_once $home_dir . 'classes/forms.php';

	$form = new AdminForm('ip_failed_attempt');
	$page_template = 'admin/form';

	$form->add([		
		[
			'name' => 'ip_failed_attempt_ip',
			'label' => 'IP',
			'type' => 'text',
			'validations' => [['type' => 'ip']]
		],
		[
			'name' => 'ip_failed_attempt_count',
			'label' => 'Failed Attempts',
			'type' => 'text',
			'validations' => [['type' => 'integer']]
		],
		[
			'name' => 'ip_failed_attempt_first',
			'label' => 'First',
			'type' => 'date',
			'hint' => 'Date of the first failed attempt.',
			'validations' => [['type' => 'date']]
		],
		[
			'name' => 'ip_failed_attempt_last',
			'label' => 'Last',
			'type' => 'date',
			'hint' => 'Date of the last failed attempt.',
			'validations' => [['type' => 'date']]
		]		
	]);
	
	IpFailedAttempt::process($db, $form);	