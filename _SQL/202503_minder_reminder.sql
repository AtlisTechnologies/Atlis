-- Table structure for minder_reminder
CREATE TABLE `minder_reminder` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11),
  `user_updated` INT(11),
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` TEXT DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `remind_at` DATETIME NOT NULL,
  `repeat_type` VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for minder_reminder_assignments
CREATE TABLE `minder_reminder_assignments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11),
  `user_updated` INT(11),
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` TEXT DEFAULT NULL,
  `reminder_id` INT(11) NOT NULL,
  `assigned_user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Indexes and constraints
ALTER TABLE `minder_reminder`
  ADD CONSTRAINT `fk_minder_reminder_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_minder_reminder_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `minder_reminder_assignments`
  ADD CONSTRAINT `fk_minder_reminder_assignments_reminder_id` FOREIGN KEY (`reminder_id`) REFERENCES `minder_reminder` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_minder_reminder_assignments_assigned_user_id` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_minder_reminder_assignments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_minder_reminder_assignments_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- Permissions
INSERT INTO `admin_permissions` (`user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `module`, `action`) VALUES
(1,1,NOW(),NOW(),NULL,'minder_reminder','create'),
(1,1,NOW(),NOW(),NULL,'minder_reminder','read'),
(1,1,NOW(),NOW(),NULL,'minder_reminder','update'),
(1,1,NOW(),NOW(),NULL,'minder_reminder','delete');
