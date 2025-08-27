-- Corporate module: settings, notes, files, permissions, and navigation

-- Create module_corporate table
CREATE TABLE `module_corporate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `legal_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `ein` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_module_corporate_user_id` (`user_id`),
  KEY `fk_module_corporate_user_updated` (`user_updated`),
  CONSTRAINT `fk_module_corporate_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_corporate_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create module_corporate_notes table
CREATE TABLE `module_corporate_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `corporate_id` int(11) NOT NULL,
  `note_text` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_module_corporate_notes_user_id` (`user_id`),
  KEY `fk_module_corporate_notes_user_updated` (`user_updated`),
  KEY `fk_module_corporate_notes_corporate_id` (`corporate_id`),
  CONSTRAINT `fk_module_corporate_notes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_corporate_notes_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_corporate_notes_corporate_id` FOREIGN KEY (`corporate_id`) REFERENCES `module_corporate` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create module_corporate_files table
CREATE TABLE `module_corporate_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `corporate_id` int(11) NOT NULL,
  `note_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_module_corporate_files_user_id` (`user_id`),
  KEY `fk_module_corporate_files_user_updated` (`user_updated`),
  KEY `fk_module_corporate_files_corporate_id` (`corporate_id`),
  KEY `fk_module_corporate_files_note_id` (`note_id`),
  CONSTRAINT `fk_module_corporate_files_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_corporate_files_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_corporate_files_corporate_id` FOREIGN KEY (`corporate_id`) REFERENCES `module_corporate` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_module_corporate_files_note_id` FOREIGN KEY (`note_id`) REFERENCES `module_corporate_notes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Lookup list for corporate features
INSERT INTO `lookup_lists` (user_id, user_updated, name, description)
VALUES (1,1,'CORPORATE_FEATURE','Corporate module features');

INSERT INTO `lookup_list_items` (user_id, user_updated, list_id, label, code, sort_order, active_from) VALUES
  (1,1,(SELECT id FROM lookup_lists WHERE name='CORPORATE_FEATURE'),'Business Strategy','BUSINESS_STRATEGY',1,'2024-10-10'),
  (1,1,(SELECT id FROM lookup_lists WHERE name='CORPORATE_FEATURE'),'Prospecting','PROSPECTING',2,'2024-10-10'),
  (1,1,(SELECT id FROM lookup_lists WHERE name='CORPORATE_FEATURE'),'Finance','FINANCE',3,'2024-10-10'),
  (1,1,(SELECT id FROM lookup_lists WHERE name='CORPORATE_FEATURE'),'Accounting','ACCOUNTING',4,'2024-10-10'),
  (1,1,(SELECT id FROM lookup_lists WHERE name='CORPORATE_FEATURE'),'Assets','ASSETS',5,'2024-10-10'),
  (1,1,(SELECT id FROM lookup_lists WHERE name='CORPORATE_FEATURE'),'Human Resources','HUMAN_RESOURCES',6,'2024-10-10');

-- Permission group for corporate module
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
VALUES (1,1,'admin_corporate','Permissions for corporate module');

-- Permissions for corporate module and features
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
  (1,1,'admin_corporate','create'),
  (1,1,'admin_corporate','read'),
  (1,1,'admin_corporate','update'),
  (1,1,'admin_corporate','delete'),
  (1,1,'admin_corporate_notes','create'),
  (1,1,'admin_corporate_notes','read'),
  (1,1,'admin_corporate_notes','update'),
  (1,1,'admin_corporate_notes','delete'),
  (1,1,'admin_corporate_files','create'),
  (1,1,'admin_corporate_files','read'),
  (1,1,'admin_corporate_files','update'),
  (1,1,'admin_corporate_files','delete'),
  (1,1,'admin_business_strategy','create'),
  (1,1,'admin_business_strategy','read'),
  (1,1,'admin_business_strategy','update'),
  (1,1,'admin_business_strategy','delete'),
  (1,1,'admin_prospecting','create'),
  (1,1,'admin_prospecting','read'),
  (1,1,'admin_prospecting','update'),
  (1,1,'admin_prospecting','delete'),
  (1,1,'admin_finance','create'),
  (1,1,'admin_finance','read'),
  (1,1,'admin_finance','update'),
  (1,1,'admin_finance','delete'),
  (1,1,'admin_accounting','create'),
  (1,1,'admin_accounting','read'),
  (1,1,'admin_accounting','update'),
  (1,1,'admin_accounting','delete'),
  (1,1,'admin_assets','create'),
  (1,1,'admin_assets','read'),
  (1,1,'admin_assets','update'),
  (1,1,'admin_assets','delete'),
  (1,1,'admin_human_resources','create'),
  (1,1,'admin_human_resources','read'),
  (1,1,'admin_human_resources','update'),
  (1,1,'admin_human_resources','delete');

-- Link permissions to admin_corporate group
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id
FROM admin_permission_groups pg
JOIN admin_permissions p ON p.module IN (
  'admin_corporate','admin_corporate_notes','admin_corporate_files',
  'admin_business_strategy','admin_prospecting','admin_finance',
  'admin_accounting','admin_assets','admin_human_resources')
WHERE pg.name='admin_corporate';

-- Navigation link for Corporate module
INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated)
VALUES ('Corporate','/admin/corporate/index.php','briefcase',14,1,1);

