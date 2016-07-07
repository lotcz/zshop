<?php
	global $data;
	$category = $data['category'];
	
	echo $category->val('category_description');
	
	renderPartial('prod-sort', null);
	
?>

<div id="products-container" class="row spaced products">	
	<?php
		foreach ( $data['products'] as $product) {
			renderPartial('prod-prev', $product);
		}
	?>
</div>
	
<?php
	// render Load more... button
	$paging = $data['paging'];
	$remaining = $paging->total_records - ($paging->offset + $paging->limit);
	if ($remaining > 0) {
		?>
			<div id="load-more" class="text-center">
				<button id="load-more-button" class="btn btn-primary" title="<?=t('Load more...') ?>" onclick="javascript:loadMore(<?=($paging->offset + $paging->limit) ?>, <?=$paging->limit ?>);" >
					<?=t('Load more...') ?>
					<span class="badge"><?=$remaining ?></span>
				</button>
				<span id="load-more-waiting" class="ajax-loader"></span>
			</div>
		<?php
	}

?>

<script>

	function loadMore(offset, limit) {
		$('#load-more-button').hide();
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
		$('#products-container').append(data);
		$('#load-more-button').show();
		$('#load-more-waiting').hide();
	}


</script>