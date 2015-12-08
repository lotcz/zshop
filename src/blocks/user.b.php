<?php
	global $auth;
	
	if (isset($auth) && $auth->isAuth()) { 
		echo "<li>" . $auth->user->user_email . "</li>";
		echo "<li><a href=\"/admin/logout\">" . t('Log out') . "</a></li>";
	}