<?php

class Language extends ModelBase {
	
	public $table_name = 'languages';
	public $id_name = 'language_id';
	
	public function loadByCode($code) {
		$filter = 'language_code = ?';
		$this->loadSingleFiltered($filter, [$code]);
	}
	
}