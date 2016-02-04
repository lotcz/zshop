<?php
	global $home_dir, $db, $custAuth;
			
	$access = _g('access');
	$name = _g('name');	
	
	if ($custAuth->customer->val('customer_anonymous')) {	
		$custAuth->customer->data['customer_anonymous'] = 0;
		$custAuth->customer->data['customer_name'] = $name;
		$custAuth->customer->data['customer_email'] = $name . '@' . $access;
		$custAuth->customer->data['customer_fb_access'] = $access;
		$custAuth->customer->save();		
	} else {
		$custAuth->logout();
		$custAuth->loginWithFacebook($access);	
	}
	
	$data = $custAuth->session->data;