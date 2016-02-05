<div class="inner cover">	
	<a class="btn btn-success top-button" href="/admin/category">+ <?=t('New Category') ?></a>

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
					<th><?=t('Parent ID') ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($data['categories'] as $cat) {
					echo '<tr onclick="javascript:openDetail(' . $cat->val('category_id') . ');">';
					echo '<td>' . $cat->val('category_id') . '</td>';
					echo '<td>' . $cat->val('category_name') . '</td>';
					echo '<td>' . $cat->val('category_ext_id') . '</td>';	
					echo '<td>' . $cat->val('category_parent_id') . '</td>';									
					echo '<td><a href="/admin/category/edit/' . $cat->val('category_id') . '">' . t('Edit') . '</a></td>';
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