<?php
	require_once $home_dir . 'classes/paging.php';
	require_once $home_dir . 'models/product.m.php';
	global $db, $data;
	$page_title = t('Search Results');
	$search = _g('search');
	$paging = Paging::getFromUrl();
	
	if (isset($search)) {
		$search_results = Product::select(
			$db, 
			'viewProducts', 
			'product_name LIKE ?',
			['%' . $search . '%'],
			's',
			$paging,
			'product_name'
		);
		$data['search_results'] = $search_results;		
	}
	
	$data['paging'] = $paging;	