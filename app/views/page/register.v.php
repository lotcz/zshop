<form id="form_register_form" method="POST" class="form-horizontal">
	<?php 
		$form->render();
	?>
	<div class="form-group">		
		<div class="col-sm-4 col-sm-offset-4">
			<input class="form-control btn btn-success" type="button" value="<?=t('Register') ?>" onclick="javascript:validateForm_register_form();" />
		</div>		
	</div>
</form>