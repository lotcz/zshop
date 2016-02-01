<div class="cart">
<?php

	global $db, $home_dir, $globals, $path, $custAuth;
	require_once $home_dir . 'models/cart.m.php';
	
	$totals = Cart::loadCartTotals($db, $custAuth->customer->val('customer_id'));
	?>
		<div>
			<span class="glyphicon glyphicon-shopping-cart"></span>
			<?=t('Shopping cart')?>:
		</div>
				
		<div class="price" id="cart_price"><?=$totals['pf']?></div>
			
	<?php		
	
?>
</div>