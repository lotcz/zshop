<?php
	global $home_dir, $db;
	require_once $home_dir . 'models/product.m.php';	
	require_once $home_dir . 'classes/paging.php';
		
	$paging = new Paging(_gi('offset'), _gi('limit'));
	$sorting = _g('sorting', 'sortby_Alphabet');
	$orderby = Product::getSorting($sorting);

	$ids = explode(',', _g('category_ids'));
	$values = [];
	$types = '';
	foreach ($ids as $id) {
		$values[] = '?';
		$types .= 'i';
	}
	
	$products = Product::select(
		$db, 
		'viewProducts', 
		sprintf('product_category_id IN (%s)', implode(',', $values)),
		$ids,
		$types,
		$paging,
		$orderby
	);
	
	$data['products'] = $products;
