<?php
	global $block_product;
	$product = $block_product;
?>

<div class="col-md-3 product">
	<div class="panel">
		<div class="panel-body">
			<?php
				renderImage('logo.jpg','Product','');
			?>
		</div>
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php
					renderLink('admin/product/edit/'. $product->val('product_id'), $product->val('product_name'), '');
				?>
			</h3>
		</div>
	</div>
</div>