<?php
	
	require_once '../models/category.m.php';
	
	global $db;
	
	if (isset($_POST['category_id'])) {
		// save category values
		if ($_POST['category_id'] > 0) {
			$category = new Category($db, $_POST['category_id']);
		} else {
			$category = new Category($db);
		}
		$category->setData($_POST);		
		if ($category->save()) {
			redirect('/admin/categories');
		}
	} elseif (isset($path[2]) && $path[2] == 'edit') {
		$category = new Category($db, $path[3]);
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