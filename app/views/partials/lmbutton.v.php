<?php
	global $data;
	$paging = $data['partials.lmbutton'];

	$remaining = $paging->total_records - ($paging->offset + $paging->limit);
	
	if ($remaining > 0) {
		?>
			<div id="load-more" class="spaced text-center">
				<button id="load-more-button" class="btn btn-primary" title="<?=t('Load more...') ?>" onclick="javascript:loadMore(<?=($paging->offset + $paging->limit) ?>, <?=$paging->limit ?>);" >
					<?=t('Load more...') ?>
					<span class="badge"><?=$remaining ?></span>
				</button>
				<span id="load-more-waiting" class="ajax-loader"></span>
			</div>
		<?php
	}
	
?>