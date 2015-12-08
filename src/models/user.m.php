<?php

class User {
	
	private $db = null;

	public $user_id = null;
	public $user_login = '';
	public $user_email = '';
	public $user_password_hash = '';
	public $user_failed_attempts = 0;
	
	function __construct($db) {
		$this->db = $db;
	}
   		
	static function loadById($db, $user_id) {
		$user = new User($db);
		if (isset($user_id)) {
			if ($statement = $db->prepare('SELECT user_id, user_login, user_email, user_password_hash, user_failed_attempts FROM users WHERE user_id = ?')) {
				$statement->bind_param('i', $user_id);
				$statement->execute();
				$statement->bind_result($user->user_id, $user->user_login, $user->user_email, $user->user_password_hash, $user->user_failed_attempts);
				$statement->fetch();
				$statement->close();			
			} else {
				die('User db error:' . $db->error);
			}
		}
		if (isset($user->user_id)) {
			return $user;
		} else {
			return null;
		}
	}
	
	static function loadByLoginOrEmail($db, $loginoremail) {
		$user = new User($db);
		if (isset($loginoremail)) {
			if ($statement = $db->prepare('SELECT user_id, user_login, user_email, user_password_hash, user_failed_attempts FROM users WHERE user_login = ? OR user_email = ?')) {
				$statement->bind_param('ss', $loginoremail, $loginoremail);
				$statement->execute();
				$statement->bind_result($user->user_id, $user->user_login, $user->user_email, $user->user_password_hash, $user->user_failed_attempts);
				$statement->fetch();
				$statement->close();			
			} else {
				die('User db error:' . $db->error);
			}
		}
		if (isset($user->user_id)) {
			return $user;
		} else {
			return null;
		}
	}
	
	public function save() {
		if (isset($this->user_id)) {
			if ($st = $this->db->prepare('UPDATE users SET user_login = ?, user_email = ?, user_password_hash = ?, user_failed_attempts = ? WHERE user_id = ?')) {
				$st->bind_param('sssii', $this->user_login, $this->user_email, $this->user_password_hash, $this->user_failed_attempts, $this->user_id);
				if (!$st->execute()) {
					die('User db error:' . $this->db->error);
				}
				$st->close();
			} else {
				die('User db error:' . $this->db->error);
			}	
		} else {
			if ($st = $this->db->prepare('INSERT INTO users (user_login, user_email, user_password_hash, user_failed_attempts) VALUES (?,?,?,?)')) {
				$st->bind_param('sssi', $this->user_login, $this->user_email, $this->user_password_hash, $this->user_failed_attempts);
				if (!$st->execute()) {
					die('User db error:' . $this->db->error);
				} else {
					$this->user_id = $this->db->insert_id;
				}
				$st->close();
			} else {
				die('User db error:' . $this->db->error);
			}
		}
	}

	static function deleteById($db, $user_id) {
		if (isset($user_id)) {
			if ($statement = $db->prepare('DELETE FROM users WHERE user_id = ?')) {
				$statement->bind_param('i', $user_id);
				$statement->execute();				
				$statement->close();			
			} else {
				die('User db error:' . $db->error);
			}
		}
	}
	
}