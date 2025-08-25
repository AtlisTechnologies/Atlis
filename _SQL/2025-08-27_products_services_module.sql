-- Products & Services module setup

-- Lookup lists
INSERT INTO `lookup_lists` (`id`,`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`,`name`,`description`) VALUES
  (42,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'','PRODUCT_SERVICE_TYPE','Types of products or services'),
  (43,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'','PERSON_SKILL','Skills a person may have'),
  (44,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'','SKILL_LEVEL','Proficiency levels for skills');

INSERT INTO `lookup_list_items` (`id`,`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`,`list_id`,`name`,`value`,`sort_order`,`date_effective`,`date_expired`) VALUES
  (214,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,42,'Product','PRODUCT',1,CURDATE(),NULL),
  (215,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,42,'Service','SERVICE',2,CURDATE(),NULL),
  (216,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,42,'Subscription','SUBSCRIPTION',3,CURDATE(),NULL),
  (217,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,43,'PHP','PHP',1,CURDATE(),NULL),
  (218,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,43,'JavaScript','JAVASCRIPT',2,CURDATE(),NULL),
  (219,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,43,'SQL','SQL',3,CURDATE(),NULL),
  (220,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,43,'Project Management','PM',4,CURDATE(),NULL),
  (221,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,43,'Design','DESIGN',5,CURDATE(),NULL),
  (222,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,44,'Beginner','BEGINNER',1,CURDATE(),NULL),
  (223,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,44,'Intermediate','INTERMEDIATE',2,CURDATE(),NULL),
  (224,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,44,'Advanced','ADVANCED',3,CURDATE(),NULL),
  (225,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,44,'Expert','EXPERT',4,CURDATE(),NULL);

-- Tables
CREATE TABLE `module_products_services` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11),
  `user_updated` INT(11),
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` TEXT DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `type_id` INT(11) NOT NULL,
  `status_id` INT(11) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `price` DECIMAL(10,2) DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`type_id`) REFERENCES `lookup_list_items`(`id`),
  FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `person_skills` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11),
  `user_updated` INT(11),
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` TEXT DEFAULT NULL,
  `person_id` INT(11) NOT NULL,
  `skill_id` INT(11) NOT NULL,
  `level_id` INT(11) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`person_id`) REFERENCES `person`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`skill_id`) REFERENCES `lookup_list_items`(`id`),
  FOREIGN KEY (`level_id`) REFERENCES `lookup_list_items`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `module_products_services_person` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11),
  `user_updated` INT(11),
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` TEXT DEFAULT NULL,
  `product_service_id` INT(11) NOT NULL,
  `person_id` INT(11) NOT NULL,
  `skill_id` INT(11) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`product_service_id`) REFERENCES `module_products_services`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`person_id`) REFERENCES `person`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`skill_id`) REFERENCES `lookup_list_items`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Admin permissions
INSERT INTO `admin_permissions` (`id`,`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`,`module`,`action`) VALUES
  (81,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,'products_services','create'),
  (82,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,'products_services','read'),
  (83,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,'products_services','update'),
  (84,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,'products_services','delete');

INSERT INTO `admin_permission_groups` (`id`,`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`,`name`,`description`) VALUES
  (16,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,'Products & Services','Permissions for managing products and services');

INSERT INTO `admin_permission_group_permissions` (`id`,`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`,`permission_group_id`,`permission_id`) VALUES
  (81,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,16,81),
  (82,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,16,82),
  (83,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,16,83),
  (84,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,16,84);

INSERT INTO `admin_roles` (`id`,`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`,`name`,`description`) VALUES
  (15,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,'Products & Services Manager','');

INSERT INTO `admin_role_permissions` (`id`,`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`,`role_id`,`permission_group_id`) VALUES
  (44,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,1,16),
  (45,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,15,16);

INSERT INTO `admin_role_permission_groups` (`id`,`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`,`role_id`,`permission_group_id`) VALUES
  (42,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,1,16),
  (43,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,15,16);

INSERT INTO `admin_navigation_links` (`id`,`title`,`path`,`icon`,`sort_order`,`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`) VALUES
  (13,'Products & Services','products-services/index.php','box',11,1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL);
