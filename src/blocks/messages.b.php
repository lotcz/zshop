<?php

	global $messages;
	
	if (count($messages->messages) > 0) {
		echo '<div class="messages">';
		foreach ($messages->messages as $m) {
			echo sprintf('<div class="message-%s">',$m[1]);
			echo $m[0];
			echo '</div>';
		}
		echo '</div>';
	}