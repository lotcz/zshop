<div class="inner cover">
	<form method="post" action="/login" class="form-horizontal" >
		<div class="form-group">
			<label for="email" class="col-sm-4 control-label"><?=t('E-mail') ?>:</label>
			<div class="col-sm-4">
				<input type="text" name="email" class="form-control" value="<?=(isset($_POST['email'])) ? $_POST['email'] : '' ?>" />
			</div>
			<div class="col-sm-4 form-validation" id="email_validation"><?= t('Required.') ?></div>
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
			<a class="form-button" href="/forgotten-password<?=(isset($_POST['email']) && strlen($_POST['email']) > 0) ? '?email=' . $_POST['email'] : '' ?>"><?= t('Forgotten Password') ?></a>		
		</div>
	</form>	
</div>

<script>
	function validate() {
		var isValid = true;
		isValid = validateField('email') && isValid;
		isValid = validateField('password') && isValid;
		
		if (isValid) {
			document.forms[0].submit();
		}
	}
</script>