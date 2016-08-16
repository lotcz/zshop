<?php
	global $data, $auth, $custAuth, $raw_path;
	$product = $data['partials.prod-prev'];
		
?>

<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 product">
	<div class="panel panel-default">
		<div class="panel-body">
			
			<?php
				if ($auth->isAuth()) {
					renderLink('admin/product/edit/'. $product->val('product_id'), 'Edit', 'badge', $raw_path);
				}
			?>
						
			<a href="<?=_url($product->val('alias_url')) ?>">
				<div class="product-image">
					<?php $product->renderImage('thumb', 'img-thumbnail'); ?>
				</div>				
			</a>
				
			<div class="panel-title">				
				<a href="<?=_url($product->val('alias_url'))?>"><?=$product->val('product_name')?></a>
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