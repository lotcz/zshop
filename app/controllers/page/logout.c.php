<?php
	global $custAuth;
	
	if ($custAuth->isAuth() && !$custAuth->val('customer_anonymous')) {
		$custAuth->logout();		
	}
	
	redirect(_g('ret','/'));