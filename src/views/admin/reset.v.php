<div class="inner cover">
	<form method="post" action="/admin/reset-password" class="form-horizontal" >
	
		<?php
			if ($data['reset_valid']) { ?>		
				<input type="hidden" name="user_id" value="<?=$data['user_id'] ?>" />
				<input type="hidden" name="reset_token" value="<?=$data['reset_token'] ?>" />
						
				<div class="form-group">
					<label for="password" class="col-sm-4 control-label"><?=t('New Password') ?>:</label>
					<div class="col-sm-4">
						<input type="password" name="password" class="form-control"  />
					</div>
					<div class="col-sm-4 form-validation" id="password_validation"><?= t('Required.') ?></div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-4 control-label"><?=t('Repeat New Password') ?>:</label>
					<div class="col-sm-4">
						<input type="password" name="password2" class="form-control"  />
					</div>
					<div class="col-sm-4 form-validation" id="password2_validation"><?= t('Required.') ?></div>
					<div class="col-sm-4 form-validation" id="password_match_validation"><?=t('Passwords don\'t match.') ?></div>
				</div>
				<div class="form-buttons">
					<a class="form-button" href="/"><?=t('Go to E-shop') ?></a>
					<a class="form-button" href="/admin"><?=t('Sign In') ?></a>
					<input type="button" onclick="javascript:validate();" class="btn btn-success form-button" value="<?=t('Reset Password') ?>">
					<a class="form-button" href="/admin/forgotten-password"><?= t('Forgotten Password') ?></a>
				</div>
		<?php } else { ?>
			<div class="form-buttons">
				<a class="form-button" href="/"><?=t('Go to E-shop') ?></a>
				<a class="form-button" href="/admin"><?=t('Sign In') ?></a>
				<a class="form-button" href="/admin/forgotten-password"><?= t('Forgotten Password') ?></a>
			</div>
		<?php } ?>
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