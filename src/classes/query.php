<?php

class Paging {
	
	static $default_size = 10;	
	static $default_url_name = 'p';	
	public $offset = 0;
	
	function __construct($limit = null, $offset = 0) {
		if (isset($limit)) {
			$this->limit = intval($limit);
		} else {
			$this->limit = Paging::$default_size;
		}		
		if (isset($offset)) {
			$this->offset = $offset;
		}
	}

	static function getFromUrl($name = null) {
		if (!isset($name)) {
			$name = Self::$default_url_name;
		}			
		if (isset($_GET[$name])) {
			$arr = explode(',', $_GET[$name]);
			return new Paging(intval($arr[0]), intval($arr[1]));
		} else {
			return new Paging();
		}
	}
}

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