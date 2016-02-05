<div class="container admin" role="main">
	<?php
		if (isset($page_title)) {
			echo '<h1>' . $page_title . '</h1>';
		}
		
		renderBlock('messages');
								
		include $home_dir . 'views/' . $page . '.v.php';
	?>
</div>