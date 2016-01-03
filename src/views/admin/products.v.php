<form action="/admin/products" method="GET" class="form form-inline">
	<input type="text" name="s" value="<?=$data['search'] ?>" class="form-control" />
	<input type="submit" value="<?=t('Search') ?>" class="btn btn-primary form-control" />
	<a class="btn btn-success form-control" href="/admin/product">+ <?=t('New Product') ?></a>
	<a class="btn btn-warning form-control" href="/import?token=<?=$globals['security_token'] ?>">+ <?=t('Run Import') ?></a>
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
				<th><?=t('ID') ?></th>
				<th><?=t('Name') ?></th>
				<th><?=t('ABX ID') ?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($data['products'] as $product) {
				echo '<tr onclick="javascript:openDetail(' . $product->val('product_id') . ');">';
				echo '<td>' . $product->val('product_id') . '</td>';
				echo '<td>' . $product->val('product_name') . '</td>';
				echo '<td>' . $product->val('product_abx_id') . '</td>';	
				echo '<td><a href="/admin/product/edit/' . $product->val('product_id') . '">' . t('Edit') . '</a></td>';
				echo '</tr>';
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
		document.location = '<?=$base_url . '/admin/product/edit/' ?>' + id;
	}
</script>