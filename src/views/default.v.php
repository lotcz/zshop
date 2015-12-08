<div class="site-wrapper">
	<div class="site-wrapper-inner">
		<div class="cover-container">
		
			<div class="masthead clearfix">
				<div class="inner">
					<h1 class="masthead-brand">DEFAULT HEADER</h1>					
					<nav>
						<ul class="nav masthead-nav">
							<?php 
								renderBlock('user');
								renderBlock('lang');
							?>
						</ul>
					</nav>
				</div>
			</div>

			<?php
				include $home_dir . 'views/' . $page . '.v.php';
			?>

			<div class="mastfoot">
				<div class="inner">
					FOOTER
				</div>
			</div>

		</div>
	</div>
</div>