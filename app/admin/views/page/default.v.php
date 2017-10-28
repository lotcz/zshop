<?php

  	$pending_orders = $this->getData('pending_orders');

    echo sprintf('There is %s pending orders.', count($pending_orders));
