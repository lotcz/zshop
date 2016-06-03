<?php

require_once $home_dir . 'models/alias.m.php';

class Category extends ModelBase {
	
	public $table_name = 'categories';
	public $id_name = 'category_id';
	
	static $cache_tree = null;
	
	public function loadByExtId($id) {
		$filter = 'category_ext_id = ?';
		$this->loadSingleFiltered($filter, [$id]);
	}

	// add category to array while keeping the alphabet ordering
	static function addToArray(&$list, $c) {
		$list[] = $c;
	}
	
	static function findInTree($tree, $id) {
		foreach ($tree as $c) {
			if ($c->ival('category_id') == $id) {
				return $c;
			} elseif (isset($c->children)) {
				$sc = Category::findInTree($c->children, $id);
				if (isset($sc)) {
					return $sc;
				}
			}
		}
	}
	
	static function getCategoryTree($db) {
		if (isset(Category::$cache_tree)) {
			return Category::$cache_tree;
		} else {
			$all = Category::select(
				$db, 
				'viewCategories',
				null,
				null,
				null,
				null,
				'category_name');
			$tree = [];
			while (count($all) > 0) {
				foreach ($all as $i => $c) {
					if ($c->ival('category_parent_id') == null) {
						Category::addToArray($tree, $c);
						unset($all[$i]);
					} else {
						$pc = Category::findInTree($tree, $c->ival('category_parent_id'));
						if (isset($pc)) {
							if (!isset($pc->children)) {
								$pc->children = [];
							}
							Category::addToArray($pc->children, $c);
							unset($all[$i]);
						}
					}
				}
			}			
			Category::$cache_tree = $tree;
		}
		return Category::$cache_tree;		
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
	
	public function renderLink() {
		if (strlen($this->val('alias_url')) > 0) {
			$url = $this->val('alias_url');		
		} else {
			$url = 'category/' . $this->val('category_id');
		}
		echo sprintf('<a href="%s" class="side-menu-link" data-toggle="collapse" data-target="#side-nav-%s">%s</a>', _url($url), $this->val('category_id'), $this->val('category_name'));		 
	}

	static function renderMenu($tree, $level = 0, $parent_id = 0, $selected_id = 0) {
		$class = ($parent_id == 0 || $parent_id == $selected_id) ? 'in' : '';
		?>
			<ul id="side-nav-<?=$parent_id ?>" class="nav nav-sidebar collapse <?=$class ?>">
				<?php		
					foreach ($tree as $category) {
						$active = '';
						if ($selected_id == $category->ival('category_id')) {
							$active = 'active';
						}
						
						?>
							<li class="<?=$active?>">
								<div class="side-menu-link-wrapper side-menu-link-wrapper-level-<?=$level ?>">
									<?php						
										$category->renderLink();
									?>
								</div>
								<?php
									if (isset($category->children)) {
										Category::renderMenu($category->children, $level + 1, $category->ival('category_id'), $selected_id);
									}
								?>
							</li>
						<?php
					}					
				?>	
			</ul>
		<?php		
	}
	
	static function renderSideMenu($db, $selected_id = 0) {
		$categories_tree = Category::getCategoryTree($db);
		Category::renderMenu($categories_tree, 0, 0, $selected_id);		
	}
	
}