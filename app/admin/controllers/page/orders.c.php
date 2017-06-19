<?php
	
	$this->setPageTitle('Orders');	
	$this->renderAdminTable(		
		'viewOrders', 		
		'order',
		[
			[
				'name' => 'order_created',
				'label' => 'Date',
				'type' => 'date'			
			],
			[
				'name' => 'order_state_name',
				'label' => 'Status'			
			],
			[
				'name' => 'customer_name',
				'label' => 'Customer'
			],
			[
				'name' => 'order_payment_code',
				'label' => 'Payment Code'			
			]
		]
	);