ALTER TABLE `module_conferences`
  ADD COLUMN `latitude` decimal(10,6) DEFAULT NULL AFTER `city`,
  ADD COLUMN `longitude` decimal(10,6) DEFAULT NULL AFTER `latitude`,
  ADD COLUMN `banner_image_id` int(11) DEFAULT NULL AFTER `sponsors`;

ALTER TABLE `module_conference_images`
  ADD COLUMN `is_banner` tinyint(1) DEFAULT 0 AFTER `file_type`;
