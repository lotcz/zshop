<?php
	global $data;
	$product = $data['product'];
	
	echo $product->val('product_description');
	
	?>
		<div class="panel panel-default spaced">		
			<div class="panel-body">
				<?php
					$product->renderImage('view');
				?>
			</div>
		</div>	
	<?php