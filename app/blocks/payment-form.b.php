<?php
	global $db, $messages, $home_dir;
	require_once $home_dir . 'models/payment_type.m.php';
			
	$payment_types = PaymentType::all($db);
	$selected_payment = PaymentType::getDefault($payment_types);

?>

<h2><?=t('Payment Type'); ?></h2>

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