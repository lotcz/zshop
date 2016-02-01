<div class="cart panel panel-default">
<?php
	if (isset($custAuth) && $custAuth->isAuth()) {
		?>
			<div class="">
				<?php
					if ($totals['c'] > 0) {
						?>
							<div class="table-responsive">
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
														<td><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></td>
													</tr>
												<?php
											}
										?>
										<tr>
											<td></td>											
											<td colspan="2" class="text-right"><a class="btn btn-primary"><?=t('Update Cart') ?></a></td>
											<td class="text-right"><?=$totals['pf'] ?></td>
											<td><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></td>
										</tr>
									</tbody>
								</table>
							</div>
							
						<?php
						
					} else {
						?>
							<p>Your shopping cart is empty.</p>							
						<?php
					}
				?>
			</div>
		<?php
	} else {	
		?>
			<p>You can't be logged in! Maybe your browser has cookies disabled?</p>			
		<?php
	}
	
?>
</div>