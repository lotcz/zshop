<?php
	$this->requireClass('paging');

	$categories_tree = $this->getData('category_tree');

	$category_id = intval($this->getPath(-1));
	$category = $categories_tree->setSelectedCategory($category_id);

	if (!isset($category)) {
		$this->redirect('notfound');
	}

	$this->setData('category', $category);
	$this->setPageTitle($category->val('category_name'));
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

	$cart_products = $this->z->cart->loadCartProducts();

	foreach ($cart_products as $cart_product) {
		$product = null;
		$product = zModel::find($products, 'product_id', $cart_product->ival('product_id'));
		if (isset($product)) {
			$product->set('in_cart_prod_count', $cart_product->ival('cart_count'));
		}
	}

	$this->setData('products', $products);
	$this->setData('paging', $paging);
	$this->setData('ids', $ids);
