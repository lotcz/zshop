<?php

require_once '../models/customer.m.php';
require_once '../models/custsess.m.php';

/*
	provides customer authentication mechanism
*/
class CustomerAuthentication {
	
	private $db = null;
	
	private $cookie_name = 'customer_session_token';
		
	public $customer = null;
	public $session = null;
	public $customer_id = 0;
	
	static $max_attempts = 100;
	static $session_expire = 60*60*24*7; //7 days
	
	function __construct($auth_db) {
		$this->db = $auth_db;
		$this->checkAuthentication();
	}

	public function isAuth() {
		return isset($this->customer) && isset($this->session);
	}
	
	public function login($email, $password) {
		
		if (isset($_COOKIE[$this->cookie_name])) {
			$this->logout();
		}
		
		$customer = new Customer($this->db);
		$customer->loadByEmail($email);
		
		if (isset($customer) && $customer->is_loaded) {
			if ($customer->val('customer_failed_attempts') > $this::$max_attempts) {
				$messages[] = t('Max. number of login attempts exceeded. Please ask for new password.');
			}
			if (CustomerAuthentication::verifyPassword($password, $customer->val('customer_password_hash'))) {
				// success - create new session				
				$this->customer = $customer;
				$this->updateLastAccess();
				$token = $this->generateToken();
				$token_hash = CustomerAuthentication::hashPassword($token);
				$expires = time()+CustomerAuthentication::$session_expire;
				$session = new CustomerSession($this->db);
				$session->data['customer_session_token_hash'] = $token_hash;
				$session->data['customer_session_customer_id'] = $this->customer->val('customer_id');
				$session->data['customer_session_expires'] = SqlQuery::mysqlTimestamp($expires);
				$session->save();
				setcookie($this->cookie_name, $session->val('customer_session_id') . "-" . $token, $expires, '/', false, false); 				
				$this->session = $session;
			} else {
				$customer->data['customer_failed_attempts'] += 1;
				$customer->save();
			}
			
		}
		
	}
	
	public function checkAuthentication() {
		$this->customer = null;
						
		if (isset($_COOKIE[$this->cookie_name])) {
			$arr = explode('-', $_COOKIE[$this->cookie_name]);
			$session_id = intval($arr[0]);
			$session_token = $arr[1];
		}
		
		if (isset($session_id)) {
			$this->session = new CustomerSession($this->db, $session_id);			
			if (isset($this->session) && $this->session->is_loaded && CustomerAuthentication::verifyPassword($session_token, $this->session->val('customer_session_token_hash'))) {
				$expires = time()+CustomerAuthentication::$session_expire;
				$session = new CustomerSession($this->db);
				$session->data['customer_session_id'] = $session_id;
				$session->data['customer_session_expires'] = SqlQuery::mysqlTimestamp($expires);
				$session->save();
				setcookie($this->cookie_name, $this->session->val('customer_session_id') . '-' . $session_token, $expires, '/', false, false); 				
				$this->customer = new Customer($this->db, $this->session->val('customer_session_customer_id'));				
				$this->updateLastAccess();
			}
		}
		
		if ($this->isAuth()) {
			$this->customer_id = $this->customer->val('customer_id');
		} else {
			$this->customer_id = 0;
		}
	}
	
	public function updateLastAccess() {
		if ($this->isAuth()) {
			$customer = new Customer($this->db);
			$customer->data['customer_id'] = $this->customer->val('customer_id');
			$customer->data['customer_last_access'] = SqlQuery::mysqlTimestamp(time());
			$customer->save();
		}
	}
	
	public function logout() {
		$this->customer = null;
		
		if (isset($_COOKIE[$this->cookie_name])) {			
			unset($_COOKIE[$this->cookie_name]);
			setcookie($this->cookie_name, '', time()-3600, '/', false, false);
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
	
	static function verifyPassword($pass, $hash) {
		return password_verify($pass, $hash);
	}
	
}