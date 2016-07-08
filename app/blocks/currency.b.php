<?php
	global $db, $messages, $home_dir;
	require_once $home_dir . 'models/currency.m.php';
			
	$currencies = Currency::all($db);
	$selected_currency = Currency::getSelectedCurrency($db);

?>

<div class="currency dropdown btn btn-default">
	<span class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		<?= t($selected_currency->val('currency_name')) ?>
		<span class="caret"></span>
	</span>
	<ul class="dropdown-menu">
		<?php
			
			foreach ($currencies as $currency) {
				?>
					<li class="<?=($currency === $selected_currency) ? 'active' : '' ?>">
						<a href="#" onclick="javascript:setCurrency(<?=$currency->val('currency_id')?>);return false" >							
							<?= t($currency->val('currency_name')) ?>
						</a>
					</li>
				<?php
			}
			
		?>		
	</ul>
</div>