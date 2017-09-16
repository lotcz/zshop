<?php

  $product = new ProductModel($this->db, $this->get('product_id'));
  $this->setData('product', $product);
