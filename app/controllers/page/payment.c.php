<?php
	$customer = $this->getCustomer();

	$selected_delivery = new DeliveryTypeModel($this->db, $customer->val('customer_delivery_type_id'));
	if (!isset($selected_delivery)) {
		$this->redirect('delivery');
	}

	$payment_types = $selected_delivery->loadAllowedPaymentTypes();
	$selected_payment = PaymentTypeModel::find($payment_types, 'payment_type_id', $customer->val('customer_payment_type_id'));

	if (!isset($selected_payment)) {
		$selected_payment = $payment_types[0];
	}

	$render_page = true;

	if (z::isPost()) {
		$cust = new CustomerModel($this->db);
		$cust->data['customer_id'] = $customer->val('customer_id');
		$cust->data['customer_payment_type_id'] = z::getInt('payment_type_id');		
		if ($cust->save()) {
			$this->redirect('confirm');
			$render_page = false;
		}
	}

	if ($render_page) {
		$this->setPageTitle('Payment Type');
		$this->setMainTemplate('nocats');
		$this->includeJS('js/payment.js');
		$this->setData('payment_types', $payment_types);
		$this->setData('selected_payment', $selected_payment);
	}
