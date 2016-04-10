<div class="panel panel-default">
	<div class="panel-heading">		
		<span class="panel-title"><?=t('Maintenance Jobs') ?></span>
	</div>
	<div class="panel-body">
		<div>			
			<a href="#" onclick="javascript:runJob('clean');return false;" class="btn btn-default"><?=t('Clean sessions') ?></a>
			<a href="#" onclick="javascript:runJob('abx');return false;" class="btn btn-default"><?=t('Import from ABX') ?></a>
			<a href="#" onclick="javascript:runJob('cube');return false;" class="btn btn-default"><?=t('Import from Cubecart') ?></a>
			<a href="#" onclick="javascript:runJob('backup');return false;" class="btn btn-default"><?=t('Backup') ?></a>
			<a href="#" onclick="javascript:runJob('zbozi');return false;" class="btn btn-default"><?=t('Generate XML for Zbozi.cz') ?></a>
		</div>
		
		<div>
			<div id="console"></div>
		</div>		
		
	</div>
</div>

<script>

	function jobFinished(data) {		
		hideAjaxLoaders();
		$('#console > .ajax-loader').remove();
		$('#console').append(data + '<br/>');
	}
	
	function runJob(name) {
		$('#console').append('<span class="ajax-loader"></span>');
		showAjaxLoaders();
		$.ajax({
			dataType: 'html',
			url: '<?=_url('cron.php') ?>',
			data: {
					job: name,
					security_token: '<?=$config['security_token'] ?>'
				},
			success: jobFinished
		});
	}	
	
</script>