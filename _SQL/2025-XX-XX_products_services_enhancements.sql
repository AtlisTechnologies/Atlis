-- Products & Services enhancements

-- Lookup list for product/service categories
INSERT INTO `lookup_lists` (`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`,`name`,`description`) VALUES
  (1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'','PRODUCT_SERVICE_CATEGORY','Categories for products and services');

INSERT INTO `lookup_list_items` (`user_id`,`user_updated`,`date_created`,`date_updated`,`memo`,`list_id`,`name`,`value`,`sort_order`,`date_effective`,`date_expired`) VALUES
  (1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,(SELECT id FROM lookup_lists WHERE name='PRODUCT_SERVICE_CATEGORY'),'Consulting','CONSULTING',1,CURDATE(),NULL),
  (1,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL,(SELECT id FROM lookup_lists WHERE name='PRODUCT_SERVICE_CATEGORY'),'Hardware','HARDWARE',2,CURDATE(),NULL);

-- Table linking products/services to categories
CREATE TABLE `module_products_services_category` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11),
  `user_updated` INT(11),
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` TEXT DEFAULT NULL,
  `product_service_id` INT(11) NOT NULL,
  `category_id` INT(11) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`product_service_id`) REFERENCES `module_products_services`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `lookup_list_items`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table to track product/service price changes
CREATE TABLE `module_products_services_price_history` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11),
  `user_updated` INT(11),
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` TEXT DEFAULT NULL,
  `product_service_id` INT(11) NOT NULL,
  `old_price` DECIMAL(10,2) NOT NULL,
  `new_price` DECIMAL(10,2) NOT NULL,
  `changed_by` INT(11) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`user_updated`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`product_service_id`) REFERENCES `module_products_services`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`changed_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
