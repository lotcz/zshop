<div class="inner cover">	
	<form method="post" action="/admin/customer" class="form-horizontal admin-form">
		<input type="hidden" name="customer_id" value="<?=$data->val('customer_id') ?>" />
		<div class="form-group">
			<label for="customer_login" class="col-sm-2 control-label"><?= t('Login:') ?></label>
			<div class="col-sm-6"><input type="text" name="customer_login" value="<?=$data->val('customer_login') ?>" class="form-control" /></div>
		</div>
		<div class="form-group">
			<label for="customer_email" class="col-sm-2 control-label"><?= t('E-mail:') ?></label>
			<div class="col-sm-6"><input type="text" name="customer_email" value="<?=$data->val('customer_email') ?>" class="form-control" /></div>
			<span id="customer_email_validation" class="form-validation"><?= t('Email required.') ?></span>
		</div>
		<div class="form-buttons">
			<a class="form-button" href="/admin/customers"><?= t('Back') ?></a>
			<input type="button" onclick="javascript:deleteUser();" class="btn btn-danger form-button" value="Delete">
			<input type="button" onclick="javascript:validate();" class="btn btn-success form-button" value="Save">
		</div>
	</form>	
</div>

<script>
	function validate() {
		var isValid = true;
		isValid = validateField('customer_email') && isValid;
		if (isValid) {
			document.forms[0].submit();
		}
	}
	
	function deleteUser() {
		if (confirm('<?= t('Are you sure to delete this customer?') ?>')) {
			document.location = '<?= $base_url ?>/admin/customer/delete/<?=$data->val('customer_id') ?>';
		}
	}	
</script>