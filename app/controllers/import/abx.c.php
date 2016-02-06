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

		$data_path = '../data/';
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
				
				// update alias
				$a = new Alias($db, $zCategory->val('category_alias_id'));							
				if (!$a->is_loaded) {
					$a->setUrl($zCategory->getAliasUrl());
					$a->data['alias_path'] = $zCategory->getAliasPath();
					$a->save();
					$zCategory->data['category_alias_id'] = $a->ival('alias_id');				
					$zCategory->save();
				}
				
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
					$price_sales = trim($product->price_sales);
					$price_eus = trim($product->price_eus);
					$product_price = ($price_sales) ? $price_sales : $price_eus;
					$product_name = myTrim($product->name);						
					$product_stock = intval(trim($product->stock));
					
					/* varianty */	
					if (strpos($product_name, ' var.') > 0) {				
						list($prodname, $prodvar) = explode(' var.', $product_name);
						$product_name = myTrim($prodname);
						
						$zVariant = new ProductVariant($db);					
						$zVariant->loadByExtId($prod_id);
												
						if ($zVariant->is_loaded) {
							$zProduct->loadById($zVariant->data['product_variant_product_id']);
						}
						
						if (!$zProduct->is_loaded) {
							$zProduct->loadSingleFiltered('product_name = ?', [$product_name]);
						}

						if (!$zProduct->is_loaded) {
							$save_product = true;
							$zProduct->data['product_default_variant_id'] = $zVariant->val('product_variant_id');
						} elseif ($zProduct->val('product_default_variant_id') == $zVariant->val('product_variant_id')) {
							$save_product = true;
						}

					} else {						
						$save_product = true;
					} 
					
					if ($save_product) {
						if ($zProduct->is_loaded) {
							$data['updated'] += 1;
						} else {
							$data['inserted'] += 1;
							$zProduct->data['product_ext_id'] = $prod_id;
						}
						$zProduct->data['product_name'] = $product_name;
						$zProduct->data['product_price'] = $product_price;
						$zProduct->data['product_stock'] = $product_stock;
						$zProduct->save();
						
						// update alias
						$a = new Alias($db, $zProduct->val('product_alias_id'));							
						if (!$a->is_loaded) {
							$a->setUrl($zProduct->getAliasUrl());
							$a->data['alias_path'] = $zProduct->getAliasPath();
							$a->save();
							$zProduct->data['product_alias_id'] = $a->ival('alias_id');				
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
					} // if $save_product					
					
					if (isset($zVariant)) {
						$zVariant->data['product_variant_ext_id'] = $prod_id;						
						$zVariant->data['product_variant_name'] = $prodvar;
						$zVariant->data['product_variant_product_id'] = $zProduct->val('product_id');
						$zVariant->data['product_variant_price'] = $product_price;
						$zVariant->data['product_variant_stock'] = trim($product->stock);
						$zVariant->save();
					}
				} // foreach
				
			} // if false

		} else {
			$data['outmsg'] = sprintf('Import file %s not found!', $xml_path);
		}
	} else {
		$data['outmsg'] = 'Security token invalid';
	}