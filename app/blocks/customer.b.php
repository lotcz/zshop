<?php
	global $custAuth;	
?>
<div class="customer-small">
	<?php
		if ($custAuth->isAuth()) {
			renderLink('customer', $custAuth->val('customer_name', $custAuth->val('customer_email')), 'link');
			if (!$custAuth->customer->val('customer_anonymous')) {
				?>
					<a href="/logout"><span class="link glyphicon glyphicon glyphicon-log-out"></span></a>
				<?php
			}
		}
	?>
</div>