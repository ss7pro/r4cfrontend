<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1347488349.
 * Generated on 2012-09-13 00:19:09 by rtatar
 */
class PropelMigration_1347488349
{

	public function preUp($manager)
	{
		// add the pre-migration code here
	}

	public function postUp($manager)
	{
		// add the post-migration code here
	}

	public function preDown($manager)
	{
		// add the pre-migration code here
	}

	public function postDown($manager)
	{
		// add the post-migration code here
	}

	/**
	 * Get the SQL statements for the Up migration
	 *
	 * @return array list of the SQL strings to execute for the Up migration
	 *               the keys being the datasources
	 */
	public function getUpSQL()
	{
		return array (
  'propel' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `rc_payment` ADD
(
	`invoice_id` INTEGER
);

CREATE INDEX `rc_payment_FI_3` ON `rc_payment` (`invoice_id`);

ALTER TABLE `rc_payment` ADD CONSTRAINT `rc_payment_FK_3`
	FOREIGN KEY (`invoice_id`)
	REFERENCES `rc_invoice` (`invoice_id`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
	}

	/**
	 * Get the SQL statements for the Down migration
	 *
	 * @return array list of the SQL strings to execute for the Down migration
	 *               the keys being the datasources
	 */
	public function getDownSQL()
	{
		return array (
  'propel' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `rc_invoice_item` CHANGE `price` `price` DECIMAL NOT NULL;

ALTER TABLE `rc_invoice_item` CHANGE `tax` `tax` DECIMAL NOT NULL;

ALTER TABLE `rc_invoice_item` CHANGE `cost` `cost` DECIMAL NOT NULL;

ALTER TABLE `rc_payment` DROP FOREIGN KEY `rc_payment_FK_3`;

DROP INDEX `rc_payment_FI_3` ON `rc_payment`;

ALTER TABLE `rc_payment` DROP `invoice_id`;

ALTER TABLE `rc_promo_code` CHANGE `value` `value` DECIMAL NOT NULL;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
	}

}
