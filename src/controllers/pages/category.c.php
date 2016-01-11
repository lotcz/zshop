<?php
	require_once '../models/category.m.php';
	require_once '../models/product.m.php';
	
	global $db, $data;
	
	$category = new Category($db, $path[1]);
	$category->loadChildren();
	$data['category'] = $category;
	$page_title = t($category->val('category_name'));
	
	$sorting = isset($_GET['o']) ? ucfirst($_GET['o']) : 'Price';
	$dir = (isset($_GET['d']) && (strtolower($_GET['d']) == 'asc')) ? '' : 'DESC';
	
	switch ($sorting) {
		case 'Popularity' :
			$orderby = 'product_stock ' . $dir;
			break;
		case 'Alphabet' : 
			$orderby = 'product_name ' . $dir;
			break;
		default:
			$orderby = 'product_price ' . $dir;
	}
	
	$products = Product::select(
	/* db */		$db, 
	/* table */		'viewProducts', 
	/* where */		'product_category_category_id = ?',
	/* bindings */	[ $category->val('category_id') ],
	/* types */		'i',
	/* paging */	new Paging(10),
	/* orderby */	$orderby
	);
	
	$data['products'] = $products;