-- Seed permissions and role for managing persons
INSERT INTO `admin_permissions` (`module`, `action`) VALUES
  ('person', 'create'),
  ('person', 'read'),
  ('person', 'update'),
  ('person', 'delete');

-- Create Manage Person role
INSERT INTO `admin_roles` (`name`, `description`) VALUES ('Manage Person', 'Can manage person records');

-- Grant permissions to Manage Person role (excluding delete)
INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM admin_roles r
JOIN admin_permissions p ON p.module = 'person' AND p.action IN ('create','read','update')
WHERE r.name = 'Manage Person';

-- Grant permissions to Admin role
INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM admin_roles r
JOIN admin_permissions p ON p.module = 'person' AND p.action IN ('create','read','update','delete')
WHERE r.name = 'Admin';
