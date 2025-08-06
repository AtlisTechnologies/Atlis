-- Seed permissions for managing users
INSERT INTO `admin_permissions` (`module`, `action`) VALUES
  ('users', 'create'),
  ('users', 'read'),
  ('users', 'update'),
  ('users', 'delete');

-- Grant permissions to the default Admin role
INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM admin_roles r
JOIN admin_permissions p ON p.module = 'users' AND p.action IN ('create','read','update','delete')
WHERE r.name = 'Admin';
