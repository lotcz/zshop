<?php

	include_once $home_dir . 'classes/emails.php';
	
	$page_title = t('Reset Password');
	
	if (isset($page[2])) {
		$arr = explode('-', $page[2]);
		
		$zUser = new User($db, $arr[0]);
		if ($zUser->is_loaded) {
			$reset_token = generateToken(50);
			$expires = time() + User::$reset_password_expires;
			$zUser->data['user_reset_password_hash'] = Authentication::hashPassword($reset_token);			
			$zUser->data['user_reset_password_expires'] = ModelBase::mysqlTimestamp($expires);
			$zUser->save();
			
			Emails::sendPlain($globals['emails_from'], $zUser->val('user_email'), '', t('Forgotten Password'), t('To reset your password, visit this link: %s.', $reset_token));
			$messages->add(t('An e-mail was sent to your address with reset password instructions.'));
		} else {
			$messages->error(t('Your link seems to be invalid.'));
		}
	} else {
		$messages->error(t('This page should only be accessed from link sent to your e-mail.'));
	}