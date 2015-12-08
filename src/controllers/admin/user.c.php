<?php
	
	global $db;
	
	if (isset($_POST['user_id'])) {
		// save user values
		if ($_POST['user_id'] > 0) {
			$user = User::LoadById($db, $_POST['user_id']);
		} else {
			$user = new User($db);
		}
		$user->user_login = $_POST['user_login'];
		$user->user_email = strtolower($_POST['user_email']);
		if (isset($_POST['user_password']) && strlen($_POST['user_password']) > 0) {
			$user->user_password_hash = Authentication::hashPassword($_POST['user_password']);
		}
		$user->save();
		redirect('/admin/users');
	} elseif (isset($path[2]) && $path[2] == 'edit') {
		// load for edit
		$user = User::LoadById($db, $path[3]);
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		User::deleteById($db, $path[3]);
		redirect('/admin/users');
	} else {
		// new user
		$user = new User($db);
		$user->user_id = 0;
	}