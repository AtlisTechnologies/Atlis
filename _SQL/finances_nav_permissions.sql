-- Add Finances navigation link
INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated)
VALUES ('Finances', 'finances/index.php', 'dollar-sign', 99, 1, 1);

-- Seed read permissions for finances and statements of work
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
(1,1,'finances','read'),
(1,1,'sow','read');

-- Link permissions to the Finances permission group if it exists
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p
  ON pg.name='Finances' AND p.module='finances' AND p.action='read';
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id FROM admin_permission_groups pg JOIN admin_permissions p
  ON pg.name='Finances' AND p.module='sow' AND p.action='read';
