<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title"><?=t('Registration') ?></h3>
	</div>

	<div class="panel-body">
		<form class="form-horizontal" action="/register">			
			<div class="form-group">
				<label for="email" class="col-md-4 control-label"><?=t('E-mail') ?>:</label>
				<div class="col-md-8">
					<input type="text" name="email" class="form-control" value="<?=(isset($_POST['email'])) ? $_POST['email'] : '' ?>" />
				</div>			
			</div>
			<div class="form-validation" id="email_validation"><?= t('Required.') ?></div>
			<div class="form-group">
				<label for="password" class="col-md-4 control-label"><?=t('Password') ?>:</label>
				<div class="col-md-8">
					<input type="password" name="password" class="form-control"  />
				</div>			
			</div>
			<div class="form-group">
				<label for="password" class="col-md-4 control-label"><?=t('Confirm') ?>:</label>
				<div class="col-md-8">
					<input type="password" name="password" class="form-control"  />
				</div>			
			</div>
			<div class="form-validation" id="password_validation"><?= t('Required.') ?></div>
			<div class="form-group">
				<div class="col-md-offset-4 col-md-8">
					<input type="submit" onclick="javascript:validate();return false;" class="btn btn-success" value="<?=t('Register') ?>">					
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-md-offset-4 col-md-8">
					<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
					</fb:login-button>
					<div id="fbstatus">
					</div>
				</div>
			</div>

		</form>
	</div>

</div>