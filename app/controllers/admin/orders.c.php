<?php
	require_once $home_dir . 'models/order.m.php';
	
	$page_title	= t('Orders');
	
	$paging = Paging::getFromUrl();
	$search = isset($_GET['s']) ? $_GET['s'] : '';
	$data['search'] = $search;
	
	$where = null;
	$bindings = null;
	$types = null;
	
	$orders = Order::select(
		/* db */		$db, 
		/* table */		'viewOrders', 
		/* where */		$where,
		/* bindings */	$bindings,
		/* types */		$types,
		/* paging */	$paging,
		/* orderby */	'order_created'
	);
	
	$data['orders'] = $orders;
	$data['paging'] = $paging;