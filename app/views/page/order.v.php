<?php
	$order = $this->getData('order');	
	$delivery_type = $this->getData('delivery_type');
	$payment_type = $this->getData('payment_type');
?>

<div class="table-responsive panel panel-default">
	<table class="table">
		<tbody>
			<?php
				foreach ($order->products as $product) {
					?>
						<tr class="item">
							<td>
								<?=$product->val('product_name')?>
							</td>

							<td class="text-right">
								<span><?=$this->convertAndFormatMoney($product->val('product_price')) ?></span>
							</td>

							<td>
								<?=$product->val('order_product_count') ?>x
							</td>

							<td class="text-right">
								<strong><span><?=$this->convertAndFormatMoney($product->val('item_price')) ?></span></strong>
							</td>
						</tr>
					<?php
				}

			?>

			<tr class="item">
				<td>
					<strong><?=$this->t('Subtotal')?></strong>
				</td>

				<td>
				</td>

				<td>
				</td>

				<td id="order_subtotal" class="text-right">
					<strong><?=$this->convertAndFormatMoney($order->val('order_total_cart_price'))?></strong>
				</td>
			</tr>

		</tbody>
	</table>
</div>

<div class="table-responsive panel panel-default">
	<table class="table">
		<tbody>

			<tr class="item">
				<td>
					<?=$this->t('Delivery Type')?>: <?=$this->t($delivery_type->val('delivery_type_name'))?>
				</td>

				<td>
				</td>

				<td>
				</td>

				<td class="text-right">
					<strong><span><?=$this->convertAndFormatMoney($order->fval('order_delivery_type_price'))?></span></strong>
				</td>
			</tr>

			<tr class="item">
				<td>
					<?=$this->t('Payment Type')?>: <?=$this->t($payment_type->val('payment_type_name'))?>
				</td>

				<td>
				</td>

				<td>
				</td>

				<td class="text-right">
					<strong><span><?=$this->convertAndFormatMoney($payment_type->fval('order_payment_type_price'))?></span></strong>
				</td>
			</tr>


			<tr class="item">
				<td>
					<strong><?=$this->t('Total')?></strong>
				</td>

				<td>
				</td>

				<td>
				</td>

				<td class="text-right">
					<strong><span><?=$order->val('order_total_price') ?></span></strong>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="">

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?=$this->t('Total Cost') ?></h3>
		</div>
		<div class="panel-body text-center">			
			<div class="price">
				<span class="form-control-static cart-total-price"><?=$order->val('order_total_price') ?></span>
			</div>			
		</div>
	</div>


</div>