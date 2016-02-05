<?php
	require_once $home_dir . 'models/product.m.php';
	global $db, $data;
	
	$product = new Product($db, $path[1]);
	if (!$product->is_loaded) {
		redirect('notfound');
	}
	
	$page_title = $product->val('product_name');
		
	$data['product'] = $product;