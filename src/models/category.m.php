<?php

class Category extends ModelBase {
	
	public $table_name = 'categories';
	public $id_name = 'category_id';
	
	public function loadByAbxId($id) {
		$filter = 'category_abx_id = ?';
		$this->loadSingleFiltered($filter, [$id]);
	}

	public function loadChildren() {
		$sql = sprintf('SELECT * FROM %s WHERE category_parent_id = ? ORDER BY category_name', $this->table_name);
		if ($statement = $this->db->prepare($sql)) {
			$statement->bind_param('i', $this->val('category_id'));
			if ($statement->execute()) {
				$result = $statement->get_result();
				$this->children = [];
				while ($row = $result->fetch_assoc()) {
					$cat = new Category();
					$cat->setData($row);
					$this->children[] = $cat;
				}				
				$statement->close();
			} else {
				dbErr($this->table_name, 'execute', $sql, $this->db->error);					
			}			
		} else {
			dbErr($this->table_name, 'prepare', $sql, $this->db->error);				
		}		
	}
		
	
}