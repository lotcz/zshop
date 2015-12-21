<?php

class ProductVariant extends ModelBase {
	
	public $table_name = 'product_variants';
	public $id_name = 'product_variant_id';
	
	public function load($product_id, $variant_name) {
		$filter = [];
		$filter['product_variant_product_id'] = $product_id;
		$filter['product_variant_name'] = $variant_name;
		$this->loadSingleFiltered($filter);
	}

}