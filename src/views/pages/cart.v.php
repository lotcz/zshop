<div class="cart">
<?php
	if (isset($custAuth) && $custAuth->isAuth()) {
		if ($totals['c'] > 0) {
			?>
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
													<div class="col-sm-6">
														<span class="price"><?=$totals['pf'] ?></span>
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
							echo "logged in";
						}
					?>																		
					
				</div> <!-- // row -->
				
				<div class="table-responsive panel panel-default">
					<table class="table">									
						<tbody>
							<?php
								foreach ($products as $product) {
									?>
										<tr onclick="javascript:openDetail(<?=$product->val('product_id') ?>);">
											<td>
												<?php
													$images->renderImage($product->val('product_image'), 'mini-thumb');
												?>
											</td>
											<td>
												<?php
													renderLink($product->val('alias_url'), $product->val('product_name'))
												?>
											</td>
											<td class="text-right"><?=formatPrice($product->val('product_price')) ?></td>														
											<td><input type="text" maxlength="2" class="form-control item-count" value="<?=$product->val('cart_count') ?>"></td>
											<td class="text-right"><?=formatPrice($product->val('item_price')) ?></td>
											<td><a href="#" class="remove-item"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a></td>
										</tr>
									<?php
								}
							?>
							
						</tbody>
					</table>
				</div>
				
			<?php
			
		} else {
			?>
				<p>Your shopping cart is empty.</p>							
			<?php
		}
				
	} else {	
		?>
			<p>You can't be logged in! Maybe your browser has cookies disabled?</p>			
		<?php
	}
	
?>
</div>