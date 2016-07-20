<?php
	global $db, $messages, $home_dir;
	require_once $home_dir . 'models/delivery_type.m.php';
			
	$delivery_types = DeliveryType::all($db);
	$selected_delivery = DeliveryType::getDefault($delivery_types);

?>
<div class="list-group">  
	<?php
		foreach ($delivery_types as $delivery) {
			?>
				<a href="#" class="list-group-item <?=($selected_delivery === $delivery) ? 'active' : ''?>">
					<span class="badge"><?=$delivery->val('delivery_type_price')?></span>
					<span class="">
						<input type="radio" aria-label="...">
					</span>
					<h4 class="list-group-item-heading"><?=$delivery->val('delivery_type_name')?></h4>
					<p class="list-group-item-text"><?=$delivery->val('delivery_type_name')?></p>
					
					<p class="list-group-item-text"><?=$delivery->val('delivery_type_min_order_cost')?></p>
				</a>
			<?php
		}
	?>
</div>