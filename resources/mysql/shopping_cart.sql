CREATE TABLE `xsolla_shopping_cart_invoice` (
  `v1` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `v2` VARCHAR(200) NULL DEFAULT NULL,
  `v3` VARCHAR(100) NULL DEFAULT NULL,
  `timestamp_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_amount` DECIMAL(12,2) UNSIGNED NOT NULL,
  `invoice_currency` CHAR(3) NOT NULL,
  `id_xsolla` INT(11) UNSIGNED NULL DEFAULT NULL,
  `timestamp_ipn` TIMESTAMP NULL DEFAULT NULL,
  `timestamp_xsolla_ipn` TIMESTAMP NULL DEFAULT NULL,
  `is_dry_run` TINYINT(1) NULL,
  `pid` INT NULL DEFAULT NULL,
  `geotype` INT NULL DEFAULT NULL,
  `user_amount` DECIMAL(12,2) UNSIGNED NULL DEFAULT NULL,
  `user_currency` CHAR(3) NULL DEFAULT NULL,
  `transfer_amount` DECIMAL(12,2) UNSIGNED NULL DEFAULT NULL,
  `transfer_currency` CHAR(3) NULL DEFAULT NULL,
  `is_canceled` TINYINT(1) NOT NULL DEFAULT 0,
  `timestamp_canceled` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`v1`),
  UNIQUE INDEX `id_xsolla_UNIQUE` (`id_xsolla` ASC))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;
