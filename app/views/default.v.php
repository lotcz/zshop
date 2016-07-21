<div class="container">
	<div class="header basic-bg spaced">
		<div class="row">	
			<div class="col-md-2 text-left">
				<a href="<?=$base_url ?>" alt="<?=t('Home') ?>">
					<?php
						renderImage('logo.jpg', 'Logo', 'img-circle img-responsive logo' );			
					?>
				</a>
			</div>
			
			<div class="col-md-4 text-center">
				<div class="main-title"><?=$globals['site_title'] ?></div>
			</div>	
			
			<div class="col-md-6 text-right">		
				<?php
					
							

					renderBlock('menu');
					renderBlock('cart');
				?>			
			</div>
		</div>
	</div>

	<div class="row spaced">
		<div class="col-md-4 sidebar">
			<?php		
				renderBlock('search');					
				renderBlock('side-menu');
			?>			
		</div>
		<div class="col-md-8">
			<?php
				if (isset($page_title)) {
					?>
						<h1><?=$page_title ?></h1>						
					<?php
				}
				
				renderBlock('messages');

				include $home_dir . 'views/' . $page . '.v.php';
				
				renderBlock('messages');				
			?>
		</div>
	</div>
</div>