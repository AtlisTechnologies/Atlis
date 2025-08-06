-- Tables for Organization, Agency, Division
CREATE TABLE `module_organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `main_person` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_module_organization_user_id` (`user_id`),
  KEY `fk_module_organization_user_updated` (`user_updated`),
  KEY `fk_module_organization_main_person` (`main_person`),
  KEY `fk_module_organization_status` (`status`),
  CONSTRAINT `fk_module_organization_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_module_organization_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_module_organization_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`),
  CONSTRAINT `fk_module_organization_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `module_agency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `organization_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `main_person` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_module_agency_user_id` (`user_id`),
  KEY `fk_module_agency_user_updated` (`user_updated`),
  KEY `fk_module_agency_organization_id` (`organization_id`),
  KEY `fk_module_agency_main_person` (`main_person`),
  KEY `fk_module_agency_status` (`status`),
  CONSTRAINT `fk_module_agency_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_module_agency_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_module_agency_organization_id` FOREIGN KEY (`organization_id`) REFERENCES `module_organization` (`id`),
  CONSTRAINT `fk_module_agency_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`),
  CONSTRAINT `fk_module_agency_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `module_division` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `agency_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `main_person` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_module_division_user_id` (`user_id`),
  KEY `fk_module_division_user_updated` (`user_updated`),
  KEY `fk_module_division_agency_id` (`agency_id`),
  KEY `fk_module_division_main_person` (`main_person`),
  KEY `fk_module_division_status` (`status`),
  CONSTRAINT `fk_module_division_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_module_division_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_module_division_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`),
  CONSTRAINT `fk_module_division_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`),
  CONSTRAINT `fk_module_division_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Lookup lists for statuses
INSERT INTO `lookup_lists` (`name`, `description`) VALUES
('ORGANIZATION_STATUS','Status values for organizations'),
('AGENCY_STATUS','Status values for agencies'),
('DIVISION_STATUS','Status values for divisions');

-- Seed status items
INSERT INTO `lookup_list_items` (`list_id`, `label`, `value`, `sort_order`)
SELECT l.id, 'Active', 'active', 1 FROM lookup_lists l WHERE l.name = 'ORGANIZATION_STATUS';
INSERT INTO `lookup_list_items` (`list_id`, `label`, `value`, `sort_order`)
SELECT l.id, 'Inactive', 'inactive', 2 FROM lookup_lists l WHERE l.name = 'ORGANIZATION_STATUS';
INSERT INTO `lookup_list_items` (`list_id`, `label`, `value`, `sort_order`)
SELECT l.id, 'Active', 'active', 1 FROM lookup_lists l WHERE l.name = 'AGENCY_STATUS';
INSERT INTO `lookup_list_items` (`list_id`, `label`, `value`, `sort_order`)
SELECT l.id, 'Inactive', 'inactive', 2 FROM lookup_lists l WHERE l.name = 'AGENCY_STATUS';
INSERT INTO `lookup_list_items` (`list_id`, `label`, `value`, `sort_order`)
SELECT l.id, 'Active', 'active', 1 FROM lookup_lists l WHERE l.name = 'DIVISION_STATUS';
INSERT INTO `lookup_list_items` (`list_id`, `label`, `value`, `sort_order`)
SELECT l.id, 'Inactive', 'inactive', 2 FROM lookup_lists l WHERE l.name = 'DIVISION_STATUS';
