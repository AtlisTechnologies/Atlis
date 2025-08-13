-- Table for system properties and version history
-- Column `type` renamed to `type`

CREATE TABLE `system_properties` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11),
  `user_updated` INT(11),
  `category_id` INT(11) NOT NULL,
  `type` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `value` TEXT,
  `memo` TEXT DEFAULT NULL,
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `lookup_list_items`(`id`),
  FOREIGN KEY (`type`) REFERENCES `lookup_list_items`(`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `system_properties_versions` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `property_id` INT(11) NOT NULL,
  `value` TEXT,
  `user_id` INT(11),
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`property_id`) REFERENCES `system_properties`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Permissions for system properties
INSERT INTO `admin_permissions` (`module`,`action`) VALUES
  ('system_properties','create'),
  ('system_properties','read'),
  ('system_properties','update'),
  ('system_properties','delete');

-- Grant permissions to Admin role
INSERT INTO `admin_role_permissions` (`role_id`,`permission_id`)
SELECT r.id, p.id
FROM admin_roles r
JOIN admin_permissions p ON p.module='system_properties' AND p.action IN ('create','read','update','delete')
WHERE r.name='Admin';
