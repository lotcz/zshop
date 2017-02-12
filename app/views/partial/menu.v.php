<?php
	$is_logged_in = $this->z->custauth->isAuth() && !$this->z->custauth->customer->val('customer_anonymous');
	$available_languages = $this->z->i18n->available_languages;
	$selected_language = $this->z->i18n->selected_language;
	$available_currencies = $this->z->i18n->available_currencies;
	$selected_currency = $this->z->i18n->selected_currency;
?>
<div class="btn-group" role="group" aria-label="...">
	<div class="language dropdown btn btn-default">
		<span class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<?php
				$this->renderImage($selected_language->val('language_code') . '.jpg', $selected_language->val('language_name'));
				echo $this->t($selected_language->val('language_name'));
			?>
			<span class="caret"></span>
		</span>
		<ul class="dropdown-menu">
			<?php 
				foreach ($available_languages as $language) {
					?>
						<li class="<?=($selected_language === $language) ? 'active' : ''; ?>">
							<a href="#" onclick="javascript:setLang(<?=$language->val('language_id'); ?>);return false" >
								<?php
									$this->renderImage($language->val('language_code') . '.jpg', $language->val('language_name'));
									echo $this->t($language->val('language_name'));
								?>								
							</a>
						</li>
					<?php
				}		
			?>
		</ul>
	</div>
	<div class="currency dropdown btn btn-default">
		<span class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<?= $this->t($selected_currency->val('currency_name')) ?>
			<span class="caret"></span>
		</span>
		<ul class="dropdown-menu">
			<?php				
				foreach ($available_currencies as $currency) {
					?>
						<li class="<?=($currency === $selected_currency) ? 'active' : ''; ?>">
							<a href="#" onclick="javascript:setCurrency(<?=$currency->val('currency_id')?>);return false" >							
								<?= $this->t($currency->val('currency_name')) ?>
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
					echo $this->custauth->val('customer_name', $this->custauth->val('customer_email'));
				} else {
					echo $this->t('Anonymous');
				}					
			?>
			
		</span>
		
		<ul class="dropdown-menu">
			<?php
				if ($is_logged_in) {				
					?>				
						<li>
							<?php
								$this->renderLink('customer', $this->custauth->val('customer_name', $this->custauth->val('customer_email')), 'link');
							?>
						</li>
						
						<li>
							<a href="<?=$this->url('logout');?>"><span class="link glyphicon glyphicon glyphicon-log-out"></span><?=$this->t('Log out')?></a>
						</li>
					<?php
				} else {
					?>				
						<li>
							<?php
								$this->renderLink('register', 'Register', 'link', $this->raw_path);	
								$this->renderLink('login', 'Sign In', 'link', $this->raw_path);	
							?>
						</li>
					<?php
				}
			?>
		</ul>
	</div>
</div>