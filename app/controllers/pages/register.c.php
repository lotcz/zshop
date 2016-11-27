<?php	
	global $db, $home_dir, $custAuth;
	require_once $home_dir . 'classes/forms.php';
	require_once $home_dir . 'classes/emails.php';
	
	$page_title	= t('Registration');
	
	$form = new Form('register_form');
	$form->add([		
		[
			'name' => 'customer_email',
			'label' => 'E-mail',
			'type' => 'text',
			'validations' => [['type' => 'email']]
		],
		[
			'name' => 'customer_password',
			'label' => 'Password',
			'type' => 'password',
			'validations' => [['type' => 'length', 'param' => 5]]
		],
		[
			'name' => 'customer_password_confirm',
			'label' => 'Confirm Password',
			'type' => 'password',
			'validations' => [['type' => 'confirm', 'param' => 'customer_password']]
		],
		[
			'label' => 'Shipping Address',
			'type' => 'begin_group'
		],
		[
			'name' => 'customer_ship_name',
			'label' => 'Name',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_ship_city',
			'label' => 'City',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_ship_street',
			'label' => 'Street',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_ship_zip',
			'label' => 'ZIP',
			'type' => 'text',
			'validations' => [
				['type' => 'integer', 'param' => true]
			]
		],
		[
			'type' => 'end_group'
		],		
		
	]);
	
	if (!$custAuth->isAnonymous()) {
		$messages->add(t('You are already registered and logged in.'));
	} elseif (Form::submitted()) {
		
		$email = myTrim(strtolower(_g('customer_email')));
		$password = _g('customer_password');
		
		// validate email and password once again 
		if ($custAuth->isValidEmail($email) && $custAuth->isValidPassword($password)) {			
			
			// check if email exists
			$customer = new Customer($db);
			$customer->loadByEmail($email);
			if ($customer->is_loaded) {
				$messages->error(t('This email is already used.'));
			} else {				
				$custAuth->customer->setData($form->processInput($_POST));
				$custAuth->customer->data['customer_name'] = null;
				$custAuth->customer->data['customer_email'] = $email;
				$custAuth->customer->data['customer_anonymous'] = 0;
				$custAuth->customer->data['customer_password_hash'] = CustomerAuthentication::hashPassword($password);
				unset($custAuth->customer->data['customer_password']);		
				unset($custAuth->customer->data['customer_password_confirm']);
				$custAuth->customer->save();
								
				if ($custAuth->login($email, $password)) {
					Emails::sendPlain('info@zshop.com', $email, null, 'Welcome to zShop', 'Hello, you have been registered.');
					redirect(_g('ret','/'));
				} else {
					$messages->error(t('Cannot log you in. Something went wrong during registration process.'));
				}
			}
		} else {
			$messages->error(t('Invalid password or email.'));
		}
		
	}
	