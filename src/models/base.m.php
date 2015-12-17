<?php

class ModelBase {

	private $db = null;

	public $table_name = 'table';
	public $id_name = 'table_id';
	public $is_loaded = false;
	public $data = [];
	
	function __construct($db, $id = null) {		
		$this->db = $db;
		if (isset($id)) {
			$this->loadById($id);
		}
	}

	public function setData($data) {
		foreach ($data as $key => $value) {			
			$this->data[$key] = $value;
		}
	}

	public function val($key) {
		if (isset($this->data[$key])) {
			return $this->data[$key];
		} else {
			return null;
		}
	}

	public function loadById($id) {
		if (isset($id)) {
			$sql = sprintf('SELECT * FROM %s WHERE %s = ?', $this->table_name, $this->id_name);
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

	public function save() {
		$id = $this->val($this->id_name);		
		
		if (isset($id) && $id > 0) {
			$columns = [];
			$bindings = [];
			$types = '';
			
			foreach ($this->data as $key => $value) {
				if ($key != $this->id_name) {
					$columns[] = $key . ' = ?';
					$bindings[] = & $this->data[$key];
					$types .= 's';
				}
			}
			$bindings[] = & $this->data[$this->id_name];
			$types .= 'i';
			array_unshift($bindings, $types);
			$sql = sprintf('UPDATE %s SET %s WHERE %s = ?', $this->table_name, implode(',', $columns), $this->id_name);
			
			if ($st = $this->db->prepare($sql)) {
				call_user_func_array(array($st, 'bind_param'), $bindings);	
				if (!$st->execute()) {
					die('DB error:' . $this->db->error);
				}
				$st->close();
			} else {
				die('DB error:' . $this->db->error);
			}	
		} else {
			$columns = [];
			$values = [];
			$bindings = [];
			$types = '';
			
			foreach ($this->data as $key => $value) {
				if ($key != $this->id_name) {
					$columns[] = $key;
					$values[] = '?';
					$bindings[] = & $this->data[$key];
					$types .= 's';
				}
			}			
			array_unshift($bindings, $types);			
			$sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table_name, implode(',', $columns), implode(',', $values));
			
			if ($st = $this->db->prepare($sql)) {				
				call_user_func_array(array($st, 'bind_param'), $bindings);				
				if (!$st->execute()) {
					die('DB error:' . $this->db->error);
				} else {
					$this->data[$this->id_name] = $this->db->insert_id;
				}
				$st->close();
			} else {
				die('DB error:' . $this->db->error);
			}
		}
	}

	public function deleteById($id) {
		if (!isset($id)) {
			$id = $this->data[$this->id_name];
		}
		$sql = sprintf('DELETE FROM %s WHERE %s = ?', $this->table_name, $this->id_name);
		if ($statement = $this->db->prepare($sql)) {
			$statement->bind_param('i', $id);
			$statement->execute();
			$statement->close();
		} else {
			die('DB error:' . $this->db->error);
		}		
	}

}