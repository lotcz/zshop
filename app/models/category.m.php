<?php

require_once $home_dir . 'models/alias.m.php';

class Category extends ModelBase {
	
	public $table_name = 'categories';
	public $id_name = 'category_id';
	
	static $cache_tree = null;
	
	public $is_selected = false;
	public $is_on_selected_path = false;
		
	public function loadByExtId($id) {
		$filter = 'category_ext_id = ?';
		$this->loadSingleFiltered($filter, [$id]);
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
	
	public function addChild($c) {
		if (!isset($this->children)) {
			$this->children = [];
		}
		$this->children[] = $c;
		$c->treeParent = $this;
	}

	public function setSelectedPath() {
		$this->is_on_selected_path = true;
		if (isset($this->treeParent)) {			
			$this->treeParent->setSelectedPath();
		}
	}
	
	static function getCategoryTree($db, $selected_id = 0) {
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
						$tree[] = $c;
						if ($c->val('category_id') == $selected_id) {
							$c->is_selected = true;
						}
						unset($all[$i]);
					} else {
						$pc = Category::findInTree($tree, $c->ival('category_parent_id'));
						if (isset($pc)) {
							$pc->addChild($c);
							if ($c->val('category_id') == $selected_id) {
								$c->is_selected = true;
								$c->setSelectedPath();
							}							
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
	
	public function getLinkUrl() {
		if (strlen($this->val('alias_url')) > 0) {
			$url = $this->val('alias_url');		
		} else {
			$url = 'category/' . $this->val('category_id');
		}
		return _url($url);
	}	
					
	static function renderMenu($tree, $level = 0, $parent_id = 0, $collapsed = false) {
		?>
			<ul id="zmenu-collapse-<?=$parent_id ?>" class="list-group collapse <?=($collapsed) ? '' : 'in' ?> zmenu-collapse level-<?=$level ?>">
				<?php		
					foreach ($tree as $category) {
						?>
							<li class="list-group-item <?=($category->is_selected) ? 'selected' : '' ?>">																
								<?php
									if ((isset($category->children)) && (count($category->children) > 0)) {
										?>
											<span 
												id="zmenu-toggle-<?=$category->val('category_id')?>" 
												data-toggle="collapse" 
												data-target="#zmenu-collapse-<?=$category->val('category_id')?>" 
												class="glyphicon <?=($category->is_on_selected_path) ? 'glyphicon-menu-down' : 'glyphicon-menu-right' ?> zmenu-toggle">
											</span>
										<?php
									}
								?>
								<a href="<?=$category->getLinkUrl(); ?>">
									<?=$category->val('category_name')?>
								</a>								
							</li>							
							
						<?php
						
						if (isset($category->children)) {
							Category::renderMenu($category->children, $level + 1, $category->ival('category_id'), !$category->is_on_selected_path);
						}
					}					
				?>	
			</ul>
		<?php		
	}
	
	static function renderSideMenu($db, $selected_id = 0) {
		$categories_tree = Category::getCategoryTree($db, $selected_id);
		
		?>
			<div id="side-menu">
				<?php
					Category::renderMenu($categories_tree, 0, 0);
				?>
				
				<script>
					function updateToggle(caller) {
						var id = String.substr(caller.id, 15);
						var state = $(caller).hasClass('in');
						var toggle = $('#zmenu-toggle-' + id);
						toggle.removeClass('glyphicon-menu-right');
						toggle.removeClass('glyphicon-menu-down');
						
						if (state) {
							toggle.addClass('glyphicon-menu-down');
						} else {
							toggle.addClass('glyphicon-menu-right');
						}
					}
					
					$('.zmenu-collapse').on('show.bs.collapse', function () {
						updateToggle(this);
					});
					$('.zmenu-collapse').on('hide.bs.collapse', function () {
						updateToggle(this);
					});
					$('.zmenu-collapse').on('shown.bs.collapse', function () {
						updateToggle(this);
					});
					$('.zmenu-collapse').on('hidden.bs.collapse', function () {
						updateToggle(this);
					});
				</script>
			</div>
		<?php
	}
	
}