<?php
		
	$render_page = true;
	
	if ($this->isPost()) {		
		$customer = new CustomerModel($this->db);
		$customer->set('customer_id', $this->getCustomer()->ival('customer_id'));
		
		$customer->set('customer_delivery_type_id', $this->getInt('customer_delivery_type_id'));
		$customer->set('customer_payment_type_id', $this->getInt('customer_payment_type_id'));
		
		//invoice address
		$customer->set('customer_name', $this->get('customer_name'));
		$customer->set('customer_address_city', $this->get('customer_address_city'));
		$customer->set('customer_address_street', $this->get('customer_address_street'));
		$customer->set('customer_address_zip', $this->getInt('customer_address_zip'));
		
		//shipping address
		$use_ship_address = $this->getInt('customer_use_ship_address');		
		$customer->set('customer_use_ship_address', $use_ship_address);
		if ($use_ship_address) {
			$customer->set('customer_ship_name', $this->get('customer_ship_name'));
			$customer->set('customer_ship_city', $this->get('customer_ship_city'));
			$customer->set('customer_ship_street', $this->get('customer_ship_street'));
			$customer->set('customer_ship_zip', $this->getInt('customer_ship_zip'));
		}
		
		if ($customer->save()) {
			$this->redirect('payment');
			$render_page = false;	
		}		
	}

	if ($render_page) {
		$this->setPageTitle('Delivery Type');
		$this->setMainTemplate('nocats');
		$this->includeJS('js/delivery.js');
		$this->requireModule('forms');
		
		if (!isset($customer)) {
			$customer = $this->getCustomer();
		}
		
		$delivery_types = DeliveryTypeModel::all($this->db);
		$selected_delivery = DeliveryTypeModel::find($delivery_types, 'delivery_type_id', $customer->val('customer_delivery_type_id'));
		
		if (!isset($selected_delivery)) {
			$selected_delivery = DeliveryTypeModel::getDefault($delivery_types);
		}		

		$this->setData('customer', $customer);
		$this->setData('customer_email', $customer->bval('customer_anonymous') ? '' : $customer->val('customer_email'));
		$this->setData('delivery_types', $delivery_types);
		$this->setData('selected_delivery', $selected_delivery);
	}