<?php

	$product = $this->getData('product');	
	$currency = $this->z->i18n->selected_currency;
	
	?>
		<div class="spaced product">		
			
			<div class="row">
				<div class="col col-md-6 text-center">
					<?php					
						$this->z->images->renderImage($product->val('product_image'), 'view', $product->val('product_name'), 'img-thumbnail');
					?>
				</div>
				
				<div class="col col-md-6">
					<div class="row">
						<div class="col col-md-6 text-left">
							<h3><?=$this->t('Price') ?></h3>
						</div>
						<div class="col col-md-6 text-right">
							<h3><?=$this->formatMoney($product->val('product_price'), $currency) ?></h3>
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
			
			<div class="row spaced">
				<div class="spaced col col-md-12">
					<?=$product->val('product_description') ?>
				</div>
			</div>
			
		</div>	
	<?php
	