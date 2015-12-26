<?php

class Category extends ModelBase {
	
	public $table_name = 'categories';
	public $id_name = 'category_id';
	
	public function loadByAbxId($id) {
		$filter['category_abx_id'] = $id;
		$this->loadSingleFiltered($filter);
	}

}