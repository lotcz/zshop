<?php

require_once $home_dir . 'models/alias.m.php';

class Product extends ModelBase {
	
	public $table_name = 'products';
	public $id_name = 'product_id';
	
	public function loadByExtId($id) {
		$filter = 'product_ext_id = ?';
		$this->loadSingleFiltered($filter, [$id]);		
	}
	
	public function removeFromAllCategories() {		
		$sql = 'DELETE FROM product_category WHERE product_category_product_id = ?';
		if ($statement = $this->db->prepare($sql)) {
			$statement->bind_param('i', $this->val($this->id_name));
			$statement->execute();
			$statement->close();
		} else {
			dbErr($this->table_name, 'prepare', $sql, $this->db->error);
		}		
	}
	
	public function addToCategory($category_id) {		
		$sql = 'INSERT INTO product_category (product_category_product_id, product_category_category_id) VALUES(?,?)';
		if ($statement = $this->db->prepare($sql)) {
			$statement->bind_param('ii', $this->val($this->id_name), $category_id);
			$statement->execute();
			$statement->close();
		} else {
			dbErr($this->table_name, 'prepare', $sql, $this->db->error);
		}		
	}
	
	public function loadVariants() {
		$this->variants = ModelBase::select($this->db, 'product_variants', 'product_variant_product_id = ?', [ $this->val('product_id') ]);
	}
	
	public function loadCategories() {
		$this->categories = ModelBase::select($this->db, 'viewCategoriesByProduct', 'product_category_product_id = ?', [ $this->val('product_id') ]);
	}
	
	public function renderImage($size = 'thumb') {
		if ($this->val('product_image')) {			
			renderProductImage($this->val('product_image'), $size, $this->val('product_name'), '');
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