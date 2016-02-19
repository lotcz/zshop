<?php
	require_once $home_dir . 'classes/paging.php';
	require_once $home_dir . 'models/category.m.php';
	require_once $home_dir . 'models/product.m.php';
	
	global $db, $data;
	
	$category = new Category($db, $path[1]);
	if (!$category->is_loaded) {
		redirect('notfound');
	}
	$category->loadChildren();
	$data['category'] = $category;
	$page_title = $category->val('category_name');
	
	$sorting = isset($_GET['o']) ? ucfirst($_GET['o']) : 'sortby_Price';
	$dir = (isset($_GET['d']) && (strtolower($_GET['d']) == 'asc')) ? '' : 'DESC';
	
	switch ($sorting) {
		case 'sortby_Popularity' :
			$orderby = 'product_stock ' . $dir;
			break;
		case 'sortby_Alphabet' : 
			$orderby = 'product_name ' . $dir;
			break;
		default:
			$orderby = 'product_price ' . $dir;
	}
	
	$paging = new Paging(0,12);
	
	$products = Product::select(
	/* db */		$db, 
	/* table */		'viewProductsInCategories', 
	/* where */		'product_category_category_id = ?',
	/* bindings */	[ $category->val('category_id') ],
	/* types */		'i',
	/* paging */	$paging,
	/* orderby */	$orderby
	);
	
	$data['products'] = $products;
	$data['paging'] = $paging;