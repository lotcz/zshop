<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="height:50px">
	<div class="container">
		<!-- grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			 </button>
			 <a class="navbar-brand" href="/admin"><?=t('Administration') ?></a>
		</div>
				
		<?php 
			renderBlock('user');					
		?>
	
	</div>
	<!-- /.container -->
</nav>

<div class="container" style="margin-top:50px">			
	<div class="row">
		<div class="col-md-3 sidebar">
			<p>
				<a class="btn btn-default form-button" href="/"><?=t('Go to E-shop') ?></a>
			<p>
			<?php					
				if ($auth->isAuth()) {
					renderBlock('admin');
				}
			?>			
			<div style="text-align:center">
				<?php renderBlock('lang'); ?>
			</div>
		</div>
		<div class="col-md-9">
			<?php
				if (isset($page_title)) {
					echo '<h1>' . $page_title . '</h1>';
				}
				
				renderBlock('messages');
										
				include $home_dir . 'views/' . $page . '.v.php';
			?>
		</div>
	</div>
</div>