<div class="inner cover">	
	<form method="post" action="/admin/product" class="form-horizontal admin-form">
		<input type="hidden" name="product_id" value="<?=$data->val('product_id') ?>" />
		<div class="form-group">
			<label for="product_name" class="col-sm-2 control-label"><?=t('Name') ?>:</label>
			<div class="col-sm-6"><input type="text" name="product_name" value="<?=$data->val('product_name') ?>" class="form-control" /></div>
			<div class="col-sm-4 form-validation" id="product_name_validation"><?= t('Required.') ?></div>
		</div>
		<div class="form-group">
			<label for="product_price" class="col-sm-2 control-label"><?=t('Price') ?>:</label>
			<div class="col-sm-6"><input type="text" name="product_price" value="<?=$data->val('product_price') ?>" class="form-control" /></div>
			<div class="col-sm-4 form-validation" id="product_price_validation"><?= t('Required.') ?></div>
		</div>
		<div class="form-group">
			<label for="product_default_category_id" class="col-sm-2 control-label"><?=t('Default category') ?>:</label>
			<div class="col-sm-6">
				<?php 
					
					//var_dump($data->categories);
				
					renderSelect(
						'product_default_category_id',
						$data->categories,
						'category_id',
						'category_name',
						$data->val('product_default_category_id')
					);
				?>				
			</div>
			<div class="col-sm-4 form-validation" id="product_price_validation"><?= t('Required.') ?></div>
		</div>
		
		<div class="form-group has-success has-feedback">
					<label class="col-sm-2 control-label" for="inputSuccess">
					Input with success and icon</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="inputSuccess">
					  <span class="glyphicon glyphicon-ok form-control-feedback"></span>
					</div>
				  </div>
				  
		<div class="form-group">
			<label for="product_default_variant_id" class="col-sm-2 control-label"><?=t('Default variant') ?>:</label>
			<div class="col-sm-6">
				<?php 
					renderSelect(
						'product_default_variant_id',
						$data->variants,
						'product_variant_id',
						'product_variant_name',
						$data->val('product_default_variant_id')
					);
					
					if (isset($data->variants)) {
						?>
							<ul class="list-group">
								<?php
									foreach ($data->variants as $variant) {
										?>
											<li class="list-group-item">
												<?=$variant->val('product_variant_name') ?>
												<?=$variant->val('product_variant_price') ?>
												<?=$variant->val('product_variant_stock') ?>
											</li>
										<?php
									}
								?>
							</ul>
						<?php
					}
				?>
			</div>
			<div class="col-sm-4 form-validation" id="product_price_validation"><?= t('Required.') ?></div>
		</div>
		
		<div class="form-group">
			<label for="product_ext_id" class="col-sm-2 control-label"><?=t('Extenal ID (ABX)') ?>:</label>
			<div class="col-sm-6"><span name="product_ext_id" class="form-control" ><?=$data->val('product_ext_id') ?></span></div>
			<div class="col-sm-4 form-validation" id="product_ext_id"><?= t('Required.') ?></div>
		</div>
			
		<div class="form-buttons">
			<a class="form-button" href="/admin/products"><?= t('Back') ?></a>
			<input type="button" onclick="javascript:deleteProduct();" class="btn btn-danger form-button" value="<?=t('Delete') ?>">
			<input type="button" onclick="javascript:validate();" class="btn btn-success form-button" value="<?=t('Save') ?>">
		</div>
	</form>	
</div>

<script>
	function validate() {
		var isValid = true;
		isValid = validateField('product_name') && isValid;
		isValid = validateField('product_price') && isValid;
		if (isValid) {
			document.forms[0].submit();
		}
	}
	
	function deleteProduct() {
		if (confirm('<?= t('Are you sure to delete this product?') ?>')) {
			document.location = '<?= $base_url ?>/admin/product/delete/<?=$data->val('product_id') ?>';
		}
	}	
</script>