<ul class="nav nav-sidebar">
	<?php
		global $db, $path;
		
		$result = $db->query('SELECT * FROM viewCategories WHERE category_parent_id IS NULL ORDER BY category_name');
		while ($row = $result->fetch_assoc()) {
			$active = '';
			if (isset($path[1]) && $path[1] == $row['category_id']) {
				$active = 'active';
			}
			
			?>
				<li class="<?=$active?>">
					<?php
						if (isset($row['alias_url']) && strlen($row['alias_url']) > 0) {
							renderLink($row['alias_url'], $row['category_name'], '');			
						} else {
							renderLink('category/'. $row['category_id'], $row['category_name'], '');			
						}
					?>
				</li>
			<?php
		}
	?>	
</ul>