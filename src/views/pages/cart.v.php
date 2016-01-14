<div class="panel label-default">
<?php
	if ($total > 0) {
		?>
			<div class="panel-body">
				<?php
					foreach ($products as $product) {
						?>
							<div>
								<?php
									echo $product->val('cart_count');
									renderLink('admin/product/edit/' . $product->val('product_id'), $product->val('product_name'), '');
								?>								
							</div>
						<?php
					}
				?>
			</div>
		<?php
	} else {	
		renderLink('/login', t('Sign In'), '');
	}
	
?>
</div>