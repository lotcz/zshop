<?php

class Alias extends ModelBase {
	
	public $table_name = 'aliases';
	public $id_name = 'alias_id';
	
	static $target_type_item = 1;
	static $target_type_category = 2;
	static $target_type_static = 3;
	
	public function loadByUrl($url) {
		$sql = sprintf('SELECT * FROM %s WHERE alias_url = ?', $this->table_name);
		if ($statement = $this->db->prepare($sql)) {
			$statement->bind_param('s', trimSlashes(strtolower($url)));
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