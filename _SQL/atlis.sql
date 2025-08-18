-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2025 at 10:21 PM
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
(8, 1, 1, '2025-08-14 16:43:46', '2025-08-14 16:43:46', NULL, 'module_projects', 4, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"1\",\"name\":\"Dave\",\"description\":\"Dave\",\"requirements\":\"Dave\",\"specifications\":\"Dave\",\"status\":\"29\",\"start_date\":\"2025-08-14\"}'),
(9, 1, 1, '2025-08-14 22:11:35', '2025-08-14 22:11:35', NULL, 'module_projects_notes', 3, 'NOTE', '', '', 'test'),
(10, 1, 1, '2025-08-14 22:12:05', '2025-08-14 22:12:05', NULL, 'module_projects_notes', 4, 'NOTE', '', '', 'test @'),
(11, 1, 1, '2025-08-14 22:12:13', '2025-08-14 22:12:13', NULL, 'module_projects_files', 2, 'UPLOAD', '', '', '{\"file\":\"Image from iOS.jpg\"}'),
(12, 1, 1, '2025-08-14 22:17:14', '2025-08-14 22:17:14', NULL, 'module_projects', 5, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"2\",\"division_id\":\"2\",\"name\":\"Emailing Sealed Documents\",\"description\":\"Court Clerks should be able to send sealed documents to eDefender and eProsecutor.\",\"requirements\":\"Send sealed documents to eDef and ePros via email.\",\"specifications\":\"Defined later.\",\"status\":\"29\",\"start_date\":\"2025-08-01\"}'),
(13, 1, 1, '2025-08-14 22:26:57', '2025-08-14 22:26:57', NULL, 'module_projects_notes', 5, 'NOTE', '', '', 'This is the first note.'),
(14, 1, 1, '2025-08-14 22:27:02', '2025-08-14 22:27:02', NULL, 'module_projects_notes', 6, 'NOTE', '', '', 'FROM THE FIRST NOTE !'),
(15, 1, 1, '2025-08-14 22:27:08', '2025-08-14 22:27:08', NULL, 'module_projects_files', 3, 'UPLOAD', '', '', '{\"file\":\"Image from iOS.jpg\"}'),
(16, 1, 1, '2025-08-15 00:09:17', '2025-08-15 00:09:17', NULL, 'module_tasks_notes', 11, 'NOTE', '', '', 'test'),
(17, 1, 1, '2025-08-15 00:09:26', '2025-08-15 00:09:26', NULL, 'module_tasks_files', 1, 'UPLOAD', '', '', '{\"file\":\"Kratom-Colors-Chart-Final.png\"}'),
(18, 1, 1, '2025-08-15 00:12:39', '2025-08-15 00:12:39', NULL, 'person', 2, 'UPDATE', 'Updated person', '{\"user_id\":2,\"first_name\":\"ADMIN\",\"last_name\":\"ADMIN\"}', '{\"user_id\":2,\"first_name\":\"Sean\",\"last_name\":\"Cadina\"}'),
(19, 1, 1, '2025-08-15 13:22:34', '2025-08-15 13:22:34', NULL, 'module_projects_notes', 6, 'DELETE', '', 'FROM THE FIRST NOTE !', ''),
(20, 1, 1, '2025-08-15 13:22:39', '2025-08-15 13:22:39', NULL, 'module_projects_files', 3, 'DELETE', '', '{\"file\":\"Image from iOS.jpg\"}', ''),
(21, 1, 1, '2025-08-15 13:24:13', '2025-08-15 13:24:13', NULL, 'module_projects_notes', 7, 'NOTE', '', '', 'Kratom'),
(22, 1, 1, '2025-08-15 13:24:13', '2025-08-15 13:24:13', NULL, 'module_projects_files', 4, 'UPLOAD', '', '', '{\"file\":\"IMG_9186.JPEG\"}'),
(23, 1, 1, '2025-08-15 13:28:35', '2025-08-15 13:28:35', NULL, 'module_projects_notes', 5, 'DELETE', '', 'This is the first note.', ''),
(24, 1, 1, '2025-08-15 13:31:17', '2025-08-15 13:31:17', NULL, 'module_projects_files', 5, 'UPLOAD', '', '', '{\"file\":\"brand_trust.PNG\"}'),
(25, 1, 1, '2025-08-15 13:37:43', '2025-08-15 13:37:43', NULL, 'module_projects_notes', 8, 'NOTE', '', '', 'No file.'),
(26, 1, 1, '2025-08-15 13:37:49', '2025-08-15 13:37:49', NULL, 'module_projects_notes', 9, 'NOTE', '', '', 'Not even another one.'),
(27, 1, 1, '2025-08-15 13:46:48', '2025-08-15 13:46:48', NULL, 'module_projects_files', 6, 'UPLOAD', '', '', '{\"file\":\"LPP Affilaite Doc.pdf\"}'),
(28, 1, 1, '2025-08-15 13:46:54', '2025-08-15 13:46:54', NULL, 'module_projects_files', 7, 'UPLOAD', '', '', '{\"file\":\"Document.png\"}'),
(29, 1, 1, '2025-08-15 13:48:07', '2025-08-15 13:48:07', NULL, 'module_projects_notes', 10, 'NOTE', '', '', 'Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one.'),
(30, 1, 1, '2025-08-15 13:48:50', '2025-08-15 13:48:50', NULL, 'module_projects_notes', 11, 'NOTE', '', '', 'test'),
(31, 1, 1, '2025-08-15 14:27:57', '2025-08-15 14:27:57', NULL, 'module_tasks_notes', 12, 'NOTE', '', '', 'test'),
(32, 1, 1, '2025-08-15 14:27:59', '2025-08-15 14:27:59', NULL, 'module_tasks_notes', 13, 'NOTE', '', '', 'test 2'),
(33, 1, 1, '2025-08-15 14:55:12', '2025-08-15 14:55:12', NULL, 'module_tasks_notes', 14, 'NOTE', '', '', 'Test 2'),
(34, 1, 1, '2025-08-15 14:55:21', '2025-08-15 14:55:21', NULL, 'module_tasks_notes', 15, 'NOTE', '', '', 'Test 3'),
(35, 1, 1, '2025-08-15 14:55:21', '2025-08-15 14:55:21', NULL, 'module_tasks_files', 2, 'UPLOAD', '', '', '{\"file\":\"IMG_9522.JPEG\"}'),
(36, 1, 1, '2025-08-16 21:45:00', '2025-08-16 21:45:00', NULL, 'module_projects', 6, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"2\",\"division_id\":\"2\",\"name\":\"Test\",\"description\":\"Test\",\"requirements\":\"Test\",\"specifications\":\"Test\",\"status\":\"55\",\"start_date\":\"2025-08-19\"}'),
(37, 1, 1, '2025-08-16 21:45:29', '2025-08-16 21:45:29', NULL, 'module_projects', 7, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"2\",\"division_id\":\"2\",\"name\":\"Test\",\"description\":\"Test\",\"requirements\":\"Test\",\"specifications\":\"Test\",\"status\":\"55\",\"start_date\":\"\"}'),
(38, 1, 1, '2025-08-16 22:02:15', '2025-08-16 22:02:15', NULL, 'module_projects', 8, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"1\",\"name\":\"Dave\",\"description\":\"dave\",\"requirements\":\"dave\",\"specifications\":\"dave\",\"status\":\"30\",\"start_date\":\"2025-08-14\"}'),
(39, 1, 1, '2025-08-16 23:44:55', '2025-08-16 23:44:55', NULL, 'person', 3, 'CREATE', 'Created person', NULL, '{\"user_id\":null,\"first_name\":\"Tyler\",\"last_name\":\"Jessop\"}'),
(40, 1, 1, '2025-08-17 00:10:59', '2025-08-17 00:10:59', NULL, 'module_projects_files', 5, 'DELETE', '', '{\"file\":\"brand_trust.PNG\"}', ''),
(41, 1, 1, '2025-08-17 00:11:03', '2025-08-17 00:11:03', NULL, 'module_projects_files', 6, 'DELETE', '', '{\"file\":\"LPP Affilaite Doc.pdf\"}', ''),
(42, 1, 1, '2025-08-17 00:11:04', '2025-08-17 00:11:04', NULL, 'module_projects_files', 7, 'DELETE', '', '{\"file\":\"Document.png\"}', ''),
(43, 1, 1, '2025-08-17 00:30:48', '2025-08-17 00:30:48', NULL, 'person', 3, 'DELETE', 'Deleted person', NULL, NULL),
(44, 1, 1, '2025-08-17 11:08:14', '2025-08-17 11:08:14', NULL, 'users', 3, 'CREATE', 'Created user', NULL, '{\"username\":\"soup@atlistechnologies.com\",\"email\":\"soup@atlistechnologies.com\",\"type\":\"USER\",\"status\":1}'),
(45, 1, 1, '2025-08-17 11:08:43', '2025-08-17 11:08:43', NULL, 'users', 3, 'UPDATE', 'Updated user', '{\"username\":\"soup@atlistechnologies.com\",\"email\":\"soup@atlistechnologies.com\",\"type\":\"USER\",\"status\":1}', '{\"username\":\"Soup@AtlisTechnologies.com\",\"email\":\"Soup@AtlisTechnologies.com\",\"type\":\"USER\",\"status\":1}'),
(46, 1, 1, '2025-08-17 11:10:30', '2025-08-17 11:10:30', NULL, 'person', 4, 'CREATE', 'Created person', NULL, '{\"user_id\":3,\"first_name\":\"Tyler\",\"last_name\":\"Jessop\"}'),
(47, 1, 1, '2025-08-17 14:14:57', '2025-08-17 14:14:57', NULL, 'admin_roles', 9, 'DELETE', 'Deleted role', NULL, NULL),
(48, 1, 1, '2025-08-17 14:14:59', '2025-08-17 14:14:59', NULL, 'admin_roles', 7, 'DELETE', 'Deleted role', NULL, NULL),
(49, 1, 1, '2025-08-17 14:14:59', '2025-08-17 14:14:59', NULL, 'admin_roles', 8, 'DELETE', 'Deleted role', NULL, NULL),
(50, 1, 1, '2025-08-17 14:15:00', '2025-08-17 14:15:00', NULL, 'admin_roles', 2, 'DELETE', 'Deleted role', NULL, NULL),
(51, 1, 1, '2025-08-17 14:15:01', '2025-08-17 14:15:01', NULL, 'admin_roles', 4, 'DELETE', 'Deleted role', NULL, NULL),
(52, 1, 1, '2025-08-17 14:15:02', '2025-08-17 14:15:02', NULL, 'admin_roles', 5, 'DELETE', 'Deleted role', NULL, NULL),
(53, 1, 1, '2025-08-17 14:15:03', '2025-08-17 14:15:03', NULL, 'admin_roles', 3, 'DELETE', 'Deleted role', NULL, NULL),
(54, 1, 1, '2025-08-17 14:15:24', '2025-08-17 14:15:24', NULL, 'admin_roles', 10, 'CREATE', 'Created role', NULL, '{\"name\":\"Principle Project Manager\",\"description\":\"\"}'),
(55, 1, 1, '2025-08-17 14:17:19', '2025-08-17 14:17:19', NULL, 'admin_roles', 11, 'CREATE', 'Created role', NULL, '{\"name\":\"Project Manager\",\"description\":\"\"}'),
(56, 1, 1, '2025-08-17 14:18:03', '2025-08-17 14:18:03', NULL, 'admin_roles', 12, 'CREATE', 'Created role', NULL, '{\"name\":\"Developer\",\"description\":\"\"}'),
(57, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 'admin_role_permissions', 1, 'SYNC', 'Updated role permissions', '[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36]', '[9,12,10,11,21,24,22,23,17,20,18,19,5,8,6,7,29,32,30,31,13,16,14,15,25,28,26,27,33,36,34,35,1,4,2,3]'),
(58, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 'admin_role_permissions', 10, 'SYNC', 'Updated role permissions', '[]', '[9,12,10,11,21,24,22,23,17,20,18,19,5,8,6,7,29,32,30,31,13,16,14,15,25,28,26,27,33,36,34,35,1,4,2,3]'),
(59, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 'admin_role_permissions', 11, 'SYNC', 'Updated role permissions', '[]', '[9,12,10,11,21,24,22,23,17,20,18,19,5,8,6,7,29,32,30,31,13,16,14,15,25,28,26,27,33,36,34,35,1,4,2,3]'),
(60, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 'admin_role_permissions', 12, 'SYNC', 'Updated role permissions', '[]', '[33,34,35]');

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
-- Table structure for table `admin_permission_groups`
--

CREATE TABLE `admin_permission_groups` (
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
-- Dumping data for table `admin_permission_groups`
--

INSERT INTO `admin_permission_groups` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `description`) VALUES
(1,1,1,'2025-08-06 16:07:50','2025-08-08 22:17:06',NULL,'Users','Permissions for managing users'),
(2,1,1,'2025-08-06 16:07:59','2025-08-08 22:17:06',NULL,'People','Permissions for managing people'),
(3,1,1,'2025-08-06 19:39:18','2025-08-08 22:17:06',NULL,'Agencies','Permissions for managing agencies'),
(4,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,'Roles','Permissions for managing roles'),
(5,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,'Organization','Permissions for managing organizations'),
(6,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,'Division','Permissions for managing divisions'),
(7,1,1,'2025-08-12 19:38:17','2025-08-12 19:38:17',NULL,'System Properties','Permissions for system properties'),
(8,1,1,'2025-08-14 00:00:00','2025-08-14 00:00:00',NULL,'Projects','Permissions for managing projects'),
(9,1,1,'2025-08-14 00:00:00','2025-08-14 00:00:00',NULL,'Tasks','Permissions for managing tasks');

-- --------------------------------------------------------

--
-- Table structure for table `admin_permission_group_permissions`
--

CREATE TABLE `admin_permission_group_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `permission_group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_permission_group_permissions`
--

INSERT INTO `admin_permission_group_permissions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `permission_group_id`, `permission_id`) VALUES
(1,1,1,'2025-08-06 16:07:50','2025-08-08 22:17:06',NULL,1,1),
(2,1,1,'2025-08-06 16:07:50','2025-08-08 22:17:06',NULL,1,2),
(3,1,1,'2025-08-06 16:07:50','2025-08-08 22:17:06',NULL,1,3),
(4,1,1,'2025-08-06 16:07:50','2025-08-08 22:17:06',NULL,1,4),
(5,1,1,'2025-08-06 16:07:59','2025-08-08 22:17:06',NULL,2,5),
(6,1,1,'2025-08-06 16:07:59','2025-08-08 22:17:06',NULL,2,6),
(7,1,1,'2025-08-06 16:07:59','2025-08-08 22:17:06',NULL,2,7),
(8,1,1,'2025-08-06 16:07:59','2025-08-08 22:17:06',NULL,2,8),
(9,1,1,'2025-08-06 19:39:18','2025-08-08 22:17:06',NULL,3,9),
(10,1,1,'2025-08-06 19:39:18','2025-08-08 22:17:06',NULL,3,10),
(11,1,1,'2025-08-06 19:39:18','2025-08-08 22:17:06',NULL,3,11),
(12,1,1,'2025-08-06 19:39:18','2025-08-08 22:17:06',NULL,3,12),
(13,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,4,13),
(14,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,4,14),
(15,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,4,15),
(16,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,4,16),
(17,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,5,17),
(18,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,5,18),
(19,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,5,19),
(20,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,5,20),
(21,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,6,21),
(22,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,6,22),
(23,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,6,23),
(24,1,1,'2025-08-06 21:16:21','2025-08-08 22:17:06',NULL,6,24),
(25,1,1,'2025-08-12 19:38:17','2025-08-12 19:38:17',NULL,7,25),
(26,1,1,'2025-08-12 19:38:17','2025-08-12 19:38:17',NULL,7,26),
(27,1,1,'2025-08-12 19:38:17','2025-08-12 19:38:17',NULL,7,27),
(28,1,1,'2025-08-12 19:38:17','2025-08-12 19:38:17',NULL,7,28),
(29,1,1,'2025-08-14 00:00:00','2025-08-14 00:00:00',NULL,8,29),
(30,1,1,'2025-08-14 00:00:00','2025-08-14 00:00:00',NULL,8,30),
(31,1,1,'2025-08-14 00:00:00','2025-08-14 00:00:00',NULL,8,31),
(32,1,1,'2025-08-14 00:00:00','2025-08-14 00:00:00',NULL,8,32),
(33,1,1,'2025-08-14 00:00:00','2025-08-14 00:00:00',NULL,9,33),
(34,1,1,'2025-08-14 00:00:00','2025-08-14 00:00:00',NULL,9,34),
(35,1,1,'2025-08-14 00:00:00','2025-08-14 00:00:00',NULL,9,35),
(36,1,1,'2025-08-14 00:00:00','2025-08-14 00:00:00',NULL,9,36);

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
(10, 1, 1, '2025-08-17 14:15:24', '2025-08-17 14:15:24', NULL, 'Principle Project Manager', ''),
(11, 1, 1, '2025-08-17 14:17:19', '2025-08-17 14:17:19', NULL, 'Project Manager', ''),
(12, 1, 1, '2025-08-17 14:18:03', '2025-08-17 14:18:03', NULL, 'Developer', '');

-- --------------------------------------------------------


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
  `permission_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_role_permissions`
--

INSERT INTO `admin_role_permissions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `role_id`, `permission_group_id`) VALUES
(1,1,1,'2025-08-17 14:19:36','2025-08-17 14:19:36',NULL,1,1),
(2,1,1,'2025-08-17 14:19:36','2025-08-17 14:19:36',NULL,1,2),
(3,1,1,'2025-08-17 14:19:36','2025-08-17 14:19:36',NULL,1,3),
(4,1,1,'2025-08-17 14:19:36','2025-08-17 14:19:36',NULL,1,4),
(5,1,1,'2025-08-17 14:19:36','2025-08-17 14:19:36',NULL,1,5),
(6,1,1,'2025-08-17 14:19:36','2025-08-17 14:19:36',NULL,1,6),
(7,1,1,'2025-08-17 14:19:36','2025-08-17 14:19:36',NULL,1,7),
(8,1,1,'2025-08-17 14:19:36','2025-08-17 14:19:36',NULL,1,8),
(9,1,1,'2025-08-17 14:19:36','2025-08-17 14:19:36',NULL,1,9),
(10,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,10,1),
(11,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,10,2),
(12,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,10,3),
(13,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,10,4),
(14,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,10,5),
(15,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,10,6),
(16,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,10,7),
(17,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,10,8),
(18,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,10,9),
(19,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,11,1),
(20,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,11,2),
(21,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,11,3),
(22,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,11,4),
(23,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,11,5),
(24,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,11,6),
(25,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,11,7),
(26,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,11,8),
(27,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,11,9),
(28,1,1,'2025-08-17 14:19:37','2025-08-17 14:19:37',NULL,12,9);

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
(1, 1, 1, '2025-08-07 00:47:07', '2025-08-12 19:38:55', NULL, 1, 1),
(17, 1, 1, '2025-08-15 00:11:51', '2025-08-15 00:11:51', NULL, 2, 8),
(18, 1, 1, '2025-08-15 00:11:51', '2025-08-15 00:11:51', NULL, 2, 9);

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
(62, 1, 1, '2025-08-14 20:48:19', '2025-08-14 20:48:19', NULL, 'lookup_list_item_attributes', 31, 'CREATE', 'Created item attribute'),
(63, 1, 1, '2025-08-14 22:11:40', '2025-08-14 22:11:40', NULL, 'module_projects_users', 1, 'ASSIGN', 'Assigned user'),
(64, 1, 1, '2025-08-14 22:11:45', '2025-08-14 22:11:45', NULL, 'module_tasks', 4, 'CREATE', 'Created task'),
(65, 1, 1, '2025-08-14 22:15:47', '2025-08-14 22:15:47', NULL, 'lookup_list_items', 55, 'CREATE', 'Created lookup list item'),
(66, 1, 1, '2025-08-14 22:15:51', '2025-08-14 22:15:51', NULL, 'lookup_list_item_attributes', 10, 'UPDATE', 'Updated item attribute'),
(67, 1, 1, '2025-08-14 22:15:54', '2025-08-14 22:15:54', NULL, 'lookup_list_item_attributes', 12, 'UPDATE', 'Updated item attribute'),
(68, 1, 1, '2025-08-14 22:16:05', '2025-08-14 22:16:05', NULL, 'lookup_list_item_attributes', 32, 'CREATE', 'Created item attribute'),
(69, 1, 1, '2025-08-14 22:16:26', '2025-08-14 22:16:26', NULL, 'lookup_list_items', 29, 'UPDATE', 'Updated lookup list item'),
(70, 1, 1, '2025-08-14 22:22:53', '2025-08-14 22:22:53', NULL, 'lookup_list_item_attributes', 33, 'CREATE', 'Created item attribute'),
(71, 1, 1, '2025-08-15 00:06:43', '2025-08-15 00:06:43', NULL, 'module_projects_assignments', 2, 'ASSIGN', 'Assigned user'),
(72, 1, 1, '2025-08-15 00:09:39', '2025-08-15 00:09:39', NULL, 'module_projects_assignments', 2, 'DELETE', 'Removed user assignment'),
(73, 1, 1, '2025-08-15 00:09:42', '2025-08-15 00:09:42', NULL, 'module_projects_assignments', 3, 'ASSIGN', 'Assigned user'),
(74, 1, 1, '2025-08-15 00:11:11', '2025-08-15 00:11:11', NULL, 'users', 2, 'CREATE', 'Created user'),
(75, 1, 1, '2025-08-15 00:11:11', '2025-08-15 00:11:11', NULL, 'person', 2, 'CREATE', 'Created person for user'),
(76, 1, 1, '2025-08-15 00:11:11', '2025-08-15 00:11:11', NULL, 'admin_user_roles', 2, 'CREATE', 'Assigned roles to user'),
(77, 1, 1, '2025-08-15 00:11:51', '2025-08-15 00:11:51', NULL, 'users', 2, 'UPDATE', 'Updated user'),
(78, 1, 1, '2025-08-15 00:11:51', '2025-08-15 00:11:51', NULL, 'admin_user_roles', 2, 'UPDATE', 'Updated user roles'),
(79, 1, 1, '2025-08-15 00:12:46', '2025-08-15 00:12:46', NULL, 'module_projects_assignments', 4, 'ASSIGN', 'Assigned user'),
(80, 1, 1, '2025-08-15 13:21:18', '2025-08-15 13:21:18', NULL, 'module_tasks', 10, 'UPDATE', 'Completed task'),
(81, 1, 1, '2025-08-15 13:21:19', '2025-08-15 13:21:19', NULL, 'module_tasks', 10, 'UPDATE', 'Marked task incomplete'),
(82, 1, 1, '2025-08-15 13:49:24', '2025-08-15 13:49:24', NULL, 'module_tasks', 10, 'UPDATE', 'Completed task'),
(83, 1, 1, '2025-08-15 13:49:25', '2025-08-15 13:49:25', NULL, 'module_tasks', 10, 'UPDATE', 'Marked task incomplete'),
(84, 1, 1, '2025-08-15 14:25:03', '2025-08-15 14:25:03', NULL, 'module_tasks', 10, 'UPDATE', 'Completed task'),
(85, 1, 1, '2025-08-15 14:25:03', '2025-08-15 14:25:03', NULL, 'module_tasks', 10, 'UPDATE', 'Marked task incomplete'),
(86, 1, 1, '2025-08-15 14:27:48', '2025-08-15 14:27:48', NULL, 'module_task_assignments', 1, 'ASSIGN', 'Assigned user'),
(87, 1, 1, '2025-08-15 14:27:50', '2025-08-15 14:27:50', NULL, 'module_task_assignments', 2, 'ASSIGN', 'Assigned user'),
(88, 1, 1, '2025-08-15 14:55:00', '2025-08-15 14:55:00', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(89, 1, 1, '2025-08-15 14:55:01', '2025-08-15 14:55:01', NULL, 'module_tasks', 15, 'UPDATE', 'Marked task incomplete'),
(90, 1, 1, '2025-08-15 14:55:07', '2025-08-15 14:55:07', NULL, 'module_tasks', 6, 'UPDATE', 'Completed task'),
(91, 1, 1, '2025-08-15 14:55:07', '2025-08-15 14:55:07', NULL, 'module_tasks', 6, 'UPDATE', 'Marked task incomplete'),
(92, 1, 1, '2025-08-15 15:07:45', '2025-08-15 15:07:45', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(93, 1, 1, '2025-08-15 15:07:49', '2025-08-15 15:07:49', NULL, 'module_tasks', 1, 'UPDATE', 'Completed task'),
(94, 1, 1, '2025-08-15 15:07:55', '2025-08-15 15:07:55', NULL, 'module_tasks', 2, 'UPDATE', 'Completed task'),
(95, 1, 1, '2025-08-15 15:07:56', '2025-08-15 15:07:56', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(96, 1, 1, '2025-08-15 15:07:56', '2025-08-15 15:07:56', NULL, 'module_tasks', 6, 'UPDATE', 'Completed task'),
(97, 1, 1, '2025-08-15 15:08:00', '2025-08-15 15:08:00', NULL, 'module_tasks', 6, 'UPDATE', 'Marked task incomplete'),
(98, 1, 1, '2025-08-15 15:08:00', '2025-08-15 15:08:00', NULL, 'module_tasks', 3, 'UPDATE', 'Marked task incomplete'),
(99, 1, 1, '2025-08-15 15:08:01', '2025-08-15 15:08:01', NULL, 'module_tasks', 2, 'UPDATE', 'Marked task incomplete'),
(100, 1, 1, '2025-08-15 15:08:01', '2025-08-15 15:08:01', NULL, 'module_tasks', 1, 'UPDATE', 'Marked task incomplete'),
(101, 1, 1, '2025-08-15 15:08:02', '2025-08-15 15:08:02', NULL, 'module_tasks', 16, 'UPDATE', 'Marked task incomplete'),
(102, 1, 1, '2025-08-15 15:08:03', '2025-08-15 15:08:03', NULL, 'module_tasks', 2, 'UPDATE', 'Completed task'),
(103, 1, 1, '2025-08-15 15:08:05', '2025-08-15 15:08:05', NULL, 'module_tasks', 1, 'UPDATE', 'Completed task'),
(104, 1, 1, '2025-08-15 15:08:11', '2025-08-15 15:08:11', NULL, 'module_tasks', 1, 'UPDATE', 'Marked task incomplete'),
(105, 1, 1, '2025-08-15 15:08:11', '2025-08-15 15:08:11', NULL, 'module_tasks', 2, 'UPDATE', 'Marked task incomplete'),
(106, 1, 1, '2025-08-15 15:17:39', '2025-08-15 15:17:39', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(107, 1, 1, '2025-08-15 15:18:05', '2025-08-15 15:18:05', NULL, 'module_tasks', 9, 'UPDATE', 'Completed task'),
(108, 1, 1, '2025-08-15 15:18:08', '2025-08-15 15:18:08', NULL, 'module_tasks', 9, 'UPDATE', 'Marked task incomplete'),
(109, 1, 1, '2025-08-16 17:30:17', '2025-08-16 17:30:17', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(110, 1, 1, '2025-08-16 17:30:40', '2025-08-16 17:30:40', NULL, 'module_tasks', 2, 'UPDATE', 'Completed task'),
(111, 1, 1, '2025-08-16 17:31:38', '2025-08-16 17:31:38', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(112, 1, 1, '2025-08-16 17:31:41', '2025-08-16 17:31:41', NULL, 'module_tasks', 3, 'UPDATE', 'Marked task incomplete'),
(113, 1, 1, '2025-08-16 17:31:42', '2025-08-16 17:31:42', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(114, 1, 1, '2025-08-16 17:32:07', '2025-08-16 17:32:07', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(115, 1, 1, '2025-08-16 17:32:08', '2025-08-16 17:32:08', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(116, 1, 1, '2025-08-16 17:32:10', '2025-08-16 17:32:10', NULL, 'module_tasks', 16, 'UPDATE', 'Marked task incomplete'),
(117, 1, 1, '2025-08-16 17:32:13', '2025-08-16 17:32:13', NULL, 'module_tasks', 16, 'UPDATE', 'Marked task incomplete'),
(118, 1, 1, '2025-08-16 17:32:13', '2025-08-16 17:32:13', NULL, 'module_tasks', 16, 'UPDATE', 'Marked task incomplete'),
(119, 1, 1, '2025-08-16 17:32:14', '2025-08-16 17:32:14', NULL, 'module_tasks', 16, 'UPDATE', 'Marked task incomplete'),
(120, 1, 1, '2025-08-16 17:32:14', '2025-08-16 17:32:14', NULL, 'module_tasks', 16, 'UPDATE', 'Marked task incomplete'),
(121, 1, 1, '2025-08-16 17:38:09', '2025-08-16 17:38:09', NULL, 'module_tasks', 10, 'UPDATE', 'Completed task'),
(122, 1, 1, '2025-08-16 17:38:10', '2025-08-16 17:38:10', NULL, 'module_tasks', 10, 'UPDATE', 'Marked task incomplete'),
(123, 1, 1, '2025-08-16 17:38:11', '2025-08-16 17:38:11', NULL, 'module_tasks', 10, 'UPDATE', 'Completed task'),
(124, 1, 1, '2025-08-16 17:38:11', '2025-08-16 17:38:11', NULL, 'module_tasks', 10, 'UPDATE', 'Marked task incomplete'),
(125, 1, 1, '2025-08-16 17:38:12', '2025-08-16 17:38:12', NULL, 'module_tasks', 10, 'UPDATE', 'Completed task'),
(126, 1, 1, '2025-08-16 17:38:13', '2025-08-16 17:38:13', NULL, 'module_tasks', 10, 'UPDATE', 'Marked task incomplete'),
(127, 1, 1, '2025-08-16 17:51:57', '2025-08-16 17:51:57', NULL, 'module_tasks', 8, 'UPDATE', 'Completed task'),
(128, 1, 1, '2025-08-16 17:51:58', '2025-08-16 17:51:58', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(129, 1, 1, '2025-08-16 17:51:59', '2025-08-16 17:51:59', NULL, 'module_tasks', 9, 'UPDATE', 'Completed task'),
(130, 1, 1, '2025-08-16 17:51:59', '2025-08-16 17:51:59', NULL, 'module_tasks', 9, 'UPDATE', 'Marked task incomplete'),
(131, 1, 1, '2025-08-16 17:52:00', '2025-08-16 17:52:00', NULL, 'module_tasks', 16, 'UPDATE', 'Marked task incomplete'),
(132, 1, 1, '2025-08-16 17:52:00', '2025-08-16 17:52:00', NULL, 'module_tasks', 2, 'UPDATE', 'Marked task incomplete'),
(133, 1, 1, '2025-08-16 17:52:01', '2025-08-16 17:52:01', NULL, 'module_tasks', 3, 'UPDATE', 'Marked task incomplete'),
(134, 1, 1, '2025-08-16 17:52:03', '2025-08-16 17:52:03', NULL, 'module_tasks', 8, 'UPDATE', 'Marked task incomplete'),
(135, 1, 1, '2025-08-16 19:15:20', '2025-08-16 19:15:20', NULL, 'module_tasks', 7, 'UPDATE', 'Completed task'),
(136, 1, 1, '2025-08-16 19:15:23', '2025-08-16 19:15:23', NULL, 'module_tasks', 8, 'UPDATE', 'Completed task'),
(137, 1, 1, '2025-08-16 19:15:24', '2025-08-16 19:15:24', NULL, 'module_tasks', 9, 'UPDATE', 'Completed task'),
(138, 1, 1, '2025-08-16 19:15:24', '2025-08-16 19:15:24', NULL, 'module_tasks', 10, 'UPDATE', 'Completed task'),
(139, 1, 1, '2025-08-16 19:15:26', '2025-08-16 19:15:26', NULL, 'module_tasks', 10, 'UPDATE', 'Marked task incomplete'),
(140, 1, 1, '2025-08-16 19:15:27', '2025-08-16 19:15:27', NULL, 'module_tasks', 9, 'UPDATE', 'Marked task incomplete'),
(141, 1, 1, '2025-08-16 19:15:28', '2025-08-16 19:15:28', NULL, 'module_tasks', 8, 'UPDATE', 'Marked task incomplete'),
(142, 1, 1, '2025-08-16 19:15:28', '2025-08-16 19:15:28', NULL, 'module_tasks', 7, 'UPDATE', 'Marked task incomplete'),
(143, 1, 1, '2025-08-16 19:15:39', '2025-08-16 19:15:39', NULL, 'module_tasks', 10, 'UPDATE', 'Completed task'),
(144, 1, 1, '2025-08-16 19:15:39', '2025-08-16 19:15:39', NULL, 'module_tasks', 9, 'UPDATE', 'Completed task'),
(145, 1, 1, '2025-08-16 19:15:40', '2025-08-16 19:15:40', NULL, 'module_tasks', 8, 'UPDATE', 'Completed task'),
(146, 1, 1, '2025-08-16 19:15:40', '2025-08-16 19:15:40', NULL, 'module_tasks', 7, 'UPDATE', 'Completed task'),
(147, 1, 1, '2025-08-16 19:15:47', '2025-08-16 19:15:47', NULL, 'module_tasks', 10, 'UPDATE', 'Marked task incomplete'),
(148, 1, 1, '2025-08-16 19:15:48', '2025-08-16 19:15:48', NULL, 'module_tasks', 9, 'UPDATE', 'Marked task incomplete'),
(149, 1, 1, '2025-08-16 19:15:48', '2025-08-16 19:15:48', NULL, 'module_tasks', 8, 'UPDATE', 'Marked task incomplete'),
(150, 1, 1, '2025-08-16 19:15:49', '2025-08-16 19:15:49', NULL, 'module_tasks', 7, 'UPDATE', 'Marked task incomplete'),
(151, 1, 1, '2025-08-16 19:15:50', '2025-08-16 19:15:50', NULL, 'module_tasks', 15, 'UPDATE', 'Marked task incomplete'),
(152, 1, 1, '2025-08-16 19:41:35', '2025-08-16 19:41:35', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(153, 1, 1, '2025-08-16 19:41:36', '2025-08-16 19:41:36', NULL, 'module_tasks', 3, 'UPDATE', 'Marked task incomplete'),
(154, 1, 1, '2025-08-16 19:48:41', '2025-08-16 19:48:41', NULL, 'module_tasks', 9, 'UPDATE', 'Completed task'),
(155, 1, 1, '2025-08-16 19:50:57', '2025-08-16 19:50:57', NULL, 'module_tasks', 9, 'UPDATE', 'Marked task incomplete'),
(156, 1, 1, '2025-08-16 19:50:58', '2025-08-16 19:50:58', NULL, 'module_tasks', 9, 'UPDATE', 'Completed task'),
(157, 1, 1, '2025-08-16 20:05:04', '2025-08-16 20:05:04', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(158, 1, 1, '2025-08-16 20:05:05', '2025-08-16 20:05:05', NULL, 'module_tasks', 4, 'UPDATE', 'Completed task'),
(159, 1, 1, '2025-08-16 20:05:06', '2025-08-16 20:05:06', NULL, 'module_tasks', 3, 'UPDATE', 'Marked task incomplete'),
(160, 1, 1, '2025-08-16 20:05:07', '2025-08-16 20:05:07', NULL, 'module_tasks', 4, 'UPDATE', 'Marked task incomplete'),
(161, 1, 1, '2025-08-16 20:05:13', '2025-08-16 20:05:13', NULL, 'module_tasks', 8, 'UPDATE', 'Completed task'),
(162, 1, 1, '2025-08-16 20:05:14', '2025-08-16 20:05:14', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(163, 1, 1, '2025-08-16 21:35:49', '2025-08-16 21:35:49', NULL, 'module_tasks', 2, 'UPDATE', 'Completed task'),
(164, 1, 1, '2025-08-16 21:35:50', '2025-08-16 21:35:50', NULL, 'module_tasks', 2, 'UPDATE', 'Marked task incomplete'),
(165, 1, 1, '2025-08-16 21:36:31', '2025-08-16 21:36:31', NULL, 'module_task_assignments', 3, 'ASSIGN', 'Assigned user'),
(166, 1, 1, '2025-08-16 22:17:00', '2025-08-16 22:17:00', NULL, 'module_projects_assignments', 5, 'ASSIGN', 'Assigned user'),
(167, 1, 1, '2025-08-16 22:17:02', '2025-08-16 22:17:02', NULL, 'module_projects_assignments', 6, 'ASSIGN', 'Assigned user'),
(168, 1, 1, '2025-08-16 23:26:29', '2025-08-16 23:26:29', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(169, 1, 1, '2025-08-16 23:26:31', '2025-08-16 23:26:31', NULL, 'module_tasks', 16, 'UPDATE', 'Marked task incomplete'),
(170, 1, 1, '2025-08-16 23:26:35', '2025-08-16 23:26:35', NULL, 'module_tasks', 12, 'UPDATE', 'Completed task'),
(171, 1, 1, '2025-08-16 23:26:36', '2025-08-16 23:26:36', NULL, 'module_tasks', 12, 'UPDATE', 'Marked task incomplete'),
(172, 1, 1, '2025-08-16 23:26:37', '2025-08-16 23:26:37', NULL, 'module_tasks', 12, 'UPDATE', 'Completed task'),
(173, 1, 1, '2025-08-16 23:26:37', '2025-08-16 23:26:37', NULL, 'module_tasks', 12, 'UPDATE', 'Marked task incomplete'),
(174, 1, 1, '2025-08-16 23:26:37', '2025-08-16 23:26:37', NULL, 'module_tasks', 12, 'UPDATE', 'Completed task'),
(175, 1, 1, '2025-08-16 23:26:38', '2025-08-16 23:26:38', NULL, 'module_tasks', 12, 'UPDATE', 'Marked task incomplete'),
(176, 1, 1, '2025-08-16 23:26:39', '2025-08-16 23:26:39', NULL, 'module_tasks', 3, 'UPDATE', 'Marked task incomplete'),
(177, 1, 1, '2025-08-16 23:26:41', '2025-08-16 23:26:41', NULL, 'module_tasks', 8, 'UPDATE', 'Marked task incomplete'),
(178, 1, 1, '2025-08-16 23:26:42', '2025-08-16 23:26:42', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(179, 1, 1, '2025-08-16 23:26:43', '2025-08-16 23:26:43', NULL, 'module_tasks', 15, 'UPDATE', 'Marked task incomplete'),
(180, 1, 1, '2025-08-16 23:26:44', '2025-08-16 23:26:44', NULL, 'module_tasks', 13, 'UPDATE', 'Completed task'),
(181, 1, 1, '2025-08-16 23:26:44', '2025-08-16 23:26:44', NULL, 'module_tasks', 13, 'UPDATE', 'Marked task incomplete'),
(182, 1, 1, '2025-08-17 00:08:43', '2025-08-17 00:08:43', NULL, 'module_projects', 5, 'UPDATE', 'Updated status to 30'),
(183, 1, 1, '2025-08-17 00:08:53', '2025-08-17 00:08:53', NULL, 'module_projects_assignments', 4, 'DELETE', 'Removed user assignment'),
(184, 1, 1, '2025-08-17 00:08:57', '2025-08-17 00:08:57', NULL, 'module_projects_assignments', 7, 'ASSIGN', 'Assigned user'),
(185, 1, 1, '2025-08-17 00:13:02', '2025-08-17 00:13:02', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(186, 1, 1, '2025-08-17 00:13:03', '2025-08-17 00:13:03', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(187, 1, 1, '2025-08-17 00:13:05', '2025-08-17 00:13:05', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(188, 1, 1, '2025-08-17 00:13:05', '2025-08-17 00:13:05', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(189, 1, 1, '2025-08-17 00:13:05', '2025-08-17 00:13:05', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(190, 1, 1, '2025-08-17 00:13:05', '2025-08-17 00:13:05', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(191, 1, 1, '2025-08-17 00:13:05', '2025-08-17 00:13:05', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(192, 1, 1, '2025-08-17 00:13:06', '2025-08-17 00:13:06', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(193, 1, 1, '2025-08-17 00:13:06', '2025-08-17 00:13:06', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(194, 1, 1, '2025-08-17 00:13:10', '2025-08-17 00:13:10', NULL, 'module_tasks', 2, 'UPDATE', 'Completed task'),
(195, 1, 1, '2025-08-17 00:13:13', '2025-08-17 00:13:13', NULL, 'module_tasks', 2, 'UPDATE', 'Updated task status'),
(196, 1, 1, '2025-08-17 00:13:15', '2025-08-17 00:13:15', NULL, 'module_tasks', 2, 'UPDATE', 'Updated task status'),
(197, 1, 1, '2025-08-17 00:13:16', '2025-08-17 00:13:16', NULL, 'module_tasks', 2, 'UPDATE', 'Updated task status'),
(198, 1, 1, '2025-08-17 00:13:17', '2025-08-17 00:13:17', NULL, 'module_tasks', 2, 'UPDATE', 'Updated task status'),
(199, 1, 1, '2025-08-17 00:13:20', '2025-08-17 00:13:20', NULL, 'module_tasks', 9, 'UPDATE', 'Marked task incomplete'),
(200, 1, 1, '2025-08-17 00:13:20', '2025-08-17 00:13:20', NULL, 'module_tasks', 16, 'UPDATE', 'Marked task incomplete'),
(201, 1, 1, '2025-08-17 00:13:21', '2025-08-17 00:13:21', NULL, 'module_tasks', 2, 'UPDATE', 'Marked task incomplete'),
(202, 1, 1, '2025-08-17 00:13:26', '2025-08-17 00:13:26', NULL, 'module_tasks', 13, 'UPDATE', 'Updated task priority'),
(203, 1, 1, '2025-08-17 00:13:26', '2025-08-17 00:13:26', NULL, 'module_tasks', 13, 'UPDATE', 'Updated task priority'),
(204, 1, 1, '2025-08-17 00:13:27', '2025-08-17 00:13:27', NULL, 'module_tasks', 13, 'UPDATE', 'Updated task priority'),
(205, 1, 1, '2025-08-17 01:00:14', '2025-08-17 01:00:14', NULL, 'module_tasks', 8, 'UPDATE', 'Completed task'),
(206, 1, 1, '2025-08-17 01:00:28', '2025-08-17 01:00:28', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(207, 1, 1, '2025-08-17 01:00:29', '2025-08-17 01:00:29', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(208, 1, 1, '2025-08-17 01:00:30', '2025-08-17 01:00:30', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(209, 1, 1, '2025-08-17 01:00:30', '2025-08-17 01:00:30', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(210, 1, 1, '2025-08-17 01:00:30', '2025-08-17 01:00:30', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(211, 1, 1, '2025-08-17 01:00:30', '2025-08-17 01:00:30', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(212, 1, 1, '2025-08-17 01:13:03', '2025-08-17 01:13:03', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(213, 1, 1, '2025-08-17 01:13:14', '2025-08-17 01:13:14', NULL, 'module_tasks', 4, 'UPDATE', 'Completed task'),
(214, 1, 1, '2025-08-17 01:13:21', '2025-08-17 01:13:21', NULL, 'module_tasks', 11, 'UPDATE', 'Completed task'),
(215, 1, 1, '2025-08-17 01:13:23', '2025-08-17 01:13:23', NULL, 'module_tasks', 11, 'UPDATE', 'Marked task incomplete'),
(216, 1, 1, '2025-08-17 01:15:23', '2025-08-17 01:15:23', NULL, 'module_tasks', 13, 'UPDATE', 'Completed task'),
(217, 1, 1, '2025-08-17 01:15:24', '2025-08-17 01:15:24', NULL, 'module_tasks', 13, 'UPDATE', 'Completed task'),
(218, 1, 1, '2025-08-17 01:15:27', '2025-08-17 01:15:27', NULL, 'module_tasks', 10, 'UPDATE', 'Completed task'),
(219, 1, 1, '2025-08-17 01:17:08', '2025-08-17 01:17:08', NULL, 'module_tasks', 18, 'CREATE', 'Created task'),
(220, 1, 1, '2025-08-17 01:17:11', '2025-08-17 01:17:11', NULL, 'module_tasks', 19, 'CREATE', 'Created task'),
(221, 1, 1, '2025-08-17 10:31:31', '2025-08-17 10:31:31', NULL, 'module_projects', 5, 'UPDATE', 'Updated status to 29'),
(222, 1, 1, '2025-08-17 10:34:41', '2025-08-17 10:34:41', NULL, 'module_tasks', 20, 'CREATE', 'Created task'),
(223, 1, 1, '2025-08-17 10:35:53', '2025-08-17 10:35:53', NULL, 'module_tasks', 3, 'UPDATE', 'Marked task incomplete'),
(224, 1, 1, '2025-08-17 10:35:54', '2025-08-17 10:35:54', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(225, 1, 1, '2025-08-17 10:36:46', '2025-08-17 10:36:46', NULL, 'module_tasks', 20, 'UPDATE', 'Completed task'),
(226, 1, 1, '2025-08-17 10:36:52', '2025-08-17 10:36:52', NULL, 'module_tasks', 19, 'UPDATE', 'Completed task'),
(227, 1, 1, '2025-08-17 10:36:55', '2025-08-17 10:36:55', NULL, 'module_tasks', 18, 'UPDATE', 'Completed task'),
(228, 1, 1, '2025-08-17 11:02:46', '2025-08-17 11:02:46', NULL, 'lookup_lists', 14, 'CREATE', 'Created lookup list'),
(229, 1, 1, '2025-08-17 11:02:58', '2025-08-17 11:02:58', NULL, 'lookup_list_items', 56, 'CREATE', 'Created lookup list item'),
(230, 1, 1, '2025-08-17 11:03:02', '2025-08-17 11:03:02', NULL, 'lookup_list_items', 57, 'CREATE', 'Created lookup list item'),
(231, 1, 1, '2025-08-17 11:03:06', '2025-08-17 11:03:06', NULL, 'lookup_list_items', 58, 'CREATE', 'Created lookup list item'),
(232, 1, 1, '2025-08-17 11:03:09', '2025-08-17 11:03:09', NULL, 'module_projects', 8, 'UPDATE', 'Updated priority to 56'),
(233, 1, 1, '2025-08-17 11:03:22', '2025-08-17 11:03:22', NULL, 'lookup_list_item_attributes', 34, 'CREATE', 'Created item attribute'),
(234, 1, 1, '2025-08-17 11:03:34', '2025-08-17 11:03:34', NULL, 'lookup_list_item_attributes', 35, 'CREATE', 'Created item attribute'),
(235, 1, 1, '2025-08-17 11:03:44', '2025-08-17 11:03:44', NULL, 'lookup_list_item_attributes', 36, 'CREATE', 'Created item attribute'),
(236, 1, 1, '2025-08-17 11:03:53', '2025-08-17 11:03:53', NULL, 'module_projects', 8, 'UPDATE', 'Updated status to 29'),
(237, 1, 1, '2025-08-17 11:03:55', '2025-08-17 11:03:55', NULL, 'module_projects', 8, 'UPDATE', 'Updated priority to 58'),
(238, 1, 1, '2025-08-17 11:03:57', '2025-08-17 11:03:57', NULL, 'module_projects', 8, 'UPDATE', 'Updated priority to 58'),
(239, 1, 1, '2025-08-17 11:03:59', '2025-08-17 11:03:59', NULL, 'module_projects', 8, 'UPDATE', 'Updated priority to 57');

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
(12, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'TASK_PRIORITY', 'Priority levels for tasks'),
(14, 1, 1, '2025-08-17 11:02:46', '2025-08-17 11:02:46', '', 'PROJECT_PRIORITY', '');

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
(29, 1, 1, '2025-08-14 00:00:00', '2025-08-14 22:16:26', NULL, 10, 'In Progress', 'INPROGRESS', 1, '2025-08-01', NULL),
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
(54, 1, 1, '2025-08-14 20:47:55', '2025-08-14 20:47:55', NULL, 9, 'Business', 'BUSINESS', 0, '2025-08-14', NULL),
(55, 1, 1, '2025-08-14 22:15:47', '2025-08-14 22:15:47', NULL, 10, 'Backlog', 'BACKLOG', 0, '2025-08-14', NULL),
(56, 1, 1, '2025-08-17 11:02:58', '2025-08-17 11:02:58', NULL, 14, 'High', 'HIGH', 0, '2025-08-17', NULL),
(57, 1, 1, '2025-08-17 11:03:02', '2025-08-17 11:03:02', NULL, 14, 'Medium', 'MEDIUM', 0, '2025-08-17', NULL),
(58, 1, 1, '2025-08-17 11:03:06', '2025-08-17 11:03:06', NULL, 14, 'Low', 'LOW', 0, '2025-08-17', NULL);

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
(10, 1, 1, '2025-08-13 22:11:06', '2025-08-14 22:15:51', NULL, 29, 'COLOR-CLASS', 'primary'),
(11, 1, 1, '2025-08-13 22:16:23', '2025-08-13 22:16:23', NULL, 30, 'COLOR-CLASS', 'warning'),
(12, 1, 1, '2025-08-13 22:16:23', '2025-08-14 22:15:54', NULL, 31, 'COLOR-CLASS', 'success'),
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
(31, 1, 1, '2025-08-14 20:48:19', '2025-08-14 20:48:19', NULL, 54, 'TEST', 'test'),
(32, 1, 1, '2025-08-14 22:16:05', '2025-08-14 22:16:05', NULL, 55, 'COLOR-CLASS', 'info'),
(33, 1, 1, '2025-08-14 22:22:53', '2025-08-14 22:22:53', NULL, 35, 'COLOR-CLASS', 'atlis'),
(34, 1, 1, '2025-08-17 11:03:22', '2025-08-17 11:03:22', NULL, 56, 'COLOR-CLASS', 'danger'),
(35, 1, 1, '2025-08-17 11:03:34', '2025-08-17 11:03:34', NULL, 58, 'COLOR-CLASS', 'primary'),
(36, 1, 1, '2025-08-17 11:03:44', '2025-08-17 11:03:44', NULL, 57, 'COLOR-CLASS', 'warning');

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
  `priority` varchar(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects`
--

INSERT INTO `module_projects` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `agency_id`, `division_id`, `name`, `description`, `requirements`, `specifications`, `status`, `priority`, `start_date`, `complete_date`, `completed`) VALUES
(5, 1, 1, '2025-08-14 22:17:14', '2025-08-17 10:31:31', NULL, 2, 2, 'Emailing Sealed Documents', 'Court Clerks should be able to send sealed documents to eDefender and eProsecutor.', 'Send sealed documents to eDef and ePros via email.', 'Defined later.', '29', '1', '2025-08-01', NULL, 0),
(6, 1, 1, '2025-08-16 21:45:00', '2025-08-16 21:45:00', NULL, 2, 2, 'Test', 'Test', 'Test', 'Test', '55', NULL, '2025-08-19', NULL, 0),
(7, 1, 1, '2025-08-16 21:45:29', '2025-08-16 21:45:29', NULL, 2, 2, 'Test', 'Test', 'Test', 'Test', '55', NULL, '0000-00-00', NULL, 0),
(8, 1, 1, '2025-08-16 22:02:15', '2025-08-17 11:03:59', NULL, 1, 1, 'Dave', 'dave', 'dave', 'dave', '29', '57', '2025-08-14', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_projects_assignments`
--

CREATE TABLE `module_projects_assignments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `assigned_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects_assignments`
--

INSERT INTO `module_projects_assignments` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`, `assigned_user_id`) VALUES
(3, 1, 1, '2025-08-15 00:09:42', '2025-08-15 00:09:42', NULL, 5, 1),
(5, 1, 1, '2025-08-16 22:17:00', '2025-08-16 22:17:00', NULL, 8, 1),
(6, 1, 1, '2025-08-16 22:17:02', '2025-08-16 22:17:02', NULL, 8, 2),
(7, 1, 1, '2025-08-17 00:08:57', '2025-08-17 00:08:57', NULL, 5, 2);

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
  `note_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects_files`
--

INSERT INTO `module_projects_files` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`, `note_id`, `file_name`, `file_path`, `file_size`, `file_type`) VALUES
(4, 1, 1, '2025-08-15 13:24:13', '2025-08-15 13:24:13', NULL, 5, 7, 'IMG_9186.JPEG', '/module/project/uploads/project_5_1755285853_0_IMG_9186.JPEG', 1217423, 'image/jpeg');

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

--
-- Dumping data for table `module_projects_notes`
--

INSERT INTO `module_projects_notes` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`, `note_text`) VALUES
(7, 1, 1, '2025-08-15 13:24:13', '2025-08-15 13:24:13', NULL, 5, 'Kratom'),
(8, 1, 1, '2025-08-15 13:37:43', '2025-08-15 13:37:43', NULL, 5, 'No file.'),
(9, 1, 1, '2025-08-15 13:37:49', '2025-08-15 13:37:49', NULL, 5, 'Not even another one.'),
(10, 1, 1, '2025-08-15 13:48:07', '2025-08-15 13:48:07', NULL, 5, 'Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one. Not even another one.'),
(11, 1, 1, '2025-08-15 13:48:50', '2025-08-15 13:48:50', NULL, 5, 'test');

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
  `completed_by` int(11) DEFAULT NULL,
  `progress_percent` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_tasks`
--

INSERT INTO `module_tasks` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`, `agency_id`, `division_id`, `name`, `description`, `requirements`, `specifications`, `status`, `priority`, `start_date`, `due_date`, `complete_date`, `completed`, `completed_by`, `progress_percent`) VALUES
(1, 1, 1, '2025-08-14 22:21:21', '2025-08-15 15:08:11', NULL, 5, 2, 2, 'Probation Officer Role and Permissions in eCourt Portal', NULL, NULL, NULL, '35', '38', NULL, '2025-03-17', NULL, 0, NULL, 0),
(2, 1, 1, '2025-08-14 22:21:21', '2025-08-17 00:13:21', NULL, 5, 2, 2, 'GAL Role and Permissions in eCourt Portal', NULL, NULL, NULL, '34', '38', NULL, '2025-03-17', NULL, 0, NULL, 0),
(3, 1, 1, '2025-08-14 22:21:21', '2025-08-17 10:35:54', NULL, 5, 2, 2, 'Fee Waiver Icon in Case Header', NULL, NULL, NULL, '34', '38', NULL, '2025-03-17', '2025-08-17', 1, 1, 100),
(4, 1, 1, '2025-08-14 22:21:21', '2025-08-17 01:13:14', NULL, 5, 2, 2, 'New Judicial Assistant eCourt Role', NULL, NULL, NULL, '34', '39', NULL, '2025-03-25', '2025-08-17', 1, 1, 100),
(6, 1, 1, '2025-08-14 22:21:21', '2025-08-15 15:08:00', NULL, 5, 2, 2, 'Zoom Link', NULL, NULL, NULL, '35', NULL, NULL, '2025-03-24', NULL, 0, NULL, 0),
(7, 1, 1, '2025-08-14 22:21:21', '2025-08-16 19:15:49', NULL, 5, 2, 2, 'Write a SQL Query for Warrants?', NULL, NULL, NULL, '35', '37', NULL, '2025-03-26', NULL, 0, NULL, 0),
(8, 1, 1, '2025-08-14 22:21:21', '2025-08-17 01:00:14', NULL, 5, 2, 2, 'Document View / Stamp Tool', NULL, NULL, NULL, '34', '38', NULL, '2025-03-27', '2025-08-17', 1, 1, 100),
(9, 1, 1, '2025-08-14 22:21:21', '2025-08-17 00:13:20', NULL, 5, 2, 2, 'Judge Mass Reassignment', NULL, NULL, NULL, '32', '38', NULL, '2025-03-27', NULL, 0, NULL, 0),
(10, 1, 1, '2025-08-14 22:21:21', '2025-08-17 01:15:27', NULL, 5, 2, 2, 'AOIC Update to Report E and I - Quarterly Statistic Reports', NULL, NULL, NULL, '34', '39', NULL, '2025-04-01', '2025-08-17', 1, 1, 100),
(11, 1, 1, '2025-08-14 22:21:21', '2025-08-17 01:13:23', NULL, 5, 2, 2, 'Report K Update', NULL, NULL, NULL, '34', '39', NULL, NULL, NULL, 0, NULL, 0),
(12, 1, 1, '2025-08-14 22:21:21', '2025-08-16 23:26:38', NULL, 5, 2, 2, 'New search form request: search by assigned judge and current attorney law firm', NULL, NULL, NULL, '35', '38', NULL, NULL, NULL, 0, NULL, 0),
(13, 1, 1, '2025-08-14 22:21:21', '2025-08-17 01:15:23', NULL, 5, 2, 2, 'Block Restricted Documents from eProsecutor and eDefender', NULL, NULL, NULL, '34', '39', NULL, NULL, '2025-08-17', 1, 1, 100),
(15, 1, 1, '2025-08-14 22:21:21', '2025-08-17 01:00:28', NULL, 5, 2, 2, 'COURT CLERK DocDef REVIEW', NULL, NULL, NULL, '34', NULL, NULL, NULL, '2025-08-17', 1, 1, 100),
(16, 1, 1, '2025-08-14 22:21:21', '2025-08-17 00:13:20', NULL, 5, 2, 2, 'Interpreter Needed - UPDATE EVENT & WF', NULL, NULL, NULL, '34', '38', NULL, NULL, NULL, 0, NULL, 0),
(17, 1, NULL, '2025-08-17 01:02:06', '2025-08-17 01:02:06', NULL, 8, 1, 2, 'test', NULL, NULL, NULL, '35', '40', NULL, NULL, NULL, 0, NULL, 0),
(18, 1, 1, '2025-08-17 01:17:08', '2025-08-17 10:36:55', NULL, 5, NULL, NULL, 'Test', NULL, NULL, NULL, '34', NULL, NULL, NULL, '2025-08-17', 1, 1, 100),
(19, 1, 1, '2025-08-17 01:17:11', '2025-08-17 10:36:52', NULL, 5, NULL, NULL, 'Test 2', NULL, NULL, NULL, '34', NULL, NULL, NULL, '2025-08-17', 1, 1, 100),
(20, 1, 1, '2025-08-17 10:34:41', '2025-08-17 10:36:46', NULL, 8, NULL, NULL, 'Test 2', NULL, NULL, NULL, '34', NULL, NULL, NULL, '2025-08-17', 1, 1, 100);

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
  `note_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_tasks_files`
--

INSERT INTO `module_tasks_files` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `task_id`, `note_id`, `file_name`, `file_path`, `file_size`, `file_type`) VALUES
(1, 1, 1, '2025-08-15 00:09:26', '2025-08-15 00:09:26', NULL, 6, NULL, 'Kratom-Colors-Chart-Final.png', '/module/task/uploads/task_6_1755238166_Kratom-Colors-Chart-Final.png', 939198, 'image/png'),
(2, 1, 1, '2025-08-15 14:55:21', '2025-08-15 14:55:21', NULL, 6, 15, 'IMG_9522.JPEG', '/module/task/uploads/task_6_1755291321_IMG_9522.JPEG', 514284, 'image/jpeg');

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

--
-- Dumping data for table `module_tasks_notes`
--

INSERT INTO `module_tasks_notes` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `task_id`, `note_text`) VALUES
(1, 1, 1, '2025-03-11 14:08:41', '2025-08-14 22:21:21', NULL, 4, 'All Adoption cases are SEALED with a sealType of &#34;SEAL&#34;'),
(2, 1, 1, '2025-03-11 14:12:23', '2025-08-14 22:21:21', NULL, 4, 'Viewing sealed Cases and Documents are done in separate securities.'),
(3, 1, 1, '2025-03-11 14:26:15', '2025-08-14 22:21:21', NULL, 4, '- MiGarcia DirPerson created\r\n- User Created'),
(5, 1, 1, '2025-03-11 15:09:28', '2025-08-14 22:21:21', NULL, 4, 'Winnie asked to reduce the options in the LEFT \"Workspace\" NAV so Kasper gave her \"Public\"'),
(6, 1, 1, '2025-03-11 15:14:36', '2025-08-14 22:21:21', NULL, 4, 'I consulted Kasper as he did this.'),
(7, 1, 1, '2025-03-19 00:21:49', '2025-08-14 22:21:21', NULL, 8, 'Kasper emailed me and said he figured this out.'),
(8, 1, 1, '2025-04-08 14:04:57', '2025-08-14 22:21:21', NULL, 16, 'METADATA created on eCourt Test - 4/8/25\r\n\r\ncfInterpreterOrdered2\r\ncfInterpreterPresent2\r\ncfInterpreterRequired2\r\ncfInterpreterMemo2\r\n\r\ncfInterpreterOrdered3\r\ncfInterpreterPresent3\r\ncfInterpreterRequired3\r\ncfInterpreterMemo3'),
(9, 1, 1, '2025-04-09 16:22:02', '2025-08-14 22:21:21', NULL, 9, 'ISSUE TO CONSIDER: Some Judge\'s have multiple DirPerson, Persons, PersonIdentifiers, and Users.\r\n***issue particularly when using the LU-Judges or S-Judges and multiple are options to select... should just be 1 !'),
(10, 1, 1, '2025-04-09 17:06:52', '2025-08-14 22:21:21', NULL, 16, 'METADATA created in my Lake eCourt env.\r\nABOVE FORGOT THE \"Languages\" PLAIN FIELD.'),
(11, 1, 1, '2025-08-15 00:09:17', '2025-08-15 00:09:17', NULL, 6, 'test'),
(12, 1, 1, '2025-08-15 14:27:57', '2025-08-15 14:27:57', NULL, 10, 'test'),
(13, 1, 1, '2025-08-15 14:27:59', '2025-08-15 14:27:59', NULL, 10, 'test 2'),
(14, 1, 1, '2025-08-15 14:55:12', '2025-08-15 14:55:12', NULL, 6, 'Test 2'),
(15, 1, 1, '2025-08-15 14:55:21', '2025-08-15 14:55:21', NULL, 6, 'Test 3');

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

--
-- Dumping data for table `module_task_assignments`
--

INSERT INTO `module_task_assignments` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `task_id`, `assigned_user_id`) VALUES
(1, 1, 1, '2025-08-15 14:27:48', '2025-08-15 14:27:48', NULL, 10, 1),
(2, 1, 1, '2025-08-15 14:27:50', '2025-08-15 14:27:50', NULL, 10, 2),
(3, 1, 1, '2025-08-16 21:36:31', '2025-08-16 21:36:31', NULL, 11, 1),
(4, 1, NULL, '2025-08-17 01:02:06', '2025-08-17 01:02:06', NULL, 17, 1),
(5, 1, NULL, '2025-08-17 01:02:06', '2025-08-17 01:02:06', NULL, 17, 2);

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
(1, 1, 'Dave', 'Wilkins', 1, '2025-08-08 21:52:52', '2025-08-08 21:52:52', NULL),
(2, 2, 'Sean', 'Cadina', 1, '2025-08-15 00:11:11', '2025-08-15 00:12:39', NULL),
(4, 3, 'Tyler', 'Jessop', 1, '2025-08-17 11:10:30', '2025-08-17 11:10:30', NULL);

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
(1, 1, 1, '2025-08-06 16:08:42', '2025-08-17 11:15:50', NULL, 'Dave@AtlisTechnologies.com', 'Dave@AtlisTechnologies.com', '$2y$10$jN1XBh3o8MrgbwhNU9Q4ze68Fh6B/Mv1UO8GXAgBjLchYF0.YpK/q', 1, 'dave_2.JPG', 'ADMIN', 1, '2025-08-16 17:30:14'),
(2, 1, 1, '2025-08-15 00:11:11', '2025-08-15 00:13:55', NULL, 'Sean@AtlisTechnologies.com', 'Sean@AtlisTechnologies.com', '$2y$10$Bk4sqfPb4G49fa9HepMbBOfOjz/wEtvFJBSHIz9HFMO0nzOFeeJ3u', 0, 'sean.jpg', 'USER', 1, NULL),
(3, 1, 1, '2025-08-17 11:08:14', '2025-08-17 11:08:43', NULL, 'Soup@AtlisTechnologies.com', 'Soup@AtlisTechnologies.com', '$2y$10$WjasGZyR9C55WNVRikeptOAsPDTwXFTA.Jp5PDdIHwUqusfTjReaO', 0, NULL, 'USER', 1, NULL);

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
(3, 1, 1, '2025-08-16 17:30:14', '2025-08-16 17:30:17', NULL, '843412', '2025-08-16 17:40:14', 1);

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
-- Indexes for table `admin_permission_groups`
--
ALTER TABLE `admin_permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_permission_groups_user_id` (`user_id`),
  ADD KEY `fk_admin_permission_groups_user_updated` (`user_updated`);

--
-- Indexes for table `admin_permission_group_permissions`
--
ALTER TABLE `admin_permission_group_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_admin_permission_group_permissions_group_permission` (`permission_group_id`,`permission_id`),
  ADD KEY `fk_admin_permission_group_permissions_user_id` (`user_id`),
  ADD KEY `fk_admin_permission_group_permissions_user_updated` (`user_updated`),
  ADD KEY `fk_admin_permission_group_permissions_group_id` (`permission_group_id`),
  ADD KEY `fk_admin_permission_group_permissions_permission_id` (`permission_id`);

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
  ADD UNIQUE KEY `uk_admin_role_permissions_role_group` (`role_id`,`permission_group_id`),
  ADD KEY `fk_admin_role_permissions_user_id` (`user_id`),
  ADD KEY `fk_admin_role_permissions_user_updated` (`user_updated`),
  ADD KEY `fk_admin_role_permissions_role_id` (`role_id`),
  ADD KEY `fk_admin_role_permissions_permission_group_id` (`permission_group_id`);

--
-- Indexes for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_admin_user_roles_user_role` (`user_account_id`,`role_id`),
  ADD KEY `fk_admin_user_roles_user_id` (`user_id`),
  ADD KEY `fk_admin_user_roles_user_updated` (`user_updated`),
  ADD KEY `fk_admin_user_roles_user_account_id` (`user_account_id`);

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
  ADD KEY `fk_module_projects_status` (`status`),
  ADD KEY `fk_module_projects_priority` (`priority`);

--
-- Indexes for table `module_projects_assignments`
--
ALTER TABLE `module_projects_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_projects_users_user_id` (`user_id`),
  ADD KEY `fk_module_projects_users_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_users_project_id` (`project_id`),
  ADD KEY `fk_module_projects_users_assigned_user_id` (`assigned_user_id`);

--
-- Indexes for table `module_projects_files`
--
ALTER TABLE `module_projects_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_projects_files_user_id` (`user_id`),
  ADD KEY `fk_module_projects_files_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_files_project_id` (`project_id`),
  ADD KEY `fk_module_projects_files_note_id` (`note_id`);

--
-- Indexes for table `module_projects_notes`
--
ALTER TABLE `module_projects_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_projects_notes_user_id` (`user_id`),
  ADD KEY `fk_module_projects_notes_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_notes_project_id` (`project_id`);

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
  ADD KEY `fk_module_tasks_files_task_id` (`task_id`),
  ADD KEY `fk_module_tasks_files_note_id` (`note_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `admin_permission_groups`
--
ALTER TABLE `admin_permission_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_permission_group_permissions`
--
ALTER TABLE `admin_permission_group_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `module_projects_assignments`
--
ALTER TABLE `module_projects_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `module_projects_files`
--
ALTER TABLE `module_projects_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `module_projects_notes`
--
ALTER TABLE `module_projects_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `module_tasks`
--
ALTER TABLE `module_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `module_tasks_files`
--
ALTER TABLE `module_tasks_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_tasks_notes`
--
ALTER TABLE `module_tasks_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `module_task_assignments`
--
ALTER TABLE `module_task_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_2fa`
--
ALTER TABLE `users_2fa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--
-- Constraints for table `admin_permission_groups`
--
ALTER TABLE `admin_permission_groups`
  ADD CONSTRAINT `fk_admin_permission_groups_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_permission_groups_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_permission_group_permissions`
--
ALTER TABLE `admin_permission_group_permissions`
  ADD CONSTRAINT `fk_admin_permission_group_permissions_group_id` FOREIGN KEY (`permission_group_id`) REFERENCES `admin_permission_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_permission_group_permissions_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `admin_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_permission_group_permissions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_permission_group_permissions_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  ADD CONSTRAINT `fk_admin_role_permissions_role_id` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_role_permissions_permission_group_id` FOREIGN KEY (`permission_group_id`) REFERENCES `admin_permission_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_role_permissions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_role_permissions_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  ADD CONSTRAINT `fk_admin_user_roles_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_user_roles_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `module_projects_assignments`
--
ALTER TABLE `module_projects_assignments`
  ADD CONSTRAINT `fk_module_projects_users_assigned_user_id` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_projects_users_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`);

--
-- Constraints for table `module_projects_files`
--
ALTER TABLE `module_projects_files`
  ADD CONSTRAINT `fk_module_projects_files_note_id` FOREIGN KEY (`note_id`) REFERENCES `module_projects_notes` (`id`),
  ADD CONSTRAINT `fk_module_projects_files_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`);

--
-- Constraints for table `module_projects_notes`
--
ALTER TABLE `module_projects_notes`
  ADD CONSTRAINT `fk_module_projects_notes_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`);

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
  ADD CONSTRAINT `fk_module_tasks_files_note_id` FOREIGN KEY (`note_id`) REFERENCES `module_tasks_notes` (`id`),
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
