<?php
	$customer = $this->getData('customer');
	$customer_email = $this->getData('customer_email');
	$customer_name = $this->getData('customer_name');
	$use_ship_address = $customer->val('customer_use_ship_address');
	$use_ship_address_attr = ($customer->val('customer_use_ship_address') == 1) ? '' : 'disabled';
	$delivery_types = $this->getData('delivery_types');
	$selected_delivery = $this->getData('selected_delivery');
?>
<form action="<?=$this->url('delivery')?>" id="form_delivery" class="form-horizontal" method="POST">
	<input type="hidden" name="customer_delivery_type_id" id="field_customer_delivery_type_id" value="<?=$selected_delivery->ival('delivery_type_id') ?>" />

	<?php
		$this->renderPartialView('order-progress');
	?>

	<p>
		<?=$this->t('--select-delivery--') ?>
	</p>

	<div class="delivery-types list-group">
		<?php
			foreach ($delivery_types as $delivery) {
				?>
					<a class="list-group-item delivery-type-item <?=($selected_delivery === $delivery) ? 'active' : ''?>" data-id="<?=$delivery->val('delivery_type_id')?>">
						<?php
							if ($delivery->val('delivery_type_price') > 0) {
								?>
									<span class="badge"><?=$this->convertAndFormatMoney($delivery->val('delivery_type_price'))?></span>
								<?php
							}
						?>

						<span class="radio-checkbox">
							<input type="radio" aria-label="<?=$this->t('Select type of delivery.') ?>" <?=($selected_delivery === $delivery) ? 'checked' : ''?> />
						</span>
						<h4 class="list-group-item-heading"><?=$this->t($delivery->val('delivery_type_name')) ?></h4>

						<?php
							if ($delivery->val('delivery_type_min_order_cost') > 0) {
								?>
									<p class="list-group-item-text"><?=$this->t('Spend at least %s to use this type of delivery.', $this->formatMoney($delivery->val('delivery_type_min_order_cost')))?></p>
								<?php
							}
						?>

					</a>
				<?php
			}
		?>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?=$this->t('Invoicing Address'); ?></h3>
				</div>
				<div class="panel-body">
					<div id="customer_name_form_group" class="form-group">
						<label for="customer_ship_name" class="col-sm-4 control-label form-label"><?=$this->t('Full name')?>:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_name" maxlength="50" value="<?=$customer_name ?>" class="form-control" />
							<div class="form-validation" id="customer_name_validation_name"><?=$this->t('Please enter your whole name.') ?></div>
						</div>
					</div>

					<div id="customer_address_city_form_group" class="form-group">
						<label for="customer_address_city" class="col-sm-4 control-label form-label"><?=$this->t('City')?>:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_address_city" maxlength="50" value="<?=$customer->val('customer_address_city') ?>" class="form-control" />
							<div class="form-validation" id="customer_address_city_validation_length"><?=$this->t('Required.') ?></div>
						</div>
					</div>

					<div id="customer_address_street_form_group" class="form-group">
						<label for="customer_address_street" class="col-sm-4 control-label form-label"><?=$this->t('Street')?>:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_address_street" maxlength="50" value="<?=$customer->val('customer_address_street') ?>" class="form-control" />
							<div class="form-validation" id="customer_address_street_validation_length"><?=$this->t('Required.') ?></div>
						</div>
					</div>

					<div id="customer_address_zip_form_group" class="form-group">
						<label for="customer_ship_zip" class="col-sm-4 control-label form-label"><?=$this->t('ZIP')?>:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_address_zip" value="<?=$customer->val('customer_address_zip') ?>" class="form-control" />
							<div class="form-validation" id="customer_address_zip_validation_zip"><?=$this->t('Please enter valid ZIP code.')?></div>
						</div>
					</div>

					<div id="customer_email_form_group" class="form-group">
						<label for="customer_ship_zip" class="col-sm-4 control-label form-label"><?=$this->t('Email')?>:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_email" value="<?=$customer_email ?>" class="form-control" />
							<div class="form-validation" id="customer_email_validation_email"><?=$this->t('Please enter valid email.')?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<input type="checkbox" style="float:left;margin:2px 10px 0 0;outline:none;" id="customer_use_ship_address" name="customer_use_ship_address" value="1" <?=($customer->val('customer_use_ship_address') == 1) ? 'checked' : ''?> />
						<label for="customer_use_ship_address" style="margin:0"><?=$this->t('Shipping Address'); ?></label>
					</h3>
				</div>
				<div class="panel-body shipping-address-form">
					<div id="customer_ship_name_form_group" class="form-group">
						<label for="customer_ship_name" class="col-sm-4 control-label form-label"><?=$this->t('Full name')?>:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_name" maxlength="50" value="<?=$customer->val('customer_ship_name') ?>" <?=$use_ship_address_attr ?> class="form-control" />
							<div class="form-validation" id="customer_ship_name_validation_name"><?=$this->t('Please enter your whole name.') ?></div>
						</div>
					</div>

					<div id="customer_ship_city_form_group" class="form-group">
						<label for="customer_ship_city" class="col-sm-4 control-label form-label"><?=$this->t('City')?>:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_city" maxlength="50" value="<?=$customer->val('customer_ship_city') ?>" <?=$use_ship_address_attr ?> class="form-control" />
							<div class="form-validation" id="customer_ship_city_validation_length"><?=$this->t('Required.') ?></div>
						</div>
					</div>

					<div id="customer_ship_street_form_group" class="form-group">
						<label for="customer_ship_street" class="col-sm-4 control-label form-label"><?=$this->t('Street')?>:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_street" maxlength="50" value="<?=$customer->val('customer_ship_street') ?>" <?=$use_ship_address_attr ?> class="form-control" />
							<div class="form-validation" id="customer_ship_street_validation_length"><?=$this->t('Required.') ?></div>
						</div>
					</div>

					<div id="customer_ship_zip_form_group" class="form-group">
						<label for="customer_ship_zip" class="col-sm-4 control-label form-label"><?=$this->t('ZIP')?>:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_zip" value="<?=$customer->val('customer_ship_zip') ?>" <?=$use_ship_address_attr ?> class="form-control" />
							<div class="form-validation" id="customer_ship_zip_validation_zip"><?=$this->t('Please enter valid ZIP code.')?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 text-right">
			<?php
				$this->renderLink('cart', 'Back to cart', '');
			?>
		</div>
		<div class="col-md-6">
			<button id="submit_button" onclick="javascript:validateDeliveryForm();return false;" class="btn btn-success" >
				<?=$this->t('Continue')?>
			</button>
		</div>
	</div>
</form>
