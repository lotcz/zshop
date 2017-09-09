<?php
  $this->z->forms->renderForm($this->getData('form'));
?>

<?php
  $this->z->tables->renderTable($this->getData('orders_table'));
?>

<p><?=$this->renderLink('','Go to E-shop','') ?></p>
