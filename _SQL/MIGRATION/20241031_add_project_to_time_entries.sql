START TRANSACTION;

ALTER TABLE admin_time_tracking_entries
  ADD COLUMN project_id INT(11) DEFAULT NULL AFTER person_id;

ALTER TABLE admin_time_tracking_entries
  ADD KEY `fk_admin_time_tracking_entries_project_id` (`project_id`),
  ADD CONSTRAINT `fk_admin_time_tracking_entries_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`) ON DELETE SET NULL;

COMMIT;
