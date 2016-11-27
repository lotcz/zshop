<?php
	global $db, $raw_path, $messages, $home_dir, $custAuth;
	require_once $home_dir . 'models/currency.m.php';
			
	$currencies = Currency::all($db);
	$selected_currency = Currency::getSelectedCurrency($db);
	
	$is_logged_in = $custAuth->isAuth() && !$custAuth->customer->val('customer_anonymous');
?>
<div class="btn-group" role="group" aria-label="...">
	<div class="language dropdown btn btn-default">
		<span class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<img src="/images/<?= t('language_code') ?>.jpg" alt="<?= t('language_name') ?>" title="<?= t('language_name') ?>" />
			<?= t('language_name') ?>
			<span class="caret"></span>
		</span>
		<ul class="dropdown-menu">
			<li class="<?= t('cs_css') ?>"><a href="#" onclick="javascript:setLang('cs');return false" ><img src="/images/cs.jpg" alt="<?= t('Czech') ?>" title="<?= t('Czech') ?>" /><?= t('Czech') ?></a></li>
			<li class="<?= t('en_css') ?>"><a href="#" onclick="javascript:setLang('en');return false" class="<?= t('en_css') ?>"><img src="/images/en.jpg" alt="<?= t('English') ?>" title="<?= t('English') ?>" /><?= t('English') ?></a></li>
		</ul>
	</div>
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

	<div class="dropdown btn btn-default">
		<span class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<span class="caret"></span>
			<?php
				if ($is_logged_in) {			
					echo $custAuth->val('customer_name', $custAuth->val('customer_email'));
				} else {
					echo t('Anonymous');
				}					
			?>
			
		</span>
		
		<ul class="dropdown-menu">
		<?php
			if ($is_logged_in) {				
				?>				
					<li>
						<?php
							renderLink('customer', $custAuth->val('customer_name', $custAuth->val('customer_email')), 'link');
						?>
					</li>
					
					<li>
						<a href="<?=_url('logout');?>"><span class="link glyphicon glyphicon glyphicon-log-out"></span><?=t('Log out')?></a>
					</li>
				<?php
			} else {
				?>				
					<li>
						<?php
							renderLink('register', 'Register', 'link', $raw_path);	
							renderLink('login', 'Sign In', 'link', $raw_path);	
						?>
					</li>
				<?php
			}
		?>
	</div>
</div>