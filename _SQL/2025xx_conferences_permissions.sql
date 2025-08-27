-- Seed conference permissions and lookup lists

-- Permission group
INSERT INTO admin_permission_groups (user_id, name, description)
VALUES (1, 'Conferences', 'Permissions for managing conferences');
SET @conf_group_id = LAST_INSERT_ID();

-- Module permissions
INSERT INTO admin_permissions (user_id, module, action) VALUES
 (1,'conference','create'),
 (1,'conference','read'),
 (1,'conference','update'),
 (1,'conference','delete');
SET @conf_perm_base = LAST_INSERT_ID();

-- Link permissions to group
INSERT INTO admin_permission_group_permissions (user_id, permission_group_id, permission_id) VALUES
 (1,@conf_group_id, @conf_perm_base),
 (1,@conf_group_id, @conf_perm_base+1),
 (1,@conf_group_id, @conf_perm_base+2),
 (1,@conf_group_id, @conf_perm_base+3);

-- Grant group to roles (e.g., Admin)
INSERT INTO admin_role_permissions (user_id, role_id, permission_group_id)
VALUES (1, 1, @conf_group_id);

-- Lookup lists for dropdowns
INSERT INTO lookup_lists (user_id, name, description)
VALUES (1,'CONFERENCE_TYPE','Types of conferences'),
       (1,'CONFERENCE_TOPIC','Topics for conferences');
SET @conf_type_list_id = LAST_INSERT_ID();
SET @conf_topic_list_id = LAST_INSERT_ID()+1;

INSERT INTO lookup_list_items (user_id, lookup_list_id, code, name, is_default) VALUES
(1, @conf_type_list_id, 'TECHNICAL', 'Technical', 1),
(1, @conf_type_list_id, 'EXTERNAL', 'External', 0),
(1, @conf_topic_list_id, 'ORGANIZATIONAL', 'Organizational', 1),
(1, @conf_topic_list_id, 'FINANCE', 'Finance', 0);
