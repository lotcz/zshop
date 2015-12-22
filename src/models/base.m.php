<?php

class ModelBase {

	protected $db = null;

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
				if ($statement->execute()) {
					$result = $statement->get_result();
					if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$this->is_loaded = true;
						$this->setData($row);
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

	public function loadSingleFiltered($filter) {
		if (isset($filter) && is_array($filter)) {
			$columns = [];
			$bindings = [];
			$types = '';
			
			foreach ($filter as $key => $value) {			
				$columns[] = $key . ' = ?';
				$bindings[] = & $filter[$key];
				$types .= ModelBase::getTypeChar($value);			
			}
			array_unshift($bindings, $types);
			
			$sql = sprintf('SELECT * FROM %s WHERE %s', $this->table_name, implode(' AND ', $columns));
			if ($statement = $this->db->prepare($sql)) {
				call_user_func_array(array($statement, 'bind_param'), $bindings);
				if ($statement->execute()) {
					$result = $statement->get_result();
					if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$this->is_loaded = true;
						$this->setData($row);
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
					$types .= ModelBase::getTypeChar($value);
				}
			}
			$bindings[] = & $this->data[$this->id_name];
			$types .= 'i';
			array_unshift($bindings, $types);
			$sql = sprintf('UPDATE %s SET %s WHERE %s = ?', $this->table_name, implode(',', $columns), $this->id_name);
			
			if ($st = $this->db->prepare($sql)) {
				call_user_func_array(array($st, 'bind_param'), $bindings);	
				if (!$st->execute()) {
					dbErr($this->table_name, 'execute', $sql, $this->db->error);					
				}
				$st->close();
			} else {
				dbErr($this->table_name, 'prepare', $sql, $this->db->error);
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
					$types .= ModelBase::getTypeChar($value);
				}
			}			
			array_unshift($bindings, $types);			
			$sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table_name, implode(',', $columns), implode(',', $values));
			
			if ($st = $this->db->prepare($sql)) {				
				call_user_func_array(array($st, 'bind_param'), $bindings);				
				if (!$st->execute()) {
					dbErr($this->table_name, 'execute', $sql, $this->db->error);					
				} else {
					$this->data[$this->id_name] = $this->db->insert_id;
				}
				$st->close();
			} else {
				dbErr($this->table_name, 'prepare', $sql, $this->db->error);
			}
		}
	}

	public function deleteById($id) {
		if (!isset($id)) {
			$id = $this->val($this->id_name);
		}
		$sql = sprintf('DELETE FROM %s WHERE %s = ?', $this->table_name, $this->id_name);
		if ($statement = $this->db->prepare($sql)) {
			$statement->bind_param('i', $id);
			if ($statement->execute()) {
				$statement->close();	
			} else {
				dbErr($this->table_name, 'prepare', $sql, $this->db->error);
			}			
		} else {
			dbErr($this->table_name, 'prepare', $sql, $this->db->error);
		}		
	}

	/*
		format datetime for mysql
	*/
	static function mysqlTimestamp($d) {
		if (isset($d)) {
			return date('Y-m-d G:i:s', $d);	
		} else {
			return null;
		}		
	}
	
	/*
		get character representing type for bind_param function
	*/
	static function getTypeChar($val) {
		if (is_int($val)) {
			return 'i';	
		} else {
			return 's';
		}		
	}
	
}