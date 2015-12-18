<div class="inner cover">
	<form method="post" action="/admin" class="form-horizontal" style="max-width:320px;margin:auto">
		<span class="help-block">Pouze pro správce e-shopu.</span>
		<div class="form-group">
			<label for="login" class="col-sm-3 control-label">Login:</label>
			<div class="col-sm-9">
				<input type="text" name="login" class="form-control" value="<?= (isset($_POST['login'])) ? $_POST['login'] : "" ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-3 control-label">Password:</label>
			<div class="col-sm-9">
				<input type="password" name="password" class="form-control"  />
			</div>
		</div>
		<?php
			renderBlock('messages');
		?>
		<div class="form-buttons">
			<a class="form-button" href="/"><?= t('Go to e-shop') ?></a>
			<input type="submit" class="btn btn-success form-button" value="<?=t('Sign in') ?>">			
		</div>
	</form>	
</div>