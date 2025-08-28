ALTER TABLE `module_strategy_key_results`
  ADD COLUMN `task_id` INT(11) NULL AFTER `sort_order`,
  ADD COLUMN `project_id` INT(11) NULL AFTER `task_id`;

ALTER TABLE `module_strategy_key_results`
  ADD KEY `fk_mskr_task` (`task_id`),
  ADD KEY `fk_mskr_project` (`project_id`);

ALTER TABLE `module_strategy_key_results`
  ADD CONSTRAINT `fk_mskr_task` FOREIGN KEY (`task_id`) REFERENCES `module_tasks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mskr_project` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
