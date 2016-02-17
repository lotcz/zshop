<?php
	global $data, $custAuth;
	$product = $data['partials.prod-prev'];
		
?>

<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 product">
	<div class="panel panel-default">
		<div class="panel-body">
			
			<div class="product-image">
				<a href="/<?=$product->val('alias_url') ?>"><?php $product->renderImage(); ?></a>
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
		
		<div class="panel-heading basic-bg text-right">
			<form class="form-inline">
				<input id="prod_count_<?=$product->val('product_id')?>" value="1" type="text" maxlength="2" class="form-control prod-item-count" />
				<button class="btn btn-success" onclick="javascript:addProductToCart(<?=$product->val('product_id')?>);return false;"><span class="glyphicon glyphicon-shopping-cart"></span><?=t('Buy')?></button>
			</form>
		</div>
			
	</div>
</div>