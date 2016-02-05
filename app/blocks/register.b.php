<?php 
	global $raw_path;
	
?>

<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title"><?=t('Registration') ?></h3>
	</div>

	<div class="panel-body">
		<form id="register_form" class="form-horizontal" action="/register?ret=<?=$raw_path ?>" method="post">			
			<div class="form-group">
				<label for="register_email" class="col-md-4 control-label"><?=t('E-mail') ?>:</label>
				<div class="col-md-8">
					<input type="text" name="register_email" maxlength="50" class="form-control" value="<?=(isset($_POST['email'])) ? $_POST['email'] : '' ?>" />
					<div class="form-validation" id="register_email_validation_email"><?= t('Enter valid email.') ?></div>
				</div>			
			</div>			
			<div class="form-group">
				<label for="register_password" class="col-md-4 control-label"><?=t('Password') ?>:</label>
				<div class="col-md-8">
					<input type="password" maxlength="50" name="register_password" class="form-control"  />
					<div class="form-validation" id="register_password_validation_length"><?= t('At least 5 letters.') ?></div>
				</div>
			</div>
			<div class="form-group">
				<label for="register_password_confirm" class="col-md-4 control-label"><?=t('Confirm') ?>:</label>
				<div class="col-md-8">
					<input type="password" maxlength="50" name="register_password_confirm" class="form-control"  />
					<div class="form-validation" id="register_password_confirm_validation_confirm"><?= t('Passwords don\'t match.') ?></div>
				</div>			
			</div>			
			<div class="form-group">
				<div class="col-md-12 text-center">
					<input type="submit" onclick="javascript:register_validate();return false;" class="btn btn-success" value="<?=t('Create New Account') ?>">
				</div>
			</div>

		</form>
	</div>

</div>

<script>
	function register_validate() {
		var frm = new formValidation('register_form');
		frm.add('register_email', 'email');
		frm.add('register_password', 'length', 5);
		frm.add('register_password_confirm', 'confirm', 'register_password');
		frm.submit();		
	}
</script>