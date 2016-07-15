<?php
	global $home_dir, $db, $data;
	require_once $home_dir . 'classes/paging.php';
	require_once $home_dir . 'models/category.m.php';
	require_once $home_dir . 'models/product.m.php';
		
	$categories_tree = Category::getCategoryTree($db);
	$category = $categories_tree->findInChildren(intval($path[1]));
	
	if (!isset($category)) {
		redirect('notfound');
	}
	
	$data['category'] = $category;
	$page_title = $category->val('category_name');		
	$paging = Paging::getFromUrl(Product::getSortingItems());
	
	$ids = $category->getSubTreeIDs();
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
		$paging->getOrderBy()
	);
	
	$data['products'] = $products;
	$data['paging'] = $paging;
	$data['ids'] = $ids;