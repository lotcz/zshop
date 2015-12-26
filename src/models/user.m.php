<?php

class User extends ModelBase {
	
	public $table_name = 'users';
	public $id_name = 'user_id';

	static $reset_password_expires_days = 7;

	public function loadByLoginOrEmail($loginoremail) {
		$sql = sprintf('SELECT * FROM %s WHERE user_login = ? OR user_email = ?', $this->table_name);
		if ($statement = $this->db->prepare($sql)) {
			$statement->bind_param('ss', $loginoremail, $loginoremail);
			$statement->execute();
			$result = $statement->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$this->is_loaded = true;
				$this->setData($row);
			}
			$statement->close();
		} else {
			dbErr($this->table_name, 'prepare', $sql, $this->db->error);
		}		
	}
	
}