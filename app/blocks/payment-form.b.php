<?php
	global $db, $messages, $home_dir;
	require_once $home_dir . 'models/payment_type.m.php';
			
	$payment_types = PaymentType::all($db);
	$selected_payment = PaymentType::getDefault($payment_types);

?>
<div class="list-group">  
	<?php
		foreach ($payment_types as $payment) {
			?>
				<a href="#" class="list-group-item <?=($selected_payment === $payment) ? 'active' : ''?>">
					<span class="badge"><?=$payment->val('payment_type_price')?></span>
					<span class="">
						<input type="radio" aria-label="...">
					</span>
					<h4 class="list-group-item-heading"><?=$payment->val('payment_type_name')?></h4>
					<p class="list-group-item-text"><?=$payment->val('payment_type_name')?></p>
					
					<p class="list-group-item-text"><?=$payment->val('payment_type_min_order_cost')?></p>
				</a>
			<?php
		}
	?>
</div>