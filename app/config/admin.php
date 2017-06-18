<?php
	
	return [
		
		'menu' => [
			['admin/products','Products'],
			['admin/orders','Orders'],
			['admin/customers','Customers'],
			[
				[
					['admin/categories','Categories'],
					['admin/currencies', 'Currencies'],
					['admin/payment_types', 'Payment types'],
					['admin/delivery_types', 'Delivery types']
				],
				'More...'
			]
		]
		
	];