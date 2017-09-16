<?php
  $product = $this->getData('product');
?>
<td>
  <?php
    if ($product->val('product_image')) {
      $this->z->images->renderImage($product->val('product_image'), 'mini-thumb', $product->val('product_name'));
    }
  ?>
</td>
<td>
  <?php
    $this->renderLink($product->val('alias_url'), $product->val('product_name'))
  ?>
</td>

<td class="text-right">
  <span><?=$this->convertAndFormatMoney($product->val('product_price')) ?></span>
  <input type="hidden" id="item-price-<?=$product->val('product_id') ?>" value="<?=$product->val('product_price') ?>" />
</td>

<td>
  <div class="item-count">
    <a onclick="javascript:minusItem(<?=$product->val('product_id') ?>);return false;" href="#" class="minus-item"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>
    <input id="prod_count_<?=$product->val('product_id') ?>" type="text" maxlength="2" class="form-control" value="<?=$product->val('cart_count') ?>">
    <a onclick="javascript:plusItem(<?=$product->val('product_id') ?>);return false;" href="#" class="plus-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
  </div>
</td>

<td class="text-right"><strong><span id="item_total_price_<?=$product->val('product_id') ?>"><?=$this->convertAndFormatMoney($product->val('item_price')) ?></span></strong></td>
<td>
  <a onclick="javascript:removeItem(<?=$product->val('product_id') ?>);return false;" href="#" class="remove-item"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
</td>
