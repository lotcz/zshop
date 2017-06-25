<?php
	
	$product = new ProductModel($this->db, $this->getPath(-1));
	if (!$product->is_loaded) {
		redirect('notfound');
	}
	
	$this->setPageTitle($product->val('product_name'));		
	$this->setData('product', $product);