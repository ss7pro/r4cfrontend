
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
-- rc_profile
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rc_profile`;

CREATE TABLE `rc_profile`
(
	`profile_id` INTEGER NOT NULL,
	`default_address_id` INTEGER,
	`invoice_address_id` INTEGER,
	`title` VARCHAR(10),
	`first_name` VARCHAR(50) NOT NULL,
	`last_name` VARCHAR(50) NOT NULL,
	`type` TINYINT DEFAULT 0 NOT NULL,
	`company_name` VARCHAR(100),
	`nip` VARCHAR(16),
	`www` VARCHAR(16),
	`client_id` VARCHAR(64),
	PRIMARY KEY (`profile_id`),
	INDEX `rc_profile_I_1` (`client_id`),
	INDEX `rc_profile_FI_2` (`default_address_id`),
	INDEX `rc_profile_FI_3` (`invoice_address_id`),
	CONSTRAINT `rc_profile_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `sf_guard_user` (`id`),
	CONSTRAINT `rc_profile_FK_2`
		FOREIGN KEY (`default_address_id`)
		REFERENCES `rc_address` (`address_id`),
	CONSTRAINT `rc_profile_FK_3`
		FOREIGN KEY (`invoice_address_id`)
		REFERENCES `rc_address` (`address_id`)
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

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
