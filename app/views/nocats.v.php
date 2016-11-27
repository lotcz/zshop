<div class="container">
	
	<?php		
		renderBlock('header');					

		if (isset($page_title)) {
			?>
				<h1 class="page-title"><?=$page_title ?></h1>						
			<?php
		}
		
		renderBlock('messages');

		include $home_dir . 'views/' . $page_template . '.v.php';
		
		renderBlock('messages');	
		
		renderBlock('footer');		
	?>
	
</div>