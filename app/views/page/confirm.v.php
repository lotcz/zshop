<?php
	$products = $this->getData('products');
	$total_cart_value = $this->getData('total_cart_value');
	$total_order_value_formatted = $this->getData('total_order_value_formatted');
	$delivery_type = $this->getData('delivery_type');
	$payment_type = $this->getData('payment_type');
?>
<form action="<?=$this->url('confirm')?>" method="POST">
				
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
									<span><?=$this->formatAndConvertMoney($product->val('product_price')) ?></span>
								</td>
								
								<td>
									<?=$product->val('cart_count') ?>
								</td>
								
								<td class="text-right">
									<strong><span><?=$this->formatAndConvertMoney($product->val('item_price')) ?></span></strong>
								</td>								
							</tr>
						<?php
					}					
					
				?>
				
				<tr class="item">								
					<td>
						<?=$this->t('Total')?>
					</td>
					
					<td>						
					</td>
					
					<td>
					</td>
					
					<td class="text-right">
						<strong><span><?=$this->formatAndConvertMoney($total_cart_value)?></span></strong>
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
						<strong><span><?=$this->formatAndConvertMoney($delivery_type->fval('delivery_type_price'))?></span></strong>
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
						<strong><span><?=$this->formatAndConvertMoney($payment_type->fval('payment_type_price'))?></span></strong>
					</td>								
				</tr>
				
				
				<tr class="item">								
					<td>
						<?=$this->t('Total')?>
					</td>
					
					<td>						
					</td>
					
					<td>
					</td>
					
					<td class="text-right">
						<strong><span><?=$total_order_value_formatted ?></span></strong>
					</td>								
				</tr>
			</tbody>
		</table>
	</div>
	
	<div class="row">
		
		<div class="panel panel-default">										
			<div class="panel-heading">
				<h3 class="panel-title"><?=$this->t('Place an order') ?></h3>
			</div>
			<div class="panel-body text-center">											
				<div  class="col-sm-12 control-label"><?=$this->t('Total Cost') ?>:</div>
				<div class="col-sm-12 price">
					<span class="form-control-static cart-total-price"><?=$total_order_value_formatted ?></span>														
				</div>												
				<div class="form-group text-center">
					<input type="submit" class="btn btn-success" value="<?=$this->t('Confirm Your Order') ?>" />
				</div>															
			</div>										
		</div>
																		
		
	</div> <!-- // row -->

</form> <!-- // order -->