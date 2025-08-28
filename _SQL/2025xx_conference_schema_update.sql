ALTER TABLE module_conferences ADD latitude DECIMAL(10,8), ADD longitude DECIMAL(11,8), ADD banner_image_id INT NULL;
ALTER TABLE module_conference_images ADD is_banner TINYINT(1) DEFAULT 0, ADD sort_order INT DEFAULT 0;
DROP TABLE IF EXISTS module_conference_custom_fields;
