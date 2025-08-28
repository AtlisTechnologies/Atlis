START TRANSACTION;

-- RBAC for corporate notes
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
SELECT 1,1,'admin_corporate_notes','Permissions for corporate notes management'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permission_groups WHERE name='admin_corporate_notes'
);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_corporate_notes','create'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permissions WHERE module='admin_corporate_notes' AND action='create'
);
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_corporate_notes','read'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permissions WHERE module='admin_corporate_notes' AND action='read'
);
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_corporate_notes','update'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permissions WHERE module='admin_corporate_notes' AND action='update'
);
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_corporate_notes','delete'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permissions WHERE module='admin_corporate_notes' AND action='delete'
);

INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id
FROM admin_permission_groups pg
JOIN admin_permissions p ON p.module='admin_corporate_notes'
WHERE pg.name='admin_corporate_notes'
  AND NOT EXISTS (
    SELECT 1 FROM admin_permission_group_permissions gpp
    WHERE gpp.permission_group_id=pg.id AND gpp.permission_id=p.id
  );

INSERT INTO admin_role_permission_groups (user_id, user_updated, role_id, permission_group_id)
SELECT 1,1,1,pg.id
FROM admin_permission_groups pg
WHERE pg.name='admin_corporate_notes'
  AND NOT EXISTS (
    SELECT 1 FROM admin_role_permission_groups rpg
    WHERE rpg.role_id=1 AND rpg.permission_group_id=pg.id
  );

-- RBAC for corporate files
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
SELECT 1,1,'admin_corporate_files','Permissions for corporate files management'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permission_groups WHERE name='admin_corporate_files'
);

INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_corporate_files','create'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permissions WHERE module='admin_corporate_files' AND action='create'
);
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_corporate_files','read'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permissions WHERE module='admin_corporate_files' AND action='read'
);
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_corporate_files','update'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permissions WHERE module='admin_corporate_files' AND action='update'
);
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1,1,'admin_corporate_files','delete'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permissions WHERE module='admin_corporate_files' AND action='delete'
);

INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id
FROM admin_permission_groups pg
JOIN admin_permissions p ON p.module='admin_corporate_files'
WHERE pg.name='admin_corporate_files'
  AND NOT EXISTS (
    SELECT 1 FROM admin_permission_group_permissions gpp
    WHERE gpp.permission_group_id=pg.id AND gpp.permission_id=p.id
  );

INSERT INTO admin_role_permission_groups (user_id, user_updated, role_id, permission_group_id)
SELECT 1,1,1,pg.id
FROM admin_permission_groups pg
WHERE pg.name='admin_corporate_files'
  AND NOT EXISTS (
    SELECT 1 FROM admin_role_permission_groups rpg
    WHERE rpg.role_id=1 AND rpg.permission_group_id=pg.id
  );

COMMIT;
