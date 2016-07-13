<?php
	require_once $home_dir . 'models/category.m.php';
	global $db, $path;
				
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
													class="glyphicon <?=($category->is_on_selected_path) ? 'glyphicon-menu-down' : 'glyphicon-menu-right' ?> zmenu-toggle">
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
	
	$selected_id = null;
	if (isset($path[0]) && $path[0] == 'category' && isset($path[1])) {
		$selected_id = parseInt($path[1]);
	}
	
	$categories_tree = Category::getCategoryTree($db, $selected_id);
		
?>
	
	<div id="side-menu">
		<?php
			renderSideMenu($categories_tree);
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