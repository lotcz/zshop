<?php
	require_once '../models/category.m.php';
	require_once '../models/product.m.php';
	
	global $db, $data;
	
	$category = new Category($db, $path[1]);
	$category->loadChildren();
	$data['category'] = $category;
	$page_title = t($category->val('category_name'));
	
	$products = Product::select(
	/* db */		$db, 
	/* table */		'viewProducts', 
	/* where */		'product_category_category_id = ?',
	/* bindings */	[ $category->val('category_id') ],
	/* types */		'i',
	/* paging */	null,
	/* orderby */	'product_name'
	);
	
	$data['products'] = $products;