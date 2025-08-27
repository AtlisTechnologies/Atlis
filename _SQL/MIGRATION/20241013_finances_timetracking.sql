-- Migration to add corporate finances and time tracking features

START TRANSACTION;

-- Add Finances and Time Tracking to CORPORATE_FEATURE lookup list
SET @corp_feature_list_id := (SELECT id FROM lookup_lists WHERE name = 'CORPORATE_FEATURE');
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
VALUES (1,1,@corp_feature_list_id,'Finances','FINANCES',0),
       (1,1,@corp_feature_list_id,'Time Tracking','TIME_TRACKING',1);

-- Create lookup list for corporate finance sections
INSERT INTO lookup_lists (user_id, user_updated, name, description)
VALUES (1,1,'CORPORATE_FINANCE_SECTION','Sections for corporate finance');
SET @corp_finance_section_id := LAST_INSERT_ID();
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
VALUES (1,1,@corp_finance_section_id,'Invoices','INVOICES',0),
       (1,1,@corp_finance_section_id,'Statements of Work','STATEMENTS_OF_WORK',1);

-- Table: admin_finances_invoices
CREATE TABLE admin_finances_invoices (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  corporate_id int(11) NOT NULL,
  invoice_number varchar(255) NOT NULL,
  status_id int(11) DEFAULT NULL,
  bill_to varchar(255) DEFAULT NULL,
  invoice_date date DEFAULT NULL,
  due_date date DEFAULT NULL,
  total_amount decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_admin_finances_invoices_user_id (user_id),
  KEY fk_admin_finances_invoices_user_updated (user_updated),
  KEY fk_admin_finances_invoices_corporate_id (corporate_id),
  KEY fk_admin_finances_invoices_status_id (status_id),
  CONSTRAINT fk_admin_finances_invoices_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_admin_finances_invoices_user_updated FOREIGN KEY (user_updated) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_admin_finances_invoices_corporate_id FOREIGN KEY (corporate_id) REFERENCES module_corporate (id) ON DELETE CASCADE,
  CONSTRAINT fk_admin_finances_invoices_status_id FOREIGN KEY (status_id) REFERENCES lookup_list_items (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: admin_finances_invoice_items
CREATE TABLE admin_finances_invoice_items (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  invoice_id int(11) NOT NULL,
  description varchar(255) DEFAULT NULL,
  quantity decimal(10,2) DEFAULT NULL,
  rate decimal(10,2) DEFAULT NULL,
  amount decimal(10,2) DEFAULT NULL,
  time_entry_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_admin_finances_invoice_items_user_id (user_id),
  KEY fk_admin_finances_invoice_items_user_updated (user_updated),
  KEY fk_admin_finances_invoice_items_invoice_id (invoice_id),
  KEY fk_admin_finances_invoice_items_time_entry_id (time_entry_id),
  CONSTRAINT fk_admin_finances_invoice_items_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_admin_finances_invoice_items_user_updated FOREIGN KEY (user_updated) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_admin_finances_invoice_items_invoice_id FOREIGN KEY (invoice_id) REFERENCES admin_finances_invoices (id) ON DELETE CASCADE,
  CONSTRAINT fk_admin_finances_invoice_items_time_entry_id FOREIGN KEY (time_entry_id) REFERENCES admin_time_tracking_entries (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: admin_finances_statements_of_work
CREATE TABLE admin_finances_statements_of_work (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  corporate_id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  start_date date DEFAULT NULL,
  end_date date DEFAULT NULL,
  status_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_admin_finances_sow_user_id (user_id),
  KEY fk_admin_finances_sow_user_updated (user_updated),
  KEY fk_admin_finances_sow_corporate_id (corporate_id),
  KEY fk_admin_finances_sow_status_id (status_id),
  CONSTRAINT fk_admin_finances_sow_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_admin_finances_sow_user_updated FOREIGN KEY (user_updated) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_admin_finances_sow_corporate_id FOREIGN KEY (corporate_id) REFERENCES module_corporate (id) ON DELETE CASCADE,
  CONSTRAINT fk_admin_finances_sow_status_id FOREIGN KEY (status_id) REFERENCES lookup_list_items (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: admin_finances_invoice_sow (bridge between invoices and statements of work)
CREATE TABLE admin_finances_invoice_sow (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  invoice_id int(11) NOT NULL,
  statement_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY fk_admin_finances_invoice_sow_user_id (user_id),
  KEY fk_admin_finances_invoice_sow_user_updated (user_updated),
  KEY fk_admin_finances_invoice_sow_invoice_id (invoice_id),
  KEY fk_admin_finances_invoice_sow_statement_id (statement_id),
  CONSTRAINT fk_admin_finances_invoice_sow_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_admin_finances_invoice_sow_user_updated FOREIGN KEY (user_updated) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_admin_finances_invoice_sow_invoice_id FOREIGN KEY (invoice_id) REFERENCES admin_finances_invoices (id) ON DELETE CASCADE,
  CONSTRAINT fk_admin_finances_invoice_sow_statement_id FOREIGN KEY (statement_id) REFERENCES admin_finances_statements_of_work (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: admin_time_tracking_entries
CREATE TABLE admin_time_tracking_entries (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  corporate_id int(11) NOT NULL,
  person_id int(11) NOT NULL,
  work_date date NOT NULL,
  hours decimal(10,2) NOT NULL,
  rate decimal(10,2) DEFAULT NULL,
  invoice_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_admin_time_tracking_entries_user_id (user_id),
  KEY fk_admin_time_tracking_entries_user_updated (user_updated),
  KEY fk_admin_time_tracking_entries_corporate_id (corporate_id),
  KEY fk_admin_time_tracking_entries_person_id (person_id),
  KEY fk_admin_time_tracking_entries_invoice_id (invoice_id),
  CONSTRAINT fk_admin_time_tracking_entries_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_admin_time_tracking_entries_user_updated FOREIGN KEY (user_updated) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_admin_time_tracking_entries_corporate_id FOREIGN KEY (corporate_id) REFERENCES module_corporate (id) ON DELETE CASCADE,
  CONSTRAINT fk_admin_time_tracking_entries_person_id FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE,
  CONSTRAINT fk_admin_time_tracking_entries_invoice_id FOREIGN KEY (invoice_id) REFERENCES admin_finances_invoices (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- RBAC setup for finances and time tracking

-- Permission group for Finances Invoices
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
VALUES (1,1,'Finances Invoices','Permissions for managing invoices');
SET @pg_fin_invoices := LAST_INSERT_ID();

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_finances_invoices','create');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_fin_invoices,@perm);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_finances_invoices','read');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_fin_invoices,@perm);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_finances_invoices','update');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_fin_invoices,@perm);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_finances_invoices','delete');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_fin_invoices,@perm);

-- Permission group for Finances Statements of Work
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
VALUES (1,1,'Finances Statements of Work','Permissions for managing statements of work');
SET @pg_fin_sow := LAST_INSERT_ID();

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_finances_statements_of_work','create');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_fin_sow,@perm);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_finances_statements_of_work','read');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_fin_sow,@perm);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_finances_statements_of_work','update');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_fin_sow,@perm);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_finances_statements_of_work','delete');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_fin_sow,@perm);

-- Permission group for Time Tracking
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
VALUES (1,1,'Time Tracking','Permissions for managing time tracking');
SET @pg_time_tracking := LAST_INSERT_ID();

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_time_tracking','create');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_time_tracking,@perm);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_time_tracking','read');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_time_tracking,@perm);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_time_tracking','update');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_time_tracking,@perm);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
VALUES (1,1,'admin_time_tracking','delete');
SET @perm := LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
VALUES (1,1,@pg_time_tracking,@perm);

-- Navigation links under Corporate
INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated)
VALUES ('Finances › Invoices','corporate/finance/invoices/index.php','file-text',15,1,1),
       ('Finances › Statements of Work','corporate/finance/statements-of-work/index.php','file',16,1,1),
       ('Time Tracking','corporate/time-tracking/index.php','clock',17,1,1);

COMMIT;
