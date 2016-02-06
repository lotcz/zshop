<h1>DASHBOARD</h1>

<div class="panel panel-default">
	<div class="panel-heading">
		<span class="panel-title"><?=t('Maintenance jobs') ?></span>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<canvas id="myChart1" width="200" height="200" />
			</div>
			<div class="col-md-6">
				<canvas id="myChart2" width="200" height="200" />
			</div>
		</div>
		<div>		
			<a href="/cron.php?job=clean&security_token=<?=$globals['security_token'] ?>" target="_blank" class="btn btn-default"><?=t('Clean Sessions') ?></a>
		</div>
	</div>
</div>

<script src="http://localhost/Chart.js/Chart.min.js"></script>
<!-- https://cdnjs.com/libraries/chart.js-->

<script>
	var data = [
		<?php
			foreach ($sessions as $s) {
				?>
					{
						value: <?=$s->val('c') ?>,						
						label: "<?=$s->val('n') ?>"
					},
				<?php
			}
		?>
	]

	var options = {
		//Boolean - Whether we should show a stroke on each segment
		segmentShowStroke : true,

		//String - The colour of each segment stroke
		segmentStrokeColor : "#fff",

		//Number - The width of each segment stroke
		segmentStrokeWidth : 2,

		//Number - The percentage of the chart that we cut out of the middle
		percentageInnerCutout : 50, // This is 0 for Pie charts

		//Number - Amount of animation steps
		animationSteps : 100,

		//String - Animation easing effect
		animationEasing : "easeOutBounce",

		//Boolean - Whether we animate the rotation of the Doughnut
		animateRotate : true,

		//Boolean - Whether we animate scaling the Doughnut from the centre
		animateScale : false,

		//String - A legend template
		legendTemplate : "<ul class=\"legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"

	}

	$(function(){
		// For a pie chart
		var ctx = document.getElementById('myChart1').getContext('2d');
		var myPieChart = new Chart(ctx).Pie(data);

		// And for a doughnut chart
		ctx = document.getElementById("myChart2").getContext("2d");
		var myDoughnutChart = new Chart(ctx).Doughnut(data,options);
	});
</script>