<div class="cart">

	<?php
	
		if ($this->data['cart_totals']['total_cart_price'] > 0) {
			
			$this->renderPartialView('order-progress');
			
			?>					
				<div class="table-responsive panel panel-default">
					<table class="table">									
						<tbody>
							<?php
								foreach ($this->data['cart_products'] as $product) {
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
									<?=$this->t('Total')?>
								</td>
								
								<td></td>								
								<td></td>
								<td></td>								
								
								<td class="text-right">
									<strong class="cart-total-price"><?=$this->data['cart_totals']['cart_total_price_formatted']?></strong>
									<input type="hidden" name="cart_total_price" id="cart_total_price" value="<?=$this->data['cart_totals']['cart_total_price_converted'] ?>" />
								</td>								
								
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<p>&nbsp;</p>
				
				<?php
					
					if ($this->getCustomer->val('customer_anonymous')) {
						?>		
							<div class="row">
								<div class="col-md-12">	
									<h2><?=$this->t('Sign In or Register'); ?></h2>										
									<p>
										<?=$this->t('You are currently not logged in. If you have an account with our e-shop, please log in to use all features.');?>
									</p>
									<p>
										<?php
											$this->renderLink('login', 'Sign In', 'btn btn-primary', 'cart'); 
										?>
									</p>										
									<p>
										<?=$this->t('If you don\'t have an account with us yet, please create one. Only registered customers can use all features of our e-shop.');?>
									</p>
									<p>
										<?php
											$this->renderLink('register', 'Register', 'btn btn-success', 'cart'); 
										?>
									</p>									
								</div>
							</div>
						<?php							
					}
				?>
				
				<p>&nbsp;</p>
				
				<div class="row">
					<div class="col-md-12">	
						<h2><?=$this->t('Place an order'); ?></h2>
						
						<p>
							<?=$this->t('Total Cost') ?>:								
							<span id="order_total_price"></span>
							<span class="ajax-loader" style="vertical-align:middle"></span>
						</p>
						
						<p>
							<?php
								if ($this->getCustomer->val('customer_anonymous')) {									
									$this->renderLink('delivery', 'Order Without Registration', 'btn btn-default', 'cart'); 									
								} else {									
									$this->renderLink('delivery', 'Create Order', 'btn btn-success', 'cart');																
								}
							?>	
						</p>							
					</div>
				</div>
					
			<?php
			
		} else {
			?>
				<p><?=$this->t('Your shopping cart is empty.');?></p>							
			<?php
		}
	
	?>

</div>

<script>
	<?=$this->z->i18n->jsFormatPrice();?>	
</script>

<script src="<?=$this->url('js/cart.js')?>"></script>