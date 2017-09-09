<?php
  $customer = $this->getCustomer();
  $this->setPageTitle($customer->val('customer_name', $customer->val('customer_email')));
  $this->setMainTemplate('nocats');

  $this->requireModule('forms');
  $form = new zForm('register_form');
	$form->add([
			[
				'name' => 'customer_created',
				'label' => 'Date',
				'type' => 'static'
			],
			[
				'name' => 'customer_last_access',
				'label' => 'Last visited',
				'type' => 'static'
			],
			[
				'name' => 'customer_email',
				'label' => 'E-mail',
				'type' => 'text',
				'validations' => [['type' => 'email']]
			],
			[
				'name' => 'customer_language_id',
				'label' => 'Language',
				'type' => 'select',
				'select_table' => 'languages',
				'select_id_field' => 'language_id',
				'select_label_field' => 'language_name'
			],
			[
				'name' => 'customer_currency_id',
				'label' => 'Currency',
				'type' => 'select',
				'select_table' => 'currencies',
				'select_id_field' => 'currency_id',
				'select_label_field' => 'currency_name'
			],
			[
				'label' => 'Address',
				'type' => 'begin_group'
			],
			[
				'name' => 'customer_name',
				'label' => 'Name',
				'type' => 'text',
				'validations' => [['type' => 'maxlen', 'param' => 50]]
			],
			[
				'name' => 'customer_address_city',
				'label' => 'City',
				'type' => 'text',
				'validations' => [['type' => 'maxlen', 'param' => 50]]
			],
			[
				'name' => 'customer_address_street',
				'label' => 'Street with house n.',
				'type' => 'text',
				'validations' => [['type' => 'maxlen', 'param' => 50]]
			],
			[
				'name' => 'customer_address_zip',
				'label' => 'ZIP',
				'type' => 'text',
				'validations' => [
					['type' => 'integer', 'param' => true]
				]
			],
			[
				'type' => 'end_group'
			],
			[
				'label' => 'Shipping Address',
				'type' => 'begin_group'
			],
			[
				'name' => 'customer_use_ship_address',
				'label' => 'Use different shipping address',
				'type' => 'bool'
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
			],
			[
				'type' => 'end_group'
			],
			[
				'name' => 'customer_delivery_type_id',
				'label' => 'Delivery Type',
				'type' => 'select',
				'select_table' => 'delivery_types',
				'select_id_field' => 'delivery_type_id',
				'select_label_field' => 'delivery_type_name'
			],
			[
				'name' => 'customer_payment_type_id',
				'label' => 'Payment Type',
				'type' => 'select',
				'select_table' => 'payment_types',
				'select_id_field' => 'payment_type_id',
				'select_label_field' => 'payment_type_name'
			]
		]
	);

  $form->render_wrapper = true;
  $form->prepare($this->db, $customer);
  $this->setData('form', $form);

  $this->requireModule('tables');
  $orders_table = new zTable('viewOrders', 'order_id', '', null, null);
  $orders_table->add([
    [
      'name' => 'order_created',
      'label' => 'Date',
      'type' => 'date'
    ],
    [
      'name' => 'order_state_name',
      'label' => 'Status'
    ],
    [
      'name' => 'customer_name',
      'label' => 'Customer'
    ],
    [
      'name' => 'order_payment_code',
      'label' => 'Payment Code'
    ]
  ]);
  $orders_table->where = sprintf('order_customer_id = %d', $customer->ival('customer_id'));
  $orders_table->prepare($this->db);
  $this->setData('orders_table', $orders_table);
