<?php
	$this->setPageTitle('Sign In');

	$this->z->core->includeJS('resources/forms.js');

	if ($this->isPost()) {
		if ($this->z->custauth->login($this->get('email'), $this->get('password'))) {
			$this->redirectBack();
		} else {
			$this->z->messages->error($this->t('Login incorrect!'));
		}
	}

	$page_title	= $this->t('Sign In');
