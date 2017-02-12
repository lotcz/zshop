<?php
	$selected_id = null;
	if (isset($this->data['category'])) {
		$selected_id = $this->data['category']->val('category_id');
	}
	$this->data['category_tree'] = CategoryModel::getCategoryTree($this->db, $selected_id);