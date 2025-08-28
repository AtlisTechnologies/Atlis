ALTER TABLE admin_finances_invoices
  ADD COLUMN file_name VARCHAR(255) DEFAULT NULL,
  ADD COLUMN file_path VARCHAR(255) DEFAULT NULL,
  ADD COLUMN file_size INT(11) DEFAULT NULL,
  ADD COLUMN file_type VARCHAR(100) DEFAULT NULL;

ALTER TABLE admin_finances_statements_of_work
  ADD COLUMN file_name VARCHAR(255) DEFAULT NULL,
  ADD COLUMN file_path VARCHAR(255) DEFAULT NULL,
  ADD COLUMN file_size INT(11) DEFAULT NULL,
  ADD COLUMN file_type VARCHAR(100) DEFAULT NULL;

CREATE TABLE admin_finances_invoice_projects (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) DEFAULT NULL,
  user_updated INT(11) DEFAULT NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  invoice_id INT(11) NOT NULL,
  project_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  KEY fk_admin_finances_invoice_projects_invoice_id (invoice_id),
  KEY fk_admin_finances_invoice_projects_project_id (project_id),
  CONSTRAINT fk_admin_finances_invoice_projects_invoice_id FOREIGN KEY (invoice_id) REFERENCES admin_finances_invoices (id) ON DELETE CASCADE,
  CONSTRAINT fk_admin_finances_invoice_projects_project_id FOREIGN KEY (project_id) REFERENCES module_projects (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
