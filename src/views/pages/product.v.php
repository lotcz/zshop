<?php
	global $data;
	$product = $data['product'];
	
	echo $raw_path;
	
	?>
		<div class="panel panel-default spaced">		
			<div class="panel-body">
				<?php					
					$product->renderImage('full');					
				?>
			</div>
		</div>	
	<?php