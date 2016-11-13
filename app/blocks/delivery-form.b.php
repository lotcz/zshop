<?php
	global $db, $messages, $home_dir;
	require_once $home_dir . 'models/delivery_type.m.php';
			
	$delivery_types = DeliveryType::all($db);
	$selected_delivery = DeliveryType::getDefault($delivery_types);

?>
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

<input type="hidden" name="delivery_type_id" id="delivery_type_id" value="<?=$selected_delivery->val('delivery_type_id')?>" />

<script>	
	$(function (){
		cartSelectDelivery(<?=$selected_delivery->val('delivery_type_id')?>);
	});
</script>