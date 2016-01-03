<?php
	global $data;
	$paging = $data['partials.paging'];
	$links = $paging->getLinks('');
	
	if (count($links) > 0) {
		?>
			<div class="text-center">
				<div class="panel panel-primary">
					<?php
						foreach ($links as $link) {						
							?>
								<a class="btn btn-sm btn-default <?=$link['class'] ?>" href="<?=$link['href']?>"><?=$link['title']?></a>
							<?php						
						}
					?>
				</div>
			</div>
		<?php
	}
?>