<?php
	global $db, $messages, $home_dir;
	require_once $home_dir . 'models/product.m.php';
	require_once $home_dir . 'classes/paging.php';
			
	$sellers = Product::select(
	/* db */		$db, 
	/* table */		'viewProducts', 
	/* where */		null,
	/* bindings */	null,
	/* types */		null,
	/* paging */	new Paging(0,4),
	/* orderby */	'RAND()'
	);
	
?>
<div class="row top-sellers products">
	<?php
		
		foreach ($sellers as $product) {
			renderPartial('prod-prev', $product);
		}
		
	?>
</div>