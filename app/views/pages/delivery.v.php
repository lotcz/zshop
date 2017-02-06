<form action="<?=_url('delivery')?>" method="POST">
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

<?php
	$form->render();
?>

<input type="hidden" name="delivery_type_id" id="delivery_type_id" value="<?=$selected_delivery->val('delivery_type_id')?>" />

<script>
	$(function (){
		cartSelectDelivery(<?=$selected_delivery->val('delivery_type_id')?>);
	});
</script>
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

<script src="<?=_url('js/delivery.js')?>"></script>