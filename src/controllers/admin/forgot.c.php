<?php

	include_once $home_dir . 'classes/emails.php';
	
	$page_title = t('Forgotten Password');
	
	if (isset($_POST['email'])) {
		$zUser = new User($db);
		$zUser->loadByLoginOrEmail($_POST['email']);
		if ($zUser->is_loaded) {
			$reset_token = generateToken(50);
			$expires = time() + User::$reset_password_expires;
			$zUser->data['user_reset_password_hash'] = Authentication::hashPassword($reset_token);			
			$zUser->data['user_reset_password_expires'] = ModelBase::mysqlTimestamp($expires);
			$zUser->save();
			
			Emails::sendPlain($globals['emails_from'], $zUser->val('user_email'), '', t('Forgotten Password'), t('To reset your password, visit this link: %s.', $reset_token));
			$messages->add(t('An e-mail was sent to your address with reset password instructions.'));
		} else {
			$messages->error(t('This e-mail address or login was not found in our database.'));
		}
	}