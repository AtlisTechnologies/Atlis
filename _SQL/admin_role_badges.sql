-- Lookup list for admin role badge colors
INSERT INTO lookup_lists (id, user_id, user_updated, name, description)
VALUES (10, 1, 1, 'ADMIN_ROLE_BADGES', 'Badge colors for admin roles');

INSERT INTO lookup_list_items (id, user_id, user_updated, list_id, label, code, active_from, active_to) VALUES
(29, 1, 1, 10, 'Admin', 'Admin', CURDATE(), NULL),
(30, 1, 1, 10, 'Manage Person', 'Manage Person', CURDATE(), NULL),
(31, 1, 1, 10, 'Manage Agency', 'Manage Agency', CURDATE(), NULL),
(32, 1, 1, 10, 'Manage Organization', 'Manage Organization', CURDATE(), NULL),
(33, 1, 1, 10, 'Manage Division', 'Manage Division', CURDATE(), NULL),
(34, 1, 1, 10, 'Manage System Properties', 'Manage System Properties', CURDATE(), NULL);

INSERT INTO lookup_list_item_attributes (id, user_id, user_updated, item_id, attr_code, attr_value) VALUES
(1, 1, 1, 29, 'COLOR-CLASS', 'danger'),
(2, 1, 1, 30, 'COLOR-CLASS', 'info'),
(3, 1, 1, 31, 'COLOR-CLASS', 'warning'),
(4, 1, 1, 32, 'COLOR-CLASS', 'success'),
(5, 1, 1, 33, 'COLOR-CLASS', 'primary'),
(6, 1, 1, 34, 'COLOR-CLASS', 'purple');
