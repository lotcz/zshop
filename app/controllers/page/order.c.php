<?php
	require_once $home_dir . 'models/order.m.php';	
	
	$order = new Order($db, $path[1]);
	if (!$order->is_loaded) {
		redirect('notfound');
	}
	
	$page_title = t('Order');