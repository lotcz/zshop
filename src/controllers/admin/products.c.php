<?php
	require_once '../models/product.m.php';
	
	$page_title	= t('Products');
	
	$paging = Paging::getFromUrl();
	$search = isset($_GET['s']) ? $_GET['s'] : '';
	$data['search'] = $search;
	
	$where = null;
	$bindings = null;
	$types = null;
	
	if (strlen($search) > 0) {
		$where = 'product_name LIKE ?';
		$bindings = [ '%' . $search . '%' ];
		$types = 's';
		$paging->filter = $search;
	}
	
	$products = Product::select(
		/* db */		$db, 
		/* table */		'products', 
		/* where */		$where,
		/* bindings */	$bindings,
		/* types */		$types,
		/* paging */	$paging,
		/* orderby */	'product_name'
	);
	
	$data['products'] = $products;
	$data['paging'] = $paging;