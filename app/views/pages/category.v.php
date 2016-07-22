<?php
	global $data;
	$category = $data['category'];
	$paging = $data['paging'];
	
	echo $category->val('category_description');
	
	$paging->renderSorting();
	$paging->renderLinks();
	
?>

<div id="products-container" class="row spaced products">	
	<?php
		foreach ( $data['products'] as $product) {
			renderPartial('prod-prev', $product);
		}
		
		// render Load more... button
		
		//renderPartial('lmbutton', $paging);
	?>	
	
</div>

<?php
	$paging->renderLinks();	
?>	

<script>

	function loadMore(offset, limit) {
		$('#load-more-button').remove();
		$('#load-more-waiting').show();
		$.get(
			'<?=_url('partials/loadmore') ?>', 
			{
				category_ids: '<?=implode(',', $data['ids']) ?>',
				sorting: '<?=$data['sorting'] ?>',
				offset: offset,
				limit: limit
			},
			moreLoaded,
			'html'
		);
	}

	function moreLoaded(data) {
		$('#load-more').remove();
		$('#products-container').html(data);
	}


</script>