<div class="cart-small">
<?php

	global $db, $home_dir, $globals, $path, $custAuth;
	require_once $home_dir . 'models/cart.m.php';
	
	if (isset($custAuth) && $custAuth->isAuth()) {
		$totals = Cart::loadCartTotals($db, $custAuth->customer->val('customer_id'));
	}
	
	?>
		<div>
			<span class="glyphicon glyphicon-shopping-cart"></span>
			<?=t('Shopping Cart')?>:
		</div>
				
		<a class="price" href="/cart"><div id="cart_price"><?=$totals['pf']?></div></a>
			
	<?php		
	
?>
</div>