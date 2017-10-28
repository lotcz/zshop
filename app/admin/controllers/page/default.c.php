<?php

	$this->setPageTitle('Admin dashboard');

	$pending_orders = zModel::select(
		$this->db,
		'viewOrders',
		'order_state_closed = 0'
	);

	$this->setData('pending_orders', $pending_orders);
