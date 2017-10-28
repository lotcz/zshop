<?php

	$this->setPageTitle('Products');
	$this->renderAdminTable(
		'viewProducts',
		'product',
		[
			[
				'name' => 'product_id',
				'label' => 'ID'
			],
			[
				'name' => 'product_name',
				'label' => 'Name'
			],
			[
				'name' => 'category_name',
				'label' => 'Category'
			]
		],
		[
			[
				'name' => 'search_text',
				'label' => 'Search',
				'type' => 'text',
				'filter_fields' => ['product_name', 'product_description']
			]
		]
	);
