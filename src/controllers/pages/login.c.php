<?php
	global $custAuth;
	
	if (isset($_POST['email'])) { 
		$custAuth->login($_POST['email'], $_POST['password']);
		if ($custAuth->isAuth()) {
			redirect('/');
		} else {
			$messages->error(t('Login incorrect!'));
		}
	}
	
	$page_title	= t('Sign In');