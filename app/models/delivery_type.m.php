<?php

class DeliveryType extends ModelBase {
	
	public $table_name = 'delivery_types';
	public $id_name = 'delivery_type_id';
	
	public function loadAllowedPaymentTypes() {
		$this->allowed_payment_types = ModelBase::select($this->db, 'viewAllowedPaymentTypes', 'allowed_payment_type_delivery_type_id = ?', [ $this->val('delivery_type_id') ]);
	}	
}