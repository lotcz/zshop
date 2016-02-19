<?php

class SqlQuery {
	
	public $db = null;
	public $table_name = 'table';	
	public $query_type = 'select';
	public $where = null;
	public $whereSQL = '';
	public $bindings = null;
	public $types = null;
	public $orderby = null;
	public $orderbySQL = '';
	public $paging = null;
	public $limitSQL = '';
	
	function __construct($db, $table_name, $query_type = null) {
		$this->db = $db;		
		$this->table_name = $table_name;
		if (isset($query_type)) {
			$this->query_type = $query_type;
		}
	}
	
	static function mysqlTimestamp($d) {
		if (isset($d)) {
			return date('Y-m-d H:i:s', $d);	
		} else {
			return null;
		}		
	}
	
	static function validateColumn($col) {
		return substr($col,0,50);
	}
	
	static function getTypeChar($val) {
		if (is_int($val)) {
			return 'i';	
		} else {
			return 's';
		}		
	}
	
	static function executeSQL($db, $sql, $bindings = null, $types = null) {
		if ($statement = $db->prepare($sql)) {
			if (isset($bindings)) {
				$reset_types = false;
				if (!isset($types)) {
					$types = '';
					$reset_types = true;
				}
				$bindings_ref = [];
				foreach ($bindings as $key => $value) {
					$bindings_ref[] = & $bindings[$key];
					if ($reset_types) {
						$types .= SqlQuery::getTypeChar($value);
					}
				}			
				array_unshift($bindings_ref, $types);
				call_user_func_array(array($statement, 'bind_param'), $bindings_ref);
			}
			if ($statement->execute()) {
				return $statement;
			} else {
				dbErr('query', 'execute', $sql, $db->error);					
			}			
		} else {
			dbErr('query', 'prepare', $sql, $db->error);				
		}
	}
	
	static function getRecordCount($db, $table_name, $whereSQL = '', $bindings = null, $types = null) {
		$count = null;
		$sql = sprintf('SELECT count(*) AS cnt FROM %s %s', $table_name, $whereSQL);
		$statement = Self::executeSQL($db, $sql, $bindings, $types);
		$result = $statement->get_result();
		if ($row = $result->fetch_assoc()) {
			$count = $row['cnt'];
		}
		$statement->close();
		return $count;
	}
	
	public function execute() {

		if (isset($this->orderby)) {
			$this->orderbySQL = sprintf('ORDER BY %s', $this->orderby);
		}
		
		if (isset($this->paging)) {
			$this->limitSQL = sprintf('LIMIT %d,%d', $this->paging->offset, $this->paging->limit);			
		}
		
		if (isset($this->where)) {			
			$this->whereSQL = sprintf('WHERE %s', $this->where);
		}
		
		switch ($this->query_type) {
			
			default:
				$sql = sprintf('SELECT * FROM %s %s %s %s', $this->table_name, $this->whereSQL, $this->orderbySQL, $this->limitSQL);
		
		}
		
		if (isset($this->paging) && !isset($this->paging->total_records)) {
			$this->paging->total_records = SqlQuery::getRecordCount($this->db, $this->table_name, $this->whereSQL, $this->bindings, $this->types);
		}
		
		//dbg($sql);
		//$messages->render();
		
		
		return SqlQuery::executeSQL($this->db, $sql, $this->bindings, $this->types);
	}
	
	static function select($db, $table_name, $where = null, $bindings = null, $types = null, $paging = null, $orderby = null) {
		$query = new SqlQuery($db, $table_name);
		$query->where = $where;
		$query->bindings = $bindings;
		$query->types = $types;
		$query->paging = $paging;
		$query->orderby = $orderby;
		return $query->execute();
	}
	
}