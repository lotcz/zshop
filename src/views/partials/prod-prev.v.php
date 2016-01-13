<?php
	global $data;
	$product = $data['partials.prod-prev'];
?>

<div class="col-md-3 product">
	<div class="panel panel-primary">
		<div class="panel-body">
			
			<div class="product-image">
				<a href="/admin/product/edit/<?=$product->val('product_id') ?>"><?php $product->renderImage(); ?></a>
			</div>
			
					
						
			<div class="panel-title">				
				<?php
					renderLink('admin/product/edit/'. $product->val('product_id'), $product->val('product_name'), '');
				?>
			</div>
			
			<div class="product-price">
				<div class="price">
					<?=formatPrice($product->val('product_price')) ?>
				</div>					
			</div>	

		</div>
		
		<div class="panel-heading text-right">
			<form class="form-inline">
				<input name="prod_count" value="1" type="text" maxlength="2" class="form-control" style="width:50px;" />
				<button class="btn btn-success">+ <?=t('Add')?></button>
			</form>
		</div>
			
	</div>
</div>