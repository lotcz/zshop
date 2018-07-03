<?php
	$this->setPageTitle('Sign In');

	$this->z->core->includeJS('resources/forms.js');

	if (z::isPost()) {
		if ($this->z->custauth->login(z::get('email'), z::get('password'))) {
			$this->redirectBack();
		} else {
			$this->z->messages->error($this->t('Login incorrect!'));
		}
	}

	$page_title	= $this->t('Sign In');
