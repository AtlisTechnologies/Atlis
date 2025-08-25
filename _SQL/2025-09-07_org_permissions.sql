-- Seed permission groups and permissions for organization hierarchy

-- Permission groups
INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
SELECT 0,0,'Organization','Permissions for managing organizations'
WHERE NOT EXISTS (SELECT 1 FROM admin_permission_groups WHERE name='Organization');

INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
SELECT 0,0,'Agencies','Permissions for managing agencies'
WHERE NOT EXISTS (SELECT 1 FROM admin_permission_groups WHERE name='Agencies');

INSERT INTO admin_permission_groups (user_id, user_updated, name, description)
SELECT 0,0,'Division','Permissions for managing divisions'
WHERE NOT EXISTS (SELECT 1 FROM admin_permission_groups WHERE name='Division');

-- CRUD permissions
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'organization','create'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='organization' AND action='create');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'organization','read'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='organization' AND action='read');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'organization','update'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='organization' AND action='update');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'organization','delete'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='organization' AND action='delete');

INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'agency','create'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='agency' AND action='create');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'agency','read'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='agency' AND action='read');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'agency','update'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='agency' AND action='update');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'agency','delete'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='agency' AND action='delete');

INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'division','create'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='division' AND action='create');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'division','read'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='division' AND action='read');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'division','update'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='division' AND action='update');
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 0,0,'division','delete'
WHERE NOT EXISTS (SELECT 1 FROM admin_permissions WHERE module='division' AND action='delete');

-- Map permissions to groups
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 0,0,pg.id,p.id
FROM admin_permission_groups pg
JOIN admin_permissions p ON (
  (pg.name='Organization' AND p.module='organization') OR
  (pg.name='Agencies' AND p.module='agency') OR
  (pg.name='Division' AND p.module='division')
)
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permission_group_permissions x
  WHERE x.permission_group_id = pg.id AND x.permission_id = p.id
);
