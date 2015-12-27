<div class="inner cover">	
	<a class="btn btn-success top-button" href="/admin/product">+ <?=t('New Product') ?></a>
	<a class="btn btn-warning top-button" href="/import?token=<?=$globals['security_token'] ?>">+ <?=t('Run Import') ?></a>

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
				global $db;
				$result = $db->query('SELECT * FROM products ORDER BY product_name');
				while ($row = $result->fetch_assoc()) {
					echo '<tr onclick="javascript:openDetail(' . $row['product_id'] . ');">';
					echo '<td>' . $row['product_id'] . '</td>';
					echo '<td>' . $row['product_name'] . '</td>';
					echo '<td>' . $row['product_abx_id'] . '</td>';	
					echo '<td><a href="/admin/product/edit/' . $row['product_id'] . '">' . t('Edit') . '</a></td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
</div>

<script>
	function openDetail(id) {
		document.location = '<?=$base_url . '/admin/product/edit/' ?>' + id;
	}
</script>