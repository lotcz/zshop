<?php

	$this->setPageTitle('Admin dashboard');

	$pending_orders = zModel::select(
		$this->db,
		'viewOrders',
		'order_state_closed = 0'
	);

	if (count($pending_orders) > 0) {
		$pending_orders_table = new zTable('pending_orders', 'order_id', 'admin/default/default/order/edit/%d');
		$pending_orders_table->add([
		    [
		      'name' => 'order_created',
		      'label' => 'Date',
		      'type' => 'date'
		    ],
		    [
		      'name' => 'order_state_name',
		      'label' => 'Status',
					'type' => 'localized'
		    ],
		    [
		      'name' => 'customer_name',
		      'label' => 'Customer'
		    ],
		    [
		      'name' => 'order_payment_code',
		      'label' => 'Payment Code'
		    ]
		  ]);
			$pending_orders_table->data = $pending_orders;
	} else {
		$pending_orders_table = null;
	}

	$this->setData('pending_orders_count', count($pending_orders));
	$this->setData('pending_orders_table', $pending_orders_table);
