<?php
	global $globals, $config;
?>
<div class="header basic-bg spaced">
	<div class="row">	
		<div class="col-md-2 text-left">
			<a href="<?=$config['base_url'] ?>" alt="<?=t('Home') ?>">
				<?php
					renderImage('logo.jpg', 'Logo', 'img-circle img-responsive logo' );			
				?>
			</a>
		</div>
		
		<div class="col-md-4">
			<span class="main-title"><?=$globals['site_title'] ?></span>
		</div>	
		
		<div class="col-md-6 text-right">		
			<?php
				renderBlock('menu');
				renderBlock('cart');
			?>			
		</div>
	</div>
</div>
