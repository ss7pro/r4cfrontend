
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
	`street` VARCHAR(50) NOT NULL,
	`post` VARCHAR(8) NOT NULL,
	`city` VARCHAR(50) NOT NULL,
	`phone` VARCHAR(25) NOT NULL,
	PRIMARY KEY (`address_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rc_account
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_account`;

CREATE TABLE `rc_account`
(
	`account_id` INTEGER NOT NULL AUTO_INCREMENT,
	`default_address_id` INTEGER,
	`invoice_address_id` INTEGER,
	`name` VARCHAR(100) NOT NULL,
	`nip` VARCHAR(16),
	`www` VARCHAR(16),
	`email` VARCHAR(16),
	PRIMARY KEY (`account_id`),
	INDEX `rc_account_FI_1` (`default_address_id`),
	INDEX `rc_account_FI_2` (`invoice_address_id`),
	CONSTRAINT `rc_account_FK_1`
		FOREIGN KEY (`default_address_id`)
		REFERENCES `rc_address` (`address_id`),
	CONSTRAINT `rc_account_FK_2`
		FOREIGN KEY (`invoice_address_id`)
		REFERENCES `rc_address` (`address_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rc_user_profile
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_user_profile`;

CREATE TABLE `rc_user_profile`
(
	`user_id` INTEGER NOT NULL,
	`account_id` INTEGER,
	`title` VARCHAR(10) NOT NULL,
	`first_name` VARCHAR(50) NOT NULL,
	`last_name` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`user_id`),
	INDEX `rc_user_profile_FI_2` (`account_id`),
	CONSTRAINT `rc_user_profile_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`),
	CONSTRAINT `rc_user_profile_FK_2`
		FOREIGN KEY (`account_id`)
		REFERENCES `rc_account` (`account_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rc_invoice
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_invoice`;

CREATE TABLE `rc_invoice`
(
	`invoice_id` INTEGER NOT NULL AUTO_INCREMENT,
	`account_id` INTEGER NOT NULL,
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
	INDEX `rc_invoice_FI_1` (`account_id`),
	CONSTRAINT `rc_invoice_FK_1`
		FOREIGN KEY (`account_id`)
		REFERENCES `rc_account` (`account_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rc_invoice_item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_invoice_item`;

CREATE TABLE `rc_invoice_item`
(
	`name` TEXT NOT NULL,
	`qty` INTEGER NOT NULL,
	`tax_rate` INTEGER NOT NULL,
	`price` DECIMAL(10,2) NOT NULL,
	`tax` DECIMAL(10,2) NOT NULL,
	`cost` DECIMAL(10,2) NOT NULL,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
