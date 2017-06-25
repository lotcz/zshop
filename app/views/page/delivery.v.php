<?php
	$form = $this->getData('form');
	$delivery_types = $this->getData('delivery_types');
	$selected_delivery = $this->getData('selected_delivery');
?>
<form action="<?=$this->url('delivery')?>" method="POST">

	<?php	
		$this->renderPartialView('order-progress');	
		$this->z->forms->renderForm($form);
	?>

	<h2><?=$this->t('Delivery type'); ?></h2>

	<div class="delivery-types list-group">  
		<?php
			foreach ($delivery_types as $delivery) {
				?>
					<a class="list-group-item delivery-type-item <?=($selected_delivery === $delivery) ? 'active' : ''?>" data-id="<?=$delivery->val('delivery_type_id')?>">
						<?php
							if ($delivery->val('delivery_type_price') > 0) {
								?>
									<span class="badge"><?=$this->formatMoney($delivery->val('delivery_type_price'))?></span>
								<?php
							}
						?>
						
						<span class="radio-checkbox">
							<input type="radio" aria-label="<?=$this->t('Select type of delivery.') ?>" <?=($selected_delivery === $delivery) ? 'checked' : ''?> />
						</span>
						<h4 class="list-group-item-heading"><?=$delivery->val('delivery_type_name')?></h4>
							
						<?php
							if ($delivery->val('delivery_type_min_order_cost') > 0) {
								?>
									<p class="list-group-item-text"><?=$this->t('Spend at least %s to use this type of delivery.', $this->formatMoney($delivery->val('delivery_type_min_order_cost')))?></p>
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
				$this->renderLink('cart', 'Back to cart', 'btn btn-default'); 
			?>			
		</div>
		<div class="col-md-6">				
			<input type="submit" value="<?=$this->t('Continue')?>" class="btn btn-success" />						
		</div>
	</div>
</form>