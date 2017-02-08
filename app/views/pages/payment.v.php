<form action="<?=_url('order')?>" method="POST">
	<?php
	
		renderBlock('progress');
	
	?>
	
	<div class="payment-types list-group">  
	<?php
		foreach ($payment_types as $payment) {
			?>
				<a id="link_payment_type_<?=$payment->val('payment_type_id')?>" class="list-group-item <?=($selected_payment === $payment) ? 'active' : ''?>" data-id="<?=$payment->val('payment_type_id')?>">
					<?php
						if ($payment->val('payment_type_price') > 0) {
							?>
								<span class="badge"><?=$payment->val('payment_type_price')?></span>
							<?php
						}
					?>
					
					<span class="radio-checkbox">
						<input type="radio" aria-label="Select payment type." <?=($selected_payment === $payment) ? 'checked' : ''?>  />
					</span>
					<h4 class="list-group-item-heading"><?=$payment->val('payment_type_name')?></h4>
					
					<?php
						if ($payment->val('payment_type_min_order_cost') > 0) {
							?>
								<p class="list-group-item-text"><?=t('Spend at least %s to use this type of payment.', formatPrice($payment->val('payment_type_min_order_cost')))?></p>
							<?php
						}
					?>
				</a>
			<?php
		}
		
	?>
</div>

<input type="hidden" name="payment_type_id" id="payment_type_id" value="<?=$selected_payment->val('payment_type_id')?>" />
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

<script src="<?=_url('js/payment.js')?>"></script>