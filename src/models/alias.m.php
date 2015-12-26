<?php

class Alias extends ModelBase {
	
	public $table_name = 'aliases';
	public $id_name = 'alias_id';
	
	static $target_type_item = 1;
	static $target_type_category = 2;
	static $target_type_static = 3;
	
	public function loadByUrl($url) {
		$filter['alias_url'] = $url;
		$this->loadSingleFiltered($filter);
	}

}