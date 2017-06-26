<?php
		
	$render_page = true;
	
	if (isPost()) {		
		$customer = new CustomerModel($this->db);
		$customer->set('customer_id', $this->getCustomer()->ival('customer_id'));
		
		$customer->set('customer_name', get('customer_name'));		
		$customer->set('customer_ship_name', get('customer_ship_name'));
		
		if ($customer->save()) {
			$this->redirect('payment');
			$render_page = false;	
		}		
	}

	if ($render_page) {
		$this->setPageTitle('Delivery Type');
		$this->setMainTemplate('nocats');
		$this->includeJS('js/delivery.js');
		
		$delivery_types = DeliveryTypeModel::all($this->db);
		$selected_delivery = DeliveryTypeModel::find($delivery_types, 'delivery_type_id', $this->getCustomer()->val('customer_delivery_type_id'));
		
		if (!isset($selected_delivery)) {
			$selected_delivery = DeliveryTypeModel::getDefault($delivery_types);
		}		

		$this->setData('delivery_types', $delivery_types);
		$this->setData('selected_delivery', $selected_delivery);
	}