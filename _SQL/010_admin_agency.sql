-- Seed permissions and role for managing agencies
INSERT INTO `admin_permissions` (`module`, `action`) VALUES
  ('agency', 'create'),
  ('agency', 'read'),
  ('agency', 'update'),
  ('agency', 'delete');

-- Create Manage Agency role
INSERT INTO `admin_roles` (`name`, `description`) VALUES ('Manage Agency', 'Can manage agency records');

-- Grant permissions to Manage Agency role (excluding delete)
INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM admin_roles r
JOIN admin_permissions p ON p.module = 'agency' AND p.action IN ('create','read','update')
WHERE r.name = 'Manage Agency';

-- Grant permissions to Admin role
INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM admin_roles r
JOIN admin_permissions p ON p.module = 'agency' AND p.action IN ('create','read','update','delete')
WHERE r.name = 'Admin';
