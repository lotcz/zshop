<?php

	global $messages;
	
	if (count($messages) > 0) {
		echo '<div class="error-messages">';
		foreach ($messages as $m) {
			echo '<div class="error-message">';
			echo $m;
			echo '</div>';
		}
		echo '</div>';
	}