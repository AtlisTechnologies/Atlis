-- Migration: Strategy Module
-- Date: 2024-10-21

-- Lookup Lists
INSERT INTO lookup_lists (user_id, user_updated, name, description)
VALUES (1,1,'CORPORATE_STRATEGY_STATUS','Status values for corporate strategies');
SET @strategy_status_list_id = LAST_INSERT_ID();
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
VALUES 
    (1,1,@strategy_status_list_id,'Draft','DRAFT',1),
    (1,1,@strategy_status_list_id,'Active','ACTIVE',2),
    (1,1,@strategy_status_list_id,'Archived','ARCHIVED',3);

INSERT INTO lookup_lists (user_id, user_updated, name, description)
VALUES (1,1,'CORPORATE_STRATEGY_PRIORITY','Priority levels for corporate strategies');
SET @strategy_priority_list_id = LAST_INSERT_ID();
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
VALUES 
    (1,1,@strategy_priority_list_id,'Low','LOW',1),
    (1,1,@strategy_priority_list_id,'Medium','MEDIUM',2),
    (1,1,@strategy_priority_list_id,'High','HIGH',3),
    (1,1,@strategy_priority_list_id,'Critical','CRITICAL',4);

INSERT INTO lookup_lists (user_id, user_updated, name, description)
VALUES (1,1,'CORPORATE_STRATEGY_ROLE','Roles for corporate strategy collaboration');
SET @strategy_role_list_id = LAST_INSERT_ID();
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
VALUES 
    (1,1,@strategy_role_list_id,'Owner','OWNER',1),
    (1,1,@strategy_role_list_id,'Editor','EDITOR',2),
    (1,1,@strategy_role_list_id,'Viewer','VIEWER',3);

-- Tables
CREATE TABLE module_strategy (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  corporate_id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  description text DEFAULT NULL,
  status_id int(11) DEFAULT NULL,
  priority_id int(11) DEFAULT NULL,
  target_start date DEFAULT NULL,
  target_end date DEFAULT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY user_updated (user_updated),
  KEY corporate_id (corporate_id),
  KEY status_id (status_id),
  KEY priority_id (priority_id),
  CONSTRAINT fk_module_strategy_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_corporate_id FOREIGN KEY (corporate_id) REFERENCES module_corporate(id) ON DELETE CASCADE,
  CONSTRAINT fk_module_strategy_status_id FOREIGN KEY (status_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_priority_id FOREIGN KEY (priority_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE module_strategy_tags (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  strategy_id int(11) NOT NULL,
  tag varchar(255) NOT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY user_updated (user_updated),
  KEY strategy_id (strategy_id),
  CONSTRAINT fk_module_strategy_tags_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_tags_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_tags_strategy_id FOREIGN KEY (strategy_id) REFERENCES module_strategy(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE module_strategy_collaborators (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  strategy_id int(11) NOT NULL,
  person_id int(11) NOT NULL,
  role_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY user_updated (user_updated),
  KEY strategy_id (strategy_id),
  KEY person_id (person_id),
  KEY role_id (role_id),
  CONSTRAINT fk_module_strategy_collab_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_collab_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_collab_strategy FOREIGN KEY (strategy_id) REFERENCES module_strategy(id) ON DELETE CASCADE,
  CONSTRAINT fk_module_strategy_collab_person FOREIGN KEY (person_id) REFERENCES person(id),
  CONSTRAINT fk_module_strategy_collab_role FOREIGN KEY (role_id) REFERENCES lookup_list_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE module_strategy_objectives (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  strategy_id int(11) NOT NULL,
  parent_id int(11) DEFAULT NULL,
  objective text NOT NULL,
  owner_id int(11) DEFAULT NULL,
  progress_percent int(11) DEFAULT 0,
  sort_order int(11) DEFAULT 0,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY user_updated (user_updated),
  KEY strategy_id (strategy_id),
  KEY parent_id (parent_id),
  KEY owner_id (owner_id),
  CONSTRAINT fk_module_strategy_obj_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_obj_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_obj_strategy FOREIGN KEY (strategy_id) REFERENCES module_strategy(id) ON DELETE CASCADE,
  CONSTRAINT fk_module_strategy_obj_parent FOREIGN KEY (parent_id) REFERENCES module_strategy_objectives(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_obj_owner FOREIGN KEY (owner_id) REFERENCES person(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE module_strategy_key_results (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  objective_id int(11) NOT NULL,
  key_result text NOT NULL,
  target_value varchar(255) DEFAULT NULL,
  current_value varchar(255) DEFAULT NULL,
  kpi_unit varchar(100) DEFAULT NULL,
  sort_order int(11) DEFAULT 0,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY user_updated (user_updated),
  KEY objective_id (objective_id),
  CONSTRAINT fk_module_strategy_kr_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_kr_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_kr_objective FOREIGN KEY (objective_id) REFERENCES module_strategy_objectives(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE module_strategy_notes (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  strategy_id int(11) NOT NULL,
  note text NOT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY user_updated (user_updated),
  KEY strategy_id (strategy_id),
  CONSTRAINT fk_module_strategy_notes_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_notes_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_notes_strategy FOREIGN KEY (strategy_id) REFERENCES module_strategy(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE module_strategy_files (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  user_updated int(11) DEFAULT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  memo text DEFAULT NULL,
  strategy_id int(11) NOT NULL,
  file_name varchar(255) NOT NULL,
  file_path varchar(255) NOT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY user_updated (user_updated),
  KEY strategy_id (strategy_id),
  CONSTRAINT fk_module_strategy_files_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_files_user_updated FOREIGN KEY (user_updated) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_module_strategy_files_strategy FOREIGN KEY (strategy_id) REFERENCES module_strategy(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- RBAC
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
VALUES (1,1,'admin_strategy','Permissions for managing corporate strategy');
SET @pg_strategy = LAST_INSERT_ID();
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
VALUES (1,1,'admin_strategy_notes','Permissions for managing corporate strategy notes');
SET @pg_strategy_notes = LAST_INSERT_ID();
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
VALUES (1,1,'admin_strategy_files','Permissions for managing corporate strategy files');
SET @pg_strategy_files = LAST_INSERT_ID();

-- Strategy permissions
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
(1,1,'strategy','create'),
(1,1,'strategy','read'),
(1,1,'strategy','update'),
(1,1,'strategy','delete');
SET @p_strategy_create = LAST_INSERT_ID()-3;
SET @p_strategy_read   = LAST_INSERT_ID()-2;
SET @p_strategy_update = LAST_INSERT_ID()-1;
SET @p_strategy_delete = LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id) VALUES
(1,1,@pg_strategy,@p_strategy_create),
(1,1,@pg_strategy,@p_strategy_read),
(1,1,@pg_strategy,@p_strategy_update),
(1,1,@pg_strategy,@p_strategy_delete);

-- Strategy tag permissions
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
(1,1,'strategy_tag','create'),
(1,1,'strategy_tag','read'),
(1,1,'strategy_tag','update'),
(1,1,'strategy_tag','delete');
SET @p_strategy_tag_create = LAST_INSERT_ID()-3;
SET @p_strategy_tag_read   = LAST_INSERT_ID()-2;
SET @p_strategy_tag_update = LAST_INSERT_ID()-1;
SET @p_strategy_tag_delete = LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id) VALUES
(1,1,@pg_strategy,@p_strategy_tag_create),
(1,1,@pg_strategy,@p_strategy_tag_read),
(1,1,@pg_strategy,@p_strategy_tag_update),
(1,1,@pg_strategy,@p_strategy_tag_delete);

-- Strategy collaborator permissions
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
(1,1,'strategy_collaborator','create'),
(1,1,'strategy_collaborator','read'),
(1,1,'strategy_collaborator','update'),
(1,1,'strategy_collaborator','delete');
SET @p_strategy_collab_create = LAST_INSERT_ID()-3;
SET @p_strategy_collab_read   = LAST_INSERT_ID()-2;
SET @p_strategy_collab_update = LAST_INSERT_ID()-1;
SET @p_strategy_collab_delete = LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id) VALUES
(1,1,@pg_strategy,@p_strategy_collab_create),
(1,1,@pg_strategy,@p_strategy_collab_read),
(1,1,@pg_strategy,@p_strategy_collab_update),
(1,1,@pg_strategy,@p_strategy_collab_delete);

-- Strategy objective permissions
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
(1,1,'strategy_objective','create'),
(1,1,'strategy_objective','read'),
(1,1,'strategy_objective','update'),
(1,1,'strategy_objective','delete');
SET @p_strategy_obj_create = LAST_INSERT_ID()-3;
SET @p_strategy_obj_read   = LAST_INSERT_ID()-2;
SET @p_strategy_obj_update = LAST_INSERT_ID()-1;
SET @p_strategy_obj_delete = LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id) VALUES
(1,1,@pg_strategy,@p_strategy_obj_create),
(1,1,@pg_strategy,@p_strategy_obj_read),
(1,1,@pg_strategy,@p_strategy_obj_update),
(1,1,@pg_strategy,@p_strategy_obj_delete);

-- Strategy key result permissions
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
(1,1,'strategy_key_result','create'),
(1,1,'strategy_key_result','read'),
(1,1,'strategy_key_result','update'),
(1,1,'strategy_key_result','delete');
SET @p_strategy_kr_create = LAST_INSERT_ID()-3;
SET @p_strategy_kr_read   = LAST_INSERT_ID()-2;
SET @p_strategy_kr_update = LAST_INSERT_ID()-1;
SET @p_strategy_kr_delete = LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id) VALUES
(1,1,@pg_strategy,@p_strategy_kr_create),
(1,1,@pg_strategy,@p_strategy_kr_read),
(1,1,@pg_strategy,@p_strategy_kr_update),
(1,1,@pg_strategy,@p_strategy_kr_delete);

-- Strategy note permissions
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
(1,1,'strategy_note','create'),
(1,1,'strategy_note','read'),
(1,1,'strategy_note','update'),
(1,1,'strategy_note','delete');
SET @p_strategy_note_create = LAST_INSERT_ID()-3;
SET @p_strategy_note_read   = LAST_INSERT_ID()-2;
SET @p_strategy_note_update = LAST_INSERT_ID()-1;
SET @p_strategy_note_delete = LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id) VALUES
(1,1,@pg_strategy_notes,@p_strategy_note_create),
(1,1,@pg_strategy_notes,@p_strategy_note_read),
(1,1,@pg_strategy_notes,@p_strategy_note_update),
(1,1,@pg_strategy_notes,@p_strategy_note_delete);

-- Strategy file permissions
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
(1,1,'strategy_file','create'),
(1,1,'strategy_file','read'),
(1,1,'strategy_file','update'),
(1,1,'strategy_file','delete');
SET @p_strategy_file_create = LAST_INSERT_ID()-3;
SET @p_strategy_file_read   = LAST_INSERT_ID()-2;
SET @p_strategy_file_update = LAST_INSERT_ID()-1;
SET @p_strategy_file_delete = LAST_INSERT_ID();
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id) VALUES
(1,1,@pg_strategy_files,@p_strategy_file_create),
(1,1,@pg_strategy_files,@p_strategy_file_read),
(1,1,@pg_strategy_files,@p_strategy_file_update),
(1,1,@pg_strategy_files,@p_strategy_file_delete);

-- Navigation Link
INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated)
VALUES ('Strategy', '/admin/corporate/strategy/index.php', 'target', 18, 1, 1);
