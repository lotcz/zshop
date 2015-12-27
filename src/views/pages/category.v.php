<?php
	if (isset($data->children) && count($data->children) > 0) {
		?>
			<div class="panel panel-default">		
				<div class="panel-body">
					<?php
						if ($data->is_loaded) {													
							foreach ($data->children as $cat) {
								echo '<div class="col-md-4">';
								renderLink('category/' . $cat->val('category_id'), $cat->val('category_name'), '');
								echo '</div>';
							}
						}				
					?>			
				</div>
			</div>	
		<?php
	}	
		
	global $db;
	global $block_product;
	$sql = 'SELECT * FROM viewProducts WHERE product_category_category_id = ? ORDER BY product_name LIMIT 12';
	if ($statement = $db->prepare($sql)) {
		$statement->bind_param('i', $data->val('category_id'));
		if ($statement->execute()) {
			$result = $statement->get_result();
			while ($row = $result->fetch_assoc()) {
				$block_product = new ModelBase();
				$block_product->setData($row);
				renderBlock('product');
			}				
			$statement->close();
		} else {
			dbErr($this->table_name, 'execute', $sql, $this->db->error);					
		}			
	} else {
		dbErr($this->table_name, 'prepare', $sql, $this->db->error);				
	}
	
	renderBlock('sellers');
?>
