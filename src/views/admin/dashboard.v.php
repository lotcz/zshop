<h1>DASHBOARD</h1>

<div class="list-group">
	<?php
		foreach ($data['categories'] as $cat) {
			?>
				<a href="#" class="list-group-item"><?=$cat->val('category_name') ?></a>
			<?php
		}
	?>
</div>