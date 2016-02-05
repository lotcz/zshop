<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=t('Please sign in') ?></h3>
	</div>
		
	<div class="panel-body">		
		<form class="form-horizontal" action="/login">			
			<div class="form-group">
				<label for="email" class="col-sm-4 control-label"><?=t('E-mail') ?>:</label>
				<div class="col-sm-8">
					<input type="text" name="email" class="form-control" value="<?=(isset($_POST['email'])) ? $_POST['email'] : '' ?>" />
				</div>			
			</div>
			<div class="form-validation" id="email_validation"><?= t('Required.') ?></div>
			<div class="form-group">
				<label for="password" class="col-sm-4 control-label"><?=t('Password') ?>:</label>
				<div class="col-sm-8">
					<input type="password" name="password" class="form-control"  />
				</div>			
			</div>
			<div class="form-validation" id="password_validation"><?= t('Required.') ?></div>
			<div class="form-group">
				<div class="col-md-4 vcenter">
					<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
					</fb:login-button>
					<div id="fbstatus">
					</div>
				</div>
				<div class="col-md-8">
					<input type="submit" onclick="javascript:validate();return false;" class="btn btn-primary" value="<?=t('Sign In') ?>">					
				</div>			
			</div>
			<div class="form-group">				
				<div class="col-md-offset-4 col-md-8">
					<a href="/forgotten-password<?=(isset($_POST['email']) && strlen($_POST['email']) > 0) ? '?email=' . $_POST['email'] : '' ?>"><?= t('Forgotten Password') ?></a>
				</div>			
			</div>
			
		</form>
	</div>
	
</div>