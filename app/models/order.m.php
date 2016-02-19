<?php

require_once $home_dir . 'models/ord_prod.m.php';

class Order extends ModelBase {
	
	public $table_name = 'orders';
	public $id_name = 'order_id';	

	public function loadProducts() {
		$this->products = OrderProduct::select(
		/* db */		$this->db, 
		/* table */		'viewOrderProducts', 
		/* where */		'order_product_order_id = ?',
		/* bindings */	[ $this->ival('order_id') ],
		/* types */		'i',
		/* paging */	null,
		/* orderby */	'order_product_name'
		);		
	}
	
}