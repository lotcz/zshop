<div class="inner cover">	
	<form method="post" action="/admin/user" class="form-horizontal admin-form">
		<input type="hidden" name="user_id" value="<?php echo $data->val('user_id') ?>" />
		<div class="form-group">
			<label for="user_login" class="col-sm-3 control-label"><?= t('Login') ?>:</label>
			<div class="col-sm-2"><input type="text" maxlength="100" name="user_login" value="<?=$data->val('user_login') ?>" class="form-control" /></div>
		</div>		
		<div class="form-group">
			<label for="user_email" class="col-sm-3 control-label"><?= t('E-mail') ?>:</label>
			<div class="col-sm-4"><input type="text" name="user_email" maxlength="255" value="<?=$data->val('user_email') ?>" class="form-control" /></div>
			<div class="col-sm-5 form-validation" id="user_email_validation"><?= t('Required.') ?></div>
		</div>
		<div class="form-group">
			<label for="user_failed_attempts" class="col-sm-3 control-label"><?= t('Failed Logins') ?>:</label>
			<div class="col-sm-1"><input type="text" name="user_failed_attempts" value="<?=$data->val('user_failed_attempts') ?>" class="form-control" /></div>
			<div class="col-sm-8"><span class="help-block"><?=t('Max value is %s.', Authentication::$max_attempts) ?></span></div>			
		</div>		
		<div class="form-group">
			<label for="user_password" class="col-sm-3 control-label"><?= t('Password') ?>:</label>
			<div class="col-sm-3"><input type="password" name="user_password" class="form-control" /></div>
		</div>
		<div class="form-group">
			<label for="user_last_access" class="col-sm-3 control-label"><?= t('Last Visit') ?>:</label>
			<div class="col-sm-6"><p class="form-control-static"><?=$data->val('user_last_access') ?></p></div>
		</div>
		<div class="form-buttons">
			<a class="form-button" href="/admin/users"><?= t('Back') ?></a>
			<input type="button" onclick="javascript:deleteUser();" class="btn btn-danger form-button" value="<?=t('Delete') ?>">
			<input type="button" onclick="javascript:validate();" class="btn btn-success form-button" value="<?=t('Save') ?>">
		</div>
	</form>	
</div>

<script>
	function validate() {
		var isValid = true;
		isValid = validateField('user_email') && isValid;
		
		if (isValid) {
			document.forms[0].submit();
		}
	}
	
	function deleteUser() {
		if (confirm('<?=t('Are you sure to delete this user?') ?>')) {
			document.location = '<?=$base_url . '/admin/user/delete/' . $data->val('user_id') ?>';
		}
	}	
</script>