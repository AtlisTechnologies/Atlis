ALTER TABLE `module_calendar`
  ADD COLUMN `ics_token` varchar(64) DEFAULT NULL AFTER `is_default`,
  ADD UNIQUE KEY `idx_module_calendar_ics_token` (`ics_token`);

UPDATE `module_calendar` SET `ics_token` = UUID() WHERE `ics_token` IS NULL;
