-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2025 at 04:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atlis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_audit_log`
--

CREATE TABLE `admin_audit_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `table_name` varchar(150) NOT NULL,
  `record_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `details` text DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_audit_log`
--

INSERT INTO `admin_audit_log` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `table_name`, `record_id`, `action`, `details`, `old_value`, `new_value`) VALUES
(1, 1, 1, '2025-08-12 19:46:44', '2025-08-12 19:46:44', NULL, 'admin_roles', 6, 'CREATE', 'Created role', NULL, '{\"name\":\"Manage System Properties\",\"description\":\"\"}'),
(2, 1, 1, '2025-08-13 16:46:02', '2025-08-13 16:46:02', NULL, 'admin_roles', 6, 'DELETE', 'Deleted role', NULL, NULL),
(3, 1, 1, '2025-08-13 23:34:27', '2025-08-13 23:34:27', NULL, 'module_projects_notes', 1, 'NOTE', '', '', 'First note.'),
(4, 1, 1, '2025-08-13 23:34:36', '2025-08-13 23:34:36', NULL, 'module_projects_files', 1, 'UPLOAD', '', '', '{\"file\":\"atlisware.png\"}'),
(5, 1, 1, '2025-08-13 23:48:42', '2025-08-13 23:48:42', NULL, 'module_projects', 2, 'CREATE', 'Created project', NULL, '{\"name\":\"Dave\",\"status\":\"29\",\"description\":\"\"}'),
(6, 1, 1, '2025-08-14 11:33:59', '2025-08-14 11:33:59', NULL, 'module_projects', 3, 'CREATE', 'Created project', NULL, '{\"name\":\"Emailing Sealed Documents\",\"status\":\"29\",\"description\":\"\"}'),
(7, 1, 1, '2025-08-14 15:21:21', '2025-08-14 15:21:21', NULL, 'module_projects_notes', 2, 'NOTE', '', '', 'From the First Note !'),
(8, 1, 1, '2025-08-14 16:43:46', '2025-08-14 16:43:46', NULL, 'module_projects', 4, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"1\",\"name\":\"Dave\",\"description\":\"Dave\",\"requirements\":\"Dave\",\"specifications\":\"Dave\",\"status\":\"29\",\"start_date\":\"2025-08-14\"}');

-- --------------------------------------------------------

--
-- Table structure for table `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `module` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `module`, `action`) VALUES
(1, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:06', NULL, 'users', 'create'),
(2, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:06', NULL, 'users', 'read'),
(3, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:06', NULL, 'users', 'update'),
(4, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:06', NULL, 'users', 'delete'),
(5, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:06', NULL, 'person', 'create'),
(6, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:06', NULL, 'person', 'read'),
(7, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:06', NULL, 'person', 'update'),
(8, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:06', NULL, 'person', 'delete'),
(9, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:06', NULL, 'agency', 'create'),
(10, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:06', NULL, 'agency', 'read'),
(11, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:06', NULL, 'agency', 'update'),
(12, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:06', NULL, 'agency', 'delete'),
(13, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'roles', 'create'),
(14, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'roles', 'read'),
(15, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'roles', 'update'),
(16, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'roles', 'delete'),
(17, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'organization', 'create'),
(18, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'organization', 'read'),
(19, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'organization', 'update'),
(20, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'organization', 'delete'),
(21, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'division', 'create'),
(22, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'division', 'read'),
(23, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'division', 'update'),
(24, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'division', 'delete'),
(25, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 'system_properties', 'create'),
(26, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 'system_properties', 'read'),
(27, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 'system_properties', 'update'),
(28, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 'system_properties', 'delete'),
(29, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'project', 'create'),
(30, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'project', 'read'),
(31, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'project', 'update'),
(32, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'project', 'delete'),
(33, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'task', 'create'),
(34, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'task', 'read'),
(35, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'task', 'update'),
(36, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'task', 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `description`) VALUES
(1, 1, 1, '2025-08-06 16:07:43', '2025-08-08 22:17:38', NULL, 'Admin', 'System administrator with full permissions'),
(2, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:38', NULL, 'Manage Person', 'Can manage person records'),
(3, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:38', NULL, 'Manage Agency', 'Can manage agency records'),
(4, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:38', NULL, 'Manage Organization', 'Can manage organization records'),
(5, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:38', NULL, 'Manage Division', 'Can manage division records'),
(7, 1, 1, '2025-08-13 16:30:13', '2025-08-13 16:32:16', NULL, 'Manage System Properties', 'Can manage system properties'),
(8, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'Manage Projects', 'Can manage project records'),
(9, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'Manage Tasks', 'Can manage task records');

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_permissions`
--

CREATE TABLE `admin_role_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_role_permissions`
--

INSERT INTO `admin_role_permissions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `role_id`, `permission_id`) VALUES
(1, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:53', NULL, 1, 1),
(2, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:53', NULL, 1, 4),
(3, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:53', NULL, 1, 2),
(4, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:53', NULL, 1, 3),
(8, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:53', NULL, 2, 5),
(9, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:53', NULL, 2, 6),
(10, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:53', NULL, 2, 7),
(11, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:53', NULL, 1, 5),
(12, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:53', NULL, 1, 8),
(13, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:53', NULL, 1, 6),
(14, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:53', NULL, 1, 7),
(18, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:53', NULL, 3, 9),
(19, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:53', NULL, 3, 10),
(20, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:53', NULL, 3, 11),
(21, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:53', NULL, 1, 9),
(22, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:53', NULL, 1, 12),
(23, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:53', NULL, 1, 10),
(24, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:53', NULL, 1, 11),
(28, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 13),
(29, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 16),
(30, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 14),
(31, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 15),
(32, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 17),
(33, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 20),
(34, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 18),
(35, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 19),
(36, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 21),
(37, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 24),
(38, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 22),
(39, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 1, 23),
(40, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 4, 17),
(41, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 4, 20),
(42, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 4, 18),
(43, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 4, 19),
(44, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 5, 21),
(45, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 5, 24),
(46, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 5, 22),
(47, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:53', NULL, 5, 23),
(48, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 1, 25),
(49, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 1, 28),
(50, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 1, 26),
(51, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 1, 27),
(55, 1, 1, '2025-08-13 16:30:13', '2025-08-13 16:30:13', NULL, 6, 25),
(56, 1, 1, '2025-08-13 16:30:13', '2025-08-13 16:30:13', NULL, 6, 28),
(57, 1, 1, '2025-08-13 16:30:13', '2025-08-13 16:30:13', NULL, 6, 26),
(58, 1, 1, '2025-08-13 16:30:13', '2025-08-13 16:30:13', NULL, 6, 27),
(59, 1, 1, '2025-08-13 16:30:13', '2025-08-13 16:30:13', NULL, 7, 25),
(60, 1, 1, '2025-08-13 16:30:13', '2025-08-13 16:30:13', NULL, 7, 28),
(61, 1, 1, '2025-08-13 16:30:13', '2025-08-13 16:30:13', NULL, 7, 26),
(62, 1, 1, '2025-08-13 16:30:13', '2025-08-13 16:30:13', NULL, 7, 27),
(63, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 8, 29),
(64, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 8, 30),
(65, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 8, 31),
(66, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 8, 32),
(67, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 1, 29),
(68, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 1, 30),
(69, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 1, 31),
(70, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 1, 32),
(71, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 9, 33),
(72, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 9, 34),
(73, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 9, 35),
(74, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 9, 36),
(75, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 1, 33),
(76, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 1, 34),
(77, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 1, 35),
(78, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 1, 36);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_roles`
--

CREATE TABLE `admin_user_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `user_account_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user_roles`
--

INSERT INTO `admin_user_roles` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `user_account_id`, `role_id`) VALUES
(1, 1, 1, '2025-08-07 00:47:07', '2025-08-12 19:38:55', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `table_name` varchar(150) NOT NULL,
  `record_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `table_name`, `record_id`, `action`, `details`) VALUES
(1, 1, 1, '2025-08-13 16:43:57', '2025-08-13 16:43:57', NULL, 'lookup_lists', 8, 'UPDATE', 'Updated lookup list'),
(2, 1, 1, '2025-08-13 16:44:21', '2025-08-13 16:44:21', NULL, 'lookup_lists', 9, 'UPDATE', 'Updated lookup list'),
(3, 1, 1, '2025-08-13 16:44:53', '2025-08-13 16:44:53', NULL, 'lookup_lists', 8, 'UPDATE', 'Updated lookup list'),
(4, 1, 1, '2025-08-13 16:45:03', '2025-08-13 16:45:03', NULL, 'lookup_lists', 9, 'UPDATE', 'Updated lookup list'),
(5, 1, 1, '2025-08-13 21:13:45', '2025-08-13 21:13:45', NULL, 'lookup_list_item_attributes', 2, 'CREATE', 'Created item attribute'),
(6, 1, 1, '2025-08-13 21:37:35', '2025-08-13 21:37:35', NULL, 'lookup_list_item_attributes', 3, 'CREATE', 'Created item attribute'),
(7, 1, 1, '2025-08-13 21:37:48', '2025-08-13 21:37:48', NULL, 'lookup_list_item_attributes', 4, 'CREATE', 'Created item attribute'),
(8, 1, 1, '2025-08-13 21:38:05', '2025-08-13 21:38:05', NULL, 'lookup_list_item_attributes', 5, 'CREATE', 'Created item attribute'),
(9, 1, 1, '2025-08-13 21:38:13', '2025-08-13 21:38:13', NULL, 'lookup_list_item_attributes', 6, 'CREATE', 'Created item attribute'),
(10, 1, 1, '2025-08-13 21:38:34', '2025-08-13 21:38:34', NULL, 'lookup_list_item_attributes', 7, 'CREATE', 'Created item attribute'),
(11, 1, 1, '2025-08-13 21:44:09', '2025-08-13 21:44:09', NULL, 'lookup_list_item_attributes', 8, 'CREATE', 'Created item attribute'),
(12, 1, 1, '2025-08-13 21:44:18', '2025-08-13 21:44:18', NULL, 'lookup_list_item_attributes', 9, 'CREATE', 'Created item attribute'),
(13, 1, 1, '2025-08-13 21:46:02', '2025-08-13 21:46:02', NULL, 'lookup_list_item_attributes', 9, 'DELETE', 'Deleted item attribute'),
(14, 1, 1, '2025-08-13 22:08:42', '2025-08-13 22:08:42', NULL, 'lookup_lists', 10, 'CREATE', 'Created lookup list'),
(15, 1, 1, '2025-08-13 22:09:01', '2025-08-13 22:09:01', NULL, 'lookup_list_items', 33, 'CREATE', 'Created lookup list item'),
(16, 1, 1, '2025-08-13 22:11:06', '2025-08-13 22:11:06', NULL, 'lookup_list_item_attributes', 10, 'CREATE', 'Created item attribute'),
(17, 1, 1, '2025-08-13 22:20:03', '2025-08-13 22:20:03', NULL, 'lookup_list_item_attributes', 17, 'CREATE', 'Created item attribute'),
(18, 1, 1, '2025-08-13 22:20:15', '2025-08-13 22:20:15', NULL, 'lookup_list_item_attributes', 18, 'CREATE', 'Created item attribute'),
(19, 1, 1, '2025-08-13 22:20:22', '2025-08-13 22:20:22', NULL, 'lookup_list_item_attributes', 19, 'CREATE', 'Created item attribute'),
(20, 1, 1, '2025-08-13 22:28:51', '2025-08-13 22:28:51', NULL, 'lookup_lists', 12, 'CREATE', 'Created lookup list'),
(21, 1, 1, '2025-08-13 22:29:14', '2025-08-13 22:29:14', NULL, 'lookup_list_items', 40, 'CREATE', 'Created lookup list item'),
(22, 1, 1, '2025-08-13 22:30:05', '2025-08-13 22:30:05', NULL, 'lookup_list_items', 36, 'DELETE', 'Deleted lookup list item'),
(23, 1, 1, '2025-08-13 22:30:08', '2025-08-13 22:30:08', NULL, 'lookup_list_items', 38, 'DELETE', 'Deleted lookup list item'),
(24, 1, 1, '2025-08-13 22:30:09', '2025-08-13 22:30:09', NULL, 'lookup_list_items', 37, 'DELETE', 'Deleted lookup list item'),
(25, 1, 1, '2025-08-13 22:30:09', '2025-08-13 22:30:09', NULL, 'lookup_list_items', 35, 'DELETE', 'Deleted lookup list item'),
(26, 1, 1, '2025-08-13 22:30:10', '2025-08-13 22:30:10', NULL, 'lookup_list_items', 39, 'DELETE', 'Deleted lookup list item'),
(27, 1, 1, '2025-08-13 22:30:49', '2025-08-13 22:30:49', NULL, 'lookup_list_item_attributes', 20, 'CREATE', 'Created item attribute'),
(28, 1, 1, '2025-08-13 22:31:01', '2025-08-13 22:31:01', NULL, 'lookup_list_items', 40, 'DELETE', 'Deleted lookup list item'),
(29, 1, 1, '2025-08-13 22:31:17', '2025-08-13 22:31:17', NULL, 'lookup_lists', 11, 'DELETE', 'Deleted lookup list'),
(30, 1, 1, '2025-08-13 22:31:42', '2025-08-13 22:31:42', NULL, 'lookup_list_items', 41, 'CREATE', 'Created lookup list item'),
(31, 1, 1, '2025-08-13 22:36:04', '2025-08-13 22:36:04', NULL, 'lookup_list_items', 42, 'CREATE', 'Created lookup list item'),
(32, 1, 1, '2025-08-13 22:36:34', '2025-08-13 22:36:34', NULL, 'lookup_list_item_attributes', 21, 'CREATE', 'Created item attribute'),
(33, 1, 1, '2025-08-13 22:36:48', '2025-08-13 22:36:48', NULL, 'lookup_list_item_attributes', 22, 'CREATE', 'Created item attribute'),
(34, 1, 1, '2025-08-13 22:38:51', '2025-08-13 22:38:51', NULL, 'lookup_list_items', 43, 'CREATE', 'Created lookup list item'),
(35, 1, 1, '2025-08-13 22:41:14', '2025-08-13 22:41:14', NULL, 'lookup_list_items', 44, 'CREATE', 'Created lookup list item'),
(36, 1, 1, '2025-08-13 22:42:01', '2025-08-13 22:42:01', NULL, 'lookup_list_items', 45, 'CREATE', 'Created lookup list item'),
(37, 1, 1, '2025-08-13 22:45:22', '2025-08-13 22:45:22', NULL, 'lookup_list_items', 46, 'CREATE', 'Created lookup list item'),
(38, 1, 1, '2025-08-13 22:46:17', '2025-08-13 22:46:17', NULL, 'lookup_list_items', 47, 'CREATE', 'Created lookup list item'),
(39, 1, 1, '2025-08-13 22:46:34', '2025-08-13 22:46:34', NULL, 'lookup_list_items', 48, 'CREATE', 'Created lookup list item'),
(40, 1, 1, '2025-08-13 23:38:55', '2025-08-13 23:38:55', NULL, 'lookup_list_item_attributes', 23, 'CREATE', 'Created item attribute'),
(41, 1, 1, '2025-08-13 23:39:07', '2025-08-13 23:39:07', NULL, 'lookup_list_item_attributes', 24, 'CREATE', 'Created item attribute'),
(42, 1, 1, '2025-08-13 23:39:14', '2025-08-13 23:39:14', NULL, 'lookup_list_item_attributes', 25, 'CREATE', 'Created item attribute'),
(43, 1, 1, '2025-08-13 23:39:19', '2025-08-13 23:39:19', NULL, 'lookup_list_item_attributes', 26, 'CREATE', 'Created item attribute'),
(44, 1, 1, '2025-08-13 23:39:33', '2025-08-13 23:39:33', NULL, 'lookup_list_item_attributes', 27, 'CREATE', 'Created item attribute'),
(45, 1, 1, '2025-08-13 23:39:38', '2025-08-13 23:39:38', NULL, 'lookup_list_item_attributes', 15, 'DELETE', 'Deleted item attribute'),
(46, 1, 1, '2025-08-13 23:39:49', '2025-08-13 23:39:49', NULL, 'lookup_list_item_attributes', 13, 'UPDATE', 'Updated item attribute'),
(47, 1, 1, '2025-08-13 23:54:56', '2025-08-13 23:54:56', NULL, 'lookup_list_items', 49, 'CREATE', 'Created lookup list item'),
(48, 1, 1, '2025-08-13 23:55:07', '2025-08-13 23:55:07', NULL, 'lookup_list_items', 49, 'DELETE', 'Deleted lookup list item'),
(49, 1, 1, '2025-08-14 16:48:59', '2025-08-14 16:48:59', NULL, 'lookup_list_item_attributes', 28, 'CREATE', 'Created item attribute'),
(50, 1, 1, '2025-08-14 16:50:26', '2025-08-14 16:50:26', NULL, 'lookup_list_item_attributes', 29, 'CREATE', 'Created item attribute'),
(51, 1, 1, '2025-08-14 16:50:40', '2025-08-14 16:50:40', NULL, 'lookup_list_item_attributes', 29, 'DELETE', 'Deleted item attribute'),
(52, 1, 1, '2025-08-14 16:52:01', '2025-08-14 16:52:01', NULL, 'lookup_lists', 13, 'CREATE', 'Created lookup list'),
(53, 1, 1, '2025-08-14 16:52:09', '2025-08-14 16:52:09', NULL, 'lookup_list_items', 50, 'CREATE', 'Created lookup list item'),
(54, 1, 1, '2025-08-14 16:52:32', '2025-08-14 16:52:32', NULL, 'lookup_list_items', 50, 'DELETE', 'Deleted lookup list item'),
(55, 1, 1, '2025-08-14 16:52:35', '2025-08-14 16:52:35', NULL, 'lookup_lists', 13, 'DELETE', 'Deleted lookup list'),
(56, 1, 1, '2025-08-14 17:16:47', '2025-08-14 17:16:47', NULL, 'lookup_list_items', 51, 'CREATE', 'Created lookup list item'),
(57, 1, 1, '2025-08-14 17:16:54', '2025-08-14 17:16:54', NULL, 'lookup_list_items', 52, 'CREATE', 'Created lookup list item'),
(58, 1, 1, '2025-08-14 17:18:21', '2025-08-14 17:18:21', NULL, 'lookup_list_items', 53, 'CREATE', 'Created lookup list item'),
(59, 1, 1, '2025-08-14 20:46:43', '2025-08-14 20:46:43', NULL, 'lookup_list_item_attributes', 30, 'CREATE', 'Created item attribute'),
(60, 1, 1, '2025-08-14 20:46:48', '2025-08-14 20:46:48', NULL, 'lookup_list_item_attributes', 30, 'DELETE', 'Deleted item attribute'),
(61, 1, 1, '2025-08-14 20:47:55', '2025-08-14 20:47:55', NULL, 'lookup_list_items', 54, 'CREATE', 'Created lookup list item'),
(62, 1, 1, '2025-08-14 20:48:19', '2025-08-14 20:48:19', NULL, 'lookup_list_item_attributes', 31, 'CREATE', 'Created item attribute');

-- --------------------------------------------------------

--
-- Table structure for table `lookup_lists`
--

CREATE TABLE `lookup_lists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lookup_lists`
--

INSERT INTO `lookup_lists` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `description`) VALUES
(1, 1, 1, '2025-08-06 16:07:33', '2025-08-08 21:54:43', NULL, 'ORGANIZATION_STATUS', 'Status values for organizations'),
(2, 1, 1, '2025-08-06 16:07:33', '2025-08-08 21:54:44', NULL, 'AGENCY_STATUS', 'Status values for agencies'),
(3, 1, 1, '2025-08-06 16:07:33', '2025-08-08 21:54:46', NULL, 'DIVISION_STATUS', 'Status values for divisions'),
(4, 1, 1, '2025-08-06 20:13:08', '2025-08-08 21:54:50', NULL, 'USER_TYPE', ''),
(5, 1, 1, '2025-08-06 20:13:16', '2025-08-08 21:54:52', NULL, 'USER_STATUS', ''),
(7, 1, 1, '2025-08-06 20:26:02', '2025-08-08 21:54:55', NULL, 'LOOKUP_LIST_ITEM_ATTRIBUTES', ''),
(8, 1, 1, '2025-08-13 16:28:53', '2025-08-13 17:58:01', NULL, 'SYSTEM_PROPERTIES_CATEGORIES', 'Categories for system properties'),
(9, 1, 1, '2025-08-13 16:28:53', '2025-08-13 17:57:58', NULL, 'SYSTEM_PROPERTIES_TYPES', 'Data types for system properties'),
(10, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'PROJECT_STATUS', 'Status values for projects'),
(11, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'TASK_STATUS', 'Status values for tasks'),
(12, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'TASK_PRIORITY', 'Priority levels for tasks');

-- --------------------------------------------------------

--
-- Table structure for table `lookup_list_items`
--

CREATE TABLE `lookup_list_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `list_id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `active_from` date DEFAULT curdate(),
  `active_to` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lookup_list_items`
--

INSERT INTO `lookup_list_items` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `list_id`, `label`, `code`, `sort_order`, `active_from`, `active_to`) VALUES
(1, 1, 1, '2025-08-06 16:07:33', '2025-08-08 22:15:24', NULL, 1, 'Active', 'ACTIVE', 1, '2025-08-13', NULL),
(2, 1, 1, '2025-08-06 16:07:33', '2025-08-08 22:15:35', NULL, 1, 'Inactive', 'INACTIVE', 2, '2025-08-13', NULL),
(3, 1, 1, '2025-08-06 16:07:33', '2025-08-08 22:14:47', NULL, 2, 'Active', 'ACTIVE', 1, '2025-08-13', NULL),
(4, 1, 1, '2025-08-06 16:07:33', '2025-08-08 22:14:59', NULL, 2, 'Inactive', 'INACTIVE', 2, '2025-08-13', NULL),
(5, 1, 1, '2025-08-06 16:07:33', '2025-08-08 21:58:45', NULL, 3, 'Active', 'ACTIVE', 1, '2025-08-13', NULL),
(6, 1, 1, '2025-08-06 16:07:33', '2025-08-08 21:59:22', NULL, 3, 'Inactive', 'INACTIVE', 2, '2025-08-13', NULL),
(7, 1, 1, '2025-08-06 20:13:30', '2025-08-06 20:13:46', NULL, 5, 'Active', 'ACTIVE', 1, '2025-08-13', NULL),
(8, 1, 1, '2025-08-06 20:13:41', '2025-08-06 20:13:41', NULL, 5, 'Inactive', 'INACTIVE', 2, '2025-08-13', NULL),
(9, 1, 1, '2025-08-06 20:13:58', '2025-08-06 20:13:58', NULL, 4, 'Admin', 'ADMIN', 1, '2025-08-13', NULL),
(10, 1, 1, '2025-08-06 20:14:03', '2025-08-06 20:14:03', NULL, 4, 'User', 'USER', 2, '2025-08-13', NULL),
(11, 1, 1, '2025-08-06 20:26:20', '2025-08-06 20:26:20', NULL, 7, 'Default', 'DEFAULT', 1, '2025-08-13', NULL),
(12, 1, 1, '2025-08-06 20:26:38', '2025-08-06 20:26:38', NULL, 7, 'Color / Class', 'COLOR-CLASS', 2, '2025-08-13', NULL),
(13, 1, 1, '2025-08-08 22:02:51', '2025-08-08 22:02:51', NULL, 1, 'Pending', 'PENDING', 3, '2025-08-13', NULL),
(27, 1, 1, '2025-08-08 22:14:28', '2025-08-08 22:14:28', NULL, 3, 'Pending', 'PENDING', 3, '2025-08-13', NULL),
(28, 1, 1, '2025-08-08 22:14:38', '2025-08-08 22:14:38', NULL, 2, 'Pending', 'PENDING', 3, '2025-08-13', NULL),
(29, 1, 1, '2025-08-14 00:00:00', '2025-08-13 23:38:23', NULL, 10, 'Active', 'ACTIVE', 1, '2025-08-13', NULL),
(30, 1, 1, '2025-08-14 00:00:00', '2025-08-13 23:38:23', NULL, 10, 'On Hold', 'ON_HOLD', 2, '2025-08-13', NULL),
(31, 1, 1, '2025-08-14 00:00:00', '2025-08-13 23:38:23', NULL, 10, 'Completed', 'COMPLETED', 3, '2025-08-13', NULL),
(32, 1, 1, '2025-08-14 00:00:00', '2025-08-13 23:38:23', NULL, 11, 'Active', 'ACTIVE', 1, '2025-08-13', NULL),
(33, 1, 1, '2025-08-14 00:00:00', '2025-08-13 23:38:23', NULL, 11, 'On Hold', 'ON_HOLD', 2, '2025-08-13', NULL),
(34, 1, 1, '2025-08-14 00:00:00', '2025-08-13 23:38:23', NULL, 11, 'Completed', 'COMPLETED', 3, '2025-08-13', NULL),
(35, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 11, 'Backlog', 'BACKLOG', 4, '2025-08-14', NULL),
(37, 1, 1, '2025-08-14 00:00:00', '2025-08-13 23:38:23', NULL, 12, 'Low', 'LOW', 1, '2025-08-13', NULL),
(38, 1, 1, '2025-08-14 00:00:00', '2025-08-13 23:38:23', NULL, 12, 'Medium', 'MEDIUM', 2, '2025-08-13', NULL),
(39, 1, 1, '2025-08-14 00:00:00', '2025-08-13 23:38:23', NULL, 12, 'High', 'HIGH', 3, '2025-08-13', NULL),
(40, 1, 1, '2025-08-14 00:00:00', '2025-08-13 23:38:23', NULL, 12, 'Critical', 'CRITICAL', 4, '2025-08-13', NULL),
(51, 1, 1, '2025-08-14 17:16:47', '2025-08-14 17:16:47', NULL, 8, 'System', 'SYSTEM', 1, '2025-08-14', NULL),
(52, 1, 1, '2025-08-14 17:16:54', '2025-08-14 17:16:54', NULL, 8, 'Business', 'BUSINESS', 2, '2025-08-14', NULL),
(53, 1, 1, '2025-08-14 17:18:21', '2025-08-14 17:18:21', NULL, 9, 'System', 'SYSTEM', 1, '2025-08-14', NULL),
(54, 1, 1, '2025-08-14 20:47:55', '2025-08-14 20:47:55', NULL, 9, 'Business', 'BUSINESS', 0, '2025-08-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lookup_list_item_attributes`
--

CREATE TABLE `lookup_list_item_attributes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `attr_code` varchar(100) NOT NULL,
  `attr_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lookup_list_item_attributes`
--

INSERT INTO `lookup_list_item_attributes` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `item_id`, `attr_code`, `attr_value`) VALUES
(2, 1, 1, '2025-08-13 21:13:45', '2025-08-13 21:13:45', NULL, 7, 'COLOR-CLASS', 'success'),
(3, 1, 1, '2025-08-13 21:37:35', '2025-08-13 21:37:35', NULL, 1, 'COLOR-CLASS', 'success'),
(4, 1, 1, '2025-08-13 21:37:48', '2025-08-13 21:37:48', NULL, 5, 'COLOR-CLASS', 'success'),
(5, 1, 1, '2025-08-13 21:38:05', '2025-08-13 21:38:05', NULL, 2, 'COLOR-CLASS', 'danger'),
(6, 1, 1, '2025-08-13 21:38:13', '2025-08-13 21:38:13', NULL, 13, 'COLOR-CLASS', 'warning'),
(7, 1, 1, '2025-08-13 21:38:34', '2025-08-13 21:38:34', NULL, 9, 'COLOR-CLASS', 'atlis'),
(8, 1, 1, '2025-08-13 21:44:09', '2025-08-13 21:44:09', NULL, 10, 'COLOR-CLASS', 'primary'),
(10, 1, 1, '2025-08-13 22:11:06', '2025-08-13 22:11:06', NULL, 29, 'COLOR-CLASS', 'success'),
(11, 1, 1, '2025-08-13 22:16:23', '2025-08-13 22:16:23', NULL, 30, 'COLOR-CLASS', 'warning'),
(12, 1, 1, '2025-08-13 22:16:23', '2025-08-13 22:16:23', NULL, 31, 'COLOR-CLASS', 'primary'),
(13, 1, 1, '2025-08-13 22:16:23', '2025-08-13 23:39:49', NULL, 32, 'COLOR-CLASS', 'primary'),
(14, 1, 1, '2025-08-13 22:16:23', '2025-08-13 22:16:23', NULL, 33, 'COLOR-CLASS', 'warning'),
(17, 1, 1, '2025-08-13 22:20:03', '2025-08-13 22:20:03', NULL, 3, 'COLOR-CLASS', 'success'),
(18, 1, 1, '2025-08-13 22:20:15', '2025-08-13 22:20:15', NULL, 4, 'COLOR-CLASS', 'danger'),
(19, 1, 1, '2025-08-13 22:20:22', '2025-08-13 22:20:22', NULL, 28, 'COLOR-CLASS', 'warning'),
(21, 1, 1, '2025-08-13 22:36:34', '2025-08-13 22:36:34', NULL, 41, 'COLOR-CLASS', 'success'),
(22, 1, 1, '2025-08-13 22:36:48', '2025-08-13 22:36:48', NULL, 42, 'COLOR-CLASS', 'danger'),
(23, 1, 1, '2025-08-13 23:38:55', '2025-08-13 23:38:55', NULL, 40, 'COLOR-CLASS', 'danger'),
(24, 1, 1, '2025-08-13 23:39:07', '2025-08-13 23:39:07', NULL, 39, 'COLOR-CLASS', 'danger'),
(25, 1, 1, '2025-08-13 23:39:14', '2025-08-13 23:39:14', NULL, 37, 'COLOR-CLASS', 'primary'),
(26, 1, 1, '2025-08-13 23:39:19', '2025-08-13 23:39:19', NULL, 38, 'COLOR-CLASS', 'warning'),
(27, 1, 1, '2025-08-13 23:39:33', '2025-08-13 23:39:33', NULL, 34, 'COLOR-CLASS', 'success'),
(28, 1, 1, '2025-08-14 16:48:59', '2025-08-14 16:48:59', NULL, 8, 'COLOR-CLASS', 'danger'),
(31, 1, 1, '2025-08-14 20:48:19', '2025-08-14 20:48:19', NULL, 54, 'TEST', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `module_agency`
--

CREATE TABLE `module_agency` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `organization_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `main_person` int(11) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_agency`
--

INSERT INTO `module_agency` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `organization_id`, `name`, `main_person`, `status`, `file_name`, `file_path`, `file_size`, `file_type`) VALUES
(1, 1, 1, '2025-08-06 16:27:31', '2025-08-08 21:56:30', NULL, 1, 'Atlis Technologies', 1, '3', 'main_logo_dark_bg.png', '/module/agency/uploads/agency_1.png', 67568, 'image/png'),
(2, 1, 1, '2025-08-06 16:28:14', '2025-08-08 21:56:34', NULL, 2, '19th Circuit Court', NULL, '3', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_division`
--

CREATE TABLE `module_division` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `agency_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `main_person` int(11) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_division`
--

INSERT INTO `module_division` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `agency_id`, `name`, `main_person`, `status`) VALUES
(1, 1, 1, '2025-08-06 16:27:41', '2025-08-08 21:58:10', NULL, 1, 'Atlis', 1, '5'),
(2, 1, 1, '2025-08-06 16:28:28', '2025-08-08 21:58:10', NULL, 2, 'Judicial Information Services & Technology', NULL, '5'),
(3, 1, 1, '2025-08-06 16:28:37', '2025-08-08 21:58:10', NULL, 2, 'Business Operations', NULL, '5'),
(4, 1, 1, '2025-08-06 16:28:48', '2025-08-08 21:58:10', NULL, 2, 'Court Clerks', NULL, '5');

-- --------------------------------------------------------

--
-- Table structure for table `module_organization`
--

CREATE TABLE `module_organization` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `main_person` int(11) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_organization`
--

INSERT INTO `module_organization` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `main_person`, `status`) VALUES
(1, 1, 1, '2025-08-06 16:27:19', '2025-08-08 22:19:06', NULL, 'Atlis Technologies LLC', 1, '1'),
(2, 1, 1, '2025-08-06 16:27:55', '2025-08-08 22:19:06', NULL, 'Lake County, IL', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `module_projects`
--

CREATE TABLE `module_projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `specifications` text DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects`
--

INSERT INTO `module_projects` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `agency_id`, `division_id`, `name`, `description`, `requirements`, `specifications`, `status`, `start_date`, `complete_date`, `completed`) VALUES
(3, 1, 1, '2025-08-14 11:33:59', '2025-08-14 11:33:59', NULL, NULL, NULL, 'Emailing Sealed Documents', '', NULL, NULL, '29', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_projects_files`
--

CREATE TABLE `module_projects_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_projects_notes`
--

CREATE TABLE `module_projects_notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `note_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_projects_users`
--

CREATE TABLE `module_projects_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `assigned_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_tasks`
--

CREATE TABLE `module_tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `specifications` text DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `priority` varchar(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `completed` tinyint(1) DEFAULT 0,
  `progress_percent` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_tasks_files`
--

CREATE TABLE `module_tasks_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_tasks_notes`
--

CREATE TABLE `module_tasks_notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `note_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_task_assignments`
--

CREATE TABLE `module_task_assignments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `assigned_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `user_id`, `first_name`, `last_name`, `user_updated`, `date_created`, `date_updated`, `memo`) VALUES
(1, 1, 'Dave', 'Wilkins', 1, '2025-08-08 21:52:52', '2025-08-08 21:52:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_properties`
--

CREATE TABLE `system_properties` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_properties`
--

INSERT INTO `system_properties` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `category_id`, `name`, `value`, `type_id`, `description`) VALUES
(1, 1, 1, '2025-08-13 16:28:53', '2025-08-13 16:28:53', NULL, 30, 'logo', '/assets/logo.png', 32, 'Default site logo');

-- --------------------------------------------------------

--
-- Table structure for table `system_properties_versions`
--

CREATE TABLE `system_properties_versions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `property_id` int(11) NOT NULL,
  `version_number` int(11) NOT NULL,
  `previous_value` text DEFAULT NULL,
  `metadata` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_properties_versions`
--

INSERT INTO `system_properties_versions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `property_id`, `version_number`, `previous_value`, `metadata`) VALUES
(1, 1, 1, '2025-08-13 16:28:53', '2025-08-13 16:28:53', NULL, 1, 1, '/assets/logo.png', 'Initial version');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `profile_pic` varchar(255) DEFAULT NULL,
  `type` enum('ADMIN','USER') DEFAULT 'USER',
  `status` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `username`, `email`, `password`, `email_verified`, `profile_pic`, `type`, `status`, `last_login`) VALUES
(1, 1, 1, '2025-08-06 16:08:42', '2025-08-12 19:47:55', NULL, 'dave@atlistechnologies.com', 'dave@atlistechnologies.com', '$2y$10$WGm3X9R063fNQ6Nw1Fy4GO7k8ulP9EjusL8.TFtp3xiz7YU1.E5Lq', 1, 'dave_2.JPG', 'ADMIN', 1, '2025-08-12 15:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `users_2fa`
--

CREATE TABLE `users_2fa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `code` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_2fa`
--

INSERT INTO `users_2fa` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `code`, `expires_at`, `used`) VALUES
(1, 1, 1, '2025-08-08 21:31:59', '2025-08-08 21:32:02', NULL, '130195', '2025-08-08 21:41:59', 1),
(2, 1, 1, '2025-08-12 15:42:05', '2025-08-12 15:42:08', NULL, '810773', '2025-08-12 15:52:05', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_audit_log`
--
ALTER TABLE `admin_audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_audit_log_user_id` (`user_id`),
  ADD KEY `fk_admin_audit_log_user_updated` (`user_updated`);

--
-- Indexes for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_admin_permissions_module_action` (`module`,`action`),
  ADD KEY `fk_admin_permissions_user_id` (`user_id`),
  ADD KEY `fk_admin_permissions_user_updated` (`user_updated`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_roles_user_id` (`user_id`),
  ADD KEY `fk_admin_roles_user_updated` (`user_updated`);

--
-- Indexes for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_admin_role_permissions_role_permission` (`role_id`,`permission_id`),
  ADD KEY `fk_admin_role_permissions_user_id` (`user_id`),
  ADD KEY `fk_admin_role_permissions_user_updated` (`user_updated`),
  ADD KEY `fk_admin_role_permissions_role_id` (`role_id`),
  ADD KEY `fk_admin_role_permissions_permission_id` (`permission_id`);

--
-- Indexes for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_admin_user_roles_user_role` (`user_account_id`,`role_id`),
  ADD KEY `fk_admin_user_roles_user_id` (`user_id`),
  ADD KEY `fk_admin_user_roles_user_updated` (`user_updated`),
  ADD KEY `fk_admin_user_roles_user_account_id` (`user_account_id`),
  ADD KEY `fk_admin_user_roles_role_id` (`role_id`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_module_lookup_lists_name` (`name`),
  ADD KEY `fk_module_lookup_lists_user_id` (`user_id`),
  ADD KEY `fk_module_lookup_lists_user_updated` (`user_updated`);

--
-- Indexes for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_lookup_list_items_label` (`list_id`,`label`),
  ADD UNIQUE KEY `uq_lookup_list_items_code` (`list_id`,`code`),
  ADD KEY `fk_module_lookup_list_items_list_id` (`list_id`),
  ADD KEY `fk_module_lookup_list_items_user_id` (`user_id`),
  ADD KEY `fk_module_lookup_list_items_user_updated` (`user_updated`),
  ADD KEY `idx_module_lookup_list_items_label` (`label`);

--
-- Indexes for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_lookup_item_attr` (`item_id`,`attr_code`),
  ADD KEY `fk_module_lookup_item_attributes_item_id` (`item_id`),
  ADD KEY `fk_module_lookup_item_attributes_user_id` (`user_id`),
  ADD KEY `fk_module_lookup_item_attributes_user_updated` (`user_updated`),
  ADD KEY `idx_module_lookup_item_attributes_key` (`attr_code`);

--
-- Indexes for table `module_agency`
--
ALTER TABLE `module_agency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_agency_user_id` (`user_id`),
  ADD KEY `fk_module_agency_user_updated` (`user_updated`),
  ADD KEY `fk_module_agency_organization_id` (`organization_id`),
  ADD KEY `fk_module_agency_main_person` (`main_person`),
  ADD KEY `fk_module_agency_status` (`status`);

--
-- Indexes for table `module_division`
--
ALTER TABLE `module_division`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_division_user_id` (`user_id`),
  ADD KEY `fk_module_division_user_updated` (`user_updated`),
  ADD KEY `fk_module_division_agency_id` (`agency_id`),
  ADD KEY `fk_module_division_main_person` (`main_person`),
  ADD KEY `fk_module_division_status` (`status`);

--
-- Indexes for table `module_organization`
--
ALTER TABLE `module_organization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_organization_user_id` (`user_id`),
  ADD KEY `fk_module_organization_user_updated` (`user_updated`),
  ADD KEY `fk_module_organization_main_person` (`main_person`),
  ADD KEY `fk_module_organization_status` (`status`);

--
-- Indexes for table `module_projects`
--
ALTER TABLE `module_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_projects_user_id` (`user_id`),
  ADD KEY `fk_module_projects_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_agency_id` (`agency_id`),
  ADD KEY `fk_module_projects_division_id` (`division_id`),
  ADD KEY `fk_module_projects_status` (`status`);

--
-- Indexes for table `module_projects_files`
--
ALTER TABLE `module_projects_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_projects_files_user_id` (`user_id`),
  ADD KEY `fk_module_projects_files_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_files_project_id` (`project_id`);

--
-- Indexes for table `module_projects_notes`
--
ALTER TABLE `module_projects_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_projects_notes_user_id` (`user_id`),
  ADD KEY `fk_module_projects_notes_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_notes_project_id` (`project_id`);

--
-- Indexes for table `module_projects_users`
--
ALTER TABLE `module_projects_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_projects_users_user_id` (`user_id`),
  ADD KEY `fk_module_projects_users_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_users_project_id` (`project_id`),
  ADD KEY `fk_module_projects_users_assigned_user_id` (`assigned_user_id`);

--
-- Indexes for table `module_tasks`
--
ALTER TABLE `module_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_tasks_user_id` (`user_id`),
  ADD KEY `fk_module_tasks_user_updated` (`user_updated`),
  ADD KEY `fk_module_tasks_project_id` (`project_id`),
  ADD KEY `fk_module_tasks_agency_id` (`agency_id`),
  ADD KEY `fk_module_tasks_division_id` (`division_id`),
  ADD KEY `fk_module_tasks_status` (`status`),
  ADD KEY `fk_module_tasks_priority` (`priority`);

--
-- Indexes for table `module_tasks_files`
--
ALTER TABLE `module_tasks_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_tasks_files_user_id` (`user_id`),
  ADD KEY `fk_module_tasks_files_user_updated` (`user_updated`),
  ADD KEY `fk_module_tasks_files_task_id` (`task_id`);

--
-- Indexes for table `module_tasks_notes`
--
ALTER TABLE `module_tasks_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_tasks_notes_user_id` (`user_id`),
  ADD KEY `fk_module_tasks_notes_user_updated` (`user_updated`),
  ADD KEY `fk_module_tasks_notes_task_id` (`task_id`);

--
-- Indexes for table `module_task_assignments`
--
ALTER TABLE `module_task_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_task_assignments_user_id` (`user_id`),
  ADD KEY `fk_module_task_assignments_user_updated` (`user_updated`),
  ADD KEY `fk_module_task_assignments_task_id` (`task_id`),
  ADD KEY `fk_module_task_assignments_assigned_user_id` (`assigned_user_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_person_user_id` (`user_id`),
  ADD KEY `fk_person_user_updated` (`user_updated`);

--
-- Indexes for table `system_properties`
--
ALTER TABLE `system_properties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_system_properties_name` (`name`),
  ADD KEY `fk_system_properties_category_id` (`category_id`),
  ADD KEY `fk_system_properties_type_id` (`type_id`),
  ADD KEY `fk_system_properties_user_id` (`user_id`),
  ADD KEY `fk_system_properties_user_updated` (`user_updated`);

--
-- Indexes for table `system_properties_versions`
--
ALTER TABLE `system_properties_versions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_system_properties_versions_property_version` (`property_id`,`version_number`),
  ADD KEY `fk_system_properties_versions_property_id` (`property_id`),
  ADD KEY `fk_system_properties_versions_user_id` (`user_id`),
  ADD KEY `fk_system_properties_versions_user_updated` (`user_updated`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_user_id` (`user_id`),
  ADD KEY `fk_users_user_updated` (`user_updated`);

--
-- Indexes for table `users_2fa`
--
ALTER TABLE `users_2fa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_2fa_user_id` (`user_id`),
  ADD KEY `fk_users_2fa_user_updated` (`user_updated`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_audit_log`
--
ALTER TABLE `admin_audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `module_agency`
--
ALTER TABLE `module_agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_division`
--
ALTER TABLE `module_division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `module_organization`
--
ALTER TABLE `module_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_projects`
--
ALTER TABLE `module_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `module_projects_files`
--
ALTER TABLE `module_projects_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module_projects_notes`
--
ALTER TABLE `module_projects_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_projects_users`
--
ALTER TABLE `module_projects_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_tasks`
--
ALTER TABLE `module_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `module_tasks_files`
--
ALTER TABLE `module_tasks_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_tasks_notes`
--
ALTER TABLE `module_tasks_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_task_assignments`
--
ALTER TABLE `module_task_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_properties`
--
ALTER TABLE `system_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_properties_versions`
--
ALTER TABLE `system_properties_versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_2fa`
--
ALTER TABLE `users_2fa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  ADD CONSTRAINT `fk_module_lookup_lists_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_lookup_lists_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  ADD CONSTRAINT `fk_module_lookup_list_items_list_id` FOREIGN KEY (`list_id`) REFERENCES `lookup_lists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_lookup_list_items_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_lookup_list_items_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  ADD CONSTRAINT `fk_module_lookup_item_attributes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_lookup_item_attributes_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_division`
--
ALTER TABLE `module_division`
  ADD CONSTRAINT `fk_module_division_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`);

--
-- Constraints for table `module_projects`
--
ALTER TABLE `module_projects`
  ADD CONSTRAINT `fk_module_projects_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`),
  ADD CONSTRAINT `fk_module_projects_division_id` FOREIGN KEY (`division_id`) REFERENCES `module_division` (`id`);

--
-- Constraints for table `module_projects_files`
--
ALTER TABLE `module_projects_files`
  ADD CONSTRAINT `fk_module_projects_files_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`);

--
-- Constraints for table `module_projects_notes`
--
ALTER TABLE `module_projects_notes`
  ADD CONSTRAINT `fk_module_projects_notes_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`);

--
-- Constraints for table `module_projects_users`
--
ALTER TABLE `module_projects_users`
  ADD CONSTRAINT `fk_module_projects_users_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`),
  ADD CONSTRAINT `fk_module_projects_users_assigned_user_id` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `module_tasks`
--
ALTER TABLE `module_tasks`
  ADD CONSTRAINT `fk_module_tasks_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`),
  ADD CONSTRAINT `fk_module_tasks_division_id` FOREIGN KEY (`division_id`) REFERENCES `module_division` (`id`),
  ADD CONSTRAINT `fk_module_tasks_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`);

--
-- Constraints for table `module_tasks_files`
--
ALTER TABLE `module_tasks_files`
  ADD CONSTRAINT `fk_module_tasks_files_task_id` FOREIGN KEY (`task_id`) REFERENCES `module_tasks` (`id`);

--
-- Constraints for table `module_tasks_notes`
--
ALTER TABLE `module_tasks_notes`
  ADD CONSTRAINT `fk_module_tasks_notes_task_id` FOREIGN KEY (`task_id`) REFERENCES `module_tasks` (`id`);

--
-- Constraints for table `module_task_assignments`
--
ALTER TABLE `module_task_assignments`
  ADD CONSTRAINT `fk_module_task_assignments_assigned_user_id` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_task_assignments_task_id` FOREIGN KEY (`task_id`) REFERENCES `module_tasks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
