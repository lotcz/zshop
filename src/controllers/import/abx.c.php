<?php
	
	$page_title	= 'Import ABX';
	$master_template = 'plain';
		
	$data['outmsg'] = '';
	$data['updated'] = 0;
	$data['inserted'] = 0;
	$data['total'] = 0;
	$data['rejected'] = 0;
	$data['numrows'] = 0;
	$data['cat_updated'] = 0;
	$data['cat_inserted'] = 0;
	$data['cat_total'] = 0;
	
	if (isset($_GET['token']) && $_GET['token'] == $globals['security_token']) {
		
		set_time_limit ( 60*60 );
		
		require_once $home_dir . 'classes/zip.php';
		require_once $home_dir . 'models/category.m.php';
		require_once $home_dir . 'models/product.m.php';
		require_once $home_dir . 'models/prod_var.m.php';		

		$data_path = '../../data/';
		$archive_file = 'katalog.zip';
		$xml_file = 'katalog.xml';
		$archive_path = $data_path . $archive_file;
		$xml_path = $data_path . $xml_file;		

		if (file_exists($archive_path)) {		
			if (file_exists($xml_path)) unlink($xml_path);
			unzip($archive_path);
			unlink($archive_path);
		}
		
		if (file_exists($xml_path)) {
			$xml = simplexml_load_file($xml_path);

			/* kategorie */
			foreach ($xml->categories->category as $category) {
				$data['cat_total'] += 1;
				$zCategory = new Category($db);
				$zCategory->loadByExtId(intval($category->id));
				if ($zCategory->is_loaded) {
					$data['cat_updated'] += 1;
				} else {
					$data['cat_inserted'] += 1;
					$zCategory->data['category_ext_id'] = intval($category->id);
				}
				$zCategory->data['category_name'] = myTrim($category->name);
				$zCategory->data['category_description'] = $category->desc;
				if (isset($category->parentid) && $category->parentid > 0) {
					$parent = new Category($db);
					$parent->loadByExtId(intval($category->parentid));
					if ($parent->is_loaded) {
						$zCategory->data['category_parent_id'] = $parent->val('category_id');
					}
				}
				$zCategory->save();			
			}

			/*
				possibly update all stock numbers to zero here?
			*/
			
			if (true) {
				
				/* produkty */		
				foreach ($xml->products->product as $product) {
					$data['total'] += 1;			
					$prod_id = intval(trim($product->ean));
					$zProduct = new Product($db);
					$zProduct->loadByExtId($prod_id);
					if ($zProduct->is_loaded) {
						$data['updated'] += 1;
					} else {
						$data['inserted'] += 1;
						$zProduct->data['product_ext_id'] = $prod_id;
					}
					$price_sales = trim($product->price_sales);
					$price_eus = trim($product->price_eus);
					$product_price = ($price_sales) ? $price_sales : $price_eus;
					$product_name = myTrim($product->name);			
					$zProduct->data['product_price'] = $product_price;
					$zProduct->data['product_stock'] = intval(trim($product->stock));
					
					/* varianty */	
					if (strpos($product_name, ' var.') > 0) {				
						list($prodname, $prodvar) = explode(' var.', $product_name);
						$zProduct->data['product_name'] = $prodname;
						$zProduct->save();
						
						$zVariant = new ProductVariant($db);
						$zVariant->load($zProduct->data['product_id'], $prodvar);
						$zVariant->data['product_variant_name'] = $prodvar;
						$zVariant->data['product_variant_product_id'] = $zProduct->data['product_id'];
						$zVariant->data['product_variant_price'] = $product_price;
						$zVariant->data['product_variant_stock'] = trim($product->stock);
						$zVariant->save();
					} else {
						$zProduct->data['product_name'] = $product_name;
						$zProduct->save();
					}
					
					/* kategorie */
					$zProduct->removeFromAllCategories();
					
					if ($product->categories->category) {
						foreach ($product->categories->category as $cat) {
							$zCategory = new Category($db);
							$zCategory->loadByExtId(intval($cat));
							$zProduct->addToCategory($zCategory->val('category_id'));
						}
					}
				}
			} // if false

		} else {
			$data['outmsg'] = sprintf('Import file %s not found!', $xml_path);
		}
	} else {
		$data['outmsg'] = 'Security token invalid';
	}