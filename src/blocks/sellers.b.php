<div class="row top-sellers">
	<?php
		require_once '../models/product.m.php';
		global $db, $messages;
		
		$sellers = Product::select(
		/* db */		$db, 
		/* table */		'viewProducts', 
		/* where */		null,
		/* bindings */	null,
		/* types */		null,
		/* paging */	new Paging(4),
		/* orderby */	'RAND()'
		);
		
		foreach ($sellers as $product) {
			renderPartial('prod-prev', $product);
		}
		
	?>
</div>