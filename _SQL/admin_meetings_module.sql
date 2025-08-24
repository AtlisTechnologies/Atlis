-- Meetings navigation link
INSERT INTO `admin_navigation_links`
(`id`, `title`, `path`, `icon`, `sort_order`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`) VALUES
(11, 'Meetings', 'meetings/index.php', 'handshake', 10, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL);

-- Meetings permissions
INSERT INTO `admin_permissions`
(`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `module`, `action`) VALUES
(77, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'meeting', 'create'),
(78, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'meeting', 'read'),
(79, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'meeting', 'update'),
(80, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'meeting', 'delete');

-- Meetings permission group
INSERT INTO `admin_permission_groups`
(`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `description`) VALUES
(15, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'Meetings', 'Permissions for managing meetings');

-- Link permissions to Meetings group
INSERT INTO `admin_permission_group_permissions`
(`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `permission_group_id`, `permission_id`) VALUES
(77, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 15, 77),
(78, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 15, 78),
(79, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 15, 79),
(80, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 15, 80);
