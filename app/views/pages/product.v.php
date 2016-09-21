<?php
	global $data, $db;
	$product = $data['product'];
	
	$currency = Currency::getSelectedCurrency($db);
	
	?>
		<div class="spaced product">		
			
			<div class="row">
				<div class="col col-md-6 text-center">
					<?php					
						$product->renderImage('view', 'img-thumbnail');					
					?>
				</div>
				
				<div class="col col-md-6">
					<div class="row">
						<div class="col col-md-6 text-left">
							<h3><?=t('Price') ?></h3>
						</div>
						<div class="col col-md-6 text-right">
							<h3><?=formatPrice($product->val('product_price'), $currency) ?></h3>
						</div>					
					</div>
					
					<div class="row spaced">
						<div class="col col-md-6 col-md-offset-6 text-right">
							<form class="form-inline">
								<input name="product_count" id="prod_count_<?=$product->val('product_id')?>" value="1" type="text" maxlength="2" class="form-control prod-item-count" />
								<button class="btn btn-success" onclick="javascript:addProductToCart(<?=$product->val('product_id')?>);return false;"><span class="glyphicon glyphicon-shopping-cart"></span><?=t('Buy')?></button>
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