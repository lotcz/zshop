<?php

class Product extends ModelBase {
	
	public $table_name = 'products';
	public $id_name = 'product_id';
	
	public function loadByAbxId($id) {
		$filter = 'product_abx_id = ?';
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
	
	public function renderImage() {
		if ($this->val('product_image')) {
			renderProductImage($this->val('product_image'),$this->val('product_name'),'');
		} else {
			renderImage('no-image.png',t('Image missing'),'');
		}
	}
}