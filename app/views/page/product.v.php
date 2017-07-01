<?php

	$product = $this->getData('product');	

?>
<div class="spaced product">		
	
	<div class="row">
		<div class="col col-md-6 spaced">
			<div class="text-center light-frame">
				<?php					
					$this->z->images->renderImage($product->val('product_image'), 'view', $product->val('product_name'), '');
				?>
			</div>
		</div>
		
		<div class="col col-md-6 spaced">
			<div class="light-frame">
				<div class="row">
					<div class="col col-md-6 text-left">
						<span class="price"><?=$this->t('Price') ?></span>
					</div>
					<div class="col col-md-6 text-right">
						<span class="price"><?=$this->convertAndFormatMoney($product->val('product_price')) ?></span>
					</div>					
				</div>			
				<div class="row spaced">
					<div class="col col-md-6 col-md-offset-6 text-right">
						<form class="form-inline">
							<input name="product_count" id="prod_count_<?=$product->val('product_id')?>" value="1" type="text" maxlength="2" class="form-control prod-item-count" />
							<button class="btn btn-success" onclick="javascript:addProductToCart(<?=$product->val('product_id')?>);return false;"><span class="glyphicon glyphicon-shopping-cart"></span><?=$this->t('Buy')?></button>
						</form>
					</div>					
				</div>
			</div>
		</div>
	</div>
	
	<div class="panel spaced">
		<div class="panel-body">
			<?php
				$desc = $product->val('product_description');
				if (strlen($desc) > 0) {
					echo $desc;
				} else {
					echo $this->t('No description is available for this product.');
				}
			?>
		</div>
	</div>
	
</div>