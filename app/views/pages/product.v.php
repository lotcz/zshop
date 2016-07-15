<?php
	global $data, $db;
	$product = $data['product'];
	
	echo $product->val('product_description');
	$currency = Currency::getSelectedCurrency($db);
	
	?>
		<div class="panel panel-default spaced">		
			<div class="panel-body">
				<?php
					$product->renderImage('mini-thumb', 'img-thumbnail');
					$product->renderImage('thumb', 'img-thumbnail');
					$product->renderImage('view');
					$product->renderImage();
					
					echo formatPrice($product->val('product_price'), $currency);
				?>
			</div>
		</div>	
	<?php