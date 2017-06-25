<?php
	$this->setPageTitle('Shopping Cart');
	$this->setMainTemplate = 'nocats';
	$this->setData('cart_products', $this->z->cart->loadCartProducts());
	$this->includeJS('js/cart.js');