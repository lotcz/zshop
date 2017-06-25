<?php
	$this->requireClass('paging');
	
	$categories_tree = CategoryModel::getCategoryTree($this->db);
	$category = $categories_tree->findInChildren(intval($this->getPath(-1)));
	
	if (!isset($category)) {
		$this->redirect('notfound');
	}
	
	$this->setData('category', $category);
	$page_title = $category->val('category_name');		
	$paging = zPaging::getFromUrl(ProductModel::getSortingItems());
	
	$ids = $category->getSubTreeIDs();
	$values = [];
	$types = '';
	foreach ($ids as $id) {
		$values[] = '?';
		$types .= 'i';
	}
	
	$products = ProductModel::select(
		$this->db, 
		'viewProducts', 
		sprintf('product_category_id IN (%s)', implode(',', $values)),
		$ids,
		$types,
		$paging,
		$paging->getOrderBy()
	);
	
	$this->setData('products', $products);
	$this->setData('paging', $paging);
	$this->setData('ids', $ids);