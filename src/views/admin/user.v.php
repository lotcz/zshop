<div class="inner cover">	
	<form method="post" action="/admin/user" class="form-horizontal" style="max-width:480px;margin:auto">
		<input type="hidden" name="user_id" value="<?php echo $user->user_id ?>" />
		<div class="form-group">
			<label for="user_login" class="col-sm-5 control-label"><?= t('Login:') ?></label>
			<div class="col-sm-7">
				<input type="text" name="user_login" value="<?=$user->user_login ?>" class="form-control" />
			</div>
			<span id="user_login_validation" class="form-validation"><?= t('Login or Email required.') ?></span>			
		</div>		
		<div class="form-group">
			<label for="user_email" class="col-sm-5 control-label"><?= t('E-mail:') ?></label>
			<div class="col-sm-7">
				<input type="text" name="user_email" value="<?=$user->user_email ?>" class="form-control" />
			</div>
			<span id="user_email_validation" class="form-validation"><?= t('Login or Email required.') ?></span>
		</div>
		<div class="form-group">
			<label for="user_password" class="col-sm-5 control-label"><?= t('Password:') ?></label>
			<div class="col-sm-7">
				<input type="password" name="user_password" class="form-control" />
			</div>
			<span id="user_password_validation" class="form-validation"><?= t('Required.') ?></span>
		</div>
		<div class="form-group">
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
		if (confirm('<?= t('Are you sure to delete this user?') ?>')) {
			document.location = '<?= $base_url ?>/admin/user/delete/<?php echo $user->user_id ?>';
		}
	}	
</script>