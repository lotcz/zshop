<div class="collapse navbar-collapse" id="navbar">
	<ul class="nav navbar-nav navbar-right">
		<?php
			global $auth;
			
			if (isset($auth) && $auth->isAuth()) { 
				echo "<li><a href=\"/admin/user/edit/" . $auth->user->val('user_id') . "\">" . $auth->user->val('user_email') . "</a></li>";
				echo "<li><a href=\"/admin/logout\">" . t('Log Out') . "</a></li>";
			}
		?>
	</ul>
</div>