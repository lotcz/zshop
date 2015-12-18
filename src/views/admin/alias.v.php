<div class="inner cover">	
	<form method="post" action="/admin/customer" class="form-horizontal admin-form">
		<input type="hidden" name="customer_id" value="<?=$data->val('alias_id') ?>" />
		<div class="form-group">
			<label for="alias_url" class="col-sm-2 control-label"><?= t('URL:') ?></label>
			<div class="col-sm-6"><input type="text" name="alias_url" value="<?=$data->val('alias_url') ?>" class="form-control" /></div>
			<span id="alias_url_validation" class="form-validation"><?= t('Field required.') ?></span>
		</div>
		<div class="form-group">
			<label for="customer_email" class="col-sm-2 control-label"><?= t('Target Type:') ?></label>
			<div class="col-sm-6"><input type="text" name="customer_email" value="<?=$data->val('customer_email') ?>" class="form-control" /></div>
			
		</div>
		<div class="form-group">
			<label for="alias_target_id" class="col-sm-2 control-label"><?= t('Target ID:') ?></label>
			<div class="col-sm-6"><input type="text" name="alias_url" value="<?=$data->val('alias_url') ?>" class="form-control" /></div>
			<span id="alias_url_validation" class="form-validation"><?= t('Field required.') ?></span>
		</div>
		<div class="form-buttons">
			<a class="form-button" href="/admin/customers"><?= t('Back') ?></a>
			<input type="button" onclick="javascript:deleteAlias();" class="btn btn-danger form-button" value="Delete">
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
	
	function deleteAlias() {
		if (confirm('<?= t('Are you sure to delete this alias?') ?>')) {
			document.location = '<?= $base_url ?>/admin/alias/delete/<?=$data->val('customer_id') ?>';
		}
	}	
</script>