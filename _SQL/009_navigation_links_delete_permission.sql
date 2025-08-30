-- Add delete permission for navigation links and map to Admin role
INSERT INTO admin_permissions (module, action, user_id, user_updated)
SELECT 'navigation_links','delete',1,1
WHERE NOT EXISTS (
    SELECT 1 FROM admin_permissions WHERE module='navigation_links' AND action='delete'
);

INSERT INTO admin_permission_groups (name, description, user_id, user_updated)
SELECT 'Navigation Links','Permissions for managing navigation links',1,1
WHERE NOT EXISTS (
    SELECT 1 FROM admin_permission_groups WHERE name='Navigation Links'
);

INSERT INTO admin_permission_group_permissions (permission_group_id, permission_id, user_id, user_updated)
SELECT g.id, p.id,1,1
FROM admin_permission_groups g
JOIN admin_permissions p ON p.module='navigation_links' AND p.action='delete'
WHERE g.name='Navigation Links'
AND NOT EXISTS (
    SELECT 1 FROM admin_permission_group_permissions WHERE permission_group_id=g.id AND permission_id=p.id
);

INSERT INTO admin_role_permission_groups (role_id, permission_group_id, user_id, user_updated)
SELECT r.id, g.id,1,1
FROM admin_roles r
JOIN admin_permission_groups g ON g.name='Navigation Links'
WHERE r.name IN ('Admin')
AND NOT EXISTS (
    SELECT 1 FROM admin_role_permission_groups WHERE role_id=r.id AND permission_group_id=g.id
);
