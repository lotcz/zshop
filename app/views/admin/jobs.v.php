<div class="panel panel-default">
	<div class="panel-heading">		
		<span class="panel-title"><?=t('Maintenance Jobs') ?></span>
	</div>
	<div class="panel-body">		
		<div>
			<div id="console" style="height:100px;width:100%;border:solid 1px Black;overflow:auto;"></div>
		</div>
		<span class="ajax-loader"></span>
		<div>		
			<a href="#" onclick="javascript:runJob('clean');return false;" class="btn btn-default"><?=t('Clean sessions') ?></a>
			<a href="#" onclick="javascript:runJob('abx');return false;" class="btn btn-default"><?=t('Import from ABX') ?></a>
			<a href="#" onclick="javascript:runJob('cube');return false;" class="btn btn-default"><?=t('Import from Cubecart') ?></a>
			<a href="#" onclick="javascript:runJob('backup');return false;" class="btn btn-default"><?=t('Backup') ?></a>
			<a href="#" onclick="javascript:runJob('zbozi');return false;" class="btn btn-default"><?=t('Generate XML for Zbozi.cz') ?></a>
		</div>
	</div>
</div>

<script>

	function jobFinished(data) {
		$('#console').append(data + '<br/>');
		hideAjaxLoaders();
	}
	
	function runJob(name) {
		showAjaxLoaders();		
		$.ajax({
			dataType: 'html',
			url: '<?=_url('cron.php') ?>',
			data: {
					job: name,
					security_token: '<?=$globals['security_token'] ?>'
				},
			success: jobFinished
		});
	}	
	
</script>