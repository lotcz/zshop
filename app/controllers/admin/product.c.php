<?php
	
	require_once $home_dir . 'models/product.m.php';	
	require_once $home_dir . 'models/category.m.php';	
	require_once $home_dir . 'classes/forms.php';

	$form = new AdminForm('product');
	$page = 'admin/form';

	$form->add([
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
			'select_data' => Category::getTreeForSelect($db),
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
	
	Product::process($db, $form);