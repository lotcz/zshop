<?php
	
	require_once $home_dir . 'models/currency.m.php';
	require_once $home_dir . 'classes/forms.php';

	$form = new AdminForm('currency');
	$page = 'admin/form';

	$form->add([
		[
			'name' => 'currency_id',
			'type' => 'hidden'
		],
		[
			'name' => 'currency_name',
			'label' => 'Name',
			'type' => 'text'
		],
		[
			'name' => 'currency_format',
			'label' => 'Format',
			'type' => 'text'
		],
		[
			'name' => 'currency_value',
			'label' => 'Value',
			'type' => 'text',
			'validations' => [
				['type' => 'price'],
				['type' => 'min', 'param' => 0.000001],
			]
		],
		[
			'name' => 'currency_decimals',
			'label' => 'Value',
			'type' => 'text',
			'validations' => [['type' => 'integer', 'message' => 'Enter whole integer number.']]
		]
		
	]);
	
	if (isset($_POST['currency_id'])) {
		$currency = new Currency($db, $_POST['currency_id']);
		$currency->setData($form->processInput($_POST));	
		$currency->save();
		redirect('/admin/currencies');
	} elseif (isset($path[2]) && $path[2] == 'edit') {
		$currency = new Currency($db, $path[3]);
		$page_title	= t('Editing Currency');
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		Currency::del($path[3]);
		redirect('/admin/currencies');
	} else {
		$currency = new Currency($db);
		$page_title	= t('Add Currency');
	}
	
	$form->prepare($db, $currency);