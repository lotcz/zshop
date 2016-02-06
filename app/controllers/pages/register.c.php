<?php
	
	global $db, $home_dir, $custAuth;	
	
	if (!$custAuth->customer->val('customer_anonymous')) {
		$messages->add(t('You are already registered and logged in.'));
	} else {
		
		$email = myTrim(strtolower(_g('register_email')));
		$password = _g('register_password');
		
		// validate email and password once again 
		if ($custAuth->isValidEmail($email) && $custAuth->isValidPassword($password)) {			
			
			// check if email exists
			$customer = new Customer($db);
			$customer->loadByEmail($email);
			if ($customer->is_loaded) {
				$messages->error(t('This email is already used. '));
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
		} else {
			$messages->error(t('Invalid password or email.'));
		}
		
	}