-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2025 at 02:25 AM
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
(1, 1, 1, '2025-08-12 19:46:44', '2025-08-12 19:46:44', NULL, 'admin_roles', 6, 'CREATE', 'Created role', NULL, '{\"name\":\"Manage System Properties\",\"description\":\"\"}');

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
(25, NULL, NULL, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 'system_properties', 'create'),
(26, NULL, NULL, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 'system_properties', 'read'),
(27, NULL, NULL, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 'system_properties', 'update'),
(28, NULL, NULL, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 'system_properties', 'delete');

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
(6, 1, 1, '2025-08-12 19:46:44', '2025-08-12 19:46:44', NULL, 'Manage System Properties', '');

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
(48, NULL, NULL, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 1, 25),
(49, NULL, NULL, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 1, 28),
(50, NULL, NULL, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 1, 26),
(51, NULL, NULL, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 1, 27);

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
(7, 1, 1, '2025-08-06 20:26:02', '2025-08-08 21:54:55', NULL, 'LOOKUP_LIST_ITEM_ATTRIBUTES', '');

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
  `value` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lookup_list_items`
--

INSERT INTO `lookup_list_items` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `list_id`, `label`, `value`, `sort_order`) VALUES
(1, 1, 1, '2025-08-06 16:07:33', '2025-08-08 22:15:24', NULL, 1, 'ACTIVE', 'Active', 1),
(2, 1, 1, '2025-08-06 16:07:33', '2025-08-08 22:15:35', NULL, 1, 'INACTIVE', 'Inactive', 2),
(3, 1, 1, '2025-08-06 16:07:33', '2025-08-08 22:14:47', NULL, 2, 'ACTIVE', 'Active', 1),
(4, 1, 1, '2025-08-06 16:07:33', '2025-08-08 22:14:59', NULL, 2, 'INACTIVE', 'Inactive', 2),
(5, 1, 1, '2025-08-06 16:07:33', '2025-08-08 21:58:45', NULL, 3, 'ACTIVE', 'Active', 1),
(6, 1, 1, '2025-08-06 16:07:33', '2025-08-08 21:59:22', NULL, 3, 'INACTIVE', 'Inactive', 2),
(7, 1, 1, '2025-08-06 20:13:30', '2025-08-06 20:13:46', NULL, 5, 'ACTIVE', 'Active', 1),
(8, 1, 1, '2025-08-06 20:13:41', '2025-08-06 20:13:41', NULL, 5, 'INACTIVE', 'Inactive', 2),
(9, 1, 1, '2025-08-06 20:13:58', '2025-08-06 20:13:58', NULL, 4, 'ADMIN', 'Admin', 1),
(10, 1, 1, '2025-08-06 20:14:03', '2025-08-06 20:14:03', NULL, 4, 'USER', 'User', 2),
(11, 1, 1, '2025-08-06 20:26:20', '2025-08-06 20:26:20', NULL, 7, 'DEFAULT', 'Default', 0),
(12, 1, 1, '2025-08-06 20:26:38', '2025-08-06 20:26:38', NULL, 7, 'COLOR-CLASS', 'Color / Class', 0),
(13, 1, 1, '2025-08-08 22:02:51', '2025-08-08 22:02:51', NULL, 1, 'PENDING', 'Pending', 0),
(27, 1, 1, '2025-08-08 22:14:28', '2025-08-08 22:14:28', NULL, 3, 'PENDING', 'Pending', 0),
(28, 1, 1, '2025-08-08 22:14:38', '2025-08-08 22:14:38', NULL, 2, 'PENDING', 'Pending', 0);

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
  `attr_key` varchar(100) NOT NULL,
  `attr_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `category_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `memo` text DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_property_versions`
--

CREATE TABLE `system_property_versions` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `value` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD KEY `fk_module_lookup_list_items_list_id` (`list_id`),
  ADD KEY `fk_module_lookup_list_items_user_id` (`user_id`),
  ADD KEY `fk_module_lookup_list_items_user_updated` (`user_updated`),
  ADD KEY `idx_module_lookup_list_items_label` (`label`);

--
-- Indexes for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_lookup_item_attributes_item_id` (`item_id`),
  ADD KEY `fk_module_lookup_item_attributes_user_id` (`user_id`),
  ADD KEY `fk_module_lookup_item_attributes_user_updated` (`user_updated`),
  ADD KEY `idx_module_lookup_item_attributes_key` (`attr_key`);

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
  ADD KEY `category_id` (`category_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_updated` (`user_updated`);

--
-- Indexes for table `system_property_versions`
--
ALTER TABLE `system_property_versions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_properties`
--
ALTER TABLE `system_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_property_versions`
--
ALTER TABLE `system_property_versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `system_properties`
--
ALTER TABLE `system_properties`
  ADD CONSTRAINT `system_properties_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `system_properties_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `system_properties_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `system_properties_ibfk_4` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `system_property_versions`
--
ALTER TABLE `system_property_versions`
  ADD CONSTRAINT `system_property_versions_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `system_properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `system_property_versions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
