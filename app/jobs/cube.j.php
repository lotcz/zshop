<?php
	
	$this->requireModule('mysql');
	$this->requireModule('shop');
	$db = $this->z->core->db;
	
	function convertEncoding($str) {
		//return $str;
		//return mb_convert_encoding($str, 'UTF-8', 'ISO-8859-2');
		return iconv('Windows-1250', 'UTF-8', $str);
	}
	
	function loadCategory($ext_id, $db) {
		$category = new CategoryModel($db);
		$category->loadByExtId($ext_id);
		return $category;
	}
	
	$cube_db = new mysqli('localhost', 'root', '', 'parfumerie');
	$cube_db->set_charset('ISO-8859-2');
	
	$new = 0;
	$updated = 0;
	
	/*
	$stmt = SqlQuery::select($cube_db, 'cubecart_category');
	if ($stmt) {
		$result = $stmt->get_result();			
		while ($row = $result->fetch_assoc()) {			
			$category = loadCategory($row['cat_id']);
			
			// import new category
			if (!$category->is_loaded) {
				$category->data['category_ext_id'] = $row['cat_id'];
				$parent = loadCategory($row['cat_father_id']);
				if (isset($parent)) {
					$category->data['category_parent_id'] = $parent->ival('category_id');
				}
				$new++;
			} else {
				$updated++;
			}
			
			// update existing category
			$category->data['category_name'] = myTrim(convertEncoding($row['cat_name']));			
			
			$category->save();
		}
		$stmt->close();			
	}	
	*/
	
	$stmt = zSqlQuery::select($cube_db, 'cubecart_inventory');
	if ($stmt) {
		$result = $stmt->get_result();			
		while ($row = $result->fetch_assoc()) {			
			$product = new ProductModel($db);
			$product->loadByExtId($row['productId']);
			
			// import new product
			if (!$product->is_loaded) {
				$product->data['product_ext_id'] = $row['productId'];
				$product->data['product_name'] = customTrim(convertEncoding($row['name']));			
				$product->data['product_price'] = parseFloat($row['price']);
			
				$category = loadCategory($row['cat_id'], $db);
				if (isset($category)) {
					$product->data['product_category_id'] = $category->ival('category_id');
				}				
				$new++;
			} else {
				$updated++;
			}
						
			$product->data['product_description'] = convertEncoding($row['description']);
			$product->data['product_image'] = $row['image'];
			
			$product->save();
		}
		$stmt->close();			
	}	
	
	echo sprintf('Imported %s new, %s updated.', $new, $updated);