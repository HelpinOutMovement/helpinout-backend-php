ALTER TABLE `app_user` ADD `profile_name` VARCHAR(125) NOT NULL AFTER `last_name`;

ALTER TABLE `app_user_history` ADD `profile_name` VARCHAR(125) NOT NULL AFTER `last_name`; 

ALTER TABLE `request_help` ADD `request_note` VARCHAR(512) NULL AFTER `address`;

ALTER TABLE `request_help` ADD `self_else` INT(1) NOT NULL DEFAULT '1' AFTER `api_log_id`;

UPDATE `app_user` SET `profile_name`= concat(`first_name`," ",`last_name`);

ALTER TABLE `offer_help` CHANGE `offer_condition` `offer_note` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `offer_help_history` CHANGE `offer_condition` `offer_note` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `request_help_history` ADD `self_else` INT(1) NOT NULL DEFAULT '1' AFTER `api_log_id`;

ALTER TABLE `request_help_history` ADD `request_note` VARCHAR(512) NULL AFTER `address`;


CREATE TABLE `email_offer_mapping` (
  `id` int(11) NOT NULL,
  `app_user_id` int(11) NOT NULL,
  `email_address` varchar(256) NOT NULL,
  `datetime` datetime NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` int(1) NOT NULL
);

ALTER TABLE `email_offer_mapping`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `email_offer_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

RENAME TABLE `email_offer_mapping` TO `log_email_offer_mapping_request`;

ALTER TABLE `log_email_offer_mapping_request` CHANGE `status` `status` INT(1) NOT NULL DEFAULT '1';

ALTER TABLE `helpinout_mapping` ADD `datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `mapping_delete_by`, ADD `time_zone_offset` TIME NOT NULL AFTER `datetime`, ADD INDEX (`time_zone_offset`);

UPDATE `helpinout_mapping` SET `datetime`=from_unixtime(`created_at`) WHERE 1 ;



UPDATE `request_help` SET `payment`=0 WHERE `payment` =1
UPDATE `request_help` SET `payment`=1 WHERE `payment` =2


UPDATE `offer_help` SET `payment`=0 WHERE `payment` =1
UPDATE `offer_help` SET `payment`=1 WHERE `payment` =2


ALTER TABLE `helpinout_mapping` ADD `distance` DECIMAL(8,2) NOT NULL AFTER `offer_app_user_id`;


ALTER TABLE `offer_help` DROP `api_log_id`;
ALTER TABLE `request_help` DROP `api_log_id`;
ALTER TABLE `offer_help_history` DROP `api_log_id`;
ALTER TABLE `request_help_history` DROP `api_log_id`;


