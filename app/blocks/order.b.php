<div class="panel panel-default">										
	<div class="panel-heading">
		<h3 class="panel-title"><?=t('Place an order') ?></h3>
	</div>
	<div class="panel-body text-center">											
		<div  class="col-sm-12 control-label"><?=t('Total Cost') ?>:</div>
		<div class="col-sm-12 price">
			<span class="ajax-loader" style="margin-left:-31px;vertical-align:middle"></span>
			<span class="form-control-static" id="order_total_price"></span>			
		</div>												
		<div class="form-group text-center">												
			<input type="submit" class="btn btn-success" value="<?=t('Continue') ?>" />												
		</div>															
	</div>										
</div>