<?php
	global $auth, $path;
	
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			 </button>
			<?php
				if ($path[0] == 'admin') {
					?>
						<a class="navbar-brand" href="/"><?=t('Go to E-shop') ?></a>
					<?php
				} else {
					?>
						<a class="navbar-brand" href="/admin"><?=t('Administration') ?></a>
					<?php
				}		 
			?>
		</div>
		
		<div class="collapse navbar-collapse" id="navbar">		
			<ul class="nav navbar-nav navbar-left">
				<?php 
					if ($path[0] == 'admin') {
						renderMenuLink('admin', 'Dashboard');
					}
					
					renderMenuLink('admin/products', 'Products');
					renderMenuLink('admin/orders', 'Orders');
					
					renderMenuLink('admin/customers', 'Customers');					
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=t('More...') ?><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="dropdown-header"><?=t('Content') ?></li>
						<?php
							renderMenuLink('admin/categories', 'Categories');
							
						?>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header"><?=t('Administrators') ?></li>
						<?php
							renderMenuLink('admin/users', 'Administrators');
							renderMenuLink('admin/roles', 'Administrator roles');
							
						?>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header"><?=t('Advanced') ?></li>
						<?php
							renderMenuLink('admin/payment_types', 'Payment types');
							renderMenuLink('admin/delivery_types', 'Delivery types');
							renderMenuLink('admin/aliases', 'Aliases');
							renderMenuLink('admin/ip_failed_attempts', 'Failed login attempts');
							renderMenuLink('admin/jobs', 'Jobs');
						?>
				  </ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/admin/user/edit/<?=$auth->user->val('user_id') ?>"><?=$auth->user->val('user_email') ?></a></li>
				<li><a href="/admin/logout"><?=t('Log Out') ?></a></li>
			</ul>
		</div>
	</div>
</nav>