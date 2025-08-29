-- Migration: Add RBAC entries for corporate features
-- Date: 2024-10-30

-- 1. Permission groups
INSERT INTO admin_permission_groups (user_id, user_updated, name, description) VALUES
  (1,1,'admin_accounting','Permissions for managing accounting'),
  (1,1,'admin_assets','Permissions for managing assets'),
  (1,1,'admin_human_resources','Permissions for managing human resources'),
  (1,1,'admin_prospecting','Permissions for managing prospecting');

-- 2. CRUD permissions
INSERT INTO admin_permissions (user_id, user_updated, module, action) VALUES
  (1,1,'admin_accounting','create'),
  (1,1,'admin_accounting','read'),
  (1,1,'admin_accounting','update'),
  (1,1,'admin_accounting','delete'),
  (1,1,'admin_assets','create'),
  (1,1,'admin_assets','read'),
  (1,1,'admin_assets','update'),
  (1,1,'admin_assets','delete'),
  (1,1,'admin_human_resources','create'),
  (1,1,'admin_human_resources','read'),
  (1,1,'admin_human_resources','update'),
  (1,1,'admin_human_resources','delete'),
  (1,1,'admin_prospecting','create'),
  (1,1,'admin_prospecting','read'),
  (1,1,'admin_prospecting','update'),
  (1,1,'admin_prospecting','delete');

-- 3. Link permissions to groups
INSERT INTO admin_permission_group_permissions (user_id, user_updated, permission_group_id, permission_id)
SELECT 1,1,pg.id,p.id
FROM admin_permission_groups pg
JOIN admin_permissions p ON p.module = pg.name
WHERE pg.name IN ('admin_accounting','admin_assets','admin_human_resources','admin_prospecting');

-- 4. Navigation links under Corporate
INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated) VALUES
  ('Accounting', 'corporate/accounting/index.php', 'dollar-sign', 19, 1, 1),
  ('Assets', 'corporate/assets/index.php', 'archive', 20, 1, 1),
  ('Human Resources', 'corporate/human-resources/index.php', 'users', 21, 1, 1),
  ('Prospecting', 'corporate/prospecting/index.php', 'search', 22, 1, 1);

-- 5. Grant groups to Corporate role
INSERT INTO admin_role_permission_groups (user_id, user_updated, role_id, permission_group_id)
SELECT 1,1,r.id, pg.id
FROM admin_roles r
JOIN admin_permission_groups pg ON pg.name IN ('admin_accounting','admin_assets','admin_human_resources','admin_prospecting')
WHERE r.name = 'Corporate';
