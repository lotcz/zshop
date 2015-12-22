<div class="inner cover">	
	<a class="btn btn-success top-button" href="/admin/customer">+ <?=t('New Customer') ?></a>

	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th><?=t('Login') ?></th>
					<th><?=t('E-mail') ?></th>
					<th><?=t('Failed Logins') ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				global $db;
				$result = $db->query('SELECT * FROM customers ORDER BY customer_id');
				while ($row = $result->fetch_assoc()) {
					echo '<tr onclick="javascript:openDetail(' . $row['customer_id'] . ');">';
					echo '<td>' . $row['customer_login'] . '</td>';
					echo '<td>' . $row['customer_email'] . '</td>';	
					echo '<td>' . $row['customer_failed_attempts'] . '</td>';									
					echo '<td><a href="/admin/customer/edit/' . $row['customer_id'] . '">' . t('Edit') . '</a></td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
</div>

<script>
	function openDetail(id) {
		document.location = '<?=$base_url . '/admin/customer/edit/' ?>' + id;
	}
</script>
