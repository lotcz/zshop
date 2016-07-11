<?php
	require_once $home_dir . 'models/product.m.php';
	require_once $home_dir . 'models/category.m.php';
	
	function convertEncoding($str) {
		//return $str;
		//return mb_convert_encoding($str, 'UTF-8', 'ISO-8859-2');
		return iconv('Windows-1250', 'UTF-8', $str);
	}
	
	function loadCategory($ext_id) {
		global $db;
		$category = new Category($db);
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
	
	$stmt = SqlQuery::select($cube_db, 'cubecart_inventory');
	if ($stmt) {
		$result = $stmt->get_result();			
		while ($row = $result->fetch_assoc()) {			
			$product = new Product($db);
			$product->loadByExtId($row['productId']);
			
			// import new product
			if (!$product->is_loaded) {
				$product->data['product_ext_id'] = $row['productId'];				
				$new++;
			} else {
				$updated++;
			}
			
			// update existing product
			$product->data['product_name'] = myTrim(convertEncoding($row['name']));
			$product->data['product_description'] = convertEncoding($row['description']);
			$product->data['product_image'] = $row['image'];
			$product->data['product_price'] = parseFloat($row['price']);
			
			$category = loadCategory($row['cat_id']);
				if (isset($category)) {
					$product->data['product_category_id'] = $category->ival('category_id');
				}
				
			$product->save();
		}
		$stmt->close();			
	}	
	
	echo sprintf('Imported %s new, %s updated.', $new, $updated);