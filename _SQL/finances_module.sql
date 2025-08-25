-- Navigation link for Finances module
INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated)
VALUES ('Finances', 'finances/index.php', 'dollar-sign', 99, 1, 1);

-- CRUD permissions for finances and SoW management
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
(1,1,'finances','create'),
(1,1,'finances','read'),
(1,1,'finances','update'),
(1,1,'finances','delete'),
(1,1,'sow','create'),
(1,1,'sow','read'),
(1,1,'sow','update'),
(1,1,'sow','delete');

-- Permission group for Finances
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
VALUES (1,1,'Finances','Permissions for managing finances');

-- Link permissions to the Finances permission group
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Finances' AND p.module='finances' AND p.action='create'
UNION ALL
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Finances' AND p.module='finances' AND p.action='read'
UNION ALL
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Finances' AND p.module='finances' AND p.action='update'
UNION ALL
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Finances' AND p.module='finances' AND p.action='delete'
UNION ALL
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Finances' AND p.module='sow' AND p.action='create'
UNION ALL
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Finances' AND p.module='sow' AND p.action='read'
UNION ALL
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Finances' AND p.module='sow' AND p.action='update'
UNION ALL
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Finances' AND p.module='sow' AND p.action='delete';

-- Lookup lists for SoW and relationship metadata
INSERT INTO lookup_lists (user_id, user_updated, name, description)
VALUES
(1,1,'SOW_STATUS','Status values for statements of work'),
(1,1,'SOW_FILE_TYPE','Allowed file types for SoW attachments'),
(1,1,'RELATIONSHIP_TYPE','Relationship types for linked records');

-- Items for SOW_STATUS
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'Draft','DRAFT',1 FROM lookup_lists l WHERE l.name='SOW_STATUS';
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'On Hold','ON_HOLD',2 FROM lookup_lists l WHERE l.name='SOW_STATUS';
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'In Progress','IN_PROGRESS',3 FROM lookup_lists l WHERE l.name='SOW_STATUS';
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'Cancelled','CANCELLED',4 FROM lookup_lists l WHERE l.name='SOW_STATUS';
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'Complete','COMPLETE',5 FROM lookup_lists l WHERE l.name='SOW_STATUS';

-- Items for SOW_FILE_TYPE
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'PDF','PDF',1 FROM lookup_lists l WHERE l.name='SOW_FILE_TYPE';
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'DOCX','DOCX',2 FROM lookup_lists l WHERE l.name='SOW_FILE_TYPE';
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'XLSX','XLSX',3 FROM lookup_lists l WHERE l.name='SOW_FILE_TYPE';
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'JPG','JPG',4 FROM lookup_lists l WHERE l.name='SOW_FILE_TYPE';
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'PNG','PNG',5 FROM lookup_lists l WHERE l.name='SOW_FILE_TYPE';

-- Items for RELATIONSHIP_TYPE
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'Owner','OWNER',1 FROM lookup_lists l WHERE l.name='RELATIONSHIP_TYPE';
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'Contributor','CONTRIBUTOR',2 FROM lookup_lists l WHERE l.name='RELATIONSHIP_TYPE';
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'Viewer','VIEWER',3 FROM lookup_lists l WHERE l.name='RELATIONSHIP_TYPE';

-- Core SoW table
CREATE TABLE admin_feature_sow (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  title VARCHAR(255) NOT NULL,
  status_id INT(11) NOT NULL,
  current_version_id INT(11) DEFAULT NULL,
  start_date DATE DEFAULT NULL,
  end_date DATE DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (status_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Historical versions of SoW
CREATE TABLE admin_feature_sow_versions (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_id INT(11) NOT NULL,
  version_number INT(11) NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT DEFAULT NULL,
  status_id INT(11) NOT NULL,
  total_amount DECIMAL(12,2) DEFAULT NULL,
  effective_date DATE DEFAULT NULL,
  expiration_date DATE DEFAULT NULL,
  signed_by VARCHAR(255) DEFAULT NULL,
  signed_title VARCHAR(255) DEFAULT NULL,
  signed_on DATE DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_id) REFERENCES admin_feature_sow(id) ON DELETE CASCADE,
  FOREIGN KEY (status_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Link current version back to SoW
ALTER TABLE admin_feature_sow
  ADD CONSTRAINT fk_finances_sow_current_version FOREIGN KEY (current_version_id)
  REFERENCES admin_feature_sow_versions(id);

-- Attachments per version
CREATE TABLE admin_feature_sow_attachments (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_version_id INT(11) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  original_filename VARCHAR(255) NOT NULL,
  mime_type VARCHAR(255) DEFAULT NULL,
  file_size INT(11) DEFAULT NULL,
  file_type_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_version_id) REFERENCES admin_feature_sow_versions(id) ON DELETE CASCADE,
  FOREIGN KEY (file_type_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Line items per SoW version
CREATE TABLE admin_feature_sow_line_items (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_version_id INT(11) NOT NULL,
  description TEXT NOT NULL,
  quantity DECIMAL(10,2) DEFAULT 1.00,
  unit_price DECIMAL(12,2) DEFAULT 0.00,
  total_amount DECIMAL(12,2) DEFAULT 0.00,
  sort_order INT(11) DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_version_id) REFERENCES admin_feature_sow_versions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Join tables linking SoWs to other records
CREATE TABLE admin_feature_sow_projects (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_id INT(11) NOT NULL,
  project_id INT(11) NOT NULL,
  relationship_type_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_id) REFERENCES admin_feature_sow(id) ON DELETE CASCADE,
  FOREIGN KEY (project_id) REFERENCES module_projects(id) ON DELETE CASCADE,
  FOREIGN KEY (relationship_type_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE admin_feature_sow_agencies (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_id INT(11) NOT NULL,
  agency_id INT(11) NOT NULL,
  relationship_type_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_id) REFERENCES admin_feature_sow(id) ON DELETE CASCADE,
  FOREIGN KEY (agency_id) REFERENCES module_agency(id) ON DELETE CASCADE,
  FOREIGN KEY (relationship_type_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE admin_feature_sow_divisions (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_id INT(11) NOT NULL,
  division_id INT(11) NOT NULL,
  relationship_type_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_id) REFERENCES admin_feature_sow(id) ON DELETE CASCADE,
  FOREIGN KEY (division_id) REFERENCES module_division(id) ON DELETE CASCADE,
  FOREIGN KEY (relationship_type_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE admin_feature_sow_tasks (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_id INT(11) NOT NULL,
  task_id INT(11) NOT NULL,
  relationship_type_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_id) REFERENCES admin_feature_sow(id) ON DELETE CASCADE,
  FOREIGN KEY (task_id) REFERENCES module_tasks(id) ON DELETE CASCADE,
  FOREIGN KEY (relationship_type_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE admin_feature_sow_users (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_id INT(11) NOT NULL,
  related_user_id INT(11) NOT NULL,
  relationship_type_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_id) REFERENCES admin_feature_sow(id) ON DELETE CASCADE,
  FOREIGN KEY (related_user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (relationship_type_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE admin_feature_sow_questions (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_id INT(11) NOT NULL,
  question_id INT(11) NOT NULL,
  relationship_type_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_id) REFERENCES admin_feature_sow(id) ON DELETE CASCADE,
  FOREIGN KEY (question_id) REFERENCES module_projects_questions(id) ON DELETE CASCADE,
  FOREIGN KEY (relationship_type_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE admin_feature_sow_links (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_id INT(11) NOT NULL,
  link_id INT(11) NOT NULL,
  relationship_type_id INT(11) NOT NULL,
  FOREIGN KEY (link_id) REFERENCES module_projects_links(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_id) REFERENCES admin_feature_sow(id) ON DELETE CASCADE,
  FOREIGN KEY (relationship_type_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE admin_feature_sow_notes (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_id INT(11) NOT NULL,
  note_id INT(11) NOT NULL,
  relationship_type_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_id) REFERENCES admin_feature_sow(id) ON DELETE CASCADE,
  FOREIGN KEY (note_id) REFERENCES module_projects_notes(id) ON DELETE CASCADE,
  FOREIGN KEY (relationship_type_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE admin_feature_sow_logins (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  user_updated INT(11),
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  sow_id INT(11) NOT NULL,
  login_id INT(11) NOT NULL,
  relationship_type_id INT(11) NOT NULL,
  FOREIGN KEY (login_id) REFERENCES module_projects_logins(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (sow_id) REFERENCES admin_feature_sow(id) ON DELETE CASCADE,
  FOREIGN KEY (relationship_type_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
