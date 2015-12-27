<ul class="nav nav-sidebar">
	<?php
		global $db;
		
		$result = $db->query('SELECT * FROM categories WHERE category_parent_id IS NULL ORDER BY category_name');
		while ($row = $result->fetch_assoc()) {
			echo '<li>';
			renderLink('category/'. $row['category_id'], $row['category_name'], '');			
			echo '</li>';
		}
	?>	
</ul>