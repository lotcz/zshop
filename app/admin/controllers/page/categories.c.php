<?php

	$this->setPageTitle('Categories');	
	$this->renderAdminTable(
		'categories', 		
		'category',
		[		
			[
				'name' => 'category_name',
				'label' => 'Name'			
			],
			[
				'name' => 'category_description',
				'label' => 'Description'			
			]
		]
	);