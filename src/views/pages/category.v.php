<?php
	global $data;
	$category = $data['category'];
	
	/*
		LINKS TO CHILDREN CATEGORIES
	*/
	if (isset($category->children) && count($category->children) > 0) {
		?>
			<div class="panel panel-default spaced">		
				<div class="panel-body">
					<?php
						foreach ($category->children as $cat) {
							?>
								<div class="col-md-4">
									<?php
										renderLink('category/' . $cat->val('category_id'), $cat->val('category_name'), '');
									?>
								</div>
							<?php							
						}
					?>			
				</div>
			</div>	
		<?php
	}	

	renderPartial('prod-sort', null);
	
?>

<div class="row spaced products">	
	<?php
		foreach ( $data['products'] as $product) {
			renderPartial('prod-prev', $product);
		}
	?>
</div>