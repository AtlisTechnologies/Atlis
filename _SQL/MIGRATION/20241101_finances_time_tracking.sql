START TRANSACTION;

-- Ensure lookup items for corporate features
INSERT INTO lookup_list_items (lookup_list_id, label, value, sort_order)
SELECT ll.id, 'Finances', 'FINANCES', 0
FROM lookup_lists ll
WHERE ll.name = 'CORPORATE_FEATURE'
  AND NOT EXISTS (
    SELECT 1 FROM lookup_list_items li
    WHERE li.lookup_list_id = ll.id AND li.label = 'Finances'
  );

INSERT INTO lookup_list_items (lookup_list_id, label, value, sort_order)
SELECT ll.id, 'Time Tracking', 'TIME_TRACKING', 1
FROM lookup_lists ll
WHERE ll.name = 'CORPORATE_FEATURE'
  AND NOT EXISTS (
    SELECT 1 FROM lookup_list_items li
    WHERE li.lookup_list_id = ll.id AND li.label = 'Time Tracking'
  );

-- Create FINANCE_INVOICE_STATUS lookup list and items
INSERT INTO lookup_lists (user_id, user_updated, name, description)
SELECT 1,1,'FINANCE_INVOICE_STATUS','Invoice status values'
WHERE NOT EXISTS (SELECT 1 FROM lookup_lists WHERE name = 'FINANCE_INVOICE_STATUS');

INSERT INTO lookup_list_items (lookup_list_id, label, value, sort_order)
SELECT ll.id, 'Draft', 'DRAFT', 0
FROM lookup_lists ll
WHERE ll.name = 'FINANCE_INVOICE_STATUS'
  AND NOT EXISTS (
    SELECT 1 FROM lookup_list_items li
    WHERE li.lookup_list_id = ll.id AND li.label = 'Draft'
  );

INSERT INTO lookup_list_items (lookup_list_id, label, value, sort_order)
SELECT ll.id, 'Sent', 'SENT', 1
FROM lookup_lists ll
WHERE ll.name = 'FINANCE_INVOICE_STATUS'
  AND NOT EXISTS (
    SELECT 1 FROM lookup_list_items li
    WHERE li.lookup_list_id = ll.id AND li.label = 'Sent'
  );

INSERT INTO lookup_list_items (lookup_list_id, label, value, sort_order)
SELECT ll.id, 'Paid', 'PAID', 2
FROM lookup_lists ll
WHERE ll.name = 'FINANCE_INVOICE_STATUS'
  AND NOT EXISTS (
    SELECT 1 FROM lookup_list_items li
    WHERE li.lookup_list_id = ll.id AND li.label = 'Paid'
  );

INSERT INTO lookup_list_items (lookup_list_id, label, value, sort_order)
SELECT ll.id, 'Void', 'VOID', 3
FROM lookup_lists ll
WHERE ll.name = 'FINANCE_INVOICE_STATUS'
  AND NOT EXISTS (
    SELECT 1 FROM lookup_list_items li
    WHERE li.lookup_list_id = ll.id AND li.label = 'Void'
  );

-- Table: admin_finances_invoices
CREATE TABLE IF NOT EXISTS admin_finances_invoices (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11) DEFAULT NULL,
  user_updated INT(11) DEFAULT NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  corporate_id INT(11) NOT NULL,
  invoice_number VARCHAR(255) NOT NULL,
  agency_id INT(11) DEFAULT NULL,
  division_id INT(11) DEFAULT NULL,
  status_id INT(11) DEFAULT NULL,
  bill_to VARCHAR(255) DEFAULT NULL,
  invoice_date DATE DEFAULT NULL,
  period_start DATE DEFAULT NULL,
  period_end DATE DEFAULT NULL,
  due_date DATE DEFAULT NULL,
  total_amount DECIMAL(10,2) DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (corporate_id) REFERENCES admin_corporate(id) ON DELETE CASCADE,
  FOREIGN KEY (agency_id) REFERENCES module_agency(id) ON DELETE SET NULL,
  FOREIGN KEY (division_id) REFERENCES module_division(id) ON DELETE SET NULL,
  FOREIGN KEY (status_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL
);

ALTER TABLE admin_finances_invoices
  ADD COLUMN IF NOT EXISTS agency_id INT(11) DEFAULT NULL AFTER invoice_number,
  ADD COLUMN IF NOT EXISTS division_id INT(11) DEFAULT NULL AFTER agency_id,
  ADD COLUMN IF NOT EXISTS period_start DATE DEFAULT NULL AFTER invoice_date,
  ADD COLUMN IF NOT EXISTS period_end DATE DEFAULT NULL AFTER period_start;

-- Table: admin_finances_invoice_items
CREATE TABLE IF NOT EXISTS admin_finances_invoice_items (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11) DEFAULT NULL,
  user_updated INT(11) DEFAULT NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  invoice_id INT(11) NOT NULL,
  description VARCHAR(255) DEFAULT NULL,
  quantity DECIMAL(10,2) DEFAULT NULL,
  rate DECIMAL(10,2) DEFAULT NULL,
  amount DECIMAL(10,2) DEFAULT NULL,
  time_entry_id INT(11) DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (invoice_id) REFERENCES admin_finances_invoices(id) ON DELETE CASCADE,
  FOREIGN KEY (time_entry_id) REFERENCES admin_time_tracking_entries(id) ON DELETE SET NULL
);

-- Table: admin_finances_statements_of_work
CREATE TABLE IF NOT EXISTS admin_finances_statements_of_work (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11) DEFAULT NULL,
  user_updated INT(11) DEFAULT NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  corporate_id INT(11) NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT DEFAULT NULL,
  start_date DATE DEFAULT NULL,
  end_date DATE DEFAULT NULL,
  status_id INT(11) DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (corporate_id) REFERENCES admin_corporate(id) ON DELETE CASCADE,
  FOREIGN KEY (status_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL
);

ALTER TABLE admin_finances_statements_of_work
  ADD COLUMN IF NOT EXISTS description TEXT AFTER title;

-- Bridge table: admin_finances_invoice_sow
CREATE TABLE IF NOT EXISTS admin_finances_invoice_sow (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11) DEFAULT NULL,
  user_updated INT(11) DEFAULT NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  invoice_id INT(11) NOT NULL,
  statement_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (invoice_id) REFERENCES admin_finances_invoices(id) ON DELETE CASCADE,
  FOREIGN KEY (statement_id) REFERENCES admin_finances_statements_of_work(id) ON DELETE CASCADE
);

-- Bridge table: admin_finances_invoice_project
CREATE TABLE IF NOT EXISTS admin_finances_invoice_project (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11) DEFAULT NULL,
  user_updated INT(11) DEFAULT NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  invoice_id INT(11) NOT NULL,
  project_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (invoice_id) REFERENCES admin_finances_invoices(id) ON DELETE CASCADE,
  FOREIGN KEY (project_id) REFERENCES module_projects(id) ON DELETE CASCADE
);

-- Table: admin_time_tracking_entries
CREATE TABLE IF NOT EXISTS admin_time_tracking_entries (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11) DEFAULT NULL,
  user_updated INT(11) DEFAULT NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  corporate_id INT(11) NOT NULL,
  person_id INT(11) NOT NULL,
  project_id INT(11) DEFAULT NULL,
  work_date DATE NOT NULL,
  hours DECIMAL(10,2) NOT NULL,
  rate DECIMAL(10,2) DEFAULT NULL,
  invoice_id INT(11) DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (corporate_id) REFERENCES admin_corporate(id) ON DELETE CASCADE,
  FOREIGN KEY (person_id) REFERENCES person(id) ON DELETE CASCADE,
  FOREIGN KEY (project_id) REFERENCES module_projects(id) ON DELETE SET NULL,
  FOREIGN KEY (invoice_id) REFERENCES admin_finances_invoices(id) ON DELETE SET NULL
);

ALTER TABLE admin_time_tracking_entries
  ADD COLUMN IF NOT EXISTS project_id INT(11) DEFAULT NULL AFTER person_id;

-- RBAC seeding
-- Permission groups
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
SELECT 1,1,'admin_finances_invoices','Permissions for admin finances invoices'
WHERE NOT EXISTS (SELECT 1 FROM admin_permission_groups WHERE name='admin_finances_invoices');

INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
SELECT 1,1,'admin_finances_statements_of_work','Permissions for admin finances statements of work'
WHERE NOT EXISTS (SELECT 1 FROM admin_permission_groups WHERE name='admin_finances_statements_of_work');

INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
SELECT 1,1,'admin_time_tracking','Permissions for admin time tracking'
WHERE NOT EXISTS (SELECT 1 FROM admin_permission_groups WHERE name='admin_time_tracking');

-- Permissions and links
-- helper: insert permission if not exists
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_finances_invoices','create'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_finances_invoices' AND action='create');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_finances_invoices','read'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_finances_invoices' AND action='read');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_finances_invoices','update'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_finances_invoices' AND action='update');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_finances_invoices','delete'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_finances_invoices' AND action='delete');

INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_finances_statements_of_work','create'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_finances_statements_of_work' AND action='create');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_finances_statements_of_work','read'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_finances_statements_of_work' AND action='read');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_finances_statements_of_work','update'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_finances_statements_of_work' AND action='update');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_finances_statements_of_work','delete'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_finances_statements_of_work' AND action='delete');

INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_time_tracking','create'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_time_tracking' AND action='create');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_time_tracking','read'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_time_tracking' AND action='read');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_time_tracking','update'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_time_tracking' AND action='update');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_time_tracking','delete'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='admin_time_tracking' AND action='delete');

-- Link permissions to groups
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id
FROM admin_permission_groups pg
JOIN admin_permissions p ON p.module='admin_finances_invoices'
WHERE pg.name='admin_finances_invoices'
  AND NOT EXISTS (
    SELECT 1 FROM admin_permission_group_permissions gpp
    WHERE gpp.permission_group_id=pg.id AND gpp.permission_id=p.id
  );

INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id
FROM admin_permission_groups pg
JOIN admin_permissions p ON p.module='admin_finances_statements_of_work'
WHERE pg.name='admin_finances_statements_of_work'
  AND NOT EXISTS (
    SELECT 1 FROM admin_permission_group_permissions gpp
    WHERE gpp.permission_group_id=pg.id AND gpp.permission_id=p.id
  );

INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id
FROM admin_permission_groups pg
JOIN admin_permissions p ON p.module='admin_time_tracking'
WHERE pg.name='admin_time_tracking'
  AND NOT EXISTS (
    SELECT 1 FROM admin_permission_group_permissions gpp
    WHERE gpp.permission_group_id=pg.id AND gpp.permission_id=p.id
  );

-- Navigation links under Corporate
INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated)
SELECT 'Finances › Invoices', '/admin/corporate/finances/invoices/index.php', 'file-text',
       (SELECT IFNULL(MAX(sort_order),0)+1 FROM admin_navigation_links), 1, 1
WHERE NOT EXISTS (
  SELECT 1 FROM admin_navigation_links WHERE path='/admin/corporate/finances/invoices/index.php'
);

INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated)
SELECT 'Finances › Statements of Work', '/admin/corporate/finances/statements-of-work/index.php', 'file',
       (SELECT IFNULL(MAX(sort_order),0)+1 FROM admin_navigation_links), 1, 1
WHERE NOT EXISTS (
  SELECT 1 FROM admin_navigation_links WHERE path='/admin/corporate/finances/statements-of-work/index.php'
);

INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated)
SELECT 'Time Tracking', '/admin/corporate/time-tracking/index.php', 'clock',
       (SELECT IFNULL(MAX(sort_order),0)+1 FROM admin_navigation_links), 1, 1
WHERE NOT EXISTS (
  SELECT 1 FROM admin_navigation_links WHERE path='/admin/corporate/time-tracking/index.php'
);

COMMIT;
