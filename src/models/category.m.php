<?php

class Category extends ModelBase {
	
	public $table_name = 'categories';
	public $id_name = 'category_id';
	
	public function loadByAbxId($id) {
		if (isset($id)) {
			$sql = sprintf('SELECT * FROM %s WHERE category_abx_id = ?', $this->table_name);
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
}