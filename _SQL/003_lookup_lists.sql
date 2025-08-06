CREATE TABLE `lookup_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_lookup_lists_name` (`name`),
  KEY `fk_lookup_lists_user_id` (`user_id`),
  KEY `fk_lookup_lists_user_updated` (`user_updated`),
  CONSTRAINT `fk_lookup_lists_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_lookup_lists_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
