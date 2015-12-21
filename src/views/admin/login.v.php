<div class="inner cover">
	<form method="post" action="/admin" class="form-horizontal" >
		<span class="help-block">Vstup pro správce e-shopu.</span>
		<div class="form-group">
			<label for="login" class="col-sm-4 control-label"><?=t('Login') ?>:</label>
			<div class="col-sm-8">
				<input type="text" name="login" class="form-control" value="<?=(isset($_POST['login'])) ? $_POST['login'] : '' ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-4 control-label"><?=t('Password') ?>:</label>
			<div class="col-sm-8">
				<input type="password" name="password" class="form-control"  />
			</div>
		</div>
		<div class="form-buttons">
			<a class="form-button" href="/"><?= t('Go to e-shop') ?></a>
			<a class="form-button" href="/admin/forgotten-password"><?= t('Forgotten password') ?></a>
			<input type="submit" class="btn btn-success form-button" value="<?=t('Sign in') ?>">			
		</div>
	</form>	
</div>