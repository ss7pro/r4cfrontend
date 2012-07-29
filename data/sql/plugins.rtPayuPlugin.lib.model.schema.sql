
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- rt_payu_transaction
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rt_payu_transaction`;

CREATE TABLE `rt_payu_transaction`
(
	`transaction_id` INTEGER NOT NULL AUTO_INCREMENT,
	`pos_id` INTEGER NOT NULL,
	`session_id` VARCHAR(50) NOT NULL,
	`trans_id` VARCHAR(50),
	`pay_type` VARCHAR(8),
	`status` INTEGER DEFAULT 0 NOT NULL,
	`create_at` DATETIME,
	`init_at` DATETIME,
	`sent_at` DATETIME,
	`recv_at` DATETIME,
	`cancel_at` DATETIME,
	PRIMARY KEY (`transaction_id`),
	UNIQUE INDEX `pos_session_uq` (`pos_id`, `session_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rt_payu_transaction_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rt_payu_transaction_log`;

CREATE TABLE `rt_payu_transaction_log`
(
	`log_id` INTEGER NOT NULL AUTO_INCREMENT,
	`transaction_id` INTEGER NOT NULL,
	`created_at` DATETIME NOT NULL,
	`status` INTEGER NOT NULL,
	`message` TEXT,
	PRIMARY KEY (`log_id`),
	INDEX `rt_payu_transaction_log_FI_1` (`transaction_id`),
	CONSTRAINT `rt_payu_transaction_log_FK_1`
		FOREIGN KEY (`transaction_id`)
		REFERENCES `rt_payu_transaction` (`transaction_id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
