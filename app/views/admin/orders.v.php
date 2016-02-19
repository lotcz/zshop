<form action="/admin/orders" method="GET" class="form form-inline">
	<input type="text" name="s" value="<?=$data['search'] ?>" class="form-control" />
	<input type="submit" value="<?=t('Search') ?>" class="btn btn-primary form-control" />
	<div>
		<?= $data['paging']->getInfo() ?>
	</div>
</form>

<?php
	renderPartial('paging', $data['paging'])
?>

<div class="table-responsive">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th><?=t('Payment symbol') ?></th>
				<th><?=t('Date') ?></th>
				<th><?=t('Status') ?></th>
				<th><?=t('Closed') ?></th>				
				<th><?=t('Customer') ?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($data['orders'] as $order) {
				?>
					<tr onclick="javascript:openDetail(<?=$order->val('order_id') ?>);">
						<td><?=$order->val('order_payment_code') ?></td>
						<td><?=$order->val('order_created') ?></td>
						<td><?=$order->val('order_state_name') ?></td>
						<td><?=$order->val('order_state_closed') ?></td>
						<td><?=$order->val('customer_name') ?></td>
						<td><a href="/admin/order/edit/<?=$order->val('order_id') ?>?ret=/admin/orders"><?=t('Edit') ?></a></td>
					</tr>
				<?php
			}
		?>
		</tbody>
	</table>
</div>

<?php
	renderPartial('paging', $data['paging'])
?>

<script>
	function openDetail(id) {
		document.location = '<?=$base_url . '/admin/order/edit/' ?>' + id + '?ret=/admin/orders';
	}
</script>