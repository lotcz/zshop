<div class="inner cover">	
	<a class="btn btn-success top-button" href="/admin/category"><?=t('Create new category') ?></a>

	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th><?=t('ID') ?></th>
					<th><?=t('Name') ?></th>
					<th><?=t('ABX ID') ?></th>
					<th><?=t('Parent ID') ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				global $db;
				$result = $db->query('SELECT * FROM categories ORDER BY COALESCE(category_parent_id, category_id)');
				while ($row = $result->fetch_assoc()) {
					echo '<tr onclick="javascript:openDetail(' . $row['category_id'] . ');">';
					echo '<td>' . $row['category_id'] . '</td>';
					echo '<td>' . $row['category_name'] . '</td>';
					echo '<td>' . $row['category_abx_id'] . '</td>';	
					echo '<td>' . $row['category_parent_id'] . '</td>';									
					echo '<td><a href="/admin/category/edit/' . $row['category_id'] . '">' . t('Edit') . '</a></td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
</div>

<script>
	function openDetail(id) {
		document.location = '<?=$base_url . '/admin/category/edit/' ?>' + id;
	}
</script>