-- Project file folders and folder_id column

CREATE TABLE `module_projects_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_project_path` (`project_id`,`path`),
  KEY `fk_module_projects_folders_user_id` (`user_id`),
  KEY `fk_module_projects_folders_user_updated` (`user_updated`),
  KEY `fk_module_projects_folders_project_id` (`project_id`),
  KEY `fk_module_projects_folders_parent_id` (`parent_id`),
  CONSTRAINT `fk_module_projects_folders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_module_projects_folders_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_module_projects_folders_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`),
  CONSTRAINT `fk_module_projects_folders_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `module_projects_folders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `module_projects_files`
  ADD COLUMN `folder_id` int(11) DEFAULT NULL AFTER `project_id`,
  ADD KEY `fk_module_projects_files_folder_id` (`folder_id`),
  ADD CONSTRAINT `fk_module_projects_files_folder_id` FOREIGN KEY (`folder_id`) REFERENCES `module_projects_folders` (`id`);

