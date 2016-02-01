<div class="container">
	<div class="header basic-bg spaced">
		<div class="row">	
			<div class="col-md-3">
				<a href="<?=$base_url ?>" alt="<?=t('Home') ?>">
					<?php
						renderImage('logo.jpg', 'Logo', 'img-circle logo' );			
					?>
				</a>
			</div>
			
			<div class="col-md-3 main-title"><?=$globals['shop_title'] ?></div>
			
			<div class="col-md-3 text-center">		
				<?php
					renderBlock('search');					
				?>			
			</div>
			
			<div class="col-md-3 text-right">		
				<?php
					renderBlock('lang');
					renderBlock('cart');
				?>			
			</div>
		</div>
	</div>

	<div class="row spaced">
		<div class="col-md-3 sidebar">
			<?php				
				renderBlock('categories');
			?>			
		</div>
		<div class="col-md-9">
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