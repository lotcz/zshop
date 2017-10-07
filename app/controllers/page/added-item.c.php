<?php

  $product = new ProductModel($this->db, z::getInt('product_id'));
  $cart_item = new CartModel($this->db);
  $cart_item->load($product->ival('product_id'), $this->getCustomer()->ival('customer_id'));
  $product->set('cart_count', $cart_item->ival('cart_count'));
  $product->set('item_price', $cart_item->ival('cart_count') * $product->fval('product_price'));
  $this->setData('product', $product);
