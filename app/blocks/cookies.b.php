<div id="cookies_disabled" class="cookies-disabled panel panel-danger form-validation">
	<div class="panel-heading">
		<strong><span class="glyphicon glyphicon-alert"></span> &nbsp; <?=t('--cookies--') ?></strong>
	</div>
</div>

<script>
	$(function() {
	  if (!checkCookies()) {
			$('#cookies_disabled').show();
		}
	});
</script>