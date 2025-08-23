-- Migration: add module_calendar tables

CREATE TABLE IF NOT EXISTS `module_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `is_private` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_module_calendar_user_id` (`user_id`),
  KEY `fk_module_calendar_user_updated` (`user_updated`),
  CONSTRAINT `fk_module_calendar_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_calendar_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `module_calendar_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `calendar_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `event_type_id` int(11) DEFAULT NULL,
  `link_module` varchar(50) DEFAULT NULL,
  `link_record_id` int(11) DEFAULT NULL,
  `is_private` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_module_calendar_events_user_id` (`user_id`),
  KEY `fk_module_calendar_events_user_updated` (`user_updated`),
  KEY `fk_module_calendar_events_calendar_id` (`calendar_id`),
  KEY `fk_module_calendar_events_event_type_id` (`event_type_id`),
  KEY `fk_module_calendar_events_link_record_id` (`link_record_id`),
  CONSTRAINT `fk_module_calendar_events_calendar_id` FOREIGN KEY (`calendar_id`) REFERENCES `module_calendar` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_module_calendar_events_event_type_id` FOREIGN KEY (`event_type_id`) REFERENCES `lookup_list_items` (`id`),
  CONSTRAINT `fk_module_calendar_events_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_calendar_events_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `module_calendar_event_attendees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_module_calendar_event_attendees_event_user` (`event_id`,`user_id`),
  KEY `fk_module_calendar_event_attendees_user_id` (`user_id`),
  KEY `fk_module_calendar_event_attendees_user_updated` (`user_updated`),
  KEY `fk_module_calendar_event_attendees_event_id` (`event_id`),
  CONSTRAINT `fk_module_calendar_event_attendees_event_id` FOREIGN KEY (`event_id`) REFERENCES `module_calendar_events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_module_calendar_event_attendees_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_module_calendar_event_attendees_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
