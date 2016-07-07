<?php

	foreach ( $data['products'] as $product) {
		renderPartial('prod-prev', $product);
	}

?>