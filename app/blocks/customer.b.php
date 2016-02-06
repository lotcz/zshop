<?php
	global $custAuth;	
?>
<div class="customer-small">
	<?php
		if ($custAuth->isAuth()) {			
			if ($custAuth->customer->val('customer_anonymous')) {
				renderLink('register', 'Anonymous', 'link');
			} else {
				renderLink('customer', $custAuth->val('customer_name', $custAuth->val('customer_email')), 'link');
				?>
					<a href="/logout"><span class="link glyphicon glyphicon glyphicon-log-out"></span></a>
				<?php
			}
		}
	?>
</div>