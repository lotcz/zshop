
DROP TABLE IF EXISTS `delivery_types`;

CREATE TABLE IF NOT EXISTS `delivery_types` (
 `delivery_type_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
 `delivery_type_name` VARCHAR(50) NOT NULL,
 `delivery_type_description` TEXT,
 `delivery_type_price` DECIMAL(10,2) NOT NULL DEFAULT 0,
 `delivery_type_is_default` BOOL NOT NULL DEFAULT 0,
 `delivery_type_require_address` BOOL NOT NULL DEFAULT 0,
 `delivery_type_min_order_cost` DECIMAL(10,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`delivery_type_id`)
) ENGINE = InnoDB;

INSERT INTO `delivery_types` (`delivery_type_name`, `delivery_type_price`, `delivery_type_is_default`, `delivery_type_require_address`, `delivery_type_min_order_cost`) 
VALUES ('Pick up in store', 0, 0, 0, 0),('Czech post', 118, 0, 1, 0),('Parcel service', 99, 1, 1, 0);

CREATE TABLE IF NOT EXISTS `payment_types` (
 `payment_type_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
 `payment_type_name` VARCHAR(50) NOT NULL,
 `payment_type_description` TEXT,
 `payment_type_price` DECIMAL(10,2) NOT NULL DEFAULT 0,
 `payment_type_is_default` BOOL NOT NULL DEFAULT 0,
 `payment_type_min_order_cost` DECIMAL(10,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`payment_type_id`)
) ENGINE = InnoDB;

INSERT INTO `payment_types` (`payment_type_name`, `payment_type_price`,  `payment_type_is_default`, `payment_type_min_order_cost`) 
VALUES ('Cash in store',0,0,0),('Cash on delivery',35,0,0),('Bank transfer',0,1,0);

CREATE TABLE IF NOT EXISTS `allowed_payment_types` (
  `allowed_payment_type_delivery_type_id` TINYINT UNSIGNED NOT NULL,
  `allowed_payment_type_payment_type_id` TINYINT UNSIGNED NOT NULL,
  
  PRIMARY KEY (`allowed_payment_type_delivery_type_id`, `allowed_payment_type_payment_type_id`),
  
  CONSTRAINT `allowed_payment_types_delivery_type_fk`
    FOREIGN KEY (`allowed_payment_type_delivery_type_id`)
    REFERENCES `delivery_types` (`delivery_type_id`),
  CONSTRAINT `allowed_payment_types_payment_type_fk`
    FOREIGN KEY (`allowed_payment_type_payment_type_id`)
    REFERENCES `payment_types` (`payment_type_id`)
) ENGINE = InnoDB;

INSERT INTO `allowed_payment_types` (`allowed_payment_type_delivery_type_id`, `allowed_payment_type_payment_type_id`) 
VALUES (1,1),(2,2),(2,3),(3,2),(3,3);


CREATE TABLE IF NOT EXISTS `customers_shop_data` (
  `customer_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  
  `customer_delivery_type_id` TINYINT UNSIGNED NULL,
  `customer_payment_type_id` TINYINT UNSIGNED NULL,  
  
  
  `customer_address_city` NVARCHAR(50),
  `customer_address_street` NVARCHAR(50),
  `customer_address_zip` INT NULL,
  
  `customer_use_ship_address` BOOL NOT NULL DEFAULT FALSE,
  `customer_ship_name` NVARCHAR(50),
  `customer_ship_city` NVARCHAR(50),
  `customer_ship_street` NVARCHAR(50),
  `customer_ship_zip` INT NULL,  
  
  PRIMARY KEY (`customer_id`),  
  CONSTRAINT `customer_delivery_type_fk`
    FOREIGN KEY (`customer_delivery_type_id`)
    REFERENCES `delivery_types` (`delivery_type_id`),
  CONSTRAINT `customer_payment_type_fk`
    FOREIGN KEY (`customer_payment_type_id`)
    REFERENCES `payment_types` (`payment_type_id`),  
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `languages`;

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_ext_id` INT UNSIGNED,
  `category_parent_id` INT UNSIGNED,
  `category_alias_id` INT UNSIGNED,
  `category_name` NVARCHAR(200) NOT NULL,
  `category_description` TEXT NULL,
  `category_total_products` INT UNSIGNED NOT NULL DEFAULT 0,
  `category_visible` BIT NOT NULL DEFAULT 1,
  PRIMARY KEY (`category_id`),
  UNIQUE INDEX `categories_ext_id_unique` (`category_ext_id` ASC),
  INDEX `categories_parent_id_index` (`category_parent_id` ASC),
  CONSTRAINT `category_parent_fk`
    FOREIGN KEY (`category_parent_id`)
    REFERENCES `categories` (`category_id`)
    ON DELETE SET NULL,
  CONSTRAINT `category_alias_fk`
    FOREIGN KEY (`category_alias_id`)
    REFERENCES `aliases` (`alias_id`)
    ON DELETE SET NULL
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `languages`;

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_deleted` BOOL DEFAULT 0 NOT NULL,
  `product_ext_id` INT UNSIGNED NULL,
  `product_category_id` INT UNSIGNED NOT NULL,
  `product_alias_id` INT UNSIGNED NULL,
  `product_name` NVARCHAR(255) NOT NULL,
  `product_price` DECIMAL(10,2) UNSIGNED NOT NULL,
  `product_stock` INT UNSIGNED NOT NULL DEFAULT 0,
  `product_views` INT UNSIGNED NOT NULL DEFAULT 0,
  `product_sold` INT UNSIGNED NOT NULL DEFAULT 0,
  `product_image` VARCHAR(255) NULL,
  `product_default_variant_id` INT UNSIGNED NULL,
  `product_description` TEXT NULL,
  PRIMARY KEY (`product_id`), 
  CONSTRAINT `product_category_fk`
    FOREIGN KEY (`product_category_id`)
    REFERENCES `categories` (`category_id`),
  CONSTRAINT `product_alias_fk`
    FOREIGN KEY (`product_alias_id`)
    REFERENCES `aliases` (`alias_id`)
    ON DELETE SET NULL,
  UNIQUE INDEX `products_ext_id_unique` (`product_ext_id` ASC)
) ENGINE = InnoDB;

 DROP PROCEDURE IF EXISTS spUpdateCategoryProductCount;
 
 DELIMITER //
 CREATE PROCEDURE spUpdateCategoryProductCount(IN cat_id INT UNSIGNED)
	BEGIN
		DECLARE total INT DEFAULT 0;
		SELECT COUNT(*) INTO total
		FROM products WHERE product_category_id = cat_id;
		UPDATE categories SET category_total_products = total WHERE category_id = cat_id;
   END //
 DELIMITER ;
 
 DROP TRIGGER IF EXISTS update_product_count_trigger;
 
 DELIMITER //
 CREATE TRIGGER update_product_count_trigger AFTER UPDATE ON products
	FOR EACH ROW
		BEGIN
			CALL spUpdateCategoryProductCount(OLD.product_category_id);            
            CALL spUpdateCategoryProductCount(NEW.product_category_id);            
		END //
 DELIMITER ;
 
  DROP TRIGGER IF EXISTS update_product_count_trigger_ins;
  
  DELIMITER //
 CREATE TRIGGER update_product_count_trigger_ins AFTER INSERT ON products
	FOR EACH ROW
		BEGIN
            CALL spUpdateCategoryProductCount(NEW.product_category_id);            
		END //
 DELIMITER ;
 
  DROP TRIGGER IF EXISTS update_product_count_trigger_del;
  
 DELIMITER //
 CREATE TRIGGER update_product_count_trigger_del AFTER DELETE ON products
	FOR EACH ROW
		BEGIN
            CALL spUpdateCategoryProductCount(OLD.product_category_id);            
		END //
 DELIMITER ;
 
CREATE TABLE IF NOT EXISTS `product_variants` (
  `product_variant_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_variant_deleted` BOOL NOT NULL DEFAULT 0,
  `product_variant_product_id` INT UNSIGNED NOT NULL,
  `product_variant_ext_id` INT UNSIGNED NULL,
  `product_variant_name` VARCHAR(100) NOT NULL,
  `product_variant_stock` INT UNSIGNED NOT NULL DEFAULT 0,
  `product_variant_price` DECIMAL(10,2) UNSIGNED NULL,
  PRIMARY KEY (`product_variant_id`),
  UNIQUE INDEX `product_variants_unique` (`product_variant_product_id`, `product_variant_name`),
  CONSTRAINT `product_variant_product_fk`
    FOREIGN KEY (`product_variant_product_id`)
    REFERENCES `products` (`product_id`)
    ON DELETE CASCADE,
  UNIQUE INDEX `product_variants_ext_id_unique` (`product_variant_ext_id` ASC)
) ENGINE = InnoDB;

ALTER TABLE `products` ADD CONSTRAINT `product_default_variant_id_fk` 
    FOREIGN KEY (`product_default_variant_id`)
    REFERENCES `product_variants` (`product_variant_id`);
  
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,  
  `cart_customer_id` INT UNSIGNED NOT NULL,
  `cart_product_id` INT UNSIGNED NOT NULL,
  `cart_variant_id` INT UNSIGNED NULL,
  `cart_count` INT UNSIGNED NOT NULL DEFAULT 1,  
  PRIMARY KEY (`cart_id`),
  CONSTRAINT `cart_product_fk`
    FOREIGN KEY (`cart_product_id`)
    REFERENCES `products` (`product_id`)
    ON DELETE CASCADE,
  CONSTRAINT `cart_customer_fk`
    FOREIGN KEY (`cart_customer_id`)
    REFERENCES `customers` (`customer_id`)
    ON DELETE CASCADE,
  CONSTRAINT `cart_variant_fk`
    FOREIGN KEY (`cart_variant_id`)
    REFERENCES `product_variants` (`product_variant_id`)
    ON DELETE SET NULL
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `order_states` (
 `order_state_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
 `order_state_closed` BOOL NOT NULL,
 `order_state_name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`order_state_id`)
) ENGINE = InnoDB;

INSERT INTO `order_states` (`order_state_closed`, `order_state_name`) VALUES (0,'New (waiting for payment)'),(0,'Processing'),(0,'Re-opened'),(1,'Shipped (closed)'),(1,'Cancelled');

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_number` INT UNSIGNED NOT NULL,
  `order_order_state_id` TINYINT UNSIGNED NOT NULL DEFAULT 1, 
  `order_customer_id` INT UNSIGNED NOT NULL,
  `order_delivery_type_id` TINYINT UNSIGNED NOT NULL,
  `order_payment_type_id` TINYINT UNSIGNED NOT NULL,
  `order_payment_code` INT UNSIGNED NULL,
  `order_currency_id` TINYINT UNSIGNED NOT NULL,
  `order_delivery_type_price` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0,
  `order_payment_type_price` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0,
  `order_total_cart_price` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0,
  `order_total_price` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0,
    
  `order_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_last_status_change` TIMESTAMP NULL,
  /*`order_last_status_change` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,*/
 
  `order_ship_name` VARCHAR(50),
  `order_ship_city` VARCHAR(50),
  `order_ship_street` VARCHAR(50),
  `order_ship_zip` INT,  
  
  PRIMARY KEY (`order_id`),
  UNIQUE INDEX `order_payment_code_unique_index` (`order_payment_code`),
  UNIQUE INDEX `order_number_unique_index` (`order_number`),
  CONSTRAINT `order_customer_fk`
    FOREIGN KEY (`order_customer_id`)
    REFERENCES `customers` (`customer_id`),
  CONSTRAINT `order_delivery_type_fk`
    FOREIGN KEY (`order_delivery_type_id`)
    REFERENCES `delivery_types` (`delivery_type_id`),
  CONSTRAINT `order_payment_type_fk`
    FOREIGN KEY (`order_payment_type_id`)
    REFERENCES `payment_types` (`payment_type_id`),
  CONSTRAINT `order_currency_fk`
    FOREIGN KEY (`order_currency_id`)
    REFERENCES `currencies` (`currency_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `order_products` (
  `order_product_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,  
  `order_product_order_id` INT UNSIGNED NOT NULL,
  `order_product_product_id` INT UNSIGNED NULL,
  `order_product_variant_id` INT UNSIGNED NULL,
  `order_product_name` VARCHAR(255) NOT NULL,
  `order_product_variant_name` VARCHAR(100) NULL,
  `order_product_price` DECIMAL(10,2) UNSIGNED NOT NULL,  
  `order_product_count` INT UNSIGNED NOT NULL DEFAULT 1, 
  `order_product_item_price` DECIMAL(10,2) UNSIGNED NOT NULL,

  PRIMARY KEY (`order_product_id`),
  CONSTRAINT `order_product_product_fk`
    FOREIGN KEY (`order_product_product_id`)
    REFERENCES `products` (`product_id`)
    ON DELETE SET NULL,
  CONSTRAINT `order_product_order_fk`
    FOREIGN KEY (`order_product_order_id`)
    REFERENCES `orders` (`order_id`)
    ON DELETE CASCADE,
  CONSTRAINT `order_product_variant_fk`
    FOREIGN KEY (`order_product_variant_id`)
    REFERENCES `product_variants` (`product_variant_id`)
    ON DELETE SET NULL
) ENGINE = InnoDB;

DROP VIEW IF EXISTS `viewCategories`;

CREATE VIEW viewCategories AS
	SELECT *
    FROM categories c
    LEFT OUTER JOIN aliases a ON (a.alias_id = c.category_alias_id);

DROP VIEW IF EXISTS `viewProducts`;

CREATE VIEW viewProducts AS
	SELECT *
    FROM products p
	LEFT OUTER JOIN product_variants pv ON (p.product_default_variant_id = pv.product_variant_id)
    LEFT OUTER JOIN categories c ON (p.product_category_id = c.category_id)
    LEFT OUTER JOIN aliases a ON (a.alias_id = p.product_alias_id);

DROP VIEW IF EXISTS `viewProductsInCart` ;

CREATE VIEW viewProductsInCart AS
	SELECT *, coalesce(pv.product_variant_price, p.product_price ) AS actual_price, coalesce(pv.product_variant_price, p.product_price ) * c.cart_count AS item_price
    FROM cart c
    LEFT OUTER JOIN products p ON (c.cart_product_id = p.product_id)
    LEFT OUTER JOIN product_variants pv ON (c.cart_variant_id = pv.product_variant_id)
    LEFT OUTER JOIN aliases a ON (a.alias_id = p.product_alias_id);

DROP VIEW IF EXISTS `viewOrders`;

CREATE VIEW viewOrders AS
	SELECT *
    FROM orders o
    LEFT OUTER JOIN customers c ON (c.customer_id = o.order_customer_id)
	LEFT OUTER JOIN order_states os ON (os.order_state_id = o.order_order_state_id);
    
DROP VIEW IF EXISTS `viewOrderProducts`;
  
CREATE VIEW viewOrderProducts AS
	SELECT *
    FROM order_products o
    LEFT OUTER JOIN products p ON (p.product_id = o.order_product_product_id);
    
   DROP VIEW IF EXISTS `viewAllowedPaymentTypes`;
  
CREATE VIEW viewAllowedPaymentTypes AS
	SELECT *
    FROM allowed_payment_types apt
    JOIN payment_types pt ON (apt.allowed_payment_type_payment_type_id = pt.payment_type_id);
