<?php
	$this->requireModule('forms');
	$form = new zForm('address');
	$form->add([
		[
			'name' => 'customer_delivery_type_id',
			'type' => 'hidden'
		],	
		[
			'name' => 'customer_ship_name',
			'label' => 'Name',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_ship_city',
			'label' => 'City',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_ship_street',
			'label' => 'Street',
			'type' => 'text',
			'validations' => [['type' => 'maxlen', 'param' => 50]]
		],
		[
			'name' => 'customer_ship_zip',
			'label' => 'ZIP',
			'type' => 'text',
			'validations' => [
				['type' => 'integer', 'param' => true]
			]
		]
	]);

	$render_page = true;
	$customer = $this->getCustomer();
	
	if (isPost()) {		
		if ($form->processInput($_POST)) {
			$customer->setData($form->processed_input);
			if ($customer->save()) {
				$this->redirect('payment');
				$render_page = false;	
			}
		}
	}

	if ($render_page) {
		$this->setPageTitle('Invoicing address');
		$this->setMainTemplate('nocats');
		$this->includeJS('js/delivery.js');
		
		$delivery_types = DeliveryTypeModel::all($this->db);
		$selected_delivery = DeliveryTypeModel::find($delivery_types, 'delivery_type_id', $customer->val('customer_delivery_type_id'));
		
		if (!isset($selected_delivery)) {
			$selected_delivery = DeliveryTypeModel::getDefault($delivery_types);
		}		

		$form->prepare($this->db, $customer);
		$this->setData('form', $form);
		$this->setData('delivery_types', $delivery_types);
		$this->setData('selected_delivery', $selected_delivery);
	}