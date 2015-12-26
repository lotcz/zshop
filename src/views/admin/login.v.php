<div class="inner cover">
	<form method="post" action="/admin" class="form-horizontal" >
		<div class="form-group">
			<label for="login" class="col-sm-4 control-label"><?=t('Login or E-mail') ?>:</label>
			<div class="col-sm-4">
				<input type="text" name="login" class="form-control" value="<?=(isset($_POST['login'])) ? $_POST['login'] : '' ?>" />
			</div>
			<div class="col-sm-4 form-validation" id="login_validation"><?= t('Required.') ?></div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-4 control-label"><?=t('Password') ?>:</label>
			<div class="col-sm-4">
				<input type="password" name="password" class="form-control"  />
			</div>
			<div class="col-sm-4 form-validation" id="password_validation"><?= t('Required.') ?></div>
		</div>
		<div class="form-buttons">
			<a class="form-button" href="/"><?=t('Go to E-shop') ?></a>
			<input type="submit" onclick="javascript:validate();return false;" class="btn btn-success form-button" value="<?=t('Sign In') ?>">			
			<a class="form-button" href="/admin/forgotten-password<?=(isset($_POST['login']) && strlen($_POST['login']) > 0) ? '?email=' . $_POST['login'] : '' ?>"><?= t('Forgotten Password') ?></a>		
		</div>
	</form>	
</div>

<script>
	function validate() {
		var isValid = true;
		isValid = validateField('login') && isValid;
		isValid = validateField('password') && isValid;
		
		if (isValid) {
			document.forms[0].submit();
		}
	}
</script>