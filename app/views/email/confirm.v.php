<h1><?=$this->z->core->t('Your order n. %s has been accepted.', $data['order']->val('order_number')) ?></h1>

<p>
<?=$this->z->core->t('Dear customer') ?>,
<br/>
<?=$this->z->core->t('Your order n. %s has been accepted.', $data['order']->val('order_number')) ?>
</p>

<p>
<?=$this->z->core->t('Order number') ?>: <strong><?=$data['order']->val('order_number') ?></strong>
<br/>
<?=$this->z->core->t('Total order cost') ?>: <strong><?=$this->z->core->formatMoney($data['order']->val('order_total_price')) ?></strong>
<br/>
<?=$this->z->core->t('Payment type') ?>: <strong><?=$data['payment_type']->val('payment_type_name') ?></strong>
<br/>
<?php
  if ($data['payment_type']->val('payment_type_name'))
?>
<?=$this->z->core->t('Delivery type') ?>: <strong><?=$data['delivery_type']->val('delivery_type_name') ?></strong>
<br/>
<?php
  if ($data['delivery_type']->bval('delivery_type_require_address')) {
    ?>
      <div class="bordered indented">
        <strong><?=$this->z->core->t('Shipping address') ?>:</strong>
        <br/>
        <?=$data['order']->val('order_ship_name') ?>
        <br/>
        <?=$data['order']->val('order_ship_street') ?>
        <br/>
        <?=$data['order']->val('order_ship_zip') ?>
        <?=$data['order']->val('order_ship_city') ?>
        <br/>
      </div>
    <?php
  }
?>
</p>
