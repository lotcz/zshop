<form class="order">
				
	<div class="table-responsive panel panel-default">
		<table class="table">									
			<tbody>
				<?php
					foreach ($products as $product) {
						?>
							<tr class="item">								
								<td>
									<?=$product->val('product_name')?>
								</td>
								
								<td class="text-right">
									<span><?=formatPrice($product->val('product_price')) ?></span>
								</td>
								
								<td>
									<?=$product->val('cart_count') ?>
								</td>
								
								<td class="text-right">
									<strong><span><?=formatPrice($product->val('item_price')) ?></span></strong>
								</td>								
							</tr>
						<?php
					}					
					
				?>
				
				<tr class="item">								
					<td>
						<?=t('Total')?>
					</td>
					
					<td>						
					</td>
					
					<td>
					</td>
					
					<td class="text-right">
						<strong><span><?=formatPrice($total_cart_value)?></span></strong>
					</td>								
				</tr>
				
			</tbody>
		</table>
	</div>
	
	<div class="table-responsive panel panel-default">
		<table class="table">									
			<tbody>
			
				<tr class="item">								
					<td>
						<?=$delivery_type->val('delivery_type_name')?>
					</td>
					
					<td>						
					</td>
					
					<td>
					</td>
					
					<td class="text-right">
						<strong><span><?=formatPrice($delivery_type->fval('delivery_type_price'))?></span></strong>
					</td>								
				</tr>
				
				<tr class="item">								
					<td>
						<?=$payment_type->val('payment_type_name')?>
					</td>
					
					<td>						
					</td>
					
					<td>
					</td>
					
					<td class="text-right">
						<strong><span><?=formatPrice($payment_type->fval('payment_type_price'))?></span></strong>
					</td>								
				</tr>
				
				
				<tr class="item">								
					<td>
						<?=t('Total')?>
					</td>
					
					<td>						
					</td>
					
					<td>
					</td>
					
					<td class="text-right">
						<strong><span><?=formatPrice($total_order_value)?></span></strong>
					</td>								
				</tr>
			</tbody>
		</table>
	</div>
	
	<div class="row">
				
		<div class="col-md-6 address">									
			<?php				
				renderBlock('address-form');				
			?>
		</div>
		
		<div class="col-md-6">
			<div class="panel panel-default">										
				<div class="panel-heading">
					<h3 class="panel-title"><?=t('Place an order') ?></h3>
				</div>
				<div class="panel-body text-center">											
					<div  class="col-sm-12 control-label"><?=t('Total Cost') ?>:</div>
					<div class="col-sm-12 price">
						
						<span class="form-control-static cart-total-price"><?=formatPrice($total_order_value) ?></span>														
					</div>												
					<div class="form-group text-center">
						<a class="btn btn-success"><?=t('Confirm Your Order') ?></a>
					</div>															
				</div>										
			</div>
		</div>																	
		
	</div> <!-- // row -->

</form> <!-- // order -->