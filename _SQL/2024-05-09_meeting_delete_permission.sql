-- Ensure meeting delete permission exists and is assigned
INSERT INTO admin_permissions (user_id, user_updated, module, action)
SELECT 1, 1, 'meeting', 'delete'
WHERE NOT EXISTS (
  SELECT 1 FROM admin_permissions WHERE module='meeting' AND action='delete'
);

INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1, 1, pg.id, p.id
FROM admin_permission_groups pg
JOIN admin_permissions p ON p.module='meeting' AND p.action='delete'
WHERE pg.name='Meetings'
  AND NOT EXISTS (
    SELECT 1 FROM admin_permission_group_permissions g
    WHERE g.permission_group_id = pg.id AND g.permission_id = p.id
);

INSERT INTO admin_role_permissions (user_id, user_updated, role_id, permission_group_id)
SELECT 1, 1, r.id, pg.id
FROM admin_roles r
JOIN admin_permission_groups pg ON pg.name='Meetings'
WHERE r.name='Admin'
  AND NOT EXISTS (
    SELECT 1 FROM admin_role_permissions rp
    WHERE rp.role_id = r.id AND rp.permission_group_id = pg.id
);
