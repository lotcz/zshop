<?php

	include_once $home_dir . 'classes/emails.php';
	
	$page_title = t('Reset Password');
	
	$data['reset_valid'] = false;
	
	if (isset($path[2]) && isset($_GET['reset_token'])) {
		$user_id = intval($path[2]);
		$reset_token = $_GET['reset_token'];
		$zUser = new User($db, $user_id);
		
		$messages->add($zUser->val('user_reset_password_expires') > ModelBase::mysqlTimestamp(time()));
		$messages->add($reset_token);
		$messages->add($zUser->val('user_reset_password_hash'));
		
		if ($zUser->is_loaded && $zUser->val('user_reset_password_expires') > ModelBase::mysqlTimestamp(time()) && password_verify($reset_token, $zUser->val('user_reset_password_hash'))) {
			$data['reset_valid'] = true;
			$data['user_id'] = $zUser->val('user_id');
			$data['reset_token'] = $reset_token;
		} else {
			$messages->error(t('Your link seems to be invalid.'));
		}
	} else {
		$messages->error(t('This page should only be accessed from link sent to your e-mail.'));
	}