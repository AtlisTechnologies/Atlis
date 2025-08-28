ALTER TABLE module_strategy_key_results
  ADD COLUMN task_id INT(11) DEFAULT NULL,
  ADD COLUMN project_id INT(11) DEFAULT NULL,
  ADD CONSTRAINT fk_mskr_task
    FOREIGN KEY (task_id) REFERENCES module_tasks(id)
    ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT fk_mskr_project
    FOREIGN KEY (project_id) REFERENCES module_projects(id)
    ON DELETE SET NULL ON UPDATE CASCADE;
