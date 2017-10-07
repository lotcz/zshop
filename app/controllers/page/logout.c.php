<?php

	if ($this->isCustAuth() && !$this->z->custauth->val('customer_anonymous')) {
		$this->z->custauth->logout();
	}
	
	$this->redirectBack('');
