<?php

class Customer extends ModelBase {
	
	public $table_name = 'customers';
	public $id_name = 'customer_id';
	
	static $reset_password_expires_days = 7;

	public function loadByEmail($email) {
		$where = 'customer_email = ?';
		$bindings = [$email];
		$types = 's';
		$this->loadSingleFiltered($where, $bindings, $types);		
	}
	
}