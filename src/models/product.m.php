<?php

class Product extends ModelBase {
	
	public $table_name = 'products';
	public $id_name = 'product_id';
	
	public function loadByAbxId($id) {
		if (isset($id)) {
			$sql = sprintf('SELECT * FROM %s WHERE product_abx_id = ?', $this->table_name);
			if ($statement = $this->db->prepare($sql)) {
				$statement->bind_param('i', $id);
				$statement->execute();
				$result = $statement->get_result();
				if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$this->is_loaded = true;
					$this->setData($row);
				}
				$statement->close();
			} else {
				die('DB error:' . $this->db->error);
			}
		}		
	}
	
	public function removeFromAllCategories() {		
		if ($statement = $this->db->prepare('DELETE FROM product_category WHERE product_category_product_id = ?')) {
			$statement->bind_param('i', $this->val($this->id_name));
			$statement->execute();
			$statement->close();
		} else {
			die('DB error:' . $this->db->error);
		}		
	}
	
	public function addToCategory($category_id) {		
		if ($statement = $this->db->prepare('INSERT INTO product_category (product_category_product_id, product_category_category_id) VALUES(?,?)')) {
			$statement->bind_param('ii', $this->val($this->id_name), $category_id);
			$statement->execute();
			$statement->close();
		} else {
			die('DB error:' . $this->db->error);
		}		
	}
	
}