-- Branding navigation link
INSERT INTO `admin_navigation_links`
(`id`, `title`, `path`, `icon`, `sort_order`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`) VALUES
(10, 'Branding', 'branding/index.php', 'palette', 9, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL);

-- Branding permissions
INSERT INTO `admin_permissions`
(`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `module`, `action`) VALUES
(73, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 'branding', 'create'),
(74, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 'branding', 'read'),
(75, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 'branding', 'update'),
(76, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 'branding', 'delete');

-- Branding permission group
INSERT INTO `admin_permission_groups`
(`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `description`) VALUES
(14, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 'Branding', 'Permissions for managing branding');

-- Link permissions to Branding group
INSERT INTO `admin_permission_group_permissions`
(`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `permission_group_id`, `permission_id`) VALUES
(73, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 14, 73),
(74, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 14, 74),
(75, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 14, 75),
(76, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 14, 76);

-- Grant Branding group to roles (Super Admin and others)
INSERT INTO `admin_role_permission_groups`
(`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `role_id`, `permission_group_id`) VALUES
(42, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 1, 14),
(43, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 10, 14),
(44, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 11, 14),
(45, 1, 1, '2025-08-25 00:00:00', '2025-08-25 00:00:00', NULL, 12, 14);
