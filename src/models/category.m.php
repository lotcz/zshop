<?php

require_once $home_dir . 'models/alias.m.php';

class Category extends ModelBase {
	
	public $table_name = 'categories';
	public $id_name = 'category_id';
	
	public function loadByExtId($id) {
		$filter = 'category_ext_id = ?';
		$this->loadSingleFiltered($filter, [$id]);
	}

	public function loadChildren() {
		$sql = 'SELECT * FROM viewCategories WHERE category_parent_id = ? ORDER BY category_name';
		if ($statement = $this->db->prepare($sql)) {
			$statement->bind_param('i', $this->val('category_id'));
			if ($statement->execute()) {
				$result = $statement->get_result();
				$this->children = [];
				while ($row = $result->fetch_assoc()) {
					$cat = new Category();
					$cat->setData($row);
					$this->children[] = $cat;
				}				
				$statement->close();
			} else {
				dbErr($this->table_name, 'execute', $sql, $this->db->error);					
			}			
		} else {
			dbErr($this->table_name, 'prepare', $sql, $this->db->error);				
		}		
	}
	
	public function getParentAlias() {
		if ($this->ival('category_parent_id') > 0) {
			$p = new Category($this->db, $this->ival('category_parent_id'));
			$pa = new Alias($this->db, $p->ival('category_alias_id'));
			if (!$pa->is_loaded) {		
				$pa->setUrl($p->getAliasUrl());
				$pa->data['alias_path'] = $p->getAliasPath();
				$pa->save();
				$p->data['category_alias_id'] = $pa->val('alias_id');
				$p->save();
			}
			return $pa;
		}
	}
	
	public function getAliasUrl() {
		$pa = $this->getParentAlias();
		if (isset($pa) && $pa->is_loaded) {
			return $pa->val('alias_url') . '/' . $this->val('category_name');
		} else {
			return $this->val('category_name');
		}
	}
	
	public function getAliasPath() {
		return 'category/' . $this->val('category_id');
	}
	
}