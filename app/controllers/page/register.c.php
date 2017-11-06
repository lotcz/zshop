<?php
	$this->requireModule('forms');
	$this->setPageTitle('Registration');

	$form = new zForm('register_form');
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
		]
	]);

	$render_form = true;

	if (!$this->z->custauth->isAnonymous()) {
		$this->z->messages->add($this->t('You are already registered and logged in!'));
		$render_form = false;
	} elseif (z::isPost()) {

		$email = trim(strtolower(z::get('customer_email')));
		$password = z::get('customer_password');

		// validate email and password once again
		if ($this->z->custauth->isValidEmail($email) && $this->z->custauth->isValidPassword($password)) {

			// check if email exists
			$existing_customer = new CustomerModel($this->db);
			$existing_customer->loadByEmail($email);
			if ($existing_customer->is_loaded) {
				$this->z->messages->error($this->t('This email is already used!'));
			} else {
				$customer = $this->getCustomer();
				$customer->data['customer_name'] = null;
				$customer->data['customer_email'] = $email;
				$customer->data['customer_anonymous'] = 0;
				$customer->data['customer_password_hash'] = $this->z->custauth->hashPassword($password);
				$customer->save();

				if ($this->z->custauth->login($email, $password)) {
					$this->z->custauth->sendRegistrationEmail();
					$this->redirect('welcome');
					$render_form = false;
				} else {
					$this->z->messages->error($this->t('Cannot log you in. Something went wrong during registration process.'));
				}
			}
		} else {
			$this->z->messages->error($this->t('Invalid password or email.'));
		}

	}

	if ($render_form) {
		$this->setData('form', $form);
	}
