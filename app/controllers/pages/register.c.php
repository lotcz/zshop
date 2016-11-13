<?php	
	global $db, $home_dir, $custAuth;
	require_once $home_dir . 'classes/forms.php';
	require_once $home_dir . 'classes/emails.php';
	
	$page_title	= t('Registration');
	
	if (!$custAuth->customer->val('customer_anonymous')) {
		$messages->add(t('You are already registered and logged in.'));
	} elseif (Form::submitted()) {
		
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
					Email::sendPlain('info@zshop.com', $email, null, 'Welcome to zShop', 'Hello, you have been registered.') {
					redirect(_g('ret','/'));
				} else {
					$messages->add(t('Cannot log you in. Sorry'));
				}
			}
		} else {
			$messages->error(t('Invalid password or email.'));
		}
		
	}
	
	$form = new Form('register_form');
	$form->add([		
		[
			'name' => 'register_email',
			'label' => 'E-mail',
			'type' => 'text',
			'validations' => [['type' => 'email']]
		],
		[
			'name' => 'register_password',
			'label' => 'Password',
			'type' => 'password',
			'validations' => [['type' => 'length', 'param' => 5]]
		],
		[
			'name' => 'register_password_confirm',
			'label' => 'Confirm Password',
			'type' => 'password',
			'validations' => [['type' => 'length', 'param' => 5], ['type' => 'confirm', 'param' => 'register_password']]
		]	
		
	]);