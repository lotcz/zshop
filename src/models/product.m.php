<?php

class Product extends ModelBase {
	
	public $table_name = 'products';
	public $id_name = 'product_id';
	
	public function loadByAbxId($id) {
		$filter['product_abx_id'] = intval($id);
		$this->loadSingleFiltered($filter);		
	}
	
	public function removeFromAllCategories() {		
		$sql = 'DELETE FROM product_category WHERE product_category_product_id = ?';
		if ($statement = $this->db->prepare($sql)) {
			$statement->bind_param('i', $this->val($this->id_name));
			$statement->execute();
			$statement->close();
		} else {
			dbErr($this->table_name, 'prepare', $sql, $this->db->error);
		}		
	}
	
	public function addToCategory($category_id) {		
		$sql = 'INSERT INTO product_category (product_category_product_id, product_category_category_id) VALUES(?,?)';
		if ($statement = $this->db->prepare($sql)) {
			$statement->bind_param('ii', $this->val($this->id_name), $category_id);
			$statement->execute();
			$statement->close();
		} else {
			dbErr($this->table_name, 'prepare', $sql, $this->db->error);
		}		
	}
	/*
	static function select($db, $table_name, $where = null, $bindings = null, $types = null, $paging = null, $orderby = null) {		
		$stmt = SqlQuery::select($db, $table_name, $where, $bindings, $types, $paging, $orderby);
		$result = $stmt->get_result();
		$list = [];
		while ($row = $result->fetch_assoc()) {
			$model = new Self($db);	
			$model->setData($row);
			$list[] = $model;
		}
		$stmt->close();
		return $list;
	}
	*/
	public function test() {
			return 'Hello World!';
	}
	
}