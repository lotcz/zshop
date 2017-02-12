<?php
	global $raw_path;
	
	$progress_stages = [
		[
			'url' => 'cart',
			'name' => 'Cart'
		],
		[
			'url' => 'delivery',
			'name' => 'Delivery Type'
		],
		[
			'url' => 'payment',
			'name' => 'Payment Type'
		],
		[
			'url' => 'confirm',
			'name' => 'Confirmation'
		]
	];
	
	$progress_current = $raw_path;

?>

<div class="progress order-progress">
	<?php
		$is_passed = true;
		foreach ($progress_stages as $progress_stage) {			
			$is_selected = ($progress_stage['url'] == $progress_current) ? true : false;			
			if ($is_selected) {
				$is_passed = false;
			}
			?>
				<div class="progress-bar progress-bar-<?=($is_selected) ? 'warning' : (($is_passed) ? 'success' : 'default');?>" style="width: 25%">		
					<?php
						 if ($is_passed) {
							?>
								<span class="glyphicon glyphicon-ok"></span>
							<?php
						 }
						 
						 echo t($progress_stage['name']);
					?>							
				</div>
			<?php
			
			
			
		}
	?>	
</div>