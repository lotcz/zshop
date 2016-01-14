<div class="panel panel-default">
<?php

	global $db, $home_dir, $globals, $path, $custAuth;
	require_once $home_dir . 'models/product.m.php';
	
	if (isset($custAuth) && $custAuth->isAuth()) {
		$totals = Product::loadCartTotals($db, $custAuth->customer->val('customer_id'));
		?>
			<div class="panel-body">
				<?=$totals['total_price']?>
				<?=$totals['total_count']?>
				<?=$custAuth->customer->val('customer_email')?>
			</div>
		<?php		
	} else {	
		renderLink('/login', t('Sign In'), '');
	}
	
?>
</div>