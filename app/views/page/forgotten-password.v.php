<div class="inner cover">
	<form method="post" class="form-horizontal" id="password_forgot_form" >
		<div class="form-group">
			<label for="email" class="col-sm-4 control-label"><?=$this->t('E-mail') ?>:</label>
			<div class="col-sm-4"><input type="text" name="email" class="form-control" value="<?=z::get('email', '') ?>" /></div>
			<div class="col-sm-4 form-validation" id="email_validation_email"><?=$this->t('Required.') ?></div>
		</div>
		<div class="form-buttons">
			<a class="form-button" href="<?=$this->url('login') ?>"><?=$this->t('Sign In') ?></a>
			<input type="button" onclick="javascript:password_forgot_validate();return false;" class="btn btn-success form-button" value="<?=$this->t('Reset Password') ?>">
		</div>
	</form>
</div>

<script>
function password_forgot_validate() {
		var frm = new formValidation('password_forgot_form');
		frm.add('email', 'email');
		frm.submit();
	}
</script>
