<?php
	$delivery_types = $this->getData('delivery_types');
	$selected_delivery = $this->getData('selected_delivery');
?>
<form action="<?=$this->url('delivery')?>" id="form_delivery" class="form-horizontal" method="POST">
	<input type="hidden" name="customer_delivery_type_id" id="field_customer_delivery_type_id" value="<?=$selected_delivery->ival('delivery_type_id') ?>" />
	
	<?php	
		$this->renderPartialView('order-progress');	
	?>
	
	<p>
		<?=$this->t('Select type of delivery.') ?>
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
						<h4 class="list-group-item-heading"><?=$delivery->val('delivery_type_name')?></h4>
							
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
					<div id="customer_ship_name_form_group" class="form-group">
						<label for="customer_ship_name" class="col-sm-4 control-label form-label">Name:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_name" maxlength="50" value="" class="form-control" />
							<div class="form-validation" id="customer_name_validation_length"><?=$this->t('Please enter your name.') ?></div>
						</div>					
					</div>
								
					<div id="customer_ship_city_form_group" class="form-group">
						<label for="customer_ship_city" class="col-sm-4 control-label form-label">City:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_city" maxlength="50" value="" class="form-control" />
						</div>						
					</div>
									
					<div id="customer_ship_street_form_group" class="form-group">
						<label for="customer_ship_street" class="col-sm-4 control-label form-label">Street:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_street" maxlength="50" value="" class="form-control" />
						</div>						
					</div>
									
					<div id="customer_ship_zip_form_group" class="form-group">
						<label for="customer_ship_zip" class="col-sm-4 control-label form-label">ZIP:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_zip"  value="0" class="form-control" />
							<div class="form-validation" id="customer_ship_zip_validation_integer">Please enter whole number.</div>
						</div>						
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">				
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<input type="checkbox" style="float:left;margin:2px 10px 0 0;outline:none;" id="customer_use_ship_address" name="customer_use_ship_address" value="1" class="" />
						<label for="customer_use_ship_address" style="margin:0"><?=$this->t('Shipping Address'); ?></label>					
					</h3>
				</div>
				<div class="panel-body">
					<div id="customer_ship_name_form_group" class="form-group">
						<label for="customer_ship_name" class="col-sm-4 control-label form-label">Name:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_name" maxlength="50" value="" class="form-control" />						
						</div>					
					</div>
								
					<div id="customer_ship_city_form_group" class="form-group">
						<label for="customer_ship_city" class="col-sm-4 control-label form-label">City:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_city" maxlength="50" value="" class="form-control" />
						</div>						
					</div>
									
					<div id="customer_ship_street_form_group" class="form-group">
						<label for="customer_ship_street" class="col-sm-4 control-label form-label">Street:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_street" maxlength="50" value="" class="form-control" />
						</div>						
					</div>
									
					<div id="customer_ship_zip_form_group" class="form-group">
						<label for="customer_ship_zip" class="col-sm-4 control-label form-label">ZIP:</label>
						<div class="col-sm-8 form-field">
							<input type="text" name="customer_ship_zip"  value="0" class="form-control" />
							<div class="form-validation" id="customer_ship_zip_validation_integer">Please enter whole number.</div>
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
			<button onclick="javascript:validateDeliveryForm();return false;" class="btn btn-success large-button" >
				<?=$this->t('Continue')?>
			</button>
		</div>
	</div>
</form>