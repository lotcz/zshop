<nav class="navbar navbar-inverse navbar-fixed-top header" role="navigation" style="height:140px">
	<div class="container">
		
		<div class="col-md-2">
			<a href="<?=$base_url ?>" alt="<?=t('Home') ?>">
				<?php
					renderImage('logo.jpg', 'Logo', 'img-circle logo' );			
				?>
			</a>
		</div>
		
		<div class="col-md-8 main-title">
			<h1>zShop 1.2</h1>
		</div>
		
		<!-- grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>			
		</div>
		
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="col-md-2 head-block user" id="bs-example-navbar-collapse-1">
			<ul>
				<?php 
					renderBlock('user');	
					renderBlock('lang');					
				?>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>

<div class="container" style="margin-top:160px">			
	<div class="row">
		<div class="col-md-3 sidebar">
			<?php					
				if ($auth->isAuth()) {
					renderLink('admin','Administration','btn btn-default');
				}
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