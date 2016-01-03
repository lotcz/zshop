<?php
	require_once '../models/category.m.php';
	$page_title	= t('Categories');
	
	$paging = Paging::getFromUrl();
	$search = isset($_GET['s']) ? $_GET['s'] : '';
	
	$categories = Category::select(
		/* db */		$db, 
		/* table */		'categories', 
		/* where */		null,
		/* bindings */	null,
		/* types */		null,
		/* paging */	$paging,
		/* orderby */	'category_name'
	);
	
	$data['categories'] = $categories;
	$data['paging'] = $paging;