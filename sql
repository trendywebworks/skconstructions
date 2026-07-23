ALTER TABLE `users` ADD `profile_pic` VARCHAR(255) NULL AFTER `role`;

profile_pic - folder uploads/

drop fields from purchase
add purchase details table

ALTER TABLE `daily_entry` ADD `entry_date` DATE NULL AFTER `id`;
UPDATE `daily_entry` SET `entry_date`='2023-05-02'
ALTER TABLE `market_loans` ADD `entry_date` DATE NULL AFTER `id`;
UPDATE `market_loans` SET `entry_date`='2023-05-02'
ALTER TABLE `vehicle_expenses` ADD `entry_date` DATE NULL AFTER `id`;
UPDATE `vehicle_expenses` SET `entry_date`='2023-05-02'
ALTER TABLE `purchase` ADD `entry_date` DATE NULL AFTER `id`;
UPDATE `purchase` SET `entry_date`='2023-05-02'
ALTER TABLE `gst_bill` ADD `entry_date` DATE NULL AFTER `id`;
UPDATE `gst_bill` SET `entry_date`='2023-05-02'