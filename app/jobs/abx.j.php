<?php

	$prod_updated = 0;
	$prod_inserted = 0;
	$prod_total = 0;
	$cat_updated = 0;
	$cat_inserted = 0;
	$cat_total = 0;	
		
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
			$cat_total += 1;
			$zCategory = new Category($db);
			$zCategory->loadByExtId(intval($category->id));
			if ($zCategory->is_loaded) {
				$cat_updated += 1;
			} else {
				$cat_inserted += 1;
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

		$categories_tree = Category::getCategoryTree($db);
		
		/*
			possibly update all stock numbers to zero here?
		*/
			
		/* produkty */		
		foreach ($xml->products->product as $product) {
			$save_product = true;
			$zVariant = null;
			$prod_total += 1;			
			$prod_id = intval(trim($product->ean));
			$zProduct = new Product($db);
			$zProduct->loadByExtId($prod_id);					
			$price_sales = trim($product->price_sales);
			$price_eus = trim($product->price_eus);
			$product_price = ($price_sales) ? $price_sales : $price_eus;
			$product_name = trim($product->name);						
			$product_stock = intval(trim($product->stock));
			
			/* varianty */	
			if (strpos($product_name, ' var.') > 0) {				
				list($prodname, $variant_name) = explode(' var.', $product_name);
				$product_name = trim($prodname);
				$variant_name = trim($variant_name);
				
				if (strlen($variant_name) > 0) {
					$zVariant = new ProductVariant($db);					
					$zVariant->loadByExtId($prod_id);
											
					if ($zVariant->is_loaded) {
						$zProduct->loadById($zVariant->ival('product_variant_product_id'));
						$zProduct->data['product_default_variant_id'] = $zVariant->val('product_variant_id');
					}
					
					if (!$zProduct->is_loaded) {
						$zProduct->loadSingleFiltered('product_name = ?', [$product_name]);
					}

					if (!$zProduct->is_loaded) {
						$save_product = true;						
					} elseif ($zProduct->val('product_default_variant_id') == $zVariant->val('product_variant_id')) {
						$save_product = true;
					} else {
						$save_product = false;
					}
				} else {
					echo 'Variant name empty: ' . $product->name . '<br/>';
				}

			}
			
			if ($save_product) {
				if ($zProduct->is_loaded) {
					$prod_updated += 1;
				} else {
					$prod_inserted += 1;
					$zProduct->data['product_ext_id'] = $prod_id;
				}
				
				/* kategorie */				
				$zCategory = null;
				
				// choose category with highest level
				if ($product->categories->category) {
					foreach ($product->categories->category as $cat) {						
						$category = $categories_tree->findInChildren($cat, 'category_ext_id');						
						if ((!isset($zCategory)) || (isset($category) && ($category->level > $zCategory->level))) {
							$zCategory = $category;
						}
					}
					if (isset($zCategory)) {
						$zProduct->data['product_category_id'] = $zCategory->ival('category_id');
						
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
					} else {
						echo sprintf('Cannot find category with ABX id %s for product "%s"<br/>', $cat, $product_name);
					}
				}				
				
			} // if $save_product					
			
			if (isset($zVariant) && $zProduct->val('product_id') != null) {
				$zVariant->data['product_variant_ext_id'] = $prod_id;						
				$zVariant->data['product_variant_name'] = $variant_name;
				$zVariant->data['product_variant_product_id'] = $zProduct->ival('product_id');
				$zVariant->data['product_variant_price'] = $product_price;
				$zVariant->data['product_variant_stock'] = $product_stock;
				try {
					$zVariant->save();
				} catch (Exception $e) {
					echo $e->getMessage() . "<br/>";
				}
			}
		} // foreach
		
		echo "Categories: $cat_total total, $cat_updated updated, $cat_inserted inserted. Products: $prod_total total, $prod_updated updated, $prod_inserted inserted.";

	} else {
		echo sprintf('Import file %s not found!', $xml_path);
	}
	