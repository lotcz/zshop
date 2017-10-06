<div class="inner cover">
	<form method="post" id="login_form" action="<?=$this->url('login', $this->return_path)?>" class="form-horizontal" >
		<div class="form-group">
			<label for="email" class="col-sm-4 control-label"><?=$this->t('E-mail') ?>:</label>
			<div class="col-sm-4">
				<input type="text" name="email" class="form-control" value="<?=(isset($_POST['email'])) ? $_POST['email'] : '' ?>" />
			</div>
			<div class="col-sm-4 form-validation" id="email_validation_email"><?= $this->t('Please enter valid e-mail address.') ?></div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-4 control-label"><?=$this->t('Password') ?>:</label>
			<div class="col-sm-4">
				<input type="password" name="password" class="form-control"  />
			</div>
			<div class="col-sm-4 form-validation" id="password_validation_password"><?= $this->t('Required.') ?></div>
		</div>
		<div class="form-buttons">
			<input type="button" onclick="javascript:login_validate();return false;" class="btn btn-success form-button" value="<?=$this->t('Sign In') ?>" />
			<a class="form-button" href="<?=$this->url('forgotten-password', $this->return_path)?><?=(isset($_POST['email']) && strlen($_POST['email']) > 0) ? '&email=' . $_POST['email'] : '' ?>"><?= $this->t('Forgotten Password') ?></a>
		</div>
	</form>
</div>

<script>
	function login_validate() {
		var frm = new formValidation('login_form');
		frm.add('email', 'email');
		frm.add('password', 'password');
		frm.submit();
	}
</script>
