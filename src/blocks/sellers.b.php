<div class="row">
	<?php
		global $db;
		global $block_product;
		
		$result = $db->query('SELECT * FROM products ORDER BY RAND() LIMIT 4');
		while ($row = $result->fetch_assoc()) {
			$block_product = new ModelBase();
			$block_product->setData($row);
			renderBlock('product');
		}
	?>	
</div>