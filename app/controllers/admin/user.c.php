<?php
	
	global $db;
	
	if (isset($_POST['user_id'])) {
		// save user values
		if ($_POST['user_id'] > 0) {
			$user = new User($db, $_POST['user_id']);
		} else {
			$user = new User($db);
		}
		$user->setData($_POST);
		unset($user->data['user_password']);
		$user->data['user_email'] = strtolower($_POST['user_email']);		
		if (isset($_POST['user_password']) && strlen($_POST['user_password']) > 0) {
			$user->data['user_password_hash'] = Authentication::hashPassword($_POST['user_password']);
		}
		$user->save();
		redirect('/admin/users');
	} elseif (isset($path[2]) && $path[2] == 'edit') {
		$user = new User($db, $path[3]);
		$page_title	= t('Editing Administrator');
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		$user = new User($db);
		$user->deleteById($path[3]);
		redirect('/admin/users');
	} else {
		$user = new User($db);
		$page_title	= t('New Administrator');
	}
	
	$data = $user;