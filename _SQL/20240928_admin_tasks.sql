-- Admin task management tables and permissions

CREATE TABLE `admin_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  `completed_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_task_user_id` (`user_id`),
  KEY `fk_admin_task_user_updated` (`user_updated`),
  KEY `fk_admin_task_type_id` (`type_id`),
  KEY `fk_admin_task_category_id` (`category_id`),
  KEY `fk_admin_task_sub_category_id` (`sub_category_id`),
  KEY `fk_admin_task_status_id` (`status_id`),
  KEY `fk_admin_task_priority_id` (`priority_id`),
  CONSTRAINT `fk_admin_task_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_type_id` FOREIGN KEY (`type_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_category_id` FOREIGN KEY (`category_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_sub_category_id` FOREIGN KEY (`sub_category_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_priority_id` FOREIGN KEY (`priority_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `admin_task_assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `assigned_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_task_assignments_user_id` (`user_id`),
  KEY `fk_admin_task_assignments_user_updated` (`user_updated`),
  KEY `fk_admin_task_assignments_task_id` (`task_id`),
  KEY `fk_admin_task_assignments_assigned_user_id` (`assigned_user_id`),
  CONSTRAINT `fk_admin_task_assignments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_assignments_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_assignments_task_id` FOREIGN KEY (`task_id`) REFERENCES `admin_task` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_admin_task_assignments_assigned_user_id` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `admin_task_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_task_files_user_id` (`user_id`),
  KEY `fk_admin_task_files_user_updated` (`user_updated`),
  KEY `fk_admin_task_files_task_id` (`task_id`),
  CONSTRAINT `fk_admin_task_files_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_files_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_files_task_id` FOREIGN KEY (`task_id`) REFERENCES `admin_task` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `admin_task_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_task_comments_user_id` (`user_id`),
  KEY `fk_admin_task_comments_user_updated` (`user_updated`),
  KEY `fk_admin_task_comments_task_id` (`task_id`),
  CONSTRAINT `fk_admin_task_comments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_comments_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_comments_task_id` FOREIGN KEY (`task_id`) REFERENCES `admin_task` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `admin_task_relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `related_module` varchar(255) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_task_relations_user_id` (`user_id`),
  KEY `fk_admin_task_relations_user_updated` (`user_updated`),
  KEY `fk_admin_task_relations_task_id` (`task_id`),
  CONSTRAINT `fk_admin_task_relations_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_relations_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_admin_task_relations_task_id` FOREIGN KEY (`task_id`) REFERENCES `admin_task` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Seed navigation link
INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated)
VALUES ('Tasks', 'tasks/index.php', 'check-square', 13, 1, 1);

-- RBAC seed
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
VALUES (1,1,'Admin Tasks','Permissions for managing administrative tasks');

INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
  (1,1,'admin_task','create'),
  (1,1,'admin_task','read'),
  (1,1,'admin_task','update'),
  (1,1,'admin_task','delete'),
  (1,1,'admin_task_assignment','create'),
  (1,1,'admin_task_assignment','read'),
  (1,1,'admin_task_assignment','update'),
  (1,1,'admin_task_assignment','delete'),
  (1,1,'admin_task_file','create'),
  (1,1,'admin_task_file','read'),
  (1,1,'admin_task_file','update'),
  (1,1,'admin_task_file','delete'),
  (1,1,'admin_task_comment','create'),
  (1,1,'admin_task_comment','read'),
  (1,1,'admin_task_comment','update'),
  (1,1,'admin_task_comment','delete');

INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id
FROM admin_permission_groups pg
JOIN admin_permissions p ON p.module IN ('admin_task','admin_task_assignment','admin_task_file','admin_task_comment')
WHERE pg.name='Admin Tasks';

INSERT INTO admin_role_permissions (user_id, user_updated, role_id, permission_group_id)
SELECT 1,1,1,pg.id FROM admin_permission_groups pg WHERE pg.name='Admin Tasks';

INSERT INTO admin_role_permission_groups (user_id, user_updated, role_id, permission_group_id)
SELECT 1,1,1,pg.id FROM admin_permission_groups pg WHERE pg.name='Admin Tasks';
