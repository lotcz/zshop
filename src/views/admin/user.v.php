<div class="inner cover">	
	<form method="post" action="/admin/user" class="form-horizontal admin-form">
		<input type="hidden" name="user_id" value="<?php echo $data->val('user_id') ?>" />
		<div class="form-group">
			<label for="user_login" class="col-sm-2 control-label"><?= t('Login') ?>:</label>
			<div class="col-sm-6"><input type="text" name="user_login" value="<?=$data->val('user_login') ?>" class="form-control" /></div>
			<div class="col-sm-4 form-validation" id="user_login_validation"><?= t('Login or Email required.') ?></div>
		</div>		
		<div class="form-group">
			<label for="user_email" class="col-sm-2 control-label"><?= t('E-mail') ?>:</label>
			<div class="col-sm-6"><input type="text" name="user_email" value="<?=$data->val('user_email') ?>" class="form-control" /></div>
			<div class="col-sm-4 form-validation" id="user_email_validation"><?= t('Login or Email required.') ?></div>
		</div>
		<div class="form-group">
			<label for="user_failed_attempts" class="col-sm-2 control-label"><?= t('Failed logins') ?>:</label>
			<div class="col-sm-6"><input type="text" name="user_failed_attempts" value="<?=$data->val('user_failed_attempts') ?>" class="form-control" /></div>
			<div class="col-sm-4"><span class="help-block"><?=t('Max value is %s.', Authentication::$max_attempts) ?></span></div>			
		</div>
		
		<div class="form-group">
			<label for="user_password" class="col-sm-2 control-label"><?= t('Password:') ?></label>
			<div class="col-sm-6"><input type="password" name="user_password" class="form-control" /></div>
			<div class="col-sm-4 form-validation" id="user_password_validation"><?= t('Required.') ?></div>
		</div>
		<div class="form-buttons">
			<a class="form-button" href="/admin/users"><?= t('Back') ?></a>
			<input type="button" onclick="javascript:deleteUser();" class="btn btn-danger form-button" value="Delete">
			<input type="button" onclick="javascript:validate();" class="btn btn-success form-button" value="Save">
		</div>
	</form>	
</div>

<script>
	function validate() {
		var isValid = true;
		var login = document.forms[0]['user_login'].value;
		var email = document.forms[0]['user_email'].value;
		if (login.length == 0 && email.length == 0) {
			showFieldValidation('user_login');
			showFieldValidation('user_email');			
			isValid = false;
		} else {
			 hideFieldValidation('user_login');
			 hideFieldValidation('user_email');
		}
		var id = document.forms[0]['user_id'].value;
		if (id == '0') {
			isValid = validateField('user_password') && isValid;
		}
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