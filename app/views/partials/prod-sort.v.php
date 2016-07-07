<?php

	global $data;
	
	$items = [ 'sortby_Price', 'sortby_Price_DESC', 'sortby_Popularity', 'sortby_Alphabet', 'sortby_Alphabet_DESC' ];
	
	$sorting = isset($_GET['o']) ? $_GET['o'] : $items[0];
		
	if (!in_array($sorting, $items)) {
		$sorting = $items[0];
	}
	
	$total = $data['paging']->total_records;
	
?>

<div class="basic-bg prod-sort spaced">
	<form class="form-inline">
		<div class="form-group">
			<label><?=t('Order by') ?>:</label>
			<div class="dropdown btn btn-default form-control">
				<span class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					<?=t($sorting) ?>
					<span class="caret"></span>
				</span>
				<ul class="dropdown-menu">
					<?php
						foreach ($items as $item) {
							?>
								<li class="<?= ($sorting == $item) ? 'active' : '' ?>"><a href="?o=<?=$item ?>"><?=t($item) ?></a></li>
							<?php
						}
					?>
				</ul>
			</div>
		</div>
		<div class="form-group">			
			<label>
				<?=t('Total <b>%s</b> items.',$total) ?>
			</label>
		</div>
		
	
		
	</form>
</div>