<form action="<?=_url('order')?>" method="POST">
	<div class="cart">

	<?php

		if (isset($custAuth) && $custAuth->isAuth()) {
			if ($totals['p'] > 0) {
				?>					
					<div class="table-responsive panel panel-default">
						<table class="table">									
							<tbody>
								<?php
									foreach ($products as $product) {
										?>
											<tr class="item" id="cart_prod_<?=$product->val('product_id') ?>">
												<td>
													<?php
														if ($product->val('product_image')) {
															$images->renderImage($product->val('product_image'), 'mini-thumb');
														} else {
															renderImage('no-image.png','missing image', 'mini-thumb');
														}
													?>
												</td>
												<td>
													<?php
														renderLink($product->val('alias_url'), $product->val('product_name'))
													?>
												</td>
												
												<td class="text-right">
													<span><?=formatPrice($product->val('product_price')) ?></span>
													<input type="hidden" id="item-price-<?=$product->val('product_id') ?>" value="<?=$product->val('product_price') ?>" />
												</td>
												
												<td>
													<div class="item-count">
														<a onclick="javascript:minusItem(<?=$product->val('product_id') ?>);return false;" href="#" class="minus-item"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>
														<input id="prod_count_<?=$product->val('product_id') ?>" type="text" maxlength="2" class="form-control" value="<?=$product->val('cart_count') ?>">
														<a onclick="javascript:plusItem(<?=$product->val('product_id') ?>);return false;" href="#" class="plus-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
													</div>
												</td>
												
												<td class="text-right"><strong><span id="item_total_price_<?=$product->val('product_id') ?>"><?=formatPrice($product->val('item_price')) ?></span></strong></td>
												<td>												
													<a onclick="javascript:removeItem(<?=$product->val('product_id') ?>);return false;" href="#" class="remove-item"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>												
												</td>
											</tr>
										<?php
									}
								?>
								
								<tr class="item">								
									<td>
										<?=t('Total')?>
									</td>
									
									<td></td>								
									<td></td>
									<td></td>								
									
									<td class="text-right">
										<strong class="cart-total-price"><?=formatPrice($data['totals']['p'])?></strong>
										<input type="hidden" name="cart_total_price" id="cart_total_price" value="<?=$data['totals']['pc'] ?>" />
									</td>								
									
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				
					<div class="row">				
						<div class="col-md-6">									
							<?php				
								renderBlock('delivery-form');				
							?>
						</div>					
						<div class="col-md-6">									
							<?php				
								renderBlock('payment-form');				
							?>
						</div>					
					</div>
					
					<?php
						
						if ($custAuth->customer->val('customer_anonymous')) {
							?>		
								<div class="row">
									<div class="col-md-12">	
										<h2><?=t('Sign In or Register'); ?></h2>										
										<p>
											<?=t('You are currently not logged in. If you have an account with our e-shop, please log in to use all features.');?>
										</p>
										<p>
											<?php
												renderLink('login', 'Sign In', 'btn btn-primary', 'cart'); 
											?>
										</p>										
										<p>
											<?=t('If you don\'t have an account with us yet, please create one. Only registered customers can use all features of our e-shop.');?>
										</p>
										<p>
											<?php
												renderLink('register', 'Register', 'btn btn-success', 'cart'); 
											?>
										</p>
										<p>&nbsp;</p>
									</div>
								</div> <!-- // row -->
							<?php							
						}
					?>
					
					<div class="row">
						<div class="col-md-12">	
							<h2><?=t('Place an order'); ?></h2>
							
							<p>
								<?=t('Total Cost') ?>:								
								<span id="order_total_price"></span>
								<span class="ajax-loader" style="vertical-align:middle"></span>
							</p>
							
							<p>
								<?php
									if ($custAuth->customer->val('customer_anonymous')) {
										?>								
											<input type="submit" class="btn btn-default" value="<?=t('Order Without Registration') ?>" />
										<?php									
									} else {
										?>								
											<input type="submit" class="btn btn-success" value="<?=t('Continue') ?>" />												
										<?php									
									}
								?>	
							</p>							
						</div>
					</div> <!-- // row -->
						
				<?php
				
			} else {
				?>
					<p><?=t('Your shopping cart is empty.');?></p>							
				<?php
			}
					
		}
		
	?>
	</div>
</form>

<script>

	var payment_types = [], delivery_types = [];
	
	<?php
	
		echo Currency::jsFormatPrice($db);
	
		$delivery_types = DeliveryType::all($db);
		foreach ($delivery_types as $d) {
			echo 'delivery_types[' . $d->val('delivery_type_id') . '] = ' . json_encode($d->data) . ';';	
			echo 'delivery_types[' . $d->val('delivery_type_id') . '].allowed = [];';
		}
		
		$allowed = PaymentType::getAllowedPT($db);
		foreach ($allowed as $a) {
			echo 'delivery_types[' . $a->val('allowed_payment_type_delivery_type_id') . '].allowed.push(' . $a->val('allowed_payment_type_payment_type_id') . ');';	
		}
		
		$payment_types = PaymentType::all($db);
		foreach ($payment_types as $pt) {
			echo 'payment_types[' . $pt->val('payment_type_id') . '] = ' . json_encode($pt->data) . ';';
		}
		
	?>
	
	$(function (){
		cartUpdate();
	});
</script>
<script src="<?=_url('js/cart.js')?>"></script>