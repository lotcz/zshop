<?php

	$this->setData('category_tree', CategoryModel::getCategoryTree($this->db));