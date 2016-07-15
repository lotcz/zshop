<script src="https://cdn.jsdelivr.net/mark.js/7.0.2/jquery.mark.min.js"></script>
<?php
	global $data;
	$search_results = $data['search_results'];
?>
<div class="inner cover">	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?=t('Search')?></h3>
		</div>
		<div class="panel-body search-results">
		
			<?php
			
				renderBlock('search');
				$data['paging']->renderLinks();
			
				if (isset($search_results)) {
					foreach ($search_results as $result) {
						renderPartial('prod-prev', $result);
					}
				}
			
			
			?>
		</div>
	</div>
	
	<script>
		$(".search-results").mark('<?=$search?>');
	</script>
</div>