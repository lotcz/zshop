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
	
	public function createOrder() {
		$order = new Order($db);
		$order->data['order_order_state_id'] = OrderState::$new;
		$order->data['order_customer_id'] = $custAuth->val('customer_id');
		$order->data['order_delivery_type_id'] = $selected_delivery->ival('delivery_type_id');
		$order->data['order_payment_type_id'] = $selected_payment->ival('payment_type_id');			
		$order->data['order_ship_name'] = $custAuth->val('customer_ship_name');
		$order->data['order_ship_city'] = $custAuth->val('customer_ship_city');
		$order->data['order_ship_street'] = $custAuth->val('customer_ship_street');
		$order->data['order_ship_zip'] = $custAuth->val('customer_ship_zip');
		return $order;
	}
	
}