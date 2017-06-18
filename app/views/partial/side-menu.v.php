<?php
			
	// let's call this function recursively to render menu tree
	function renderSideMenu($parent) {
		if (isset($parent->children)) {
			?>
				<ul id="zmenu-collapse-<?=$parent->val('category_id') ?>" class="list-group collapse <?=($parent->is_on_selected_path) ? 'in' : '' ?> zmenu-collapse level-<?=$parent->level ?>">
					<?php		
						foreach ($parent->children as $category) {
							?>
								<li class="list-group-item <?=($category->is_selected) ? 'selected' : '' ?>">																
									<?php
										if ((isset($category->children)) && (count($category->children) > 0)) {
											?>
												<span 
													id="zmenu-toggle-<?=$category->val('category_id')?>" 
													data-toggle="collapse" 
													data-target="#zmenu-collapse-<?=$category->val('category_id')?>" 
													class="glyphicon glyphicon-triangle-<?=($category->is_on_selected_path) ? 'bottom' : 'right' ?> zmenu-toggle">
												</span>
											<?php
										}
									?>
									<a href="<?=$category->getLinkUrl(); ?>">
										<?=$category->val('category_name')?>
									</a>

									<span class="badge">
										<?=$category->total_products?>
									</span>
								</li>							
								
							<?php
							
							renderSideMenu($category);
							
						}					
					?>	
				</ul>
			<?php
		}
	}
		
?>

<div id="side-menu">
	<?php
		renderSideMenu($this->data['category_tree']);
	?>
</div>