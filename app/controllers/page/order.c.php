<?php

	$this->setPageTitle('Order');
	$this->setMainTemplate('nocats');
	
	$order_id = intval($this->getPath(-1));	
	$order = new OrderModel($this->db, $order_id);	
	$order->loadProducts();
	$this->setData('order', $order);
	
	$delivery_types = DeliveryTypeModel::all($this->db);	
	$delivery_type = DeliveryTypeModel::find($delivery_types, 'delivery_type_id', $order->val('order_delivery_type_id'));
	$this->setData('delivery_type', $delivery_type);
	
	$payment_types = PaymentTypeModel::all($this->db);	
	$payment_type = PaymentTypeModel::find($payment_types, 'payment_type_id', $order->val('order_payment_type_id'));
	$this->setData('payment_type', $payment_type);