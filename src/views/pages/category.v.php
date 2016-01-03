<?php
	global $data;
	$category = $data['category'];
	
	/*
		LINKS TO CHILDREN CATEGORIES
	*/
	if (isset($category->children) && count($category->children) > 0) {
		?>
			<div class="panel panel-default">		
				<div class="panel-body">
					<?php
						foreach ($category->children as $cat) {
							echo '<div class="col-md-4">';
							renderLink('category/' . $cat->val('category_id'), $cat->val('category_name'), '');
							echo '</div>';
						}
					?>			
				</div>
			</div>	
		<?php
	}	

	/*
		PRODUCTS IN CATEGORY
	*/
	foreach ( $data['products'] as $product) {
		renderPartial('prod-prev', $product);
	}

?>
