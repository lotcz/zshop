<div class="container">
	
	<?php		
		$this->renderPartialView('header');
	?>
	
	<div class="spaced">
		<h1 class="page-title"><?=$this->data['page_title'] ?></h1>
		
		<?php
			$this->renderPartialView('messages');
			$this->renderPageView();				
		?>		
	</div>
	
	<?php		
		$this->renderPartialView('footer');					
	?>
	
</div>