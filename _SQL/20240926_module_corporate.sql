-- Add corporate feature lookup list and items
INSERT INTO `lookup_lists` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `description`) VALUES
(62, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'CORPORATE_FEATURE', 'Corporate module features');

INSERT INTO `lookup_list_items` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `list_id`, `label`, `code`, `sort_order`, `active_from`, `active_to`) VALUES
(281, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Business Strategy', 'BUSINESS_STRATEGY', 1, '2025-08-26', NULL),
(282, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Prospecting', 'PROSPECTING', 2, '2025-08-26', NULL),
(283, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Finance', 'FINANCE', 3, '2025-08-26', NULL),
(284, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Accounting', 'ACCOUNTING', 4, '2025-08-26', NULL),
(285, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Assets', 'ASSETS', 5, '2025-08-26', NULL),
(286, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Human Resources', 'HUMAN_RESOURCES', 6, '2025-08-26', NULL);

-- Create module_corporate table
CREATE TABLE `module_corporate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `feature_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_module_corporate_user_id` (`user_id`),
  KEY `fk_module_corporate_user_updated` (`user_updated`),
  KEY `fk_module_corporate_feature_id` (`feature_id`),
  CONSTRAINT `fk_module_corporate_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_corporate_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_corporate_feature_id` FOREIGN KEY (`feature_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Seed navigation link for Corporate module
INSERT INTO `admin_navigation_links` (`id`, `title`, `path`, `icon`, `sort_order`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`) VALUES
(20, 'Corporate', 'corporate/index.php', 'briefcase', 14, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL);

-- Add corporate permissions
INSERT INTO `admin_permissions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `module`, `action`) VALUES
(116, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'corporate', 'create'),
(117, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'corporate', 'read'),
(118, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'corporate', 'update'),
(119, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'corporate', 'delete');

-- Add corporate permission group
INSERT INTO `admin_permission_groups` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `description`) VALUES
(19, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'Corporate', 'Permissions for managing corporate records');

-- Link corporate permissions to group
INSERT INTO `admin_permission_group_permissions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `permission_group_id`, `permission_id`) VALUES
(119, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 19, 116),
(120, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 19, 117),
(121, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 19, 118),
(122, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 19, 119);
