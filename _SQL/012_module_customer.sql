-- Module customer table and links
CREATE TABLE `module_customer` (
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
  KEY `fk_module_customer_user_id` (`user_id`),
  KEY `fk_module_customer_user_updated` (`user_updated`),
  KEY `fk_module_customer_main_person` (`main_person`),
  KEY `fk_module_customer_status` (`status`),
  CONSTRAINT `fk_module_customer_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_module_customer_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_module_customer_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`),
  CONSTRAINT `fk_module_customer_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `module_organization`
  ADD `customer_id` int(11) DEFAULT NULL AFTER `user_updated`,
  ADD KEY `fk_module_organization_customer` (`customer_id`),
  ADD CONSTRAINT `fk_module_organization_customer` FOREIGN KEY (`customer_id`) REFERENCES `module_customer` (`id`);

ALTER TABLE `module_agency`
  ADD `customer_id` int(11) DEFAULT NULL AFTER `user_updated`,
  ADD KEY `fk_module_agency_customer` (`customer_id`),
  ADD CONSTRAINT `fk_module_agency_customer` FOREIGN KEY (`customer_id`) REFERENCES `module_customer` (`id`);

ALTER TABLE `module_division`
  ADD `customer_id` int(11) DEFAULT NULL AFTER `user_updated`,
  ADD KEY `fk_module_division_customer` (`customer_id`),
  ADD CONSTRAINT `fk_module_division_customer` FOREIGN KEY (`customer_id`) REFERENCES `module_customer` (`id`);
