<?php
	require_once $home_dir . 'models/category.m.php';
	global $db, $path;
	
	$selected_id = null;
	if (isset($path[0]) && $path[0] == 'category' && isset($path[1])) {
		$selected_id = parseInt($path[1]);
	}
	
	Category::renderSideMenu($db, $selected_id);