<?php
	
	require_once $home_dir . 'models/category.m.php';
	require_once $home_dir . 'models/alias.m.php';
	
	global $db;
	
	if (isset($_POST['category_id'])) {
		$category = new Category($db, $_POST['category_id']);
		$category->setData($_POST);	
		$category->data['category_parent_id'] = parseInt($category->val('category_parent_id'));
		$alias_url = $category->val('alias_url');
		unset($category->data['alias_url']);
		$category->save();
		
		$alias = new Alias($db, $category->ival('category_alias_id'));
		// save alias if new or changed
		if ($alias->val('alias_url') != $alias_url || !$alias->is_loaded) {
			$alias->data['alias_path'] = $category->getAliasPath();
			if (isset($alias_url) && strlen(trim($alias_url)) > 0) {
				$alias->setUrl($alias_url);
			} else {
				$alias->setUrl($category->getAliasUrl());
			}
			$alias->save();
		}
		
		// update category alias if changed
		if ($alias->ival('alias_id') != $category->ival('category_alias_id')) {
			$category->data['category_alias_id'] = $alias->ival('alias_id');
			$category->save();
		}
		
		$category->alias = $alias;		
		

	} elseif (isset($path[2]) && $path[2] == 'edit') {
		$category = new Category($db, $path[3]);
		$category->alias = new Alias($db, $category->val('category_alias_id'));
		$page_title	= t('Editing Category');
	} elseif (isset($path[2]) && $path[2] == 'delete') {
		$category = new Category($db);
		$category->deleteById($path[3]);
		redirect('/admin/categories');
	} else {
		$category = new Category($db);
		$page_title	= t('New Category');
	}
	
	$data = $category;