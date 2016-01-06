<div class="container">
	<div class="jumbotron basic-bg">
		<div class="row">	
			<div class="col-md-2">
				<a href="<?=$base_url ?>" alt="<?=t('Home') ?>">
					<?php
						renderImage('logo.jpg', 'Logo', 'img-circle logo' );			
					?>
				</a>
			</div>
			
			<div class="col-md-7 main-title">
				<h1>zShop 1.2</h1>
			</div>
			
			<div class="col-md-3">		
				<?php
					renderBlock('lang');
				?>			
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3 sidebar">
			<?php				
				renderBlock('categories');
			?>			
		</div>
		<div class="col-md-9">
			<?php
				if (isset($page_title)) {
					echo '<h1>' . $page_title . '</h1>';
				}
				
				renderBlock('messages');
										
				include $home_dir . 'views/' . $page . '.v.php';
				
				renderBlock('sellers');
			?>
		</div>
	</div>
</div>