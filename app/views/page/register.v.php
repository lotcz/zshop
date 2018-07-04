<form id="form_register_form" method="POST" class="form-horizontal">
	<?php 
		if ($this->getData('render_form')) {
			$this->z->forms->renderForm($this->getData('form'));
			?>
				<div class="form-group">		
					<div class="col-sm-4 col-sm-offset-4">
						<input class="form-control btn btn-success" type="button" value="<?=$this->t('Register') ?>" onclick="javascript:validateForm_register_form();" />
					</div>		
				</div>
			<?php
		}
	?>
	
</form>
