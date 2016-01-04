<?php
	global $data;
	$product = $data['partials.prod-prev'];
?>

<div class="col-md-3 product">
	<div class="panel panel-default">
		<div class="panel-body">
			<?php
				renderImage('logo.jpg','Product','');
			?>		
			<span class="price"><?=$product->val('product_price') ?></span>
			<?=$product->val('product_stock') ?>
			<p class="panel-title">
				<?php
					renderLink('admin/product/edit/'. $product->val('product_id'), $product->val('product_name'), '');
				?>
			</p>
			<div class="text-right product-menu" >
				<button class="btn btn-success">+ <?=t('Add')?></button>
			</div>
		</div>
	</div>
</div>