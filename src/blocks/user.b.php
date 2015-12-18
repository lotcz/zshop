<?php
	global $auth;
	
	if (isset($auth) && $auth->isAuth()) { 
		echo "<li><a href=\"/admin/user/edit/" . $auth->user->val('user_id') . "\">" . $auth->user->val('user_email') . "</a></li>";
		echo "<li><a href=\"/admin/logout\">" . t('Log out') . "</a></li>";
	}