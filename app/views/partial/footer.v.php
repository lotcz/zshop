<?php
	global $globals, $config;
?>
<div class="footer basic-bg spaced">
	<div class="row">	
		<div class="col-md-4">			
			<ul>
				<li><h3><?=$this->t('Shop'); ?></h3></li>
				<li><a href="<?=_url('about'); ?>"><?=$this->t('About Us'); ?></a></li>
				<li><a href="<?=_url('terms'); ?>"><?=$this->t('Terms of Use'); ?></a></li>				
				<li><a href="<?=_url('help'); ?>"><?=$this->t('Help'); ?></a></li>
			</ul>
		</div>
		
		<div class="col-md-4">
			<ul>
				<li><h3><?=$this->t('Products'); ?></h3></li>
				<li><a href="<?=_url('search'); ?>"><?=$this->t('Search'); ?></a></li>
				<li><a href="<?=_url('most-popular'); ?>"><?=$this->t('Most Popular'); ?></a></li>
				<li><a href="<?=_url('terms'); ?>"><?=$this->t('Terms of Use'); ?></a></li>
			</ul>
		</div>	
		
		<div class="col-md-4">					
			<ul>
				<li><h3><?=$this->t('Shop'); ?></h3></li>
				<li><a href="<?=_url('terms'); ?>"><?=$this->t('Terms of Use'); ?></a></li>
				<li><a href="<?=_url('terms'); ?>"><?=$this->t('Terms of Use'); ?></a></li>
				<li><a href="<?=_url('terms'); ?>"><?=$this->t('Terms of Use'); ?></a></li>
			</ul>
		</div>
	</div>
</div>
