-- CRUD permissions for calendar module
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
(1,1,'calendar','create'),
(1,1,'calendar','read'),
(1,1,'calendar','update'),
(1,1,'calendar','delete');

-- Attach permissions to Calendar group
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Calendar' AND p.module='calendar' AND p.action='create'
UNION ALL
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Calendar' AND p.module='calendar' AND p.action='read'
UNION ALL
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Calendar' AND p.module='calendar' AND p.action='update'
UNION ALL
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p ON pg.name='Calendar' AND p.module='calendar' AND p.action='delete';

-- Map Calendar group to appropriate roles
INSERT INTO admin_role_permission_groups (user_id, user_updated, role_id, permission_group_id)
SELECT 1,1,r.id,pg.id
FROM admin_roles r
JOIN admin_permission_groups pg ON pg.name='Calendar'
WHERE r.name IN ('Admin','Principle Project Manager','Project Manager','Developer');
