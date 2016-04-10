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
							
						</tbody>
					</table>
				</div>
			
				<script>
				
					function getItemCount(id) {
						return parseInt($('#prod_count_'+id).val());
					}
					
					function setItemCount(id, cnt) {
						return $('#prod_count_'+id).val(parseInt(cnt));
					}
					
					function minusItem(id) {
						var c = getItemCount(id)-1;
						if (c < 1) {
							removeItem(id);
						} else {
							setItemCount(id, c);
							updateProductInCart(id);
						}			
					}
					
					function plusItem(id) {
						var c = getItemCount(id)+1;
						setItemCount(id, c);
						updateProductInCart(id);
						if (c == 1) {
							reviveItem(id);
						}
					}
					
					function removeItem(id) {
						if (getItemCount(id) > 0) {
							setItemCount(id, 0);
							$('#cart_prod_'+id).addClass('removed');													
						} else {
							reviveItem(id);
						}
						updateProductInCart(id);
					}
					
					function reviveItem(id) {
						setItemCount(id, 1);
						$('#cart_prod_'+id).removeClass('removed');						
					}
					
				</script>
			
				<div class="row">
				
					<?php
						
						if ($custAuth->customer->val('customer_anonymous')) {
							?>
								<div class="col-md-4">									
									<?php
										renderBlock('login');
									?>							
								</div>
								
								<div class="col-md-4">									
									<?php
										renderBlock('register');
									?>
								</div>
								
								<div class="col-md-4">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title"><?=t('Place an order') ?></h3>
										</div>
										<div class="panel-body">
											<form class="form-horizontal">												
												<div class="form-group">
													<label for="email" class="col-sm-5 control-label"><?=t('Total Cost') ?>:</label>
													<div class="col-sm-6 price">														
														<span class="ajax-loader"></span>
														<span class="form-control-static cart-total-price"><?=$totals['pf'] ?></span>
														
													</div>			
												</div>												
												<div class="form-group text-center">
													<a class="btn btn-default"><?=t('Order Without Registration') ?></a>
												</div>
											</form>						
										</div>
									</div>
								</div>	
								
							<?php
							
						} else {
							?>
							
								<div class="col-md-8 address">									
									<?php
										renderBlock('register');
									?>
								</div>
								
								<div class="col-md-4">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title"><?=t('Place an order') ?></h3>
										</div>
										<div class="panel-body">
											<form class="form-horizontal">												
												<div class="form-group">
													<label for="email" class="col-sm-5 control-label"><?=t('Total Cost') ?>:</label>
													<div class="col-sm-6 price">														
														<span class="ajax-loader"></span>
														<span class="form-control-static cart-total-price"><?=$totals['pf'] ?></span>														
													</div>
												</div>
												<div class="form-group text-center">
													<a class="btn btn-success"><?=t('Order') ?></a>
												</div>
											</form>						
										</div>
									</div>
								</div>
							
							<?php
						}
					?>																		
					
				</div> <!-- // row -->
				
			<?php
			
		} else {
			?>
				<p>Your shopping cart is empty.</p>							
			<?php
		}
				
	}
	
?>
</div>