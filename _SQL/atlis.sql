-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2025 at 07:00 AM
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
(1, NULL, NULL, '2025-08-06 16:07:50', '2025-08-06 16:07:50', NULL, 'users', 'create'),
(2, NULL, NULL, '2025-08-06 16:07:50', '2025-08-06 16:07:50', NULL, 'users', 'read'),
(3, NULL, NULL, '2025-08-06 16:07:50', '2025-08-06 16:07:50', NULL, 'users', 'update'),
(4, NULL, NULL, '2025-08-06 16:07:50', '2025-08-06 16:07:50', NULL, 'users', 'delete'),
(5, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 'person', 'create'),
(6, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 'person', 'read'),
(7, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 'person', 'update'),
(8, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 'person', 'delete'),
(9, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 'agency', 'create'),
(10, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 'agency', 'read'),
(11, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 'agency', 'update'),
(12, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 'agency', 'delete'),
(13, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'roles', 'create'),
(14, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'roles', 'read'),
(15, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'roles', 'update'),
(16, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'roles', 'delete'),
(17, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'organization', 'create'),
(18, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'organization', 'read'),
(19, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'organization', 'update'),
(20, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'organization', 'delete'),
(21, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'division', 'create'),
(22, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'division', 'read'),
(23, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'division', 'update'),
(24, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'division', 'delete');

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
(1, NULL, NULL, '2025-08-06 16:07:43', '2025-08-06 16:07:43', NULL, 'Admin', 'System administrator with full permissions'),
(2, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 'Manage Person', 'Can manage person records'),
(3, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 'Manage Agency', 'Can manage agency records'),
(4, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'Manage Organization', 'Can manage organization records'),
(5, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 'Manage Division', 'Can manage division records');

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
(1, NULL, NULL, '2025-08-06 16:07:50', '2025-08-06 16:07:50', NULL, 1, 1),
(2, NULL, NULL, '2025-08-06 16:07:50', '2025-08-06 16:07:50', NULL, 1, 4),
(3, NULL, NULL, '2025-08-06 16:07:50', '2025-08-06 16:07:50', NULL, 1, 2),
(4, NULL, NULL, '2025-08-06 16:07:50', '2025-08-06 16:07:50', NULL, 1, 3),
(8, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 2, 5),
(9, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 2, 6),
(10, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 2, 7),
(11, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 1, 5),
(12, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 1, 8),
(13, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 1, 6),
(14, NULL, NULL, '2025-08-06 16:07:59', '2025-08-06 16:07:59', NULL, 1, 7),
(18, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 3, 9),
(19, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 3, 10),
(20, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 3, 11),
(21, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 1, 9),
(22, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 1, 12),
(23, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 1, 10),
(24, NULL, NULL, '2025-08-06 19:39:18', '2025-08-06 19:39:18', NULL, 1, 11),
(28, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 13),
(29, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 16),
(30, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 14),
(31, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 15),
(32, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 17),
(33, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 20),
(34, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 18),
(35, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 19),
(36, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 21),
(37, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 24),
(38, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 22),
(39, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 1, 23),
(40, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 4, 17),
(41, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 4, 20),
(42, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 4, 18),
(43, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 4, 19),
(44, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 5, 21),
(45, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 5, 24),
(46, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 5, 22),
(47, NULL, NULL, '2025-08-06 21:16:21', '2025-08-06 21:16:21', NULL, 5, 23);

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
(9, 1, 1, '2025-08-06 21:26:35', '2025-08-06 21:26:35', NULL, 1, 1);

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
(0, 1, 1, '2025-08-06 16:10:30', '2025-08-06 16:10:30', NULL, 'users', 1, 'LOGOUT', 'User logged out'),
(0, 1, 1, '2025-08-06 16:10:37', '2025-08-06 16:10:37', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(0, 1, 1, '2025-08-06 16:16:28', '2025-08-06 16:16:28', NULL, 'users', 1, 'UPDATE', 'Updated user'),
(0, 1, 1, '2025-08-06 16:16:28', '2025-08-06 16:16:28', NULL, 'admin_user_roles', 1, 'UPDATE', 'Updated user roles'),
(0, 1, 1, '2025-08-06 16:16:30', '2025-08-06 16:16:30', NULL, 'users', 1, 'UPDATE', 'Updated user'),
(0, 1, 1, '2025-08-06 16:16:30', '2025-08-06 16:16:30', NULL, 'admin_user_roles', 1, 'UPDATE', 'Updated user roles'),
(0, 1, 1, '2025-08-06 16:16:32', '2025-08-06 16:16:32', NULL, 'users', 1, 'UPDATE', 'Updated user'),
(0, 1, 1, '2025-08-06 16:16:32', '2025-08-06 16:16:32', NULL, 'admin_user_roles', 1, 'UPDATE', 'Updated user roles'),
(0, 1, 1, '2025-08-06 16:27:19', '2025-08-06 16:27:19', NULL, 'module_organization', 1, 'CREATE', 'Created organization'),
(0, 1, 1, '2025-08-06 16:27:31', '2025-08-06 16:27:31', NULL, 'module_agency', 1, 'CREATE', 'Created agency'),
(0, 1, 1, '2025-08-06 16:27:41', '2025-08-06 16:27:41', NULL, 'module_division', 1, 'CREATE', 'Created division'),
(0, 1, 1, '2025-08-06 16:27:55', '2025-08-06 16:27:55', NULL, 'module_organization', 2, 'CREATE', 'Created organization'),
(0, 1, 1, '2025-08-06 16:28:14', '2025-08-06 16:28:14', NULL, 'module_agency', 2, 'CREATE', 'Created agency'),
(0, 1, 1, '2025-08-06 16:28:28', '2025-08-06 16:28:28', NULL, 'module_division', 2, 'CREATE', 'Created division'),
(0, 1, 1, '2025-08-06 16:28:37', '2025-08-06 16:28:37', NULL, 'module_division', 3, 'CREATE', 'Created division'),
(0, 1, 1, '2025-08-06 16:28:48', '2025-08-06 16:28:48', NULL, 'module_division', 4, 'CREATE', 'Created division'),
(0, 1, 1, '2025-08-06 20:13:08', '2025-08-06 20:13:08', NULL, 'lookup_lists', 4, 'CREATE', 'Created lookup list'),
(0, 1, 1, '2025-08-06 20:13:16', '2025-08-06 20:13:16', NULL, 'lookup_lists', 5, 'CREATE', 'Created lookup list'),
(0, 1, 1, '2025-08-06 20:13:30', '2025-08-06 20:13:30', NULL, 'lookup_list_items', 7, 'CREATE', 'Created lookup list item'),
(0, 1, 1, '2025-08-06 20:13:41', '2025-08-06 20:13:41', NULL, 'lookup_list_items', 8, 'CREATE', 'Created lookup list item'),
(0, 1, 1, '2025-08-06 20:13:46', '2025-08-06 20:13:46', NULL, 'lookup_list_items', 7, 'UPDATE', 'Updated lookup list item'),
(0, 1, 1, '2025-08-06 20:13:58', '2025-08-06 20:13:58', NULL, 'lookup_list_items', 9, 'CREATE', 'Created lookup list item'),
(0, 1, 1, '2025-08-06 20:14:03', '2025-08-06 20:14:03', NULL, 'lookup_list_items', 10, 'CREATE', 'Created lookup list item'),
(0, 1, 1, '2025-08-06 20:14:18', '2025-08-06 20:14:18', NULL, 'lookup_lists', 6, 'CREATE', 'Created lookup list'),
(0, 1, 1, '2025-08-06 20:14:24', '2025-08-06 20:14:24', NULL, 'lookup_lists', 6, 'DELETE', 'Deleted lookup list'),
(0, 1, 1, '2025-08-06 20:26:02', '2025-08-06 20:26:02', NULL, 'lookup_lists', 7, 'CREATE', 'Created lookup list'),
(0, 1, 1, '2025-08-06 20:26:20', '2025-08-06 20:26:20', NULL, 'lookup_list_items', 11, 'CREATE', 'Created lookup list item'),
(0, 1, 1, '2025-08-06 20:26:38', '2025-08-06 20:26:38', NULL, 'lookup_list_items', 12, 'CREATE', 'Created lookup list item'),
(0, 1, 1, '2025-08-06 21:26:18', '2025-08-06 21:26:18', NULL, 'users', 1, 'UPDATE', 'Updated user'),
(0, 1, 1, '2025-08-06 21:26:18', '2025-08-06 21:26:18', NULL, 'admin_user_roles', 1, 'UPDATE', 'Updated user roles'),
(0, 1, 1, '2025-08-06 21:26:21', '2025-08-06 21:26:21', NULL, 'users', 1, 'UPDATE', 'Updated user'),
(0, 1, 1, '2025-08-06 21:26:21', '2025-08-06 21:26:21', NULL, 'admin_user_roles', 1, 'UPDATE', 'Updated user roles'),
(0, 1, 1, '2025-08-06 21:26:35', '2025-08-06 21:26:35', NULL, 'users', 1, 'UPDATE', 'Updated user'),
(0, 1, 1, '2025-08-06 21:26:35', '2025-08-06 21:26:35', NULL, 'admin_user_roles', 1, 'UPDATE', 'Updated user roles');

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
(1, NULL, NULL, '2025-08-06 16:07:33', '2025-08-06 16:07:33', NULL, 'ORGANIZATION_STATUS', 'Status values for organizations'),
(2, NULL, NULL, '2025-08-06 16:07:33', '2025-08-06 16:07:33', NULL, 'AGENCY_STATUS', 'Status values for agencies'),
(3, NULL, NULL, '2025-08-06 16:07:33', '2025-08-06 16:07:33', NULL, 'DIVISION_STATUS', 'Status values for divisions'),
(4, 1, 1, '2025-08-06 20:13:08', '2025-08-06 20:13:08', '', 'USER_TYPE', ''),
(5, 1, 1, '2025-08-06 20:13:16', '2025-08-06 20:13:16', '', 'USER_STATUS', ''),
(7, 1, 1, '2025-08-06 20:26:02', '2025-08-06 20:26:02', '', 'LOOKUP_LIST_ITEM_ATTRIBUTES', '');

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
(1, NULL, NULL, '2025-08-06 16:07:33', '2025-08-06 16:07:33', NULL, 1, 'Active', 'active', 1),
(2, NULL, NULL, '2025-08-06 16:07:33', '2025-08-06 16:07:33', NULL, 1, 'Inactive', 'inactive', 2),
(3, NULL, NULL, '2025-08-06 16:07:33', '2025-08-06 16:07:33', NULL, 2, 'Active', 'active', 1),
(4, NULL, NULL, '2025-08-06 16:07:33', '2025-08-06 16:07:33', NULL, 2, 'Inactive', 'inactive', 2),
(5, NULL, NULL, '2025-08-06 16:07:33', '2025-08-06 16:07:33', NULL, 3, 'Active', 'active', 1),
(6, NULL, NULL, '2025-08-06 16:07:33', '2025-08-06 16:07:33', NULL, 3, 'Inactive', 'inactive', 2),
(7, 1, 1, '2025-08-06 20:13:30', '2025-08-06 20:13:46', NULL, 5, 'ACTIVE', 'Active', 1),
(8, 1, 1, '2025-08-06 20:13:41', '2025-08-06 20:13:41', NULL, 5, 'INACTIVE', 'Inactive', 2),
(9, 1, 1, '2025-08-06 20:13:58', '2025-08-06 20:13:58', NULL, 4, 'ADMIN', 'Admin', 1),
(10, 1, 1, '2025-08-06 20:14:03', '2025-08-06 20:14:03', NULL, 4, 'USER', 'User', 2),
(11, 1, 1, '2025-08-06 20:26:20', '2025-08-06 20:26:20', NULL, 7, 'DEFAULT', 'Default', 0),
(12, 1, 1, '2025-08-06 20:26:38', '2025-08-06 20:26:38', NULL, 7, 'COLOR-CLASS', 'Color / Class', 0);

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
  `status` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_agency`
--

INSERT INTO `module_agency` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `organization_id`, `name`, `main_person`, `status`, `file_name`, `file_path`, `file_size`, `file_type`) VALUES
(1, NULL, NULL,  '2025-08-06 16:27:31', '2025-08-06 16:27:31', NULL, 1, 'Atlis Technologies', 1, 3, NULL, NULL, NULL, NULL),
(2, NULL, NULL, '2025-08-06 16:28:14', '2025-08-06 16:28:14', NULL, 2, '19th Circuit Court', NULL, 3, NULL, NULL, NULL, NULL),
(3, 1, 1, '2025-08-06 21:25:06', '2025-08-06 21:25:06', NULL, 3, '', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Alter table for existing deployments
--
ALTER TABLE `module_agency`
  ADD COLUMN `file_name` varchar(255) DEFAULT NULL,
  ADD COLUMN `file_path` varchar(255) DEFAULT NULL,
  ADD COLUMN `file_size` int(11) DEFAULT NULL,
  ADD COLUMN `file_type` varchar(255) DEFAULT NULL;

-- --------------------------------------------------------


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
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_division`
--

INSERT INTO `module_division` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `agency_id`, `name`, `main_person`, `status`) VALUES
(1, NULL, NULL, '2025-08-06 16:27:41', '2025-08-06 16:27:41', NULL, 1, 'Atlis', 1, 5),
(2, NULL, NULL, '2025-08-06 16:28:28', '2025-08-06 16:28:28', NULL, 2, 'Judicial Information Services & Technology', NULL, 5),
(3, NULL, NULL, '2025-08-06 16:28:37', '2025-08-06 16:28:37', NULL, 2, 'Business Operations', NULL, 5),
(4, NULL, NULL, '2025-08-06 16:28:48', '2025-08-06 16:28:48', NULL, 2, 'Court Clerks', NULL, 5),
(5, 1, 1, '2025-08-06 21:25:15', '2025-08-06 21:25:15', NULL, 3, '', NULL, NULL);

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
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_organization`
--

INSERT INTO `module_organization` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `main_person`, `status`) VALUES
(1, NULL, NULL, '2025-08-06 16:27:19', '2025-08-06 16:27:19', NULL, 'Atlis Technologies LLC', 1, 1),
(2, NULL, NULL, '2025-08-06 16:27:55', '2025-08-06 16:27:55', NULL, 'Lake County, IL', NULL, 1),
(3, 1, 1, '2025-08-06 21:24:49', '2025-08-06 21:24:49', NULL, '', NULL, NULL);

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
(1, 1, 'Dave', 'Wilkins', 1, '2025-08-06 16:09:01', '2025-08-06 16:09:01', NULL);

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
(1, 1, 1, '2025-08-06 16:08:42', '2025-08-06 21:26:35', NULL, 'dave@atlistechnologies.com', 'dave@atlistechnologies.com', '$2y$10$WGm3X9R063fNQ6Nw1Fy4GO7k8ulP9EjusL8.TFtp3xiz7YU1.E5Lq', 0, 'dave_2.JPG', 'ADMIN', 0, '2025-08-06 16:10:33');

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
(1, 1, 1, '2025-08-06 16:09:43', '2025-08-06 16:09:46', NULL, '678027', '2025-08-06 16:19:43', 1),
(2, 1, 1, '2025-08-06 16:10:33', '2025-08-06 16:10:37', NULL, '380915', '2025-08-06 16:20:33', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_agency`
--
ALTER TABLE `module_agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


--
-- AUTO_INCREMENT for table `module_division`
--
ALTER TABLE `module_division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `module_organization`
--
ALTER TABLE `module_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
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
-- Constraints for table `admin_audit_log`
--
ALTER TABLE `admin_audit_log`
  ADD CONSTRAINT `fk_admin_audit_log_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_admin_audit_log_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD CONSTRAINT `fk_admin_permissions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_admin_permissions_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD CONSTRAINT `fk_admin_roles_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_admin_roles_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  ADD CONSTRAINT `fk_admin_role_permissions_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `admin_permissions` (`id`),
  ADD CONSTRAINT `fk_admin_role_permissions_role_id` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`),
  ADD CONSTRAINT `fk_admin_role_permissions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_admin_role_permissions_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  ADD CONSTRAINT `fk_admin_user_roles_role_id` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`),
  ADD CONSTRAINT `fk_admin_user_roles_user_account_id` FOREIGN KEY (`user_account_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_admin_user_roles_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_admin_user_roles_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  ADD CONSTRAINT `fk_module_lookup_lists_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_lookup_lists_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  ADD CONSTRAINT `fk_module_lookup_list_items_list_id` FOREIGN KEY (`list_id`) REFERENCES `lookup_lists` (`id`),
  ADD CONSTRAINT `fk_module_lookup_list_items_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_lookup_list_items_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  ADD CONSTRAINT `fk_module_lookup_item_attributes_item_id` FOREIGN KEY (`item_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_lookup_item_attributes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_lookup_item_attributes_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `module_agency`
--
ALTER TABLE `module_agency`
  ADD CONSTRAINT `fk_module_agency_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_module_agency_organization_id` FOREIGN KEY (`organization_id`) REFERENCES `module_organization` (`id`),
  ADD CONSTRAINT `fk_module_agency_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_agency_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_agency_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `module_division`
--
ALTER TABLE `module_division`
  ADD CONSTRAINT `fk_module_division_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`),
  ADD CONSTRAINT `fk_module_division_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_module_division_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_division_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_division_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `module_organization`
--
ALTER TABLE `module_organization`
  ADD CONSTRAINT `fk_module_organization_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_module_organization_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_organization_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_organization_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `fk_person_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_person_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_users_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_2fa`
--
ALTER TABLE `users_2fa`
  ADD CONSTRAINT `fk_users_2fa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_users_2fa_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
