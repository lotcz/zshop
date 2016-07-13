<?php

	foreach ( $data['products'] as $product) {
		renderPartial('prod-prev', $product);
	}

	// render Load more... button
	renderPartial('lmbutton',  $data['paging']);
?>