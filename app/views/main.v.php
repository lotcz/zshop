<div class="container">
	
	<?php		
		renderBlock('header');					
	?>
	
	<div class="row spaced">
		<div class="col-md-4 sidebar">
			<?php		
				//renderBlock('search');					
				renderBlock('side-menu');
			?>			
		</div>
		<div class="col-md-8">
			<?php
				if (isset($page_title)) {
					?>
						<h1 class="page-title"><?=$page_title ?></h1>						
					<?php
				}
				
				renderBlock('messages');

				include $home_dir . 'views/' . $page_template . '.v.php';
				
				renderBlock('messages');				
			?>
		</div>
	</div>
	
</div>