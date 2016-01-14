<?php

class Cart extends ModelBase {
	
	public $table_name = 'cart';
	public $id_name = 'cart_id';	

	public function load($product_id, $customer_id) {
		$filter = 'cart_product_id = ? AND cart_customer_id = ?';
		$this->loadSingleFiltered($filter, [$product_id, $customer_id]);		
	}
}