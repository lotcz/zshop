<?php

class Product extends ModelBase {
	
	public $table_name = 'products';
	public $id_name = 'product_id';
	
	public function loadByExtId($id) {
		$filter = 'product_ext_id = ?';
		$this->loadSingleFiltered($filter, [$id]);		
	}
	
	public function loadVariants() {
		$this->variants = ModelBase::select($this->db, 'product_variants', 'product_variant_product_id = ?', [ $this->val('product_id') ]);
	}
	
	public function renderImage($size = 'thumb') {
		if ($this->val('product_image')) {	
			global $images;
			$images->renderImage($this->val('product_image'), $size);
		} else {
			renderImage('no-image.png',t('Image missing'),'');
		}
	}
	
	static function loadCart($db, $customer_id) {
		return Product::select(
		/* db */		$db, 
		/* table */		'viewProductsInCart', 
		/* where */		'cart_customer_id = ?',
		/* bindings */	[ intval($customer_id) ],
		/* types */		'i',
		/* paging */	null,
		/* orderby */	'product_name'
		);		
	}
	
	public function getAliasUrl() {		
		return $this->val('product_name');		
	}
	
	public function getAliasPath() {
		return 'product/' . $this->val('product_id');
	}
	
}