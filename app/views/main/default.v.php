<div class="container">
	
	<?php		
		$this->renderPartialView('header');
	?>
	
	<div class="row spaced">
		<div class="col-md-4 sidebar">
			<?php		
				$this->renderPartialView('side-menu');
			?>			
		</div>
		<div class="col-md-8">
			<h1 class="page-title"><?=$this->data['page_title'] ?></h1>
			
			<?php
				$this->renderPartialView('messages');
				$this->renderPageView();				
			?>
		</div>
	</div>
	
	<?php		
		$this->renderPartialView('footer');					
	?>
	
</div>