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
			<div id="console">
				<div id="console_inner">
				</div>
			</div>
		</div>		
		
	</div>
</div>

<script>

	function cons(str) {
		$('#console_inner').append(str);
		$('#console').scrollTop($('#console_inner').height());
	}
	
	function jobFinished(data) {		
		hideAjaxLoaders();
		$('#console_inner > .ajax-loader').remove();
		cons(data + '<br/>');
	}
	
	function runJob(name) {
		cons('<span class="ajax-loader"></span>');
		showAjaxLoaders();
		$.ajax({
			dataType: 'html',
			url: '<?=_url('jobs.php') ?>',
			data: {
					job: name,
					security_token: '<?=$config['security_token'] ?>'
				},
			success: jobFinished
		});
	}	
	
</script>