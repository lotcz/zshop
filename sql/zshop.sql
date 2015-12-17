DROP TABLE IF EXISTS `user_sessions` ;
DROP TABLE IF EXISTS `users` ;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login` VARCHAR(100) NOT NULL,
  `user_email` VARCHAR(255) NOT NULL,
  `user_password_hash` VARCHAR(255) NOT NULL,
  `user_failed_attempts` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `users_email_unique` (`user_email` ASC),
  UNIQUE INDEX `users_login_unique` (`user_login` ASC))
ENGINE = InnoDB;

DROP TABLE IF EXISTS `user_sessions` ;

CREATE TABLE IF NOT EXISTS `user_sessions` (
  `user_session_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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

DROP TABLE IF EXISTS `customers` ;

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_login` VARCHAR(100) NOT NULL,
  `customer_email` VARCHAR(255) NOT NULL,
  `customer_password_hash` VARCHAR(255) NOT NULL,
  `customer_failed_attempts` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`customer_id`),
  UNIQUE INDEX `customers_email_unique` (`customer_email` ASC),
  UNIQUE INDEX `customers_login_unique` (`customer_login` ASC))
ENGINE = InnoDB;
