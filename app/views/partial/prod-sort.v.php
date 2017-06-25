<?php

	$paging = $this->getData('partials.prod-sort');
		
?>

<div class="basic-bg prod-sort spaced">
	<form class="form-inline">
		<div class="form-group">
			<label><?=$this->t('Order by') ?>:</label>
			<div class="dropdown btn btn-default form-control">
				<span class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					<?=$this->t($paging->active_sorting) ?>
					<span class="caret"></span>
				</span>
				<ul class="dropdown-menu">
					<?php
						foreach ($paging->sorting_items as $key => $item) {
							?>
								<li class="<?= ($paging->active_sorting == $key) ? 'active' : '' ?>"><a href="<?=$paging->getLinkUrl($paging->offset, $paging->limit, $key) ?>"><?=$this->t($key) ?></a></li>
							<?php
						}
					?>
				</ul>
			</div>
		</div>
		<div class="form-group">			
			<label>
				<?=$this->t('Total <b>%s</b> items.', $paging->total_records) ?>
			</label>
		</div>
		
	
		
	</form>
</div>