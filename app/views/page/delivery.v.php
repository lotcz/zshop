<form action="<?=_url('delivery')?>" method="POST">

	<?php
	
		renderBlock('progress');
	
		$form->render();
	?>

	<h2><?=t('Delivery type'); ?></h2>

	<div class="delivery-types list-group">  
		<?php
			foreach ($delivery_types as $delivery) {
				?>
					<a class="list-group-item delivery-type-item <?=($selected_delivery === $delivery) ? 'active' : ''?>" data-id="<?=$delivery->val('delivery_type_id')?>">
						<?php
							if ($delivery->val('delivery_type_price') > 0) {
								?>
									<span class="badge"><?=formatPrice($delivery->val('delivery_type_price'))?></span>
								<?php
							}
						?>
						
						<span class="radio-checkbox">
							<input type="radio" aria-label="Select type of delivery." <?=($selected_delivery === $delivery) ? 'checked' : ''?> />
						</span>
						<h4 class="list-group-item-heading"><?=$delivery->val('delivery_type_name')?></h4>
							
						<?php
							if ($delivery->val('delivery_type_min_order_cost') > 0) {
								?>
									<p class="list-group-item-text"><?=t('Spend at least %s to use this type of delivery.', formatPrice($delivery->val('delivery_type_min_order_cost')))?></p>
								<?php
							}
						?>
						
					</a>
				<?php
			}
		?>
	</div>

	<div class="row">
		<div class="col-md-6 text-right">				
			<?php
				renderLink('cart', 'Back to cart', 'btn btn-default'); 
			?>			
		</div>
		<div class="col-md-6">				
			<input type="submit" value="<?=t('Continue')?>" class="btn btn-success" />						
		</div>
	</div>
</form>

<script src="<?=_url('js/delivery.js')?>"></script>