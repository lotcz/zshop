<?php
	$page_title = $this->t('Shopping Cart');
	$main_template = 'nocats';
	$data['cart_products'] = $this->z->cart->loadCartProducts();

