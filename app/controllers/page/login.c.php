<?php

	if (isPost()) {
		$cart_products = null;
		$cart_totals = null;
				
		if ($this->z->custauth->login(get('email'), get('password'))) {
			redirect(get('r', 'front'));			
		} else {
			$this->z->messages->error($this->t('Login incorrect!'));
		}
	}
	
	$page_title	= $this->t('Sign In');