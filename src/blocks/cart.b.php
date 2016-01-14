<div class="panel panel-default">
<?php

	global $db, $home_dir, $globals, $path, $custAuth;
	require_once $home_dir . 'models/cart.m.php';
	
	if (isset($custAuth) && $custAuth->isAuth()) {
		$totals = Cart::loadCartTotals($db, $custAuth->customer->val('customer_id'));
		?>
			<div class="panel-heading">
				<?=$custAuth->customer->val('customer_email')?>
			</div>
			<div class="panel-body">
				<span id="cart_price"><?=$totals['p']?></span>
				<span id="cart_count"><?=$totals['c']?></span>
				
			</div>
		<?php		
	} else {	
		renderLink('/login', t('Sign In'), '');
	}
	
?>
</div>