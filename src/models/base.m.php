<?php

require_once '../classes/query.php';
	
class ModelBase {

	protected $db = null;

	public $table_name = 'table';
	public $id_name = 'table_id';
	
	public $is_loaded = false;
	public $data = [];
	
	function __construct($db = null, $id = null) {		
		$this->db = $db;
		if (isset($id)) {
			$this->loadById($id);
		}
	}

	public function setData($data, $only_update = false) {
		foreach ($data as $key => $value) {			
			if (isset($this->data[$key]) or !$only_update) {
				$this->data[$key] = $value;	
			}
		}
	}

	public function val($key) {
		if (isset($this->data[$key])) {
			return $this->data[$key];
		}
	}
	
	public function loadSingleFiltered($where, $bindings = null, $types = null) {
		$statement = SqlQuery::select($this->db, $this->table_name, $where, $bindings, $types);
		if ($statement) {
			$result = $statement->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$this->is_loaded = true;
				$this->setData($row);
			}
			$statement->close();
		}		
	}

	public function loadById($id) {		
		$where = sprintf('%s = ?', $this->id_name);
		$bindings = [$id];
		return $this->loadSingleFiltered($where, $bindings);
	}

	static function select($db, $table_name, $where = null, $bindings = null, $types = null, $paging = null, $orderby = null) {		
		$stmt = SqlQuery::select($db, $table_name, $where, $bindings, $types, $paging, $orderby);
		$result = $stmt->get_result();
		$list = [];
		$class = get_called_class();
		while ($row = $result->fetch_assoc()) {			
			$model = new $class($db);	
			$model->setData($row);
			$list[] = $model;
		}
		$stmt->close();
		return $list;
	}
	
	public function fetch() {
		return $this->result->fetch_assoc();
	}
	
	public function close() {
		return $this->stmt->close();
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
					$types .= SqlQuery::getTypeChar($value);
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
					$types .= SqlQuery::getTypeChar($value);
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
		
}