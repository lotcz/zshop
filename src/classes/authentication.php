<?php

require_once '../models/user.m.php';
require_once '../models/session.m.php';

/*
	provides basic authentication mechanism
*/
class Authentication {
	
	private $db = null;
	
	private $cookie_name = 'session_token';
		
	public $user = null;
	public $session = null;
	
	static $max_attempts = 100;
	static $session_expire = 60*60*24*30; //30 days
	
	function __construct($auth_db) {
		$this->db = $auth_db;
		$this->checkAuthentication();
	}

	public function isAuth() {
		return isset($this->user) && isset($this->session);
	}
	
	public function login($loginoremail, $password) {
		
		if (isset($_COOKIE[$this->cookie_name])) {
			$this->logout();
		}
		
		$user = new User($this->db);
		$user->loadByLoginOrEmail($loginoremail);
		
		if ($user->is_loaded) {
			if ($user->val('user_failed_attempts') > $this::$max_attempts) {
				$messages[] = t('Max. number of login attempts exceeded. Please ask for new password.');
			}
			if (password_verify($password, $user->val('user_password_hash'))) {
				// success - create new session				
				$this->user = $user;
				$this->updateLastAccess();
				$token = $this->generateToken();
				$token_hash = password_hash($token, PASSWORD_DEFAULT);
				$expires = time()+Authentication::$session_expire;
				$session = new UserSession($this->db);
				$session->data['user_session_token_hash'] = $token_hash;
				$session->data['user_session_user_id'] = $this->user->val('user_id');
				$session->data['user_session_expires'] = ModelBase::mysqlTimestamp($expires);
				$session->save();
				setcookie($this->cookie_name, $session->val('user_session_id') . "-" . $token, $expires, '/', false, false); 				
				$this->session = $session;
			} else {
				$user->data['user_failed_attempts'] += 1;
				$user->save();
			}
			
		}
		
	}
	
	public function checkAuthentication() {
		$this->user = null;
						
		if (isset($_COOKIE[$this->cookie_name])) {
			$arr = explode('-', $_COOKIE[$this->cookie_name]);
			$session_id = $arr[0];
			$session_token = $arr[1];
		}
		
		if (isset($session_id)) {
			$this->session = new UserSession($this->db, $session_id);			
			if (password_verify($session_token, $this->session->val('user_session_token_hash'))) {
				$expires = time()+Authentication::$session_expire;
				$session = new UserSession($this->db);
				$session->data['user_session_id'] = $session_id;
				$session->data['user_session_expires'] = ModelBase::mysqlTimestamp($expires);
				$session->save();
				setcookie($this->cookie_name, $this->session->val('user_session_id') . "-" . $session_token, $expires, '/', false, false); 				
				$this->user = new User($this->db, $this->session->val('user_session_user_id'));				
				$this->updateLastAccess();
			}
		}
	}
	
	public function updateLastAccess() {
		if ($this->isAuth()) {
			$user = new User($this->db);
			$user->data['user_id'] = $this->user->val('user_id');
			$user->data['user_last_access'] = ModelBase::mysqlTimestamp(time());
			$user->save();
		}
	}
	
	public function logout() {
		$this->user = null;
		
		if (isset($_COOKIE[$this->cookie_name])) {			
			unset($_COOKIE[$this->cookie_name]);
			setcookie($this->cookie_name, '', time()-3600);
		}
		
		if (isset($this->session)) {
			$this->session->deleteById();
			$this->session = null;
		}
	}
	
	private function generateToken() {
		return generateToken(50);
	}

	static function hashPassword($pass) {
		return password_hash($pass, PASSWORD_DEFAULT);
	}
	
}