<?php
	global $data;
	
	$items = [ 'Price' , 'Popularity', 'Alphabet' ];	
	
	$sorting = isset($_GET['o']) ? ucfirst($_GET['o']) : $items[0];
		
	if (!in_array($sorting, $items)) {
		$sorting = $items[0];
	}
	
	$total = $data['paging']->total_records;
	
	$dir = (isset($_GET['d']) && ($_GET['d'] == 'asc')) ? 'asc' : 'desc';
?>
<div class="basic-bg prod-sort spaced">
	<form class="form-inline">
		<div class="form-group">
			<label><?=t('Sort by:') ?></label>
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
			<label><?=t('Direction:') ?></label>
			<div class="dropdown btn btn-default form-control">
				<span class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					<?=t($dir) ?>
					<span class="caret"></span>
				</span>
				<ul class="dropdown-menu">
					<li class="<?= ($dir == 'asc') ? 'active' : '' ?>"><a href="?d=asc&o=<?=$sorting ?>"><?=t('asc') ?></a></li>
					<li class="<?= ($dir == 'desc') ? 'active' : '' ?>"><a href="?o=<?=$sorting ?>"><?=t('desc') ?></a></li>					
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