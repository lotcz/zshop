<?php
	global $custAuth;
	
	if (isset($_POST['email'])) {
		if ($custAuth->login($_POST['email'], $_POST['password'])) {
			if (_g('r', false)) {
				redirect(_g('r'));
			} else {
				redirect('/');
			}
		} else {
			$messages->error(t('Login incorrect!'));
		}
	}
	
	$page_title	= t('Sign In');