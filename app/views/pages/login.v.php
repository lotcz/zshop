<div class="inner cover">
	<form method="post" id="login_form" action="<?=_url('login', _g('r'))?>" class="form-horizontal" >
		<div class="form-group">
			<label for="email" class="col-sm-4 control-label"><?=t('E-mail') ?>:</label>
			<div class="col-sm-4">
				<input type="text" name="email" class="form-control" value="<?=(isset($_POST['email'])) ? $_POST['email'] : '' ?>" />
			</div>
			<div class="col-sm-4 form-validation" id="email_validation_email"><?= t('Required.') ?></div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-4 control-label"><?=t('Password') ?>:</label>
			<div class="col-sm-4">
				<input type="password" name="password" class="form-control"  />
			</div>
			<div class="col-sm-4 form-validation" id="password_validation_password"><?= t('Required.') ?></div>
		</div>
		<div class="form-buttons">
			<a class="form-button" href="/"><?=t('Go to E-shop') ?></a>
			<input type="button" onclick="javascript:login_validate();" class="btn btn-success form-button" value="<?=t('Sign In') ?>" />			
			<a class="form-button" href="<?=_url('forgotten-password', _g('r'))?><?=(isset($_POST['email']) && strlen($_POST['email']) > 0) ? '&email=' . $_POST['email'] : '' ?>"><?= t('Forgotten Password') ?></a>		
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