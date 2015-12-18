<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/admin"><?=t('Administration') ?></a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<?php 
					renderBlock('user');					
				?>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>

<div class="container" style="margin-top:70px">			
	<div class="row">
		<div class="col-md-3 sidebar">
			<?php					
				if ($auth->isAuth()) {
					renderBlock('admin');
				}
			?>
			<hr/>
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