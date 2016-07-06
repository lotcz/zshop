DROP DATABASE IF EXISTS zshop;
CREATE DATABASE zshop DEFAULT char set utf8;
USE zshop;

CREATE TABLE `site_globals` (
  `site_global_name` varchar(100) NOT NULL DEFAULT '',
  `site_global_value` text,
  PRIMARY KEY (`site_global_name`)
) ENGINE=InnoDB;

INSERT INTO site_globals (`site_global_name`,`site_global_value`) VALUES ('site_title','zShop');

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
  `user_is_superuser` BIT DEFAULT 0 NOT NULL,
  `user_login` VARCHAR(50),
  `user_email` VARCHAR(50) NOT NULL,
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
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` NVARCHAR(50) NOT NULL,
  `role_description` NVARCHAR(255),
  PRIMARY KEY (`role_id`),
  UNIQUE INDEX `role_name_unique` (`role_name` ASC)
) ENGINE = InnoDB;

INSERT INTO roles (role_name) VALUES (N'Users admin');
INSERT INTO roles (role_name) VALUES (N'Products admin');
INSERT INTO roles (role_name) VALUES (N'Orders admin');

CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_role_user_id` INT UNSIGNED NOT NULL,
  `user_role_role_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`user_role_user_id`, `user_role_role_id`),
  INDEX `user_roles_user_index` (`user_role_user_id`),
  CONSTRAINT `user_roles_user_fk`
    FOREIGN KEY (`user_role_user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE,
  CONSTRAINT `user_roles_role_fk`
    FOREIGN KEY (`user_role_role_id`)
    REFERENCES `roles` (`role_id`)
    ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_name` VARCHAR(50) NOT NULL,  
  `permission_description` VARCHAR(255),  
  PRIMARY KEY (`permission_id`),
  UNIQUE INDEX `permissions_name_unique` (`permission_name`)
) ENGINE = InnoDB;

INSERT INTO permissions (permission_name, permission_description) VALUES ('edit user', 'Edit users');
INSERT INTO permissions (permission_name, permission_description) VALUES ('browse order', 'Browse orders');
INSERT INTO permissions (permission_name, permission_description) VALUES ('edit order', 'Edit orders');
INSERT INTO permissions (permission_name, permission_description) VALUES ('browse product', 'Browse products');
INSERT INTO permissions (permission_name, permission_description) VALUES ('edit product', 'Edit products');

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_permission_role_id` INT UNSIGNED NOT NULL,
  `role_permission_permission_id` INT UNSIGNED NOT NULL,  
  PRIMARY KEY (`role_permission_role_id`,  `role_permission_permission_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_deleted` BOOL DEFAULT FALSE,
  `customer_anonymous` BOOL DEFAULT TRUE,
  `customer_email` VARCHAR(50) NOT NULL,
  `customer_password_hash` VARCHAR(255) ,
  `customer_failed_attempts` INT UNSIGNED NOT NULL DEFAULT 0,
  `customer_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_last_access` TIMESTAMP,

  `customer_fb_access_token` VARCHAR(255),
    
  `customer_name` NVARCHAR(50),
  `customer_address_city` NVARCHAR(50),
  `customer_address_street` NVARCHAR(50),
  `customer_address_zip` INT,
  
  `customer_ship_name` NVARCHAR(50),
  `customer_ship_city` NVARCHAR(50),
  `customer_ship_street` NVARCHAR(50),
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
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `aliases` (
  `alias_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `alias_url` VARCHAR(200) NOT NULL,
  `alias_path` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`alias_id`),
  UNIQUE INDEX `aliases_url_unique` (`alias_url` ASC))
ENGINE = InnoDB;

INSERT INTO aliases (alias_url, alias_path) VALUES ('kosik','cart');

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_ext_id` INT UNSIGNED,
  `category_parent_id` INT UNSIGNED,
  `category_alias_id` INT UNSIGNED,
  `category_name` NVARCHAR(200) NOT NULL,
  `category_description` TEXT NULL,
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

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_deleted` BOOL DEFAULT 0 NOT NULL,
  `product_ext_id` INT UNSIGNED NULL,
  `product_category_id` INT UNSIGNED NULL,
  `product_alias_id` INT UNSIGNED NULL,
  `product_name` NVARCHAR(255) NOT NULL,
  `product_price` DECIMAL(10,2) UNSIGNED NOT NULL,
  `product_stock` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `product_image` VARCHAR(255) NULL,
  `product_default_variant_id` INT UNSIGNED NULL,
  `product_description` TEXT NULL,
  PRIMARY KEY (`product_id`), 
  CONSTRAINT `product_category_fk`
    FOREIGN KEY (`product_category_id`)
    REFERENCES `categories` (`category_id`)
    ON DELETE SET NULL,
  CONSTRAINT `product_alias_fk`
    FOREIGN KEY (`product_alias_id`)
    REFERENCES `aliases` (`alias_id`)
    ON DELETE SET NULL,
  UNIQUE INDEX `products_ext_id_unique` (`product_ext_id` ASC)
) ENGINE = InnoDB;

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

CREATE TABLE IF NOT EXISTS `delivery_types` (
 `delivery_type_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
 `delivery_type_name` VARCHAR(50) NOT NULL,
 `delivery_type_price` DECIMAL(10,2) NOT NULL DEFAULT 0,
 `delivery_type_min_order_cost` DECIMAL(10,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`delivery_type_id`)
) ENGINE = InnoDB;

INSERT INTO `delivery_types` (`delivery_type_name`) VALUES ('Pick up in store'),('Czech post'),('Parcel service');

CREATE TABLE IF NOT EXISTS `payment_types` (
 `payment_type_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
 `payment_type_name` VARCHAR(50) NOT NULL,
 `payment_type_price` DECIMAL(10,2) NOT NULL DEFAULT 0,
 `payment_type_min_order_cost` DECIMAL(10,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`payment_type_id`)
) ENGINE = InnoDB;

INSERT INTO `payment_types` (`payment_type_name`) VALUES ('Cash in store'),('Cash on delivery'),('Bank transfer'),('Credit card');

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
VALUES (1,1),(1,3),(1,4),(2,2),(2,3),(2,4),(3,2),(3,3),(3,4);

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_order_state_id` TINYINT UNSIGNED NOT NULL DEFAULT 1, 
  `order_customer_id` INT UNSIGNED NOT NULL,
  `order_delivery_type_id` TINYINT UNSIGNED NOT NULL,
  `order_payment_type_id` TINYINT UNSIGNED NOT NULL,
  `order_payment_code` INT UNSIGNED NOT NULL ,
  `order_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_last_status_change` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 
  `order_ship_name` VARCHAR(50),
  `order_ship_city` VARCHAR(50),
  `order_ship_street` VARCHAR(50),
  `order_ship_zip` INT,  
  
  PRIMARY KEY (`order_id`),
  UNIQUE INDEX `order_payment_code_unique_index` (`order_payment_code`),
  CONSTRAINT `order_customer_fk`
    FOREIGN KEY (`order_customer_id`)
    REFERENCES `customers` (`customer_id`),
  CONSTRAINT `order_delivery_type_fk`
    FOREIGN KEY (`order_delivery_type_id`)
    REFERENCES `delivery_types` (`delivery_type_id`),
  CONSTRAINT `order_payment_type_fk`
    FOREIGN KEY (`order_payment_type_id`)
    REFERENCES `payment_types` (`payment_type_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `order_products` (
  `order_product_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,  
  `order_product_order_id` INT UNSIGNED NOT NULL,
  `order_product_product_id` INT UNSIGNED NULL,
  `order_product_variant_id` INT UNSIGNED NULL,
  `order_product_name` VARCHAR(255) NOT NULL,
  `order_product_variant_name` VARCHAR(100) NOT NULL,
  `order_product_price` DECIMAL(10,2) UNSIGNED NOT NULL,
  `order_product_count` INT UNSIGNED NOT NULL DEFAULT 1, 

  PRIMARY KEY (`order_product_id`),
  CONSTRAINT `order_product_pruduct_fk`
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
	SELECT *, coalesce(pv.product_variant_price, p.product_price ) * c.cart_count AS item_price
    FROM cart c
    LEFT OUTER JOIN products p ON (c.cart_product_id = p.product_id)
    LEFT OUTER JOIN product_variants pv ON (c.cart_variant_id = pv.product_variant_id)
    LEFT OUTER JOIN aliases a ON (a.alias_id = p.product_alias_id);
    
DROP VIEW IF EXISTS `viewSessionsStats` ;

CREATE VIEW viewSessionsStats AS
	SELECT 'Anonymous' as n, COUNT(*) as c
    FROM customer_sessions cs
    LEFT OUTER JOIN customers c ON (c.customer_id = cs.customer_session_customer_id)
    WHERE c.customer_anonymous = 1
    
    UNION
    
    SELECT 'Customers' as n, COUNT(*) as c
    FROM customer_sessions cs
    LEFT OUTER JOIN customers c ON (c.customer_id = cs.customer_session_customer_id)
    WHERE c.customer_anonymous = 0
    
    UNION
    
    SELECT 'Admins' as n, COUNT(*) as c FROM user_sessions;


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
    
DROP VIEW IF EXISTS `viewPermissionsByUser`;
  
CREATE VIEW viewPermissionsByUser AS
	SELECT *
    FROM permissions p
    JOIN role_permissions rp ON (rp.role_permission_permission_id = p.permission_id)
    JOIN user_roles ur ON (ur.user_role_role_id = rp.role_permission_role_id);

DROP VIEW IF EXISTS `viewAllowedPaymentTypes`;
  
CREATE VIEW viewAllowedPaymentTypes AS
	SELECT *
    FROM allowed_payment_types apt
    JOIN payment_types pt ON (apt.allowed_payment_type_payment_type_id = pt.payment_type_id);
