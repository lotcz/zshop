<?php
	require_once '../models/product.m.php';
	
	$page_title	= t('Products');
	
	$paging = Paging::getFromUrl();
	$search = isset($_GET['s']) ? $_GET['s'] : '';
	
	$where = null;
	$bindings = null;
	$types = null;
	
	if (strlen($search) > 0) {
		$where = 'product_name LIKE ?';
		$bindings = [ '%' . $search . '%' ];
		$types = 's';
	}
	
	$products = Product::select(
		/* db */		$db, 
		/* table */		'viewProducts', 
		/* where */		$where,
		/* bindings */	$bindings,
		/* types */		$types,
		/* paging */	$paging,
		/* orderby */	'product_name'
	);
	
	$data['products'] = $products;