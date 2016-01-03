<?php

class User extends ModelBase {
	
	public $table_name = 'users';
	public $id_name = 'user_id';

	static $reset_password_expires_days = 7;

	public function loadByLoginOrEmail($loginoremail) {
		$where = 'user_login = ? OR user_email = ?';
		$bindings = [$loginoremail, $loginoremail];
		$types = 'ss';
		$this->loadSingleFiltered($where, $bindings, $types);		
	}
	
}