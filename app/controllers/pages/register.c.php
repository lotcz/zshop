<?php
	
	global $db, $home_dir, $custAuth;	
	
	if ($custAuth->isAuth() && $custAuth->customer->val('customer_anonymous')) {
		$email = myTrim(strtolower(_g('register_email')));
		$password = _g('register_password');
		
		// check if email exists
		$customer = new Customer($db);
		$customer->loadByEmail($email);
		if ($customer->is_loaded) {
			$messages->add(t('This email is already used. '));
		} else {
			$custAuth->customer->data['customer_name'] = null;
			$custAuth->customer->data['customer_email'] = $email;
			$custAuth->customer->data['customer_anonymous'] = 0;
			$custAuth->customer->data['customer_password_hash'] = CustomerAuthentication::hashPassword($password);
			$custAuth->customer->save();
			
			$custAuth->login($email, $password);
			if ($custAuth->isAuth()) {
				redirect(_g('ret','/'));
			} else {
				$messages->add(t('Cannot log you in. Sorry'));
			}
		}		
		
	} elseif ($custAuth->isAuth()) {
		$messages->add(t('You are already registered and logged in.'));
	} else {
		$messages->add(t('You cannot register without turning cookies on.'));
	}	