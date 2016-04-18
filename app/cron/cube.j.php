<?php
	require_once $home_dir . 'models/product.m.php';
	
	function convertEncoding($str) {
		//return $str;
		//return mb_convert_encoding($str, 'UTF-8', 'ISO-8859-2');
		return iconv('Windows-1250', 'UTF-8', $str);
	}
	
	$cube_db = new mysqli('localhost', 'root', '', 'parfumerie');
	$cube_db->set_charset('ISO-8859-2');
	
	$new = 0;
	$updated = 0;
	
	$stmt = SqlQuery::select($cube_db, 'cubecart_inventory');
	if ($stmt) {
		$result = $stmt->get_result();			
		while ($row = $result->fetch_assoc()) {			
			$product = new Product($db);
			$product->loadByExtId($row['productId']);
			
			// import new product
			if (!$product->is_loaded) {
				$product->data['product_ext_id'] = $row['productId'];
				$product->data['product_name'] = myTrim(convertEncoding($row['name']));
				$new++;
			} else {
				$updated++;
			}
			
			// update existing product
			$product->data['product_description'] = convertEncoding($row['description']);
			$product->data['product_image'] = $row['image'];
			$product->data['product_price'] = parseFloat($row['price']);
			
			$product->save();
		}
		$stmt->close();			
	}	
	
	echo sprintf('Imported %s new, %s updated.', $new, $updated);