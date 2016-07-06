<?php
	
	require_once $home_dir . 'models/product.m.php';	
	require_once $home_dir . 'classes/forms.php';

	$form = new AdminForm('product');
	$page = 'admin/form';

	$form->add([
		[
			'name' => 'product_id',
			'type' => 'hidden'
		],
		[
			'name' => 'product_ext_id',
			'label' => 'ABX ID',
			'type' => 'static'
		],		
		[
			'name' => 'product_category_id',
			'label' => 'Category',
			'type' => 'select',
			'select_table' => 'categories',
			'select_id_field' => 'category_id',
			'select_label_field' => 'category_name'
		],
		[
			'name' => 'product_name',
			'label' => 'Name',
			'type' => 'text'
		],
		[
			'name' => 'product_price',
			'label' => 'Price',
			'type' => 'text',
			'validations' => [['type' => 'price']]
		],
		[
			'name' => 'product_description',
			'label' => 'Description',
			'type' => 'static'
		]	
		
	]);
	
	if (isset($_POST['product_id'])) {
		if ($_POST['product_id'] > 0) {
			$product = new Product($db, intval($_POST['product_id']));
		} else {
			$product = new Product($db);
		}
		$product->setData($form->processInput($_POST));
		if ($product->save()) {
			redirect('/admin/products');
		}
	} elseif (isset($path[2]) && $path[2] == 'edit') {		
		$product = new Product($db, intval($path[3]));
		$page_title	= t('Editing Product');
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		$product = new Product($db);
		$product->deleteById(intval($path[3]));
		redirect('/admin/products');
	} else {
		$product = new Product($db);
		$page_title	= t('New Product');
	}
	
	$product->loadVariants();
	
	$form->prepare($db, $product);