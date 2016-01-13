<ul class="nav nav-sidebar">
	<?php
		global $db, $path;
		
		$result = $db->query('SELECT * FROM categories WHERE category_parent_id IS NULL ORDER BY category_name');
		while ($row = $result->fetch_assoc()) {
			$active = '';
			if (isset($path[1]) && $path[1] == $row['category_id']) {
				$active = 'active';
			}
			
			?>
				<li class="<?=$active?>">
					<?php
						renderLink('category/'. $row['category_id'], $row['category_name'], '');			
					?>
				</li>
			<?php
		}
	?>	
</ul>