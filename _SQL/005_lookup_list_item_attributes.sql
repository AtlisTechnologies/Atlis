CREATE TABLE `lookup_list_item_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `attr_key` varchar(100) NOT NULL,
  `attr_value` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lookup_item_attributes_item_id` (`item_id`),
  KEY `fk_lookup_item_attributes_user_id` (`user_id`),
  KEY `fk_lookup_item_attributes_user_updated` (`user_updated`),
  KEY `idx_lookup_item_attributes_key` (`attr_key`),
  CONSTRAINT `fk_lookup_item_attributes_item_id` FOREIGN KEY (`item_id`) REFERENCES `lookup_list_items` (`id`),
  CONSTRAINT `fk_lookup_item_attributes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_lookup_item_attributes_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
