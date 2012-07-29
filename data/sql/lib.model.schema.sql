
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- rc_address
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_address`;

CREATE TABLE `rc_address`
(
	`address_id` INTEGER NOT NULL AUTO_INCREMENT,
	`street` VARCHAR(50),
	`post_code` VARCHAR(8),
	`city` VARCHAR(50),
	`phone` VARCHAR(25),
	PRIMARY KEY (`address_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rc_tenant
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_tenant`;

CREATE TABLE `rc_tenant`
(
	`tenant_id` INTEGER NOT NULL AUTO_INCREMENT,
	`type` TINYINT DEFAULT 0 NOT NULL,
	`company_name` VARCHAR(99),
	`nip` VARCHAR(16),
	`www` VARCHAR(16),
	`default_address_id` INTEGER,
	`invoice_address_id` INTEGER,
	`api_id` VARCHAR(99),
	`api_name` VARCHAR(99),
	PRIMARY KEY (`tenant_id`),
	INDEX `rc_tenant_FI_1` (`default_address_id`),
	INDEX `rc_tenant_FI_2` (`invoice_address_id`),
	CONSTRAINT `rc_tenant_FK_1`
		FOREIGN KEY (`default_address_id`)
		REFERENCES `rc_address` (`address_id`),
	CONSTRAINT `rc_tenant_FK_2`
		FOREIGN KEY (`invoice_address_id`)
		REFERENCES `rc_address` (`address_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rc_profile
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_profile`;

CREATE TABLE `rc_profile`
(
	`profile_id` INTEGER NOT NULL,
	`tenant_id` INTEGER,
	`title` VARCHAR(10),
	`first_name` VARCHAR(50) NOT NULL,
	`last_name` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`profile_id`),
	INDEX `rc_profile_FI_2` (`tenant_id`),
	CONSTRAINT `rc_profile_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `sf_guard_user` (`id`),
	CONSTRAINT `rc_profile_FK_2`
		FOREIGN KEY (`tenant_id`)
		REFERENCES `rc_tenant` (`tenant_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rc_invoice
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_invoice`;

CREATE TABLE `rc_invoice`
(
	`invoice_id` INTEGER NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER NOT NULL,
	`type` INTEGER DEFAULT 0 NOT NULL,
	`number` INTEGER NOT NULL,
	`pattern` VARCHAR(30) NOT NULL,
	`message` VARCHAR(30),
	`seller_name` VARCHAR(100) NOT NULL,
	`seller_address` VARCHAR(200) NOT NULL,
	`seller_nip` VARCHAR(16) NOT NULL,
	`seller_bank` VARCHAR(32) NOT NULL,
	`buyer_name` VARCHAR(100) NOT NULL,
	`buyer_address` VARCHAR(200) NOT NULL,
	`buyer_nip` VARCHAR(16),
	`created_at` DATETIME NOT NULL,
	`issue_at` DATE NOT NULL,
	`sale_at` DATE NOT NULL,
	`payment_date` DATE NOT NULL,
	`payment_type` INTEGER DEFAULT 0 NOT NULL,
	PRIMARY KEY (`invoice_id`),
	INDEX `rc_invoice_FI_1` (`profile_id`),
	CONSTRAINT `rc_invoice_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `rc_profile` (`profile_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rc_invoice_item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_invoice_item`;

CREATE TABLE `rc_invoice_item`
(
	`item_id` INTEGER NOT NULL AUTO_INCREMENT,
	`invoice_id` INTEGER NOT NULL,
	`name` TEXT NOT NULL,
	`qty` INTEGER NOT NULL,
	`tax_rate` INTEGER NOT NULL,
	`price` DECIMAL(10,2) NOT NULL,
	`tax` DECIMAL(10,2) NOT NULL,
	`cost` DECIMAL(10,2) NOT NULL,
	PRIMARY KEY (`item_id`),
	INDEX `rc_invoice_item_FI_1` (`invoice_id`),
	CONSTRAINT `rc_invoice_item_FK_1`
		FOREIGN KEY (`invoice_id`)
		REFERENCES `rc_invoice` (`invoice_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rc_promo_code
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_promo_code`;

CREATE TABLE `rc_promo_code`
(
	`code_id` INTEGER NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(16) NOT NULL,
	`value` DECIMAL(10,2) NOT NULL,
	`expired_at` DATETIME,
	`used_at` DATETIME,
	`used_by` INTEGER,
	PRIMARY KEY (`code_id`),
	UNIQUE INDEX `rc_promo_code_U_1` (`code`),
	INDEX `rc_promo_code_FI_1` (`used_by`),
	CONSTRAINT `rc_promo_code_FK_1`
		FOREIGN KEY (`used_by`)
		REFERENCES `rc_tenant` (`tenant_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rc_payment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_payment`;

CREATE TABLE `rc_payment`
(
	`payment_id` INTEGER NOT NULL,
	`tenant_id` INTEGER NOT NULL,
	`tenant_api_id` VARCHAR(50) NOT NULL,
	`amount` INTEGER NOT NULL,
	`first_name` VARCHAR(50) NOT NULL,
	`last_name` VARCHAR(50) NOT NULL,
	`email` VARCHAR(50) NOT NULL,
	`phone` VARCHAR(25),
	`invoice` TINYINT(1) DEFAULT 0 NOT NULL,
	`company_name` VARCHAR(99),
	`street` VARCHAR(50),
	`post_code` VARCHAR(8),
	`city` VARCHAR(50),
	`nip` VARCHAR(16),
	`desc` VARCHAR(255),
	`client_ip` VARCHAR(16),
	`created_at` DATETIME NOT NULL,
	PRIMARY KEY (`payment_id`),
	INDEX `rc_payment_FI_2` (`tenant_id`),
	CONSTRAINT `rc_payment_FK_1`
		FOREIGN KEY (`payment_id`)
		REFERENCES `rt_payu_transaction` (`transaction_id`),
	CONSTRAINT `rc_payment_FK_2`
		FOREIGN KEY (`tenant_id`)
		REFERENCES `rc_tenant` (`tenant_id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
