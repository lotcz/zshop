<div class="inner cover">	
	<a class="btn btn-success top-button" href="/admin/user">+ <?=t('Add Administrator') ?></a>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th><?=t('Login') ?></th>
					<th><?=t('E-mail') ?></th>
					<th><?=t('Last visit') ?></th>
					<th><?=t('Failed logins') ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				global $db;
				$result = $db->query('SELECT * FROM users ORDER BY user_id');
				while ($row = $result->fetch_assoc()) {
					echo '<tr onclick="javascript:openDetail(' . $row['user_id'] . ');">';
					echo '<td>' . $row['user_login'] . '</td>';
					echo '<td>' . $row['user_email'] . '</td>';
					echo '<td>' . $row['user_last_access'] . '</td>';					
					echo '<td>' . $row['user_failed_attempts'] . '</td>';
					echo '<td><a href="/admin/user/edit/' . $row['user_id'] . '">' . t('Edit') . '</a></td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
</div>

<script>
	function openDetail(id) {
		document.location = '<?=$base_url . '/admin/user/edit/' ?>' + id;
	}
</script>

