<?php
	require_once '../models/category.m.php';

	$category = new Category($db, $path[1]);
	$category->loadChildren();
	
	$page_title = t($category->val('category_name'));
	
	$data = $category;