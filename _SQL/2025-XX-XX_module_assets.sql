-- Module Assets schema, lookup data, RBAC, and sample entries

-- -----------------------------
-- Table: module_asset_models
-- -----------------------------
CREATE TABLE module_asset_models (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NULL,
  user_updated INT(11) NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  make VARCHAR(255) DEFAULT NULL,
  model VARCHAR(255) DEFAULT NULL,
  cpu VARCHAR(255) DEFAULT NULL,
  ram VARCHAR(255) DEFAULT NULL,
  ssd VARCHAR(255) DEFAULT NULL,
  gpu VARCHAR(255) DEFAULT NULL,
  notes TEXT DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_module_asset_models_make_model (make, model),
  CONSTRAINT fk_module_asset_models_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_models_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Table: module_assets
-- -----------------------------
CREATE TABLE module_assets (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NULL,
  user_updated INT(11) NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  asset_tag VARCHAR(50) NOT NULL,
  name VARCHAR(255) NOT NULL,
  type_id INT(11) NULL,
  model_id INT(11) NULL,
  serial_number VARCHAR(255) DEFAULT NULL,
  vendor_id INT(11) NULL,
  purchase_date DATE DEFAULT NULL,
  purchase_price DECIMAL(10,2) DEFAULT NULL,
  warranty_expires DATE DEFAULT NULL,
  status_id INT(11) NULL,
  condition_id INT(11) NULL,
  location VARCHAR(255) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  is_encrypted TINYINT(1) DEFAULT 0,
  is_mdm_enrolled TINYINT(1) DEFAULT 0,
  last_patch_date DATE DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_module_assets_asset_tag (asset_tag),
  CONSTRAINT fk_module_assets_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_assets_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_assets_type_id FOREIGN KEY (type_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_assets_model_id FOREIGN KEY (model_id) REFERENCES module_asset_models(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_assets_vendor_id FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_assets_status_id FOREIGN KEY (status_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_assets_condition_id FOREIGN KEY (condition_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Table: module_asset_assignments
-- -----------------------------
CREATE TABLE module_asset_assignments (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NULL,
  user_updated INT(11) NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  asset_id INT(11) NOT NULL,
  contractor_id INT(11) NOT NULL,
  assigned_by INT(11) NOT NULL,
  assigned_on DATE DEFAULT NULL,
  due_date DATE DEFAULT NULL,
  returned_on DATE DEFAULT NULL,
  condition_out_id INT(11) NULL,
  condition_in_id INT(11) NULL,
  notes TEXT DEFAULT NULL,
  policy_version VARCHAR(50) DEFAULT NULL,
  agreement_file VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_module_asset_assignments_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_assignments_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_assignments_asset_id FOREIGN KEY (asset_id) REFERENCES module_assets(id) ON DELETE CASCADE,
  CONSTRAINT fk_module_asset_assignments_contractor_id FOREIGN KEY (contractor_id) REFERENCES module_contractors(id) ON DELETE CASCADE,
  CONSTRAINT fk_module_asset_assignments_assigned_by FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_assignments_condition_out_id FOREIGN KEY (condition_out_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_assignments_condition_in_id FOREIGN KEY (condition_in_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Table: module_asset_files
-- -----------------------------
CREATE TABLE module_asset_files (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NULL,
  user_updated INT(11) NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  asset_id INT(11) NOT NULL,
  category_id INT(11) NULL,
  file_name VARCHAR(255) NOT NULL,
  file_path VARCHAR(500) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_module_asset_files_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_files_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_files_asset_id FOREIGN KEY (asset_id) REFERENCES module_assets(id) ON DELETE CASCADE,
  CONSTRAINT fk_module_asset_files_category_id FOREIGN KEY (category_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Table: module_asset_events
-- -----------------------------
CREATE TABLE module_asset_events (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NULL,
  user_updated INT(11) NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  asset_id INT(11) NOT NULL,
  assignment_id INT(11) NULL,
  event_type VARCHAR(100) NOT NULL,
  event_date DATE DEFAULT NULL,
  meta JSON DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_module_asset_events_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_events_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_events_asset_id FOREIGN KEY (asset_id) REFERENCES module_assets(id) ON DELETE CASCADE,
  CONSTRAINT fk_module_asset_events_assignment_id FOREIGN KEY (assignment_id) REFERENCES module_asset_assignments(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Table: module_asset_tag_seq
-- -----------------------------
CREATE TABLE module_asset_tag_seq (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NULL,
  user_updated INT(11) NULL,
  date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo TEXT DEFAULT NULL,
  type_id INT(11) NOT NULL,
  last_number INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY uq_module_asset_tag_seq_type_id (type_id),
  CONSTRAINT fk_module_asset_tag_seq_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_tag_seq_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_asset_tag_seq_type_id FOREIGN KEY (type_id) REFERENCES lookup_list_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Lookup Lists and Items
-- -----------------------------
INSERT INTO lookup_lists (user_id, user_updated, name, description) VALUES
  (1,1,'ASSET_TYPE','Asset types'),
  (1,1,'ASSET_STATUS','Asset status'),
  (1,1,'ASSET_CONDITION','Asset condition'),
  (1,1,'ASSET_ATTACHMENT_CATEGORY','Asset file categories');

SET @asset_type_list_id = (SELECT id FROM lookup_lists WHERE name='ASSET_TYPE');
SET @asset_status_list_id = (SELECT id FROM lookup_lists WHERE name='ASSET_STATUS');
SET @asset_condition_list_id = (SELECT id FROM lookup_lists WHERE name='ASSET_CONDITION');
SET @asset_file_cat_list_id = (SELECT id FROM lookup_lists WHERE name='ASSET_ATTACHMENT_CATEGORY');

-- Asset Types with tag prefixes
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order) VALUES
  (1,1,@asset_type_list_id,'Laptop','LAP',1),
  (1,1,@asset_type_list_id,'Monitor','MON',2),
  (1,1,@asset_type_list_id,'Keyboard','KEY',3),
  (1,1,@asset_type_list_id,'Mouse','MOU',4);

-- Asset Status
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order) VALUES
  (1,1,@asset_status_list_id,'IN_STOCK','IN_STOCK',1),
  (1,1,@asset_status_list_id,'ASSIGNED','ASSIGNED',2),
  (1,1,@asset_status_list_id,'IN_REPAIR','IN_REPAIR',3),
  (1,1,@asset_status_list_id,'LOST','LOST',4),
  (1,1,@asset_status_list_id,'RETIRED','RETIRED',5),
  (1,1,@asset_status_list_id,'DISPOSED','DISPOSED',6);

-- Asset Condition
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order) VALUES
  (1,1,@asset_condition_list_id,'NEW','NEW',1),
  (1,1,@asset_condition_list_id,'EXCELLENT','EXCELLENT',2),
  (1,1,@asset_condition_list_id,'GOOD','GOOD',3),
  (1,1,@asset_condition_list_id,'FAIR','FAIR',4),
  (1,1,@asset_condition_list_id,'POOR','POOR',5),
  (1,1,@asset_condition_list_id,'DAMAGED','DAMAGED',6);

-- Asset Attachment Categories
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order) VALUES
  (1,1,@asset_file_cat_list_id,'RECEIPT','RECEIPT',1),
  (1,1,@asset_file_cat_list_id,'PHOTO','PHOTO',2),
  (1,1,@asset_file_cat_list_id,'AGREEMENT','AGREEMENT',3),
  (1,1,@asset_file_cat_list_id,'REPAIR_DOC','REPAIR_DOC',4);

-- -----------------------------
-- RBAC Setup for Assets
-- -----------------------------
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
  (1,1,'assets','create'),
  (1,1,'assets','read'),
  (1,1,'assets','update'),
  (1,1,'assets','delete'),
  (1,1,'assets','assign');

SET @perm_create = (SELECT id FROM admin_permissions WHERE module='assets' AND action='create');
SET @perm_read   = (SELECT id FROM admin_permissions WHERE module='assets' AND action='read');
SET @perm_update = (SELECT id FROM admin_permissions WHERE module='assets' AND action='update');
SET @perm_delete = (SELECT id FROM admin_permissions WHERE module='assets' AND action='delete');
SET @perm_assign = (SELECT id FROM admin_permissions WHERE module='assets' AND action='assign');

INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
VALUES (1,1,'Assets','Permissions for managing assets');
SET @assets_group_id = (SELECT id FROM admin_permission_groups WHERE name='Assets');

INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id) VALUES
  (1,1,@assets_group_id,@perm_create),
  (1,1,@assets_group_id,@perm_read),
  (1,1,@assets_group_id,@perm_update),
  (1,1,@assets_group_id,@perm_delete),
  (1,1,@assets_group_id,@perm_assign);

SET @admin_role_id = (SELECT id FROM admin_roles WHERE name='Admin');
INSERT INTO admin_role_permission_groups (user_id, user_updated, role_id, permission_group_id)
VALUES (1,1,@admin_role_id,@assets_group_id);

INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated)
VALUES ('Assets','assets/','box',12,1,1);

-- -----------------------------
-- Sample asset model, asset type sequence, and default asset
-- -----------------------------
SET @laptop_type_id = (SELECT id FROM lookup_list_items WHERE list_id=@asset_type_list_id AND code='LAP');
SET @status_in_stock = (SELECT id FROM lookup_list_items WHERE list_id=@asset_status_list_id AND code='IN_STOCK');
SET @condition_new = (SELECT id FROM lookup_list_items WHERE list_id=@asset_condition_list_id AND code='NEW');

INSERT INTO module_asset_models (user_id, user_updated, make, model, cpu, ram, ssd, gpu, notes)
VALUES (1,1,'Dell','XPS 13','Intel i7','16GB','512GB','Intel Iris','Default model');
SET @default_model_id = LAST_INSERT_ID();

INSERT INTO module_asset_tag_seq (user_id, user_updated, type_id, last_number)
VALUES (1,1,@laptop_type_id,1);

INSERT INTO module_assets (
  user_id, user_updated, asset_tag, name, type_id, model_id, serial_number, vendor_id, purchase_date, purchase_price, warranty_expires, status_id, condition_id, location, description, is_encrypted, is_mdm_enrolled, last_patch_date)
VALUES (
  1,1,'LAP-0001','Default Laptop',@laptop_type_id,@default_model_id,'SN123456',NULL,'2025-01-15',1200.00,'2028-01-15',@status_in_stock,@condition_new,'HQ','Sample asset',1,1,'2025-02-01');

