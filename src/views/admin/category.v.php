<div class="inner cover">	
	<form method="post" action="/admin/category" class="form-horizontal admin-form">
		<input type="hidden" name="category_id" value="<?=$data->val('category_id') ?>" />
		<div class="form-group">
			<label for="category_name" class="col-sm-2 control-label"><?=t('Name') ?>:</label>
			<div class="col-sm-6"><input type="text" name="category_name" value="<?=$data->val('category_name') ?>" class="form-control" /></div>
			<div class="col-sm-4 form-validation" id="category_name_validation"><?= t('Required.') ?></div>
		</div>
		<div class="form-group">
			<label for="category_parent_id" class="col-sm-2 control-label"><?= t('Parent category') ?>:</label>
			<div class="col-sm-6">
				<?php 
					renderSelect(
						'category_parent_id',
						ModelBase::select($db, 'categories'),
						'category_id',
						'category_name',
						$data->val('category_parent_id')
					);
				?>
			</div>
		</div>		
		<div class="form-buttons">
			<a class="form-button" href="/admin/categories"><?= t('Back') ?></a>
			<input type="button" onclick="javascript:deleteCategory();" class="btn btn-danger form-button" value="<?=t('Delete') ?>">
			<input type="button" onclick="javascript:validate();" class="btn btn-success form-button" value="<?=t('Save') ?>">
		</div>
	</form>	
</div>

<script>
	function validate() {
		var isValid = true;
		isValid = validateField('category_name') && isValid;
		if (isValid) {
			document.forms[0].submit();
		}
	}
	
	function deleteCategory() {
		if (confirm('<?= t('Are you sure to delete this category?') ?>')) {
			document.location = '<?= $base_url ?>/admin/category/delete/<?=$data->val('category_id') ?>';
		}
	}	
</script>