CREATE TABLE `xsolla_standard_user` (
  `v1` VARCHAR(255) NOT NULL,
  `v2` VARCHAR(200) NULL DEFAULT NULL,
  `v3` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`v1`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;

CREATE TABLE `xsolla_shoppingcart3_invoice` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `v1` VARCHAR(255) NOT NULL,
  `id_xsolla` INT UNSIGNED NOT NULL,
  `timestamp_ipn` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `timestamp_xsolla_ipn` TIMESTAMP NOT NULL,
  `payment_amount` DECIMAL(12,2) UNSIGNED NOT NULL,
  `payment_currency` CHAR(3) NOT NULL,
  `is_dry_run` TINYINT(1) NOT NULL,
  `is_canceled` TINYINT(1) NOT NULL DEFAULT 0,
  `timestamp_canceled` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_xsolla_UNIQUE` (`id_xsolla` ASC))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;
