DROP DATABASE IF EXISTS zshop;
CREATE DATABASE zshop;
USE zshop;

CREATE TABLE IF NOT EXISTS `ip_failed_attempts` (
  `ip_failed_attempt_ip` VARCHAR(15),
  `ip_failed_attempt_count` INT UNSIGNED NOT NULL DEFAULT 1,
  `ip_failed_attempt_first` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_failed_attempt_last` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ip_failed_attempt_ip`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_deleted` BIT DEFAULT 0 NOT NULL,
  `user_login` VARCHAR(100),
  `user_email` VARCHAR(255) NOT NULL,
  `user_password_hash` VARCHAR(255) NULL,
  `user_failed_attempts` INT NOT NULL DEFAULT 0,
  `user_last_access` TIMESTAMP,
  `user_reset_password_hash` VARCHAR(255) NULL,
  `user_reset_password_until` TIMESTAMP NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `users_email_unique` (`user_email` ASC),
  UNIQUE INDEX `users_login_unique` (`user_login` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `user_sessions` (
  `user_session_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_session_token_hash` VARCHAR(255) NOT NULL,
  `user_session_user_id` INT(10) UNSIGNED NOT NULL,
  `user_session_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_session_expires` TIMESTAMP NOT NULL,
  PRIMARY KEY (`user_session_id`),
  CONSTRAINT `user_session_user_fk`
    FOREIGN KEY (`user_session_user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_deleted` BOOL DEFAULT FALSE,
  `customer_anonymous` BOOL DEFAULT TRUE,
  `customer_email` VARCHAR(255) NOT NULL,
  `customer_password_hash` VARCHAR(255) ,
  `customer_failed_attempts` INT UNSIGNED NOT NULL DEFAULT 0,
  `customer_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_last_access` TIMESTAMP,
  
  `customer_fb_access` VARCHAR(255),
  `customer_gplus_access` VARCHAR(255),
    
  `customer_name` VARCHAR(100),
  `customer_address_city` VARCHAR(100),
  `customer_address_street` VARCHAR(100),
  `customer_address_zip` INT,
  
  `customer_ship_name` VARCHAR(100),
  `customer_ship_city` VARCHAR(100),
  `customer_ship_street` VARCHAR(100),
  `customer_ship_zip` INT,  
  
  PRIMARY KEY (`customer_id`),
  UNIQUE INDEX `customers_email_unique` (`customer_email` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `customer_sessions` (
  `customer_session_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_session_token_hash` VARCHAR(255) NOT NULL,
  `customer_session_customer_id` INT(10) UNSIGNED NOT NULL,
  `customer_session_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_session_expires` TIMESTAMP NOT NULL,
  PRIMARY KEY (`customer_session_id`),
  CONSTRAINT `customer_session_customer_fk`
    FOREIGN KEY (`customer_session_customer_id`)
    REFERENCES `customers` (`customer_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `aliases` (
  `alias_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `alias_url` VARCHAR(200) NOT NULL,
  `alias_path` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`alias_id`),
  UNIQUE INDEX `aliases_url_unique` (`alias_url` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_ext_id` INT UNSIGNED,
  `category_parent_id` INT UNSIGNED,
  `category_alias_id` INT UNSIGNED,
  `category_name` VARCHAR(200) NOT NULL,
  `category_description` TEXT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE INDEX `categories_ext_id_unique` (`category_ext_id` ASC),
  INDEX `categories_parent_id_index` (`category_parent_id` ASC),
  CONSTRAINT `category_parent_fk`
    FOREIGN KEY (`category_parent_id`)
    REFERENCES `categories` (`category_id`),
  CONSTRAINT `category_alias_fk`
    FOREIGN KEY (`category_alias_id`)
    REFERENCES `aliases` (`alias_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_deleted` BOOL DEFAULT 0 NOT NULL,
  `product_ext_id` INT UNSIGNED NULL,
  `product_alias_id` INT UNSIGNED NULL,
  `product_name` VARCHAR(255) NOT NULL,
  `product_price` DECIMAL(10,2) UNSIGNED NOT NULL,
  `product_stock` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `product_image` VARCHAR(255) NULL,
  `product_default_variant_id` INT UNSIGNED NULL,
  `product_default_category_id` INT UNSIGNED NULL,
  PRIMARY KEY (`product_id`), 
  CONSTRAINT `product_category_parent_fk`
    FOREIGN KEY (`product_default_category_id`)
    REFERENCES `categories` (`category_id`),
  CONSTRAINT `product_alias_fk`
    FOREIGN KEY (`product_alias_id`)
    REFERENCES `aliases` (`alias_id`),
  UNIQUE INDEX `products_ext_id_unique` (`product_ext_id` ASC)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `product_category` (
  `product_category_category_id` INT UNSIGNED NOT NULL,
  `product_category_product_id` INT UNSIGNED NOT NULL,  
  PRIMARY KEY ( `product_category_category_id`, `product_category_product_id`),
  CONSTRAINT `product_category_product_fk`
    FOREIGN KEY (`product_category_product_id`)
    REFERENCES `products` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `product_category_category_fk`
    FOREIGN KEY (`product_category_category_id`)
    REFERENCES `categories` (`category_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `product_variants` (
  `product_variant_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_variant_product_id` INT UNSIGNED NOT NULL,
  `product_variant_ext_id` INT UNSIGNED NULL,
  `product_variant_name` VARCHAR(100) NOT NULL,
  `product_variant_stock` INT UNSIGNED NOT NULL DEFAULT 0,
  `product_variant_price` DECIMAL(10,2) UNSIGNED NULL,
  PRIMARY KEY (`product_variant_id`),
  UNIQUE INDEX `product_variants_unique` (`product_variant_product_id`, `product_variant_name`),
  CONSTRAINT `product_variant_product_fk`
    FOREIGN KEY (`product_variant_product_id`)
    REFERENCES `products` (`product_id`),
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
    REFERENCES `products` (`product_id`),
  CONSTRAINT `cart_customer_fk`
    FOREIGN KEY (`cart_customer_id`)
    REFERENCES `customers` (`customer_id`),
  CONSTRAINT `cart_variant_fk`
    FOREIGN KEY (`cart_variant_id`)
    REFERENCES `product_variants` (`product_variant_id`)
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
    LEFT OUTER JOIN categories c ON (p.product_default_category_id = c.category_id)
    LEFT OUTER JOIN aliases a ON (a.alias_id = p.product_alias_id);

DROP VIEW IF EXISTS `viewProductsInCategories`;

CREATE VIEW viewProductsInCategories AS
	SELECT *
    FROM product_category pc
    LEFT OUTER JOIN products p ON (p.product_id = pc.product_category_product_id)
    LEFT OUTER JOIN product_variants pv ON (p.product_default_variant_id = pv.product_variant_id)
    LEFT OUTER JOIN aliases a ON (a.alias_id = p.product_alias_id);
	    
DROP VIEW IF EXISTS `viewCategoriesByProduct`;

CREATE VIEW viewCategoriesByProduct AS
	SELECT *
    FROM product_category pc
    LEFT OUTER JOIN categories c ON (c.category_id = pc.product_category_category_id);

DROP VIEW IF EXISTS `viewProductsInCart` ;

CREATE VIEW viewProductsInCart AS
	SELECT *, coalesce(pv.product_variant_price, p.product_price ) * c.cart_count AS item_price
    FROM cart c
    LEFT OUTER JOIN products p ON (c.cart_product_id = p.product_id)
    LEFT OUTER JOIN product_variants pv ON (c.cart_variant_id = pv.product_variant_id)
    LEFT OUTER JOIN aliases a ON (a.alias_id = p.product_alias_id);
