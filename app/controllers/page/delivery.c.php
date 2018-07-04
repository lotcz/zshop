<?php

	$render_page = true;
	$customer = $this->getCustomer();

	if (z::isPost()) {
		$customer->set('customer_delivery_type_id', z::getInt('customer_delivery_type_id'));
		$customer->set('customer_payment_type_id', z::getInt('customer_payment_type_id'));
		$customer->set('customer_email', z::get('customer_email'));

		//invoice address
		$customer->set('customer_name', z::get('customer_name'));
		$customer->set('customer_address_city', z::get('customer_address_city'));
		$customer->set('customer_address_street', z::get('customer_address_street'));
		$customer->set('customer_address_zip', z::getInt('customer_address_zip'));

		//shipping address
		$use_ship_address = z::getInt('customer_use_ship_address', 0);
		if ((!isset($use_ship_address)) || $use_ship_address == '') {
			$use_ship_address = 0;
		}
		$customer->set('customer_use_ship_address', $use_ship_address);
		if ($use_ship_address) {
			$customer->set('customer_ship_name', z::get('customer_ship_name'));
			$customer->set('customer_ship_city', z::get('customer_ship_city'));
			$customer->set('customer_ship_street', z::get('customer_ship_street'));
			$customer->set('customer_ship_zip', z::getInt('customer_ship_zip'));
		}

		//after filling an email, customer is no longer anonymous
		$customer->set('customer_anonymous', 0);

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

		$delivery_types = DeliveryTypeModel::all($this->db);
		$selected_delivery = DeliveryTypeModel::find($delivery_types, 'delivery_type_id', $customer->val('customer_delivery_type_id'));

		if (!isset($selected_delivery)) {
			$selected_delivery = DeliveryTypeModel::getDefault($delivery_types);
		}

		$this->setData('customer', $customer);
		if ($customer->bval('customer_anonymous')) {
			$this->setData('customer_email', '');
			$this->setData('customer_name', '');
		} else {
			$this->setData('customer_email', $customer->val('customer_email'));
			$this->setData('customer_name', $customer->val('customer_name'));
		}

		$this->setData('delivery_types', $delivery_types);
		$this->setData('selected_delivery', $selected_delivery);
	}
