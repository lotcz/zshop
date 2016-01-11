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