<?php
	
	if (isset($_POST['login'])) { 
		$auth->login($_POST['login'], $_POST['password']);
		if ($auth->isAuth()) {
			redirect('admin/dashboard');
		} else {
			$messages[] = t('Login incorrect!');
		}
	}
	
	$page_title	= t('Administrator Sign In');