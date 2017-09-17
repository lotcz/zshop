<?php
	$product = $this->getData('partials.prod-prev');
?>

<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 product">
	<div class="panel panel-default">
		<div class="panel-body">

			<?php
				if ($this->isAuth()) {
					$this->renderLink('admin/default/default/product/edit/'. $product->val('product_id'), 'Edit', 'badge', $this->raw_path);
				}
			?>

			<a href="<?=$this->url($product->val('alias_url')) ?>">
				<div class="product-image">
					<?php $this->z->images->renderImage($product->val('product_image'), 'thumb', $product->val('product_name'), 'img-thumbnail'); ?>
				</div>
			</a>

			<div class="panel-title">
				<a href="<?=$this->url($product->val('alias_url'))?>"><?=$product->val('product_name')?></a>
			</div>

			<div class="product-price">
				<div class="price">
					<?=$this->convertAndFormatMoney($product->val('product_price')) ?>
				</div>
			</div>

		</div>

		<div class="panel-heading basic-bg product-preview-bottom">
			<div id="already_in_cart_<?=$product->val('product_id') ?>" class="<?=($product->ival('in_cart_prod_count', 0) > 0) ? '' : 'hidden' ?> already-in-cart">
				<span class="small"><?=$this->t('In cart') ?>:</span>
				<br/>
				<strong id="in_cart_prod_count_<?=$product->val('product_id')?>" >
					<?=$product->val('in_cart_prod_count') ?>
				</strong>
			</div>
			<button class="btn btn-success add-to-cart-button" onclick="javascript:addProductToCart(<?=$product->val('product_id')?>);return false;"><span class="glyphicon glyphicon-shopping-cart"></span><?=$this->t('Buy')?></button>
		</div>

	</div>
</div>
