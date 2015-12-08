<?php

require_once $home_dir . 'models/user.m.php';

/*
	provides basic authentication mechanism
*/
class Authentication {
	
	private $db = null;
	
	private $cookie_name = 'session_token';
		
	public $user = null;
	
	static $max_attempts = 100;
	
	function __construct($auth_db) {
		$this->db = $auth_db;
		$this->checkAuthentication();
	}

	public function isAuth() {
		return isset($this->user);
	}
	
	public function login($loginoremail, $password) {
		
		if (isset($_COOKIE[$this->cookie_name])) {
			$this->logout();
		}
		
		$user = User::loadByLoginOrEmail($this->db, $loginoremail);
		if (isset($user)) {
			if ($user->user_failed_attempts > $this::$max_attempts) {
				redirect('/error.html');
			}
			if (password_verify($password, $user->user_password_hash)) {
				// success - create new session
				$this->user = $user;
				$token = $this->generateToken();
				$token_hash = password_hash($token, PASSWORD_DEFAULT);
				$expires = time()+60*60*24*30; //30 days
				if ($st = $this->db->prepare('INSERT INTO user_sessions (user_session_token_hash, user_session_user_id, user_session_expires) VALUES (?,?,?)')) {
					$st->bind_param('sis', $token_hash, $this->user->user_id, date('Y-m-d G:i:s', $expires));
					if (!$st->execute()) {
						die('Session db error:' . $this->db->error);
					}						
					$st->close();
					setcookie($this->cookie_name, $this->db->insert_id . "-" . $token, $expires, '/', false, false); 
				} else {
					die('Session db error:' . $this->db->error);
				}
			} else {
				$user->user_failed_attempts += 1;
				$user->save();
			}
		}
		
	}
	
	public function checkAuthentication() {
		$this->user = null;
						
		if (isset($_COOKIE[$this->cookie_name])) {
			$arr = explode("-", $_COOKIE[$this->cookie_name]);
			$session_id = $arr[0];
			$session_token = $arr[1];
		}
		
		if (isset($session_id)) {
			$statement = $this->db->prepare('SELECT user_session_user_id, user_session_token_hash FROM user_sessions WHERE user_session_id = ?');
			$statement->bind_param('i', $session_id);
			$statement->execute();
			$statement->bind_result($user_id, $session_token_hash);			
			$statement->fetch();
			$statement->close();
			if (password_verify($session_token, $session_token_hash)) {
				$this->user = User::loadById($this->db, $user_id);
			}
		}
	}
	
	public function logout() {
		$this->user = null;
		
		if (isset($_COOKIE[$this->cookie_name])) {
			$arr = explode("-", $_COOKIE[$this->cookie_name]);
			$session_id = $arr[0];
			$session_token = $arr[1];
			unset($_COOKIE[$this->cookie_name]);
			setcookie($this->cookie_name, '', time()-3600);
		}
		
		if (isset($session_id)) {
			$statement = $this->db->prepare('DELETE FROM user_sessions WHERE user_session_id = ?');
			$statement->bind_param('s', $session_id);
			$statement->execute();
			$statement->close();
		}
	}
	
	private function generateToken() {
		return generateToken(50);
	}

	static function hashPassword($pass) {
		return password_hash($pass, PASSWORD_DEFAULT);
	}
	
}