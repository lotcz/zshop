<?php
	
	$product = new ProductModel($this->db, $this->getPath(-1));
	if (!$product->is_loaded) {
		$this->redirect('notfound');
	}
	
	$categories_tree = $this->getData('category_tree');
	$categories_tree->setSelectedCategory($product->ival('product_category_id'));
	
	$this->setPageTitle($product->val('product_name'));		
	$this->setData('product', $product);