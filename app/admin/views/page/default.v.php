<?php
  	$pending_orders_count = $this->getData('pending_orders_count');
    $pending_orders_table = $this->getData('pending_orders_table');
?>

<div class="panel panel-default">
  <div class="panel-heading">
    <span class="panel-title"><?=$this->t('There is <strong>%s</strong> pending orders.', $pending_orders_count) ?></span>
  </div>
  <div class="panel-body">
    <?php
      if (isset($pending_orders_table)) {
        $this->z->tables->renderTable($pending_orders_table);
      } else {
        echo $this->t('There are no pending orders.');
      }
    ?>
  </div>
</div>
