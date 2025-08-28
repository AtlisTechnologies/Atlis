-- Migration for Strategy module

-- Lookup Lists
INSERT INTO `lookup_lists` (`id`, `user_id`, `user_updated`, `name`, `description`)
VALUES
  (67, 1, 1, 'CORPORATE_STRATEGY_STATUS', 'Status values for corporate strategies'),
  (68, 1, 1, 'CORPORATE_STRATEGY_PRIORITY', 'Priority levels for corporate strategies'),
  (69, 1, 1, 'CORPORATE_STRATEGY_ROLE', 'Roles for strategy collaborators');

INSERT INTO `lookup_list_items` (`id`, `user_id`, `user_updated`, `list_id`, `label`, `code`, `sort_order`)
VALUES
  (297, 1, 1, 67, 'Draft', 'DRAFT', 1),
  (298, 1, 1, 67, 'Active', 'ACTIVE', 2),
  (299, 1, 1, 67, 'Archived', 'ARCHIVED', 3),
  (300, 1, 1, 68, 'Low', 'LOW', 1),
  (301, 1, 1, 68, 'Medium', 'MEDIUM', 2),
  (302, 1, 1, 68, 'High', 'HIGH', 3),
  (303, 1, 1, 68, 'Critical', 'CRITICAL', 4),
  (304, 1, 1, 69, 'Owner', 'OWNER', 1),
  (305, 1, 1, 69, 'Editor', 'EDITOR', 2),
  (306, 1, 1, 69, 'Viewer', 'VIEWER', 3);

-- Tables
CREATE TABLE `module_strategy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `corporate_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  `target_start` date DEFAULT NULL,
  `target_end` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`),
  FOREIGN KEY (`corporate_id`) REFERENCES `module_corporate`(`id`),
  FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items`(`id`),
  FOREIGN KEY (`priority_id`) REFERENCES `lookup_list_items`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `module_strategy_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `strategy_id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`),
  FOREIGN KEY (`strategy_id`) REFERENCES `module_strategy`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `module_strategy_collaborators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `strategy_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`),
  FOREIGN KEY (`strategy_id`) REFERENCES `module_strategy`(`id`),
  FOREIGN KEY (`person_id`) REFERENCES `person`(`id`),
  FOREIGN KEY (`role_id`) REFERENCES `lookup_list_items`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `module_strategy_objectives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `strategy_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `objective` text NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `progress_percent` int(11) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`),
  FOREIGN KEY (`strategy_id`) REFERENCES `module_strategy`(`id`),
  FOREIGN KEY (`parent_id`) REFERENCES `module_strategy_objectives`(`id`),
  FOREIGN KEY (`owner_id`) REFERENCES `person`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `module_strategy_key_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `objective_id` int(11) NOT NULL,
  `key_result` text NOT NULL,
  `target_value` varchar(255) DEFAULT NULL,
  `current_value` varchar(255) DEFAULT NULL,
  `kpi_unit` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`),
  FOREIGN KEY (`objective_id`) REFERENCES `module_strategy_objectives`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `module_strategy_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `strategy_id` int(11) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`),
  FOREIGN KEY (`strategy_id`) REFERENCES `module_strategy`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `module_strategy_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `strategy_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`),
  FOREIGN KEY (`strategy_id`) REFERENCES `module_strategy`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- RBAC
INSERT INTO `admin_permission_groups` (`id`, `user_id`, `user_updated`, `name`, `description`) VALUES
  (24, 1, 1, 'admin_strategy', 'Permissions for managing strategies'),
  (25, 1, 1, 'admin_strategy_notes', 'Permissions for managing strategy notes'),
  (26, 1, 1, 'admin_strategy_files', 'Permissions for managing strategy files');

INSERT INTO `admin_permissions` (`id`, `user_id`, `user_updated`, `module`, `action`) VALUES
  (136, 1, 1, 'strategy', 'create'),
  (137, 1, 1, 'strategy', 'read'),
  (138, 1, 1, 'strategy', 'update'),
  (139, 1, 1, 'strategy', 'delete'),
  (140, 1, 1, 'strategy_tag', 'create'),
  (141, 1, 1, 'strategy_tag', 'read'),
  (142, 1, 1, 'strategy_tag', 'update'),
  (143, 1, 1, 'strategy_tag', 'delete'),
  (144, 1, 1, 'strategy_collaborator', 'create'),
  (145, 1, 1, 'strategy_collaborator', 'read'),
  (146, 1, 1, 'strategy_collaborator', 'update'),
  (147, 1, 1, 'strategy_collaborator', 'delete'),
  (148, 1, 1, 'strategy_objective', 'create'),
  (149, 1, 1, 'strategy_objective', 'read'),
  (150, 1, 1, 'strategy_objective', 'update'),
  (151, 1, 1, 'strategy_objective', 'delete'),
  (152, 1, 1, 'strategy_key_result', 'create'),
  (153, 1, 1, 'strategy_key_result', 'read'),
  (154, 1, 1, 'strategy_key_result', 'update'),
  (155, 1, 1, 'strategy_key_result', 'delete'),
  (156, 1, 1, 'strategy_note', 'create'),
  (157, 1, 1, 'strategy_note', 'read'),
  (158, 1, 1, 'strategy_note', 'update'),
  (159, 1, 1, 'strategy_note', 'delete'),
  (160, 1, 1, 'strategy_file', 'create'),
  (161, 1, 1, 'strategy_file', 'read'),
  (162, 1, 1, 'strategy_file', 'update'),
  (163, 1, 1, 'strategy_file', 'delete');

INSERT INTO `admin_permission_group_permissions` (`id`, `user_id`, `user_updated`, `permission_group_id`, `permission_id`) VALUES
  (139, 1, 1, 24, 136),
  (140, 1, 1, 24, 137),
  (141, 1, 1, 24, 138),
  (142, 1, 1, 24, 139),
  (143, 1, 1, 24, 140),
  (144, 1, 1, 24, 141),
  (145, 1, 1, 24, 142),
  (146, 1, 1, 24, 143),
  (147, 1, 1, 24, 144),
  (148, 1, 1, 24, 145),
  (149, 1, 1, 24, 146),
  (150, 1, 1, 24, 147),
  (151, 1, 1, 24, 148),
  (152, 1, 1, 24, 149),
  (153, 1, 1, 24, 150),
  (154, 1, 1, 24, 151),
  (155, 1, 1, 24, 152),
  (156, 1, 1, 24, 153),
  (157, 1, 1, 24, 154),
  (158, 1, 1, 24, 155),
  (159, 1, 1, 25, 156),
  (160, 1, 1, 25, 157),
  (161, 1, 1, 25, 158),
  (162, 1, 1, 25, 159),
  (163, 1, 1, 26, 160),
  (164, 1, 1, 26, 161),
  (165, 1, 1, 26, 162),
  (166, 1, 1, 26, 163);

-- Navigation link
INSERT INTO `admin_navigation_links` (`id`, `title`, `path`, `icon`, `sort_order`, `user_id`, `user_updated`) VALUES
  (24, 'Strategy', '/admin/corporate/strategy/index.php', 'target', 18, 1, 1);
