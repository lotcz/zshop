<?php
	require_once $home_dir . 'classes/paging.php';
	require_once $home_dir . 'models/category.m.php';
	require_once $home_dir . 'models/product.m.php';
	
	global $db, $data;
	
	$categories_tree = Category::getCategoryTree($db);
	$category = $categories_tree->findInChildren(intval($path[1]));
	
	if (!isset($category)) {
		redirect('notfound');
	}
	
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
	
	$ids = $category->getSubTreeIDs();
	$values = [];
	$types = '';
	foreach ($ids as $id) {
		$values[] = '?';
		$types .= 'i';
	}
	
	$products = Product::select(
	/* db */		$db, 
	/* table */		'viewProducts', 
	/* where */		sprintf('product_category_id IN (%s)', implode(',', $values)),
	/* bindings */	$ids,
	/* types */		$types,
	/* paging */	$paging,
	/* orderby */	$orderby
	);
	
	$data['products'] = $products;
	$data['paging'] = $paging;