<?php

	$this->setPageTitle('Forgotten Password');
	$this->z->core->includeJS('resources/forms.js');

	if ($this->isPost()) {
		$customer = new CustomerModel($this->db);
		$customer->loadByEmail($this->get('email'));
		if ($customer->is_loaded) {
			$reset_token = $this->z->custauth->generateResetPasswordToken();
			$expires = time() + $this->z->custauth->getConfigValue('reset_password_expires');
			$customer->set('customer_reset_password_hash', $this->z->custauth->hashPassword($reset_token));
			$customer->set('customer_reset_password_expires', zSqlQuery::mysqlTimestamp($expires));
			$customer->save();

			$email_text = $this->t('To reset your password, visit this link: %s?email=%s&reset_token=%s. This link is only valid for %d days.', $this->url('password-reset'), $customer->val('customer_email'), $reset_token, 7);
			$this->z->emails->sendPlain($customer->val('customer_email'), $this->t('Forgotten Password'), $email_text);
			$this->message('An e-mail was sent to your address with reset password instructions.');
		} else {
			// increase ip address failed attempts
			IpFailedAttemptModel::saveFailedAttempt($this->db);
			$this->message('This e-mail address or login was not found in our database.','error');
		}
	}
