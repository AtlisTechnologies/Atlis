-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2025 at 04:28 PM
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
(60, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 'admin_role_permissions', 12, 'SYNC', 'Updated role permissions', '[]', '[33,34,35]'),
(61, 1, 1, '2025-08-17 22:17:28', '2025-08-17 22:17:28', NULL, 'person', 4, 'DELETE', 'Deleted person', NULL, NULL),
(62, 1, 1, '2025-08-17 22:20:25', '2025-08-17 22:20:25', NULL, 'admin_role_permission_groups', 1, 'SYNC', 'Updated role group assignments', '[]', '[3,6,5,2,8,4,7,9,1]'),
(63, 1, 1, '2025-08-17 22:20:25', '2025-08-17 22:20:25', NULL, 'admin_role_permission_groups', 10, 'SYNC', 'Updated role group assignments', '[]', '[]'),
(64, 1, 1, '2025-08-17 22:20:25', '2025-08-17 22:20:25', NULL, 'admin_role_permission_groups', 11, 'SYNC', 'Updated role group assignments', '[]', '[]'),
(65, 1, 1, '2025-08-17 22:20:25', '2025-08-17 22:20:25', NULL, 'admin_role_permission_groups', 12, 'SYNC', 'Updated role group assignments', '[]', '[]'),
(66, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 'admin_role_permission_groups', 1, 'SYNC', 'Updated role group assignments', '[1,2,3,4,5,6,7,8,9]', '[3,6,5,2,8,4,7,9,1]'),
(67, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 'admin_role_permission_groups', 10, 'SYNC', 'Updated role group assignments', '[]', '[3,6,5,2,8,9]'),
(68, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 'admin_role_permission_groups', 11, 'SYNC', 'Updated role group assignments', '[]', '[8,9]'),
(69, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 'admin_role_permission_groups', 12, 'SYNC', 'Updated role group assignments', '[]', '[8,9]'),
(70, 1, 1, '2025-08-18 22:47:40', '2025-08-18 22:47:40', NULL, 'module_projects_notes', 12, 'NOTE', '', '', 'PRIME DAY'),
(71, 1, 1, '2025-08-18 22:47:40', '2025-08-18 22:47:40', NULL, 'module_projects_files', 8, 'UPLOAD', '', '', '{\"file\":\"2025 JULY - PRIME DAY.txt\"}'),
(72, 1, 1, '2025-08-19 23:01:08', '2025-08-19 23:01:08', NULL, 'module_projects', 1, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"2\",\"division_id\":\"2\",\"name\":\"Emailing Sealed Documents (E.S.D)\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"29\",\"start_date\":\"2025-08-01\"}'),
(73, 1, 1, '2025-08-19 23:02:03', '2025-08-19 23:02:03', NULL, 'module_projects', 2, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"2\",\"division_id\":\"3\",\"name\":\"Bench View\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"55\",\"start_date\":\"2025-08-01\"}'),
(74, 1, 1, '2025-08-19 23:23:43', '2025-08-19 23:23:43', NULL, 'module_contractors', 1, 'CREATE', 'Created contractor', NULL, '{\"user_id\":1,\"person_id\":1}'),
(75, 1, 1, '2025-08-19 23:23:45', '2025-08-19 23:23:45', NULL, 'module_contractors', 1, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"pay_type_id\":64,\"start_date\":null,\"end_date\":null,\"current_rate\":null}', '{\"status_id\":\"78\",\"pay_type_id\":\"64\",\"start_date\":\"\",\"end_date\":\"\",\"current_rate\":\"\"}'),
(76, 1, 1, '2025-08-19 23:23:51', '2025-08-19 23:23:51', NULL, 'module_contractors', 2, 'CREATE', 'Created contractor', NULL, '{\"user_id\":2,\"person_id\":2}'),
(77, 1, 1, '2025-08-19 23:23:54', '2025-08-19 23:23:54', NULL, 'module_contractors', 3, 'CREATE', 'Created contractor', NULL, '{\"user_id\":4,\"person_id\":5}'),
(78, 1, 1, '2025-08-20 00:14:27', '2025-08-20 00:14:27', NULL, 'module_tasks_notes', 11, 'NOTE', '', '', 'Done through System Property.'),
(79, 1, 1, '2025-08-20 00:15:31', '2025-08-20 00:15:31', NULL, 'module_projects', 3, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"2\",\"division_id\":\"2\",\"name\":\"Fee Waiver Icon in Case Header\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"55\",\"start_date\":\"2025-04-26\"}'),
(80, 1, 1, '2025-08-20 00:40:59', '2025-08-20 00:40:59', NULL, 'module_projects_files', 1, 'UPLOAD', '', '', '{\"file\":\"Capture43434.PNG\"}'),
(81, 1, 1, '2025-08-20 00:40:59', '2025-08-20 00:40:59', NULL, 'module_projects_files', 2, 'UPLOAD', '', '', '{\"file\":\"DOCUMENT THIS WHAT I DID FOR LAKE FOR NEW ICON IN HEADER.txt\"}'),
(82, 1, 1, '2025-08-20 00:40:59', '2025-08-20 00:40:59', NULL, 'module_projects_files', 3, 'UPLOAD', '', '', '{\"file\":\"Feedback from CC and Leah Balzer.txt\"}'),
(83, 1, 1, '2025-08-20 00:40:59', '2025-08-20 00:40:59', NULL, 'module_projects_files', 4, 'UPLOAD', '', '', '{\"file\":\"FeeWaiver Entity.PNG\"}'),
(84, 1, 1, '2025-08-20 00:40:59', '2025-08-20 00:40:59', NULL, 'module_projects_files', 5, 'UPLOAD', '', '', '{\"file\":\"unnamed (2).png\"}'),
(85, 1, 1, '2025-08-20 14:36:44', '2025-08-20 14:36:44', NULL, 'module_contractors_compensation', 1, 'CREATE', 'Added compensation', '', '{\"amount\":\"681.82\",\"type\":65}'),
(86, 1, 1, '2025-08-20 14:39:03', '2025-08-20 14:39:03', NULL, 'module_contractors', 2, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"pay_type_id\":64,\"start_date\":null,\"end_date\":null,\"current_rate\":null}', '{\"status_id\":\"79\",\"pay_type_id\":\"65\",\"start_date\":\"2025-06-11\",\"end_date\":\"2025-08-31\",\"current_rate\":\"681.82\"}'),
(87, 1, 1, '2025-08-20 14:40:35', '2025-08-20 14:40:35', NULL, 'module_contractors_compensation', 2, 'CREATE', 'Added compensation', '', '{\"amount\":\"681.82\",\"type\":98}'),
(88, 1, 1, '2025-08-20 15:13:26', '2025-08-20 15:13:26', NULL, 'module_contractors', 4, 'CREATE', 'Created contractor', NULL, '{\"user_id\":8,\"person_id\":23}'),
(89, 1, 1, '2025-08-20 15:14:43', '2025-08-20 15:14:43', NULL, 'module_contractors', 5, 'CREATE', 'Created contractor', NULL, '{\"user_id\":9,\"person_id\":24}'),
(90, 1, 1, '2025-08-20 16:35:55', '2025-08-20 16:35:55', NULL, 'module_contractors_compensation', 3, 'CREATE', 'Added compensation', '', '{\"amount\":\"155\",\"type\":98}'),
(91, 1, 1, '2025-08-20 16:36:25', '2025-08-20 16:36:25', NULL, 'module_contractors_compensation', 4, 'CREATE', 'Added compensation', '', '{\"amount\":\"526.82\",\"type\":98}'),
(92, 1, 1, '2025-08-20 16:54:07', '2025-08-20 16:54:07', NULL, 'module_contractors_files', 1, 'UPLOAD', '', '', '{\"file\":\"Atlis Technologies Work Agreement - With Summer 2025 - D_SIGNED.pdf\",\"version\":1}'),
(93, 1, 1, '2025-08-20 18:05:57', '2025-08-20 18:05:57', NULL, 'module_contractors_compensation', 5, 'CREATE', 'Added compensation', '', '{\"amount\":\"500\",\"type\":98,\"title\":\"First Payment\"}'),
(94, 1, 1, '2025-08-20 20:47:36', '2025-08-20 20:47:36', NULL, 'module_contractors', 6, 'CREATE', 'Created contractor', NULL, '{\"user_id\":10,\"person_id\":27}'),
(95, 1, 1, '2025-08-20 20:47:54', '2025-08-20 20:47:54', NULL, 'module_contractors', 6, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"pay_type_id\":98,\"start_date\":null,\"end_date\":null,\"current_rate\":null}', '{\"status_id\":\"78\",\"pay_type_id\":\"98\",\"start_date\":\"\",\"end_date\":\"\",\"current_rate\":\"\"}'),
(96, 1, 1, '2025-08-20 20:49:42', '2025-08-20 20:49:42', NULL, 'module_contractors_contacts', 1, 'CREATE', 'Added contact', '', '{\"contact_type_id\":99,\"summary\":\"Initial Contact - Hey Emma, I hope things are going well for you. \\r\\nQuick question, are you interested in doing some side gig work building PowerBI \\/ Tableau dashboards and other Business Intelligence products specifically for eSeries?\\r\\nCompensation would be around\\r\\n$100\\/hr and\\/or a residual %-based strategy.  Let me know as soon as possible when you can and we can setup a call to go over more details if you\\u2019re interested. If not, no hard feelings at all.\\r\\nThanks !\"}'),
(97, 1, 1, '2025-08-20 20:51:08', '2025-08-20 20:51:08', NULL, 'module_contractors_compensation', 6, 'CREATE', 'Added compensation', '', '{\"amount\":\"555\",\"type\":98,\"title\":\"test\"}'),
(98, 1, 1, '2025-08-20 21:03:51', '2025-08-20 21:03:51', NULL, 'person', 30, 'CREATE', 'Created person', NULL, '{\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"dob\":null}'),
(99, 1, 1, '2025-08-21 01:43:32', '2025-08-21 01:43:32', NULL, 'module_contractors', 4, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"initial_contact_date\":null,\"title_role\":null,\"acquaintance\":null,\"acquaintance_type_id\":null,\"start_date\":null,\"end_date\":null}', '{\"status_id\":\"78\",\"initial_contact_date\":\"\",\"title_role\":\"\",\"acquaintance\":\"Former JTI Employee.\\r\\nThomas and Amanda\'s old neighbor.\\r\\nWorked with John Wilkins at New Dawn Technologies.\",\"acquaintance_type_id\":\"102\",\"start_date\":\"\",\"end_date\":\"\"}'),
(100, 1, 1, '2025-08-21 01:50:27', '2025-08-21 01:50:27', NULL, 'module_contractors_files', 3, 'UPLOAD', '', '', '{\"file\":\"45.jpg\",\"version\":1}'),
(101, 1, 1, '2025-08-21 01:50:57', '2025-08-21 01:50:57', NULL, 'module_contractors_files', 3, 'DELETE', 'Deleted file', '', NULL),
(102, 1, 1, '2025-08-21 01:53:22', '2025-08-21 01:53:22', NULL, 'module_contractors_files', 4, 'UPLOAD', '', '', '{\"file\":\"FIRST CONTACT.txt\",\"version\":1}'),
(103, 1, 1, '2025-08-21 01:54:03', '2025-08-21 01:54:03', NULL, 'module_contractors_files', 5, 'UPLOAD', '', '', '{\"file\":\"INITIAL CALL.txt\",\"version\":1}'),
(104, 1, 1, '2025-08-21 01:55:48', '2025-08-21 01:55:48', NULL, 'module_contractors_files', 6, 'UPLOAD', '', '', '{\"file\":\"KENNY__ATLIS_WORK_AGREEMENT-Signed.pdf\",\"version\":1}'),
(105, 1, 1, '2025-08-21 01:56:21', '2025-08-21 01:56:21', NULL, 'module_contractors', 4, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"initial_contact_date\":null,\"title_role\":null,\"acquaintance\":\"Former JTI Employee.\\r\\nThomas and Amanda\'s old neighbor.\\r\\nWorked with John Wilkins at New Dawn Technologies.\",\"acquaintance_type_id\":102,\"start_date\":null,\"end_date\":null}', '{\"status_id\":\"78\",\"initial_contact_date\":\"\",\"title_role\":\"\",\"acquaintance\":\"Former JTI Employee.\\r\\nThomas and Amanda\'s old neighbor.\\r\\nWorked with John Wilkins at New Dawn Technologies.\",\"acquaintance_type_id\":\"102\",\"start_date\":\"2025-06-21\",\"end_date\":\"\"}'),
(106, 1, 1, '2025-08-21 01:56:50', '2025-08-21 01:56:50', NULL, 'module_contractors', 4, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"initial_contact_date\":null,\"title_role\":null,\"acquaintance\":\"Former JTI Employee.\\r\\nThomas and Amanda\'s old neighbor.\\r\\nWorked with John Wilkins at New Dawn Technologies.\",\"acquaintance_type_id\":102,\"start_date\":\"2025-06-21\",\"end_date\":null}', '{\"status_id\":\"78\",\"initial_contact_date\":\"2025-06-11\",\"title_role\":\"BI Analyst \\/ Report Writer\",\"acquaintance\":\"Former JTI Employee.\\r\\nThomas and Amanda\'s old neighbor.\\r\\nWorked with John Wilkins at New Dawn Technologies.\",\"acquaintance_type_id\":\"102\",\"start_date\":\"2025-06-21\",\"end_date\":\"\"}'),
(107, 1, 1, '2025-08-21 01:57:30', '2025-08-21 01:57:30', NULL, 'module_contractors_contacts', 2, 'CREATE', 'Added contact', '', '{\"contact_type_id\":99,\"summary\":\"Pitched Kenny via text message. Said he\'s interested but on a trip right now and can talk later.\"}'),
(108, 1, 1, '2025-08-21 01:57:56', '2025-08-21 01:57:56', NULL, 'module_contractors_contacts', 3, 'CREATE', 'Added contact', '', '{\"contact_type_id\":99,\"summary\":\"KENNY TEXT ME AND SAID HE\'S INTERESTED AND WILL REACH OUT ON MONDAY !\"}'),
(109, 1, 1, '2025-08-21 01:58:19', '2025-08-21 01:58:19', NULL, 'module_contractors_contacts', 4, 'CREATE', 'Added contact', '', '{\"contact_type_id\":75,\"summary\":\"SENT KENNY FIRST CONTRACT AND DETAILS ABOUT SoW #172\"}'),
(110, 1, 1, '2025-08-21 02:12:22', '2025-08-21 02:12:22', NULL, 'person', 30, 'UPDATE', 'Updated person', '{\"id\":30,\"user_id\":null,\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-20 21:03:51\",\"date_updated\":\"2025-08-20 21:03:51\",\"memo\":null}', '{\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(111, 1, 1, '2025-08-21 02:12:22', '2025-08-21 02:12:22', NULL, 'person_addresses', 3, 'CREATE', 'Added address', NULL, '{\":pid\":30,\":type_id\":111,\":status_id\":108,\":start_date\":\"2014-08-01\",\":end_date\":null,\":line1\":\"123 Test 456 South\",\":line2\":\"\",\":city\":\"Logan\",\":state\":\"Utah\",\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1}'),
(112, 1, 1, '2025-08-21 02:14:26', '2025-08-21 02:14:26', NULL, 'module_agency', 3, 'CREATE', 'Created agency', NULL, '{\"organization_id\":2,\"name\":\"Office of the Public Defender\",\"main_person\":30,\"status\":28}'),
(113, 1, 1, '2025-08-21 02:15:50', '2025-08-21 02:15:50', NULL, 'person', 31, 'CREATE', 'Created person', NULL, '{\"first_name\":\"Lonnie\",\"last_name\":\"Renda\",\"email\":\"LRenda@LakeCountyIL.gov\",\"gender_id\":59,\"organization_id\":2,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(114, 1, 1, '2025-08-21 02:15:50', '2025-08-21 02:15:50', NULL, 'person_phones', 5, 'CREATE', 'Added phone', NULL, '{\":pid\":\"31\",\":type_id\":115,\":status_id\":105,\":start_date\":null,\":end_date\":null,\":number\":\"(224) 236-7938\",\":uid\":1}'),
(115, 1, 1, '2025-08-21 02:16:22', '2025-08-21 02:16:22', NULL, 'module_agency', 4, 'CREATE', 'Created agency', NULL, '{\"organization_id\":2,\"name\":\"State\'s Attorney Office\",\"main_person\":31,\"status\":28}'),
(116, 1, 1, '2025-08-21 02:17:10', '2025-08-21 02:17:10', NULL, 'person', 30, 'UPDATE', 'Updated person', '{\"id\":30,\"user_id\":null,\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-20 21:03:51\",\"date_updated\":\"2025-08-20 21:03:51\",\"memo\":null}', '{\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":2,\"agency_id\":3,\"division_id\":null,\"dob\":null}'),
(117, 1, 1, '2025-08-21 02:17:10', '2025-08-21 02:17:10', NULL, 'person_addresses', 3, 'UPDATE', 'Updated address', NULL, '{\":pid\":30,\":type_id\":111,\":status_id\":108,\":start_date\":\"2014-08-01\",\":end_date\":null,\":line1\":\"123 Test 456 South\",\":line2\":\"\",\":city\":\"Logan\",\":state\":\"Utah\",\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":3}'),
(118, 1, 1, '2025-08-21 02:17:20', '2025-08-21 02:17:20', NULL, 'person', 31, 'UPDATE', 'Updated person', '{\"id\":31,\"user_id\":null,\"first_name\":\"Lonnie\",\"last_name\":\"Renda\",\"email\":\"LRenda@LakeCountyIL.gov\",\"gender_id\":59,\"organization_id\":2,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-21 02:15:50\",\"date_updated\":\"2025-08-21 02:15:50\",\"memo\":null}', '{\"first_name\":\"Lonnie\",\"last_name\":\"Renda\",\"email\":\"LRenda@LakeCountyIL.gov\",\"gender_id\":59,\"organization_id\":2,\"agency_id\":4,\"division_id\":null,\"dob\":null}'),
(119, 1, 1, '2025-08-21 02:17:20', '2025-08-21 02:17:20', NULL, 'person_phones', 5, 'UPDATE', 'Updated phone', NULL, '{\":pid\":31,\":type_id\":115,\":status_id\":105,\":start_date\":null,\":end_date\":null,\":number\":\"(224) 236-7938\",\":uid\":1,\":id\":5}'),
(120, 1, 1, '2025-08-21 02:22:59', '2025-08-21 02:22:59', NULL, 'module_division', 5, 'CREATE', 'Created division', NULL, '{\"agency_id\":3,\"name\":\"Public Defender\",\"main_person\":30,\"status\":27}'),
(121, 1, 1, '2025-08-21 11:35:35', '2025-08-21 11:35:35', NULL, 'module_contractors_compensation', 7, 'CREATE', 'Added compensation', '', '{\"amount\":\"681.82\",\"type\":98,\"title\":\"Pay Period\"}'),
(122, 1, 1, '2025-08-21 11:38:34', '2025-08-21 11:38:34', NULL, 'module_contractors_files', 7, 'UPLOAD', '', '', '{\"file\":\"Aug_21st_2025 - request to be paid 4 days early.PNG\",\"version\":1}'),
(123, 1, 1, '2025-08-21 11:38:47', '2025-08-21 11:38:47', NULL, 'module_contractors_files', 7, 'UPDATE', 'Updated file', '', '{\"file_name\":\"Aug_21st_2025 - request to be paid 4 days early.PNG\",\"version\":1}'),
(124, 1, 1, '2025-08-21 15:36:27', '2025-08-21 15:36:27', NULL, 'module_contractors_contact_responses', 1, 'CREATE', 'Added contact response', '', '{\"response_type_id\":117,\"response_text\":\"No worries -- I certainly don\'t expect a response while on vacation !\\r\\nI definitely still have a need for a BI Analyst building dashboards. I can email you some more specifics if you want to provide me with your personal email address.\"}'),
(125, 1, 1, '2025-08-21 15:37:03', '2025-08-21 15:37:03', NULL, 'module_contractors_contact_responses', 2, 'CREATE', 'Added contact response', '', '{\"response_type_id\":117,\"response_text\":\"emmabaylor@gmail.com\"}'),
(126, 1, 1, '2025-08-21 15:38:14', '2025-08-21 15:38:14', NULL, 'module_projects', 4, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"1\",\"name\":\"ATLIS TECHNOLOGIES - CORE PROJECT\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"29\",\"start_date\":\"2025-08-21\"}'),
(127, 1, 1, '2025-08-21 15:47:56', '2025-08-21 15:47:56', NULL, 'module_division', 2, 'UPDATE', 'Updated division', '{\"agency_id\":2,\"name\":\"Judicial Information Services & Technology\",\"main_person\":null,\"status\":5}', '{\"agency_id\":2,\"name\":\"Judicial Information Services & Technology\",\"main_person\":null,\"status\":6}'),
(128, 1, 1, '2025-08-21 15:48:03', '2025-08-21 15:48:03', NULL, 'module_division', 2, 'UPDATE', 'Updated division', '{\"agency_id\":2,\"name\":\"Judicial Information Services & Technology\",\"main_person\":null,\"status\":6}', '{\"agency_id\":2,\"name\":\"Judicial Information Services & Technology\",\"main_person\":null,\"status\":5}'),
(129, 1, 1, '2025-08-21 15:48:10', '2025-08-21 15:48:10', NULL, 'module_division', 5, 'UPDATE', 'Updated division', '{\"agency_id\":3,\"name\":\"Public Defender\",\"main_person\":30,\"status\":27}', '{\"agency_id\":3,\"name\":\"Public Defender\",\"main_person\":30,\"status\":6}'),
(130, 1, 1, '2025-08-21 18:08:35', '2025-08-21 18:08:35', NULL, 'module_projects', 5, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"2\",\"division_id\":\"3\",\"name\":\"Judge Mass Reassignment\",\"description\":\"Hi Gia & Davey,\\r\\n\\r\\nDo you have any specific requirements or specifications for the Judge Mass Reassignment project? I don\\u2019t want to make this any more complex than necessary\\u2014at a high level, it should be straightforward. For the sake of example, Judge A is the retiring judge and Judge B is the newly assigned judge.\\r\\n\\r\\n\\r\\nThanks,\\r\\nDave\\r\\n\",\"requirements\":\"1) What gets reassigned\\r\\n-\\tReassign all future events currently assigned to Judge A over to Judge B.\\r\\no\\t\\u201cAll\\u201d assumes no filters (Case Type, Event Type, etc.).\\r\\no\\t\\u201cFuture\\u201d assumes we are not modifying past events.\\r\\n-\\tShould any case-level or caseAssignment fields also be updated (for Judge A and\\/or Judge B)?\\r\\n\\r\\n\\r\\n2) Audit, validation, and proof checking\\r\\n-\\tDo you need audit artifacts (e.g., before\\/after counts, per-case change logs with timestamp\\/user, downloadable CSV)?\\r\\n-\\tShould we add guardrails (e.g., exclude sealed\\/closed cases, skip in-progress or same-day events)?\\r\\n\\r\\n\\r\\n3) Execution & UX\\r\\n-\\tOnce Judge A \\u2192 Judge B is selected, should the process run automatically in the background, or would you prefer a preview\\/confirm step with progress tracking?\\r\\n-\\tWould a summary be useful (e.g., via Search, Report, or Email notification)?\",\"specifications\":\"\",\"status\":\"29\",\"start_date\":\"2025-08-21\"}'),
(131, 1, 1, '2025-08-21 18:09:15', '2025-08-21 18:09:15', NULL, 'module_tasks_notes', 12, 'NOTE', '', '', 'Hi Gia & Davey,\r\n\r\nDo you have any specific requirements or specifications for the Judge Mass Reassignment project? I don’t want to make this any more complex than necessary—at a high level, it should be straightforward. For the sake of example, Judge A is the retiring judge and Judge B is the newly assigned judge.\r\n\r\n1) What gets reassigned\r\n-	Reassign all future events currently assigned to Judge A over to Judge B.\r\no	“All” assumes no filters (Case Type, Event Type, etc.).\r\no	“Future” assumes we are not modifying past events.\r\n-	Should any case-level or caseAssignment fields also be updated (for Judge A and/or Judge B)?\r\n\r\n\r\n2) Audit, validation, and proof checking\r\n-	Do you need audit artifacts (e.g., before/after counts, per-case change logs with timestamp/user, downloadable CSV)?\r\n-	Should we add guardrails (e.g., exclude sealed/closed cases, skip in-progress or same-day events)?\r\n\r\n\r\n3) Execution & UX\r\n-	Once Judge A → Judge B is selected, should the process run automatically in the background, or would you prefer a preview/confirm step with progress tracking?\r\n-	Would a summary be useful (e.g., via Search, Report, or Email notification)?\r\n\r\n\r\nThanks,\r\nDave'),
(132, 1, 1, '2025-08-21 22:22:02', '2025-08-21 22:22:02', NULL, 'module_projects', 6, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"1\",\"name\":\"McLean County, IL\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"29\",\"priority\":\"56\",\"start_date\":\"2025-08-21\"}'),
(133, 1, 1, '2025-08-21 22:23:10', '2025-08-21 22:23:10', NULL, 'module_projects_notes', 1, 'NOTE', '', '', 'Sean Cadina will be Account Manager for McLean.'),
(134, 1, 1, '2025-08-21 22:25:38', '2025-08-21 22:25:38', NULL, 'module_projects', 7, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"1\",\"name\":\"JIT 2025 User Conference\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"30\",\"priority\":\"87\",\"start_date\":\"2025-11-13\"}'),
(135, 1, 1, '2025-08-21 22:27:01', '2025-08-21 22:27:01', NULL, 'module_projects_notes', 2, 'NOTE', '', '', 'https://info.journaltech.com/uc2025'),
(136, 1, 1, '2025-08-21 22:27:16', '2025-08-21 22:27:16', NULL, 'module_projects_notes', 3, 'NOTE', '', '', '<a href=\"https://info.journaltech.com/uc2025\">JTI User Conference</a>'),
(137, 1, 1, '2025-08-21 22:27:23', '2025-08-21 22:27:23', NULL, 'module_projects_notes', 3, 'DELETE', '', '<a href=\"https://info.journaltech.com/uc2025\">JTI User Conference</a>', ''),
(138, 1, 1, '2025-08-21 22:27:25', '2025-08-21 22:27:25', NULL, 'module_projects_notes', 2, 'DELETE', '', 'https://info.journaltech.com/uc2025', ''),
(139, 1, 1, '2025-08-21 22:27:53', '2025-08-21 22:27:53', NULL, 'module_projects_notes', 4, 'NOTE', '', '', '<a class=\"fw-bold\" href=\"https://info.journaltech.com/uc2025\" target=_blank>JTI 2025 User Conference</a>'),
(140, 1, 1, '2025-08-21 22:27:56', '2025-08-21 22:27:56', NULL, 'module_projects_notes', 4, 'UPDATE', '', '<a class=\"fw-bold\" href=\"https://info.journaltech.com/uc2025\" target=_blank>JTI 2025 User Conference</a>', 'JTI 2025 User Conference'),
(141, 1, 1, '2025-08-21 22:28:04', '2025-08-21 22:28:04', NULL, 'module_projects_notes', 4, 'UPDATE', '', 'JTI 2025 User Conference', 'JTI 2025 User Conference'),
(142, 1, 1, '2025-08-21 22:28:05', '2025-08-21 22:28:05', NULL, 'module_projects_notes', 4, 'UPDATE', '', 'JTI 2025 User Conference', 'JTI 2025 User Conference'),
(143, 1, 1, '2025-08-21 22:28:09', '2025-08-21 22:28:09', NULL, 'module_projects_notes', 4, 'UPDATE', '', 'JTI 2025 User Conference', '<a class=\"fw-bold\" href=\"https://info.journaltech.com/uc2025\" target=_blank>JTI 2025 User Conference</a>'),
(144, 1, 1, '2025-08-21 22:29:33', '2025-08-21 22:29:33', NULL, 'module_projects_notes', 5, 'NOTE', '', '', 'Registration: https://info.journaltech.com/uc2025-registration\r\n\r\nEvent Summary & Notes:\r\nWelcome Reception: Nov 12, 2025, 7:00 - 9:00 PM\r\nConference Dates: Nov 13-14, 2025\r\nConference Location: 4th Floor, Hudson Loft, 1200 S Hope St, Los Angeles, CA 90015\r\nEarly-Bird Registration (through July 15, 2025): $495\r\nStandard Registration (starting July 16-November 12, 2025): $595\r\nContact events@journaltech.com for group discounts of 3+ attendees of your organization.');

-- --------------------------------------------------------

--
-- Table structure for table `admin_navigation_links`
--

CREATE TABLE `admin_navigation_links` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_navigation_links`
--

INSERT INTO `admin_navigation_links` (`id`, `title`, `path`, `icon`, `sort_order`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`) VALUES
(1, 'Dashboard', 'index.php', 'home', 0, 1, 1, '2025-08-20 00:00:00', '2025-08-20 00:39:14', NULL),
(2, 'Users', 'users/index.php', 'user', 2, 1, 1, '2025-08-20 00:00:00', '2025-08-21 02:22:37', NULL),
(3, 'Persons', 'person/index.php', 'users', 5, 1, 1, '2025-08-20 00:00:00', '2025-08-21 02:22:37', NULL),
(4, 'Contractors', 'contractors/index.php', 'briefcase', 4, 1, 1, '2025-08-20 00:00:00', '2025-08-21 02:22:37', NULL),
(5, 'Lookup Lists', 'lookup-lists/index.php', 'list', 3, 1, 1, '2025-08-20 00:00:00', '2025-08-21 02:22:37', NULL),
(6, 'Roles', 'roles/index.php', 'shield', 6, 1, 1, '2025-08-20 00:00:00', '2025-08-21 02:22:37', NULL),
(7, 'System Properties', 'system-properties/index.php', 'sliders', 7, 1, 1, '2025-08-20 00:00:00', '2025-08-21 02:22:37', NULL),
(8, 'Navigation Links', 'navigation.php', 'settings', 8, 1, 1, '2025-08-20 00:37:23', '2025-08-21 02:22:37', NULL),
(9, 'Orgs', 'orgs/index.php', 'layers', 1, 1, 1, '2025-08-21 02:22:27', '2025-08-21 02:22:37', NULL);

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
(36, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'task', 'delete'),
(37, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor', 'create'),
(38, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor', 'read'),
(39, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor', 'update'),
(40, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor', 'delete'),
(41, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_note', 'create'),
(42, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_note', 'read'),
(43, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_note', 'update'),
(44, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_note', 'delete'),
(45, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_contact', 'create'),
(46, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_contact', 'read'),
(47, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_contact', 'update'),
(48, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_contact', 'delete'),
(49, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_compensation', 'create'),
(50, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_compensation', 'read'),
(51, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_compensation', 'update'),
(52, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_compensation', 'delete'),
(53, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_file', 'create'),
(54, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_file', 'read'),
(55, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_file', 'update'),
(56, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_file', 'delete'),
(57, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_status_history', 'create'),
(58, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_status_history', 'read'),
(59, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_status_history', 'update'),
(60, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'contractor_status_history', 'delete'),
(61, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 'kanban', 'create'),
(62, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 'kanban', 'read'),
(63, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 'kanban', 'update'),
(64, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 'kanban', 'delete');

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
(1, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:06', NULL, 'Users', 'Permissions for managing users'),
(2, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:06', NULL, 'People', 'Permissions for managing people'),
(3, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:06', NULL, 'Agencies', 'Permissions for managing agencies'),
(4, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'Roles', 'Permissions for managing roles'),
(5, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'Organization', 'Permissions for managing organizations'),
(6, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 'Division', 'Permissions for managing divisions'),
(7, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 'System Properties', 'Permissions for system properties'),
(8, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'Projects', 'Permissions for managing projects'),
(9, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'Tasks', 'Permissions for managing tasks'),
(10, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'Contractors', 'Permissions for managing contractors'),
(11, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 'Kanban Boards', 'Permissions for managing kanban boards');

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
(1, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:06', NULL, 1, 1),
(2, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:06', NULL, 1, 2),
(3, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:06', NULL, 1, 3),
(4, 1, 1, '2025-08-06 16:07:50', '2025-08-08 22:17:06', NULL, 1, 4),
(5, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:06', NULL, 2, 5),
(6, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:06', NULL, 2, 6),
(7, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:06', NULL, 2, 7),
(8, 1, 1, '2025-08-06 16:07:59', '2025-08-08 22:17:06', NULL, 2, 8),
(9, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:06', NULL, 3, 9),
(10, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:06', NULL, 3, 10),
(11, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:06', NULL, 3, 11),
(12, 1, 1, '2025-08-06 19:39:18', '2025-08-08 22:17:06', NULL, 3, 12),
(13, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 4, 13),
(14, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 4, 14),
(15, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 4, 15),
(16, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 4, 16),
(17, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 5, 17),
(18, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 5, 18),
(19, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 5, 19),
(20, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 5, 20),
(21, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 6, 21),
(22, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 6, 22),
(23, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 6, 23),
(24, 1, 1, '2025-08-06 21:16:21', '2025-08-08 22:17:06', NULL, 6, 24),
(25, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 7, 25),
(26, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 7, 26),
(27, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 7, 27),
(28, 1, 1, '2025-08-12 19:38:17', '2025-08-12 19:38:17', NULL, 7, 28),
(29, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 8, 29),
(30, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 8, 30),
(31, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 8, 31),
(32, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 8, 32),
(33, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 9, 33),
(34, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 9, 34),
(35, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 9, 35),
(36, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 9, 36),
(37, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 37),
(38, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 38),
(39, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 39),
(40, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 40),
(41, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 41),
(42, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 42),
(43, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 43),
(44, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 44),
(45, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 45),
(46, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 46),
(47, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 47),
(48, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 48),
(49, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 49),
(50, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 50),
(51, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 51),
(52, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 52),
(53, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 53),
(54, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 54),
(55, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 55),
(56, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 56),
(57, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 57),
(58, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 58),
(59, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 59),
(60, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 10, 60),
(61, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 11, 61),
(62, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 11, 62),
(63, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 11, 63),
(64, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 11, 64);

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
(12, 1, 1, '2025-08-17 14:18:03', '2025-08-17 14:18:03', NULL, 'Developer', ''),
(13, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'Contractor Admin', ''),
(14, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'Contractor Manager', '');

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
  `permission_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_role_permissions`
--

INSERT INTO `admin_role_permissions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `role_id`, `permission_group_id`) VALUES
(1, 1, 1, '2025-08-17 14:19:36', '2025-08-17 14:19:36', NULL, 1, 1),
(2, 1, 1, '2025-08-17 14:19:36', '2025-08-17 14:19:36', NULL, 1, 2),
(3, 1, 1, '2025-08-17 14:19:36', '2025-08-17 14:19:36', NULL, 1, 3),
(4, 1, 1, '2025-08-17 14:19:36', '2025-08-17 14:19:36', NULL, 1, 4),
(5, 1, 1, '2025-08-17 14:19:36', '2025-08-17 14:19:36', NULL, 1, 5),
(6, 1, 1, '2025-08-17 14:19:36', '2025-08-17 14:19:36', NULL, 1, 6),
(7, 1, 1, '2025-08-17 14:19:36', '2025-08-17 14:19:36', NULL, 1, 7),
(8, 1, 1, '2025-08-17 14:19:36', '2025-08-17 14:19:36', NULL, 1, 8),
(9, 1, 1, '2025-08-17 14:19:36', '2025-08-17 14:19:36', NULL, 1, 9),
(10, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 10, 1),
(11, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 10, 2),
(12, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 10, 3),
(13, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 10, 4),
(14, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 10, 5),
(15, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 10, 6),
(16, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 10, 7),
(17, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 10, 8),
(18, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 10, 9),
(19, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 11, 1),
(20, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 11, 2),
(21, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 11, 3),
(22, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 11, 4),
(23, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 11, 5),
(24, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 11, 6),
(25, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 11, 7),
(26, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 11, 8),
(27, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 11, 9),
(28, 1, 1, '2025-08-17 14:19:37', '2025-08-17 14:19:37', NULL, 12, 9),
(29, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 1, 10),
(30, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 13, 10),
(31, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 14, 10),
(32, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 1, 11),
(33, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 10, 11),
(34, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 11, 11),
(35, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 12, 11),
(36, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 13, 11),
(37, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 14, 11);

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_permission_groups`
--

CREATE TABLE `admin_role_permission_groups` (
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
-- Dumping data for table `admin_role_permission_groups`
--

INSERT INTO `admin_role_permission_groups` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `role_id`, `permission_group_id`) VALUES
(10, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 1, 3),
(11, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 1, 6),
(12, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 1, 5),
(13, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 1, 2),
(14, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 1, 8),
(15, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 1, 4),
(16, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 1, 7),
(17, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 1, 9),
(18, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 1, 1),
(19, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 10, 3),
(20, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 10, 6),
(21, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 10, 5),
(22, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 10, 2),
(23, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 10, 8),
(24, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 10, 9),
(25, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 11, 8),
(26, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 11, 9),
(27, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 12, 8),
(28, 1, 1, '2025-08-17 22:21:27', '2025-08-17 22:21:27', NULL, 12, 9),
(29, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 1, 10),
(30, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 13, 10),
(31, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 14, 10),
(32, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 1, 11),
(33, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 10, 11),
(34, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 11, 11),
(35, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 12, 11),
(36, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 13, 11),
(37, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 14, 11);

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
(239, 1, 1, '2025-08-17 11:03:59', '2025-08-17 11:03:59', NULL, 'module_projects', 8, 'UPDATE', 'Updated priority to 57'),
(240, 1, 1, '2025-08-17 18:49:32', '2025-08-17 18:49:32', NULL, 'module_tasks', 9, 'UPDATE', 'Completed task'),
(241, 1, 1, '2025-08-17 18:49:34', '2025-08-17 18:49:34', NULL, 'module_tasks', 11, 'UPDATE', 'Completed task'),
(242, 1, 1, '2025-08-17 18:50:04', '2025-08-17 18:50:04', NULL, 'module_tasks', 16, 'UPDATE', 'Completed task'),
(243, 1, 1, '2025-08-17 18:50:04', '2025-08-17 18:50:04', NULL, 'module_tasks', 16, 'UPDATE', 'Marked task incomplete'),
(244, 1, 1, '2025-08-17 18:50:05', '2025-08-17 18:50:05', NULL, 'module_tasks', 15, 'UPDATE', 'Marked task incomplete'),
(245, 1, 1, '2025-08-17 18:50:06', '2025-08-17 18:50:06', NULL, 'module_tasks', 13, 'UPDATE', 'Marked task incomplete'),
(246, 1, 1, '2025-08-17 18:50:18', '2025-08-17 18:50:18', NULL, 'module_tasks', 13, 'UPDATE', 'Completed task'),
(247, 1, 1, '2025-08-17 18:50:19', '2025-08-17 18:50:19', NULL, 'module_tasks', 13, 'UPDATE', 'Marked task incomplete'),
(248, 1, 1, '2025-08-17 18:50:20', '2025-08-17 18:50:20', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(249, 1, 1, '2025-08-17 18:50:20', '2025-08-17 18:50:20', NULL, 'module_tasks', 15, 'UPDATE', 'Marked task incomplete'),
(250, 1, 1, '2025-08-17 19:03:19', '2025-08-17 19:03:19', NULL, 'module_tasks', 13, 'UPDATE', 'Completed task'),
(251, 1, 1, '2025-08-17 19:03:20', '2025-08-17 19:03:20', NULL, 'module_tasks', 13, 'UPDATE', 'Marked task incomplete'),
(252, 1, 1, '2025-08-17 19:03:20', '2025-08-17 19:03:20', NULL, 'module_tasks', 13, 'UPDATE', 'Completed task'),
(253, 1, 1, '2025-08-17 19:03:24', '2025-08-17 19:03:24', NULL, 'module_tasks', 3, 'UPDATE', 'Marked task incomplete'),
(254, 1, 1, '2025-08-17 19:03:25', '2025-08-17 19:03:25', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(255, 1, 1, '2025-08-17 19:03:26', '2025-08-17 19:03:26', NULL, 'module_tasks', 2, 'UPDATE', 'Completed task'),
(256, 1, 1, '2025-08-17 19:03:28', '2025-08-17 19:03:28', NULL, 'module_tasks', 13, 'UPDATE', 'Marked task incomplete'),
(257, 1, 1, '2025-08-17 19:03:29', '2025-08-17 19:03:29', NULL, 'module_tasks', 13, 'UPDATE', 'Completed task'),
(258, 1, 1, '2025-08-17 19:09:08', '2025-08-17 19:09:08', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(259, 1, 1, '2025-08-17 19:09:08', '2025-08-17 19:09:08', NULL, 'module_tasks', 15, 'UPDATE', 'Marked task incomplete'),
(260, 1, 1, '2025-08-17 19:09:11', '2025-08-17 19:09:11', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(261, 1, 1, '2025-08-17 19:09:12', '2025-08-17 19:09:12', NULL, 'module_tasks', 15, 'UPDATE', 'Marked task incomplete'),
(262, 1, 1, '2025-08-17 19:09:15', '2025-08-17 19:09:15', NULL, 'module_tasks', 15, 'UPDATE', 'Updated task'),
(263, 1, 1, '2025-08-17 19:09:16', '2025-08-17 19:09:16', NULL, 'module_tasks', 16, 'UPDATE', 'Updated task'),
(264, 1, 1, '2025-08-17 19:09:18', '2025-08-17 19:09:18', NULL, 'module_tasks', 18, 'UPDATE', 'Updated task'),
(265, 1, 1, '2025-08-17 19:09:19', '2025-08-17 19:09:19', NULL, 'module_tasks', 18, 'UPDATE', 'Marked task incomplete'),
(266, 1, 1, '2025-08-17 19:09:20', '2025-08-17 19:09:20', NULL, 'module_tasks', 19, 'UPDATE', 'Marked task incomplete'),
(267, 1, 1, '2025-08-17 19:09:20', '2025-08-17 19:09:20', NULL, 'module_tasks', 2, 'UPDATE', 'Marked task incomplete'),
(268, 1, 1, '2025-08-17 19:09:21', '2025-08-17 19:09:21', NULL, 'module_tasks', 3, 'UPDATE', 'Marked task incomplete'),
(269, 1, 1, '2025-08-17 19:09:21', '2025-08-17 19:09:21', NULL, 'module_tasks', 4, 'UPDATE', 'Marked task incomplete'),
(270, 1, 1, '2025-08-17 19:09:22', '2025-08-17 19:09:22', NULL, 'module_tasks', 8, 'UPDATE', 'Marked task incomplete'),
(271, 1, 1, '2025-08-17 19:09:25', '2025-08-17 19:09:25', NULL, 'module_tasks', 9, 'UPDATE', 'Marked task incomplete'),
(272, 1, 1, '2025-08-17 19:09:25', '2025-08-17 19:09:25', NULL, 'module_tasks', 10, 'UPDATE', 'Marked task incomplete'),
(273, 1, 1, '2025-08-17 19:09:27', '2025-08-17 19:09:27', NULL, 'module_tasks', 10, 'UPDATE', 'Updated task'),
(274, 1, 1, '2025-08-17 19:09:29', '2025-08-17 19:09:29', NULL, 'module_tasks', 9, 'UPDATE', 'Updated task'),
(275, 1, 1, '2025-08-17 19:09:31', '2025-08-17 19:09:31', NULL, 'module_tasks', 8, 'UPDATE', 'Updated task'),
(276, 1, 1, '2025-08-17 19:09:33', '2025-08-17 19:09:33', NULL, 'module_tasks', 4, 'UPDATE', 'Updated task'),
(277, 1, 1, '2025-08-17 19:13:35', '2025-08-17 19:13:35', NULL, 'module_tasks', 11, 'UPDATE', 'Updated task'),
(278, 1, 1, '2025-08-17 21:14:43', '2025-08-17 21:14:43', NULL, 'lookup_list_items', 62, 'DELETE', 'Deleted lookup list item'),
(279, 1, 1, '2025-08-17 21:14:45', '2025-08-17 21:14:45', NULL, 'lookup_list_items', 61, 'DELETE', 'Deleted lookup list item'),
(280, 1, 1, '2025-08-17 22:21:54', '2025-08-17 22:21:54', NULL, 'module_tasks', 15, 'UPDATE', 'Completed task'),
(281, 1, 1, '2025-08-17 22:21:57', '2025-08-17 22:21:57', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(282, 1, 1, '2025-08-17 22:23:52', '2025-08-17 22:23:52', NULL, 'lookup_list_item_attributes', 14, 'DELETE', 'Deleted item attribute'),
(283, 1, 1, '2025-08-17 22:23:55', '2025-08-17 22:23:55', NULL, 'lookup_list_items', 33, 'DELETE', 'Deleted lookup list item'),
(284, 1, 1, '2025-08-17 22:24:01', '2025-08-17 22:24:01', NULL, 'lookup_list_item_attributes', 33, 'UPDATE', 'Updated item attribute'),
(285, 1, 1, '2025-08-17 22:24:09', '2025-08-17 22:24:09', NULL, 'lookup_list_item_attributes', 27, 'UPDATE', 'Updated item attribute'),
(286, 1, 1, '2025-08-17 22:24:26', '2025-08-17 22:24:26', NULL, 'lookup_list_item_attributes', 37, 'CREATE', 'Created item attribute'),
(287, 1, 1, '2025-08-17 22:24:39', '2025-08-17 22:24:39', NULL, 'lookup_list_item_attributes', 38, 'CREATE', 'Created item attribute'),
(288, 1, 1, '2025-08-17 22:24:53', '2025-08-17 22:24:53', NULL, 'lookup_list_item_attributes', 39, 'CREATE', 'Created item attribute'),
(289, 1, 1, '2025-08-17 22:25:11', '2025-08-17 22:25:11', NULL, 'lookup_list_item_attributes', 32, 'UPDATE', 'Updated item attribute'),
(290, 1, 1, '2025-08-17 22:25:14', '2025-08-17 22:25:14', NULL, 'lookup_list_item_attributes', 11, 'UPDATE', 'Updated item attribute'),
(291, 1, 1, '2025-08-17 22:25:20', '2025-08-17 22:25:20', NULL, 'lookup_list_item_attributes', 40, 'CREATE', 'Created item attribute'),
(292, 1, 1, '2025-08-17 22:25:33', '2025-08-17 22:25:33', NULL, 'lookup_list_item_attributes', 41, 'CREATE', 'Created item attribute'),
(293, 1, 1, '2025-08-17 22:25:45', '2025-08-17 22:25:45', NULL, 'lookup_list_item_attributes', 42, 'CREATE', 'Created item attribute'),
(294, 1, 1, '2025-08-17 22:25:59', '2025-08-17 22:25:59', NULL, 'lookup_list_item_attributes', 43, 'CREATE', 'Created item attribute'),
(295, 1, 1, '2025-08-17 22:26:05', '2025-08-17 22:26:05', NULL, 'lookup_list_item_attributes', 44, 'CREATE', 'Created item attribute'),
(296, 1, 1, '2025-08-17 22:26:21', '2025-08-17 22:26:21', NULL, 'lookup_list_items', 63, 'CREATE', 'Created lookup list item'),
(297, 1, 1, '2025-08-17 22:26:30', '2025-08-17 22:26:30', NULL, 'lookup_list_item_attributes', 45, 'CREATE', 'Created item attribute'),
(298, 1, 1, '2025-08-17 22:26:34', '2025-08-17 22:26:34', NULL, 'lookup_list_item_attributes', 46, 'CREATE', 'Created item attribute'),
(299, 1, 1, '2025-08-17 22:26:47', '2025-08-17 22:26:47', NULL, 'lookup_list_item_attributes', 47, 'CREATE', 'Created item attribute'),
(300, 1, 1, '2025-08-17 22:26:56', '2025-08-17 22:26:56', NULL, 'lookup_list_item_attributes', 31, 'DELETE', 'Deleted item attribute'),
(301, 1, 1, '2025-08-17 22:26:59', '2025-08-17 22:26:59', NULL, 'lookup_list_item_attributes', 48, 'CREATE', 'Created item attribute'),
(302, 1, 1, '2025-08-17 22:27:07', '2025-08-17 22:27:07', NULL, 'lookup_list_item_attributes', 49, 'CREATE', 'Created item attribute'),
(303, 1, 1, '2025-08-17 22:27:26', '2025-08-17 22:27:26', NULL, 'lookup_list_item_attributes', 49, 'UPDATE', 'Updated item attribute'),
(304, 1, 1, '2025-08-17 22:27:30', '2025-08-17 22:27:30', NULL, 'lookup_list_item_attributes', 50, 'CREATE', 'Created item attribute'),
(305, 1, 1, '2025-08-17 22:27:39', '2025-08-17 22:27:39', NULL, 'lookup_list_item_attributes', 51, 'CREATE', 'Created item attribute'),
(306, 1, 1, '2025-08-17 22:27:44', '2025-08-17 22:27:44', NULL, 'lookup_list_item_attributes', 52, 'CREATE', 'Created item attribute'),
(307, 1, 1, '2025-08-17 22:27:48', '2025-08-17 22:27:48', NULL, 'lookup_list_item_attributes', 53, 'CREATE', 'Created item attribute'),
(308, 1, 1, '2025-08-17 22:28:37', '2025-08-17 22:28:37', NULL, 'module_tasks', 19, 'UPDATE', 'Completed task'),
(309, 1, 1, '2025-08-17 22:28:37', '2025-08-17 22:28:37', NULL, 'module_tasks', 19, 'UPDATE', 'Marked task incomplete'),
(310, 1, 1, '2025-08-17 22:28:40', '2025-08-17 22:28:40', NULL, 'module_tasks', 19, 'UPDATE', 'Updated task status'),
(311, 1, 1, '2025-08-17 22:28:42', '2025-08-17 22:28:42', NULL, 'module_tasks', 19, 'UPDATE', 'Completed task'),
(312, 1, 1, '2025-08-17 22:28:55', '2025-08-17 22:28:55', NULL, 'module_tasks', 21, 'CREATE', 'Created task'),
(313, 1, 1, '2025-08-17 22:28:56', '2025-08-17 22:28:56', NULL, 'module_tasks', 22, 'CREATE', 'Created task'),
(314, 1, 1, '2025-08-17 22:28:58', '2025-08-17 22:28:58', NULL, 'module_tasks', 23, 'CREATE', 'Created task'),
(315, 1, 1, '2025-08-18 14:33:18', '2025-08-18 14:33:18', NULL, 'module_tasks', 24, 'CREATE', 'Created task'),
(316, 1, 1, '2025-08-18 15:29:37', '2025-08-18 15:29:37', NULL, 'lookup_lists', 16, 'CREATE', 'Created lookup list'),
(317, 1, 1, '2025-08-18 15:29:50', '2025-08-18 15:29:50', NULL, 'lookup_lists', 17, 'CREATE', 'Created lookup list'),
(318, 1, 1, '2025-08-18 15:29:59', '2025-08-18 15:29:59', NULL, 'lookup_lists', 18, 'CREATE', 'Created lookup list'),
(319, 1, 1, '2025-08-18 15:30:20', '2025-08-18 15:30:20', NULL, 'lookup_lists', 19, 'CREATE', 'Created lookup list'),
(320, 1, 1, '2025-08-18 15:32:11', '2025-08-18 15:32:11', NULL, 'lookup_lists', 20, 'CREATE', 'Created lookup list'),
(321, 1, 1, '2025-08-18 22:17:58', '2025-08-18 22:17:58', NULL, 'module_tasks', 4, 'UPDATE', 'Updated task status'),
(322, 1, 1, '2025-08-18 22:18:05', '2025-08-18 22:18:05', NULL, 'module_tasks', 8, 'UPDATE', 'Completed task'),
(323, 1, 1, '2025-08-18 22:18:08', '2025-08-18 22:18:08', NULL, 'module_tasks', 8, 'UPDATE', 'Marked task incomplete'),
(324, 1, 1, '2025-08-18 22:18:11', '2025-08-18 22:18:11', NULL, 'module_tasks', 8, 'UPDATE', 'Updated task status'),
(325, 1, 1, '2025-08-18 22:19:34', '2025-08-18 22:19:34', NULL, 'module_tasks', 9, 'UPDATE', 'Completed task'),
(326, 1, 1, '2025-08-18 22:23:34', '2025-08-18 22:23:34', NULL, 'module_tasks', 24, 'UPDATE', 'Completed task'),
(327, 1, 1, '2025-08-18 22:23:42', '2025-08-18 22:23:42', NULL, 'module_tasks', 12, 'UPDATE', 'Updated task priority'),
(328, 1, 1, '2025-08-18 22:23:46', '2025-08-18 22:23:46', NULL, 'module_tasks', 7, 'UPDATE', 'Completed task'),
(329, 1, 1, '2025-08-18 22:23:47', '2025-08-18 22:23:47', NULL, 'module_tasks', 7, 'UPDATE', 'Marked task incomplete'),
(330, 1, 1, '2025-08-18 22:23:49', '2025-08-18 22:23:49', NULL, 'module_tasks', 7, 'UPDATE', 'Completed task'),
(331, 1, 1, '2025-08-18 22:23:51', '2025-08-18 22:23:51', NULL, 'module_tasks', 24, 'UPDATE', 'Marked task incomplete'),
(332, 1, 1, '2025-08-18 22:24:10', '2025-08-18 22:24:10', NULL, 'module_tasks', 2, 'UPDATE', 'Completed task'),
(333, 1, 1, '2025-08-18 22:24:11', '2025-08-18 22:24:11', NULL, 'module_tasks', 2, 'UPDATE', 'Marked task incomplete'),
(334, 1, 1, '2025-08-18 22:46:29', '2025-08-18 22:46:29', NULL, 'module_tasks', 21, 'UPDATE', 'Completed task'),
(335, 1, 1, '2025-08-18 22:46:33', '2025-08-18 22:46:33', NULL, 'module_tasks', 21, 'UPDATE', 'Marked task incomplete'),
(336, 1, 1, '2025-08-18 22:46:37', '2025-08-18 22:46:37', NULL, 'module_tasks', 21, 'UPDATE', 'Updated task status'),
(337, 1, 1, '2025-08-18 22:46:43', '2025-08-18 22:46:43', NULL, 'module_tasks', 21, 'UPDATE', 'Completed task'),
(338, 1, 1, '2025-08-18 22:46:47', '2025-08-18 22:46:47', NULL, 'module_tasks', 21, 'UPDATE', 'Marked task incomplete'),
(339, 1, 1, '2025-08-18 22:48:12', '2025-08-18 22:48:12', NULL, 'module_projects_assignments', 7, 'DELETE', 'Removed user assignment'),
(340, 1, 1, '2025-08-18 22:48:15', '2025-08-18 22:48:15', NULL, 'module_projects_assignments', 8, 'ASSIGN', 'Assigned user'),
(341, 1, 1, '2025-08-18 22:48:17', '2025-08-18 22:48:17', NULL, 'module_projects_assignments', 9, 'ASSIGN', 'Assigned user'),
(342, 1, 1, '2025-08-19 22:59:41', '2025-08-19 22:59:41', NULL, 'module_tasks', 6, 'UPDATE', 'Updated task status'),
(343, 1, 1, '2025-08-19 23:00:03', '2025-08-19 23:00:03', NULL, 'lookup_list_items', 32, 'UPDATE', 'Updated lookup list item'),
(344, 1, 1, '2025-08-19 23:01:17', '2025-08-19 23:01:17', NULL, 'module_projects_assignments', 1, 'ASSIGN', 'Assigned user'),
(345, 1, 1, '2025-08-19 23:01:26', '2025-08-19 23:01:26', NULL, 'module_tasks', 17, 'CREATE', 'Created task'),
(346, 1, 1, '2025-08-19 23:01:30', '2025-08-19 23:01:30', NULL, 'module_tasks', 17, 'UPDATE', 'Updated task priority'),
(347, 1, 1, '2025-08-19 23:02:12', '2025-08-19 23:02:12', NULL, 'module_tasks', 18, 'CREATE', 'Created task'),
(348, 1, 1, '2025-08-19 23:02:15', '2025-08-19 23:02:15', NULL, 'module_projects_assignments', 2, 'ASSIGN', 'Assigned user'),
(349, 1, 1, '2025-08-19 23:02:19', '2025-08-19 23:02:19', NULL, 'module_task_assignments', 1, 'ASSIGN', 'Assigned user'),
(350, 1, 1, '2025-08-19 23:04:14', '2025-08-19 23:04:14', NULL, 'module_projects', 2, 'UPDATE', 'Updated status to 29'),
(351, 1, 1, '2025-08-19 23:04:17', '2025-08-19 23:04:17', NULL, 'module_projects', 2, 'UPDATE', 'Updated priority to 57'),
(352, 1, 1, '2025-08-19 23:04:25', '2025-08-19 23:04:25', NULL, 'module_projects', 1, 'UPDATE', 'Updated priority to 56'),
(353, 1, 1, '2025-08-19 23:04:55', '2025-08-19 23:04:55', NULL, 'lookup_list_items', 84, 'CREATE', 'Created lookup list item'),
(354, 1, 1, '2025-08-19 23:13:32', '2025-08-19 23:13:32', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(355, 1, 1, '2025-08-19 23:20:21', '2025-08-19 23:20:21', NULL, 'lookup_list_items', 86, 'DELETE', 'Deleted lookup list item'),
(356, 1, 1, '2025-08-19 23:20:48', '2025-08-19 23:20:48', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(357, 1, 1, '2025-08-19 23:21:00', '2025-08-19 23:21:00', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(358, 1, 1, '2025-08-19 23:24:13', '2025-08-19 23:24:13', NULL, 'module_projects', 2, 'UPDATE', 'Updated priority to 58'),
(359, 1, 1, '2025-08-19 23:24:25', '2025-08-19 23:24:25', NULL, 'module_tasks', 18, 'UPDATE', 'Updated task'),
(360, 1, 1, '2025-08-19 23:24:30', '2025-08-19 23:24:30', NULL, 'module_tasks', 18, 'UPDATE', 'Updated task'),
(361, 1, 1, '2025-08-19 23:24:40', '2025-08-19 23:24:40', NULL, 'module_projects_assignments', 3, 'ASSIGN', 'Assigned user'),
(362, 1, 1, '2025-08-19 23:24:41', '2025-08-19 23:24:41', NULL, 'module_projects_assignments', 4, 'ASSIGN', 'Assigned user'),
(363, 1, 1, '2025-08-19 23:24:44', '2025-08-19 23:24:44', NULL, 'module_projects_assignments', 5, 'ASSIGN', 'Assigned user'),
(364, 1, 1, '2025-08-20 00:12:36', '2025-08-20 00:12:36', NULL, 'module_tasks', 17, 'UPDATE', 'Completed task'),
(365, 1, 1, '2025-08-20 00:13:16', '2025-08-20 00:13:16', NULL, 'module_tasks', 19, 'CREATE', 'Created task'),
(366, 1, 1, '2025-08-20 00:13:56', '2025-08-20 00:13:56', NULL, 'module_tasks', 17, 'UPDATE', 'Updated task'),
(367, 1, 1, '2025-08-20 00:17:19', '2025-08-20 00:17:19', NULL, 'module_projects_assignments', 6, 'ASSIGN', 'Assigned user'),
(368, 1, 1, '2025-08-20 00:17:23', '2025-08-20 00:17:23', NULL, 'module_projects_assignments', 7, 'ASSIGN', 'Assigned user'),
(369, 1, 1, '2025-08-20 00:17:29', '2025-08-20 00:17:29', NULL, 'module_projects_assignments', 8, 'ASSIGN', 'Assigned user'),
(370, 1, 1, '2025-08-20 00:21:07', '2025-08-20 00:21:07', NULL, 'module_tasks', 20, 'CREATE', 'Created task'),
(371, 1, 1, '2025-08-20 00:21:11', '2025-08-20 00:21:11', NULL, 'module_tasks', 20, 'UPDATE', 'Updated task priority'),
(372, 1, 1, '2025-08-20 00:22:10', '2025-08-20 00:22:10', NULL, 'lookup_lists', 23, 'CREATE', 'Created lookup list'),
(373, 1, 1, '2025-08-20 00:22:57', '2025-08-20 00:22:57', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(374, 1, 1, '2025-08-20 00:23:04', '2025-08-20 00:23:04', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(375, 1, 1, '2025-08-20 00:23:08', '2025-08-20 00:23:08', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(376, 1, 1, '2025-08-20 00:23:15', '2025-08-20 00:23:15', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(377, 1, 1, '2025-08-20 00:23:22', '2025-08-20 00:23:22', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(378, 1, 1, '2025-08-20 00:23:28', '2025-08-20 00:23:28', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(379, 1, 1, '2025-08-20 00:23:34', '2025-08-20 00:23:34', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(380, 1, 1, '2025-08-20 00:23:41', '2025-08-20 00:23:41', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(381, 1, 1, '2025-08-20 00:23:53', '2025-08-20 00:23:53', NULL, 'lookup_list_items', 93, 'UPDATE', 'Updated lookup list item'),
(382, 1, 1, '2025-08-20 00:24:00', '2025-08-20 00:24:00', NULL, 'lookup_list_items', 92, 'UPDATE', 'Updated lookup list item'),
(383, 1, 1, '2025-08-20 00:24:12', '2025-08-20 00:24:12', NULL, 'lookup_list_items', 90, 'UPDATE', 'Updated lookup list item'),
(384, 1, 1, '2025-08-20 00:24:15', '2025-08-20 00:24:15', NULL, 'lookup_list_items', 88, 'UPDATE', 'Updated lookup list item'),
(385, 1, 1, '2025-08-20 00:24:18', '2025-08-20 00:24:18', NULL, 'lookup_list_items', 95, 'UPDATE', 'Updated lookup list item'),
(386, 1, 1, '2025-08-20 00:24:25', '2025-08-20 00:24:25', NULL, 'lookup_list_items', 89, 'UPDATE', 'Updated lookup list item'),
(387, 1, 1, '2025-08-20 00:24:28', '2025-08-20 00:24:28', NULL, 'lookup_list_items', 93, 'UPDATE', 'Updated lookup list item'),
(388, 1, 1, '2025-08-20 00:24:32', '2025-08-20 00:24:32', NULL, 'lookup_list_items', 94, 'UPDATE', 'Updated lookup list item'),
(389, 1, 1, '2025-08-20 00:24:36', '2025-08-20 00:24:36', NULL, 'lookup_list_items', 91, 'UPDATE', 'Updated lookup list item'),
(390, 1, 1, '2025-08-20 00:42:04', '2025-08-20 00:42:04', NULL, 'module_projects', 3, 'UPDATE', 'Updated priority to 57'),
(391, 1, 1, '2025-08-20 00:42:07', '2025-08-20 00:42:07', NULL, 'module_projects', 3, 'UPDATE', 'Updated status to 29'),
(392, 1, 1, '2025-08-20 00:42:11', '2025-08-20 00:42:11', NULL, 'module_tasks', 20, 'UPDATE', 'Completed task'),
(393, 1, 1, '2025-08-20 00:42:24', '2025-08-20 00:42:24', NULL, 'module_projects', 3, 'UPDATE', 'Updated status to 31'),
(394, 1, 1, '2025-08-20 00:43:16', '2025-08-20 00:43:16', NULL, 'module_tasks', 3, 'UPDATE', 'Completed task'),
(395, 1, 1, '2025-08-20 00:45:39', '2025-08-20 00:45:39', NULL, 'lookup_list_item_attributes', 63, 'DELETE', 'Deleted item attribute'),
(396, 1, 1, '2025-08-20 00:45:53', '2025-08-20 00:45:53', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(397, 1, 1, '2025-08-20 00:45:58', '2025-08-20 00:45:58', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(398, 1, 1, '2025-08-20 00:46:08', '2025-08-20 00:46:08', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(399, 1, 1, '2025-08-20 00:46:11', '2025-08-20 00:46:11', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(400, 1, 1, '2025-08-20 00:46:18', '2025-08-20 00:46:18', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(401, 1, 1, '2025-08-20 14:37:36', '2025-08-20 14:37:36', NULL, 'lookup_list_item_attributes', 74, 'DELETE', 'Deleted item attribute'),
(402, 1, 1, '2025-08-20 14:37:41', '2025-08-20 14:37:41', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(403, 1, 1, '2025-08-20 14:38:06', '2025-08-20 14:38:06', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(404, 1, 1, '2025-08-20 14:38:16', '2025-08-20 14:38:16', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(405, 1, 1, '2025-08-20 15:07:24', '2025-08-20 15:07:24', NULL, 'lookup_list_item_attributes', 60, 'DELETE', 'Deleted item attribute'),
(406, 1, 1, '2025-08-20 15:07:28', '2025-08-20 15:07:28', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(407, 1, 1, '2025-08-20 20:48:17', '2025-08-20 20:48:17', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(408, 1, 1, '2025-08-20 20:48:24', '2025-08-20 20:48:24', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(409, 1, 1, '2025-08-20 20:50:24', '2025-08-20 20:50:24', NULL, 'lookup_lists', 24, 'CREATE', 'Created lookup list'),
(410, 1, 1, '2025-08-20 20:55:43', '2025-08-20 20:55:43', NULL, 'lookup_lists', 25, 'CREATE', 'Created lookup list'),
(411, 1, 1, '2025-08-20 20:55:56', '2025-08-20 20:55:56', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(412, 1, 1, '2025-08-20 20:56:02', '2025-08-20 20:56:02', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(413, 1, 1, '2025-08-20 20:56:13', '2025-08-20 20:56:13', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(414, 1, 1, '2025-08-20 20:56:27', '2025-08-20 20:56:27', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(415, 1, 1, '2025-08-20 20:56:42', '2025-08-20 20:56:42', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(416, 1, 1, '2025-08-20 20:57:39', '2025-08-20 20:57:39', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute');
INSERT INTO `audit_log` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `table_name`, `record_id`, `action`, `details`) VALUES
(417, 1, 1, '2025-08-20 20:57:50', '2025-08-20 20:57:50', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(418, 1, 1, '2025-08-20 20:58:29', '2025-08-20 20:58:29', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(419, 1, 1, '2025-08-20 20:58:35', '2025-08-20 20:58:35', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(420, 1, 1, '2025-08-20 20:58:45', '2025-08-20 20:58:45', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(421, 1, 1, '2025-08-20 20:58:49', '2025-08-20 20:58:49', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(422, 1, 1, '2025-08-20 21:07:06', '2025-08-20 21:07:06', NULL, 'lookup_lists', 26, 'CREATE', 'Created lookup list'),
(423, 1, 1, '2025-08-20 21:07:13', '2025-08-20 21:07:13', NULL, 'lookup_lists', 27, 'CREATE', 'Created lookup list'),
(424, 1, 1, '2025-08-20 21:07:53', '2025-08-20 21:07:53', NULL, 'lookup_lists', 28, 'CREATE', 'Created lookup list'),
(425, 1, 1, '2025-08-20 21:07:59', '2025-08-20 21:07:59', NULL, 'lookup_lists', 29, 'CREATE', 'Created lookup list'),
(426, 1, 1, '2025-08-20 21:10:20', '2025-08-20 21:10:20', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(427, 1, 1, '2025-08-20 21:10:26', '2025-08-20 21:10:26', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(428, 1, 1, '2025-08-20 21:10:32', '2025-08-20 21:10:32', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(429, 1, 1, '2025-08-20 21:10:39', '2025-08-20 21:10:39', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(430, 1, 1, '2025-08-20 21:10:42', '2025-08-20 21:10:42', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(431, 1, 1, '2025-08-20 21:10:45', '2025-08-20 21:10:45', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(432, 1, 1, '2025-08-20 21:10:50', '2025-08-20 21:10:50', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(433, 1, 1, '2025-08-20 21:12:03', '2025-08-20 21:12:03', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(434, 1, 1, '2025-08-20 21:12:08', '2025-08-20 21:12:08', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(435, 1, 1, '2025-08-20 21:12:14', '2025-08-20 21:12:14', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(436, 1, 1, '2025-08-20 21:12:18', '2025-08-20 21:12:18', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(437, 1, 1, '2025-08-20 21:12:23', '2025-08-20 21:12:23', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(438, 1, 1, '2025-08-20 21:12:27', '2025-08-20 21:12:27', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(439, 1, 1, '2025-08-20 21:12:32', '2025-08-20 21:12:32', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(440, 1, 1, '2025-08-20 21:12:49', '2025-08-20 21:12:49', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(441, 1, 1, '2025-08-20 21:12:56', '2025-08-20 21:12:56', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(442, 1, 1, '2025-08-20 21:13:02', '2025-08-20 21:13:02', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(443, 1, 1, '2025-08-20 21:13:10', '2025-08-20 21:13:10', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(444, 1, 1, '2025-08-20 21:13:15', '2025-08-20 21:13:15', NULL, 'lookup_list_item_attributes', 93, 'UPDATE', 'Updated item attribute'),
(445, 1, 1, '2025-08-20 21:13:19', '2025-08-20 21:13:19', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(446, 1, 1, '2025-08-20 21:13:33', '2025-08-20 21:13:33', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(447, 1, 1, '2025-08-20 21:13:39', '2025-08-20 21:13:39', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(448, 1, 1, '2025-08-20 21:13:44', '2025-08-20 21:13:44', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(449, 1, 1, '2025-08-20 21:13:50', '2025-08-20 21:13:50', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(450, 1, 1, '2025-08-20 21:13:54', '2025-08-20 21:13:54', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(451, 1, 1, '2025-08-20 21:13:58', '2025-08-20 21:13:58', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(452, 1, 1, '2025-08-20 21:14:03', '2025-08-20 21:14:03', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(453, 1, 1, '2025-08-20 21:14:13', '2025-08-20 21:14:13', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(454, 1, 1, '2025-08-20 21:14:17', '2025-08-20 21:14:17', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(455, 1, 1, '2025-08-20 21:14:22', '2025-08-20 21:14:22', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(456, 1, 1, '2025-08-20 21:14:29', '2025-08-20 21:14:29', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(457, 1, 1, '2025-08-20 21:14:38', '2025-08-20 21:14:38', NULL, 'lookup_list_items', 118, 'UPDATE', 'Updated lookup list item'),
(458, 1, 1, '2025-08-20 21:14:43', '2025-08-20 21:14:43', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(459, 1, 1, '2025-08-20 21:14:49', '2025-08-20 21:14:49', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(460, 1, 1, '2025-08-20 21:14:54', '2025-08-20 21:14:54', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(461, 1, 1, '2025-08-21 01:44:58', '2025-08-21 01:44:58', NULL, 'lookup_list_items', 73, 'UPDATE', 'Updated lookup list item'),
(462, 1, 1, '2025-08-21 01:45:07', '2025-08-21 01:45:07', NULL, 'lookup_list_items', 74, 'UPDATE', 'Updated lookup list item'),
(463, 1, 1, '2025-08-21 01:45:13', '2025-08-21 01:45:13', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(464, 1, 1, '2025-08-21 01:45:20', '2025-08-21 01:45:20', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(465, 1, 1, '2025-08-21 01:45:31', '2025-08-21 01:45:31', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(466, 1, 1, '2025-08-21 01:45:47', '2025-08-21 01:45:47', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(467, 1, 1, '2025-08-21 01:45:57', '2025-08-21 01:45:57', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(468, 1, 1, '2025-08-21 01:46:46', '2025-08-21 01:46:46', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(469, 1, 1, '2025-08-21 01:47:01', '2025-08-21 01:47:01', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(470, 1, 1, '2025-08-21 01:47:10', '2025-08-21 01:47:10', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(471, 1, 1, '2025-08-21 01:47:45', '2025-08-21 01:47:45', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(472, 1, 1, '2025-08-21 01:47:48', '2025-08-21 01:47:48', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(473, 1, 1, '2025-08-21 01:47:52', '2025-08-21 01:47:52', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(474, 1, 1, '2025-08-21 01:47:56', '2025-08-21 01:47:56', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(475, 1, 1, '2025-08-21 01:54:31', '2025-08-21 01:54:31', NULL, 'lookup_list_items', 73, 'UPDATE', 'Updated lookup list item'),
(476, 1, 1, '2025-08-21 02:31:08', '2025-08-21 02:31:08', NULL, 'lookup_list_items', 95, 'UPDATE', 'Updated lookup list item'),
(477, 1, 1, '2025-08-21 02:31:25', '2025-08-21 02:31:25', NULL, 'lookup_list_items', 95, 'UPDATE', 'Updated lookup list item'),
(478, 1, 1, '2025-08-21 09:51:56', '2025-08-21 09:51:56', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(479, 1, 1, '2025-08-21 09:52:19', '2025-08-21 09:52:19', NULL, 'module_tasks', 8, 'UPDATE', 'Completed task'),
(480, 1, 1, '2025-08-21 09:52:20', '2025-08-21 09:52:20', NULL, 'module_tasks', 4, 'UPDATE', 'Completed task'),
(481, 1, 1, '2025-08-21 11:34:01', '2025-08-21 11:34:01', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(482, 1, 1, '2025-08-21 11:37:20', '2025-08-21 11:37:20', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(483, 1, 1, '2025-08-21 11:37:30', '2025-08-21 11:37:30', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(484, 1, 1, '2025-08-21 11:37:35', '2025-08-21 11:37:35', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(485, 1, 1, '2025-08-21 11:37:39', '2025-08-21 11:37:39', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(486, 1, 1, '2025-08-21 11:37:42', '2025-08-21 11:37:42', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(487, 1, 1, '2025-08-21 11:37:48', '2025-08-21 11:37:48', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(488, 1, 1, '2025-08-21 11:37:56', '2025-08-21 11:37:56', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(489, 1, 1, '2025-08-21 11:37:59', '2025-08-21 11:37:59', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(490, 1, 1, '2025-08-21 11:38:01', '2025-08-21 11:38:01', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(491, 1, 1, '2025-08-21 11:38:08', '2025-08-21 11:38:08', NULL, 'lookup_list_item_attributes', 106, 'UPDATE', 'Updated item attribute'),
(492, 1, 1, '2025-08-21 15:31:33', '2025-08-21 15:31:33', NULL, 'module_projects_assignments', 9, 'ASSIGN', 'Assigned user'),
(493, 1, 1, '2025-08-21 15:31:40', '2025-08-21 15:31:40', NULL, 'module_tasks', 18, 'UPDATE', 'Updated task'),
(494, 1, 1, '2025-08-21 15:31:43', '2025-08-21 15:31:43', NULL, 'module_tasks', 18, 'UPDATE', 'Updated task'),
(495, 1, 1, '2025-08-21 15:31:46', '2025-08-21 15:31:46', NULL, 'module_tasks', 18, 'UPDATE', 'Updated task'),
(496, 1, 1, '2025-08-21 15:31:49', '2025-08-21 15:31:49', NULL, 'module_task_assignments', 4, 'ASSIGN', 'Assigned user'),
(497, 1, 1, '2025-08-21 15:32:43', '2025-08-21 15:32:43', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(498, 1, 1, '2025-08-21 15:32:54', '2025-08-21 15:32:54', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(499, 1, 1, '2025-08-21 15:33:04', '2025-08-21 15:33:04', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(500, 1, 1, '2025-08-21 15:33:09', '2025-08-21 15:33:09', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(501, 1, 1, '2025-08-21 15:33:15', '2025-08-21 15:33:15', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(502, 1, 1, '2025-08-21 15:33:21', '2025-08-21 15:33:21', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(503, 1, 1, '2025-08-21 15:33:44', '2025-08-21 15:33:44', NULL, 'lookup_list_item_attributes', 117, 'UPDATE', 'Updated item attribute'),
(504, 1, 1, '2025-08-21 15:33:50', '2025-08-21 15:33:50', NULL, 'lookup_list_item_attributes', 118, 'UPDATE', 'Updated item attribute'),
(505, 1, 1, '2025-08-21 15:38:17', '2025-08-21 15:38:17', NULL, 'module_projects_assignments', 10, 'ASSIGN', 'Assigned user'),
(506, 1, 1, '2025-08-21 15:38:19', '2025-08-21 15:38:19', NULL, 'module_projects_assignments', 11, 'ASSIGN', 'Assigned user'),
(507, 1, 1, '2025-08-21 15:38:48', '2025-08-21 15:38:48', NULL, 'module_tasks', 21, 'CREATE', 'Created task'),
(508, 1, 1, '2025-08-21 15:38:52', '2025-08-21 15:38:52', NULL, 'module_tasks', 21, 'UPDATE', 'Updated task priority'),
(509, 1, 1, '2025-08-21 15:38:59', '2025-08-21 15:38:59', NULL, 'module_task_assignments', 5, 'ASSIGN', 'Assigned user'),
(510, 1, 1, '2025-08-21 15:39:01', '2025-08-21 15:39:01', NULL, 'module_tasks', 21, 'UPDATE', 'Updated task'),
(511, 1, 1, '2025-08-21 18:09:03', '2025-08-21 18:09:03', NULL, 'module_tasks', 22, 'CREATE', 'Created task'),
(512, 1, 1, '2025-08-21 18:09:25', '2025-08-21 18:09:25', NULL, 'module_tasks', 22, 'UPDATE', 'Updated task'),
(513, 1, 1, '2025-08-21 22:18:52', '2025-08-21 22:18:52', NULL, 'module_tasks', 15, 'UPDATE', 'Updated task'),
(514, 1, 1, '2025-08-21 22:18:55', '2025-08-21 22:18:55', NULL, 'module_tasks', 15, 'UPDATE', 'Updated task'),
(515, 1, 1, '2025-08-21 22:18:57', '2025-08-21 22:18:57', NULL, 'module_tasks', 15, 'UPDATE', 'Updated task'),
(516, 1, 1, '2025-08-21 22:21:16', '2025-08-21 22:21:16', NULL, 'module_task_assignments', 5, 'DELETE', 'Removed user assignment'),
(517, 1, 1, '2025-08-21 22:22:09', '2025-08-21 22:22:09', NULL, 'module_projects_assignments', 12, 'ASSIGN', 'Assigned user'),
(518, 1, 1, '2025-08-21 22:22:12', '2025-08-21 22:22:12', NULL, 'module_projects_assignments', 13, 'ASSIGN', 'Assigned user'),
(519, 1, 1, '2025-08-21 22:22:45', '2025-08-21 22:22:45', NULL, 'module_tasks', 23, 'CREATE', 'Created task'),
(520, 1, 1, '2025-08-21 22:24:14', '2025-08-21 22:24:14', NULL, 'module_tasks', 24, 'CREATE', 'Created task'),
(521, 1, 1, '2025-08-21 22:24:39', '2025-08-21 22:24:39', NULL, 'module_tasks', 25, 'CREATE', 'Created task'),
(522, 1, 1, '2025-08-21 22:26:08', '2025-08-21 22:26:08', NULL, 'module_tasks', 26, 'CREATE', 'Created task'),
(523, 1, 1, '2025-08-21 22:26:23', '2025-08-21 22:26:23', NULL, 'module_tasks', 27, 'CREATE', 'Created task'),
(524, 1, 1, '2025-08-21 22:26:43', '2025-08-21 22:26:43', NULL, 'module_tasks', 28, 'CREATE', 'Created task'),
(525, 1, 1, '2025-08-21 22:29:57', '2025-08-21 22:29:57', NULL, 'module_projects_assignments', 14, 'ASSIGN', 'Assigned user'),
(526, 1, 1, '2025-08-21 22:30:01', '2025-08-21 22:30:01', NULL, 'module_projects_assignments', 15, 'ASSIGN', 'Assigned user'),
(527, 1, 1, '2025-08-21 22:30:04', '2025-08-21 22:30:04', NULL, 'module_projects_assignments', 16, 'ASSIGN', 'Assigned user'),
(528, 1, 1, '2025-08-22 08:16:54', '2025-08-22 08:16:54', NULL, 'lookup_lists', 31, 'CREATE', 'Created lookup list'),
(529, 1, 1, '2025-08-22 08:17:19', '2025-08-22 08:17:19', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(530, 1, 1, '2025-08-22 08:17:32', '2025-08-22 08:17:32', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(531, 1, 1, '2025-08-22 08:18:11', '2025-08-22 08:18:11', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(532, 1, 1, '2025-08-22 08:18:16', '2025-08-22 08:18:16', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(533, 1, 1, '2025-08-22 08:18:20', '2025-08-22 08:18:20', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute');

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
(14, 1, 1, '2025-08-17 11:02:46', '2025-08-19 23:21:00', '', 'PROJECT_PRIORITY', ''),
(15, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'USER_GENDER', 'Gender options for users'),
(16, 1, 1, '2025-08-18 15:29:37', '2025-08-20 15:07:28', '', 'CONTRACTOR_COMPENSATION_TYPE', ''),
(17, 1, 1, '2025-08-18 15:29:50', '2025-08-20 14:37:41', '', 'CONTRACTOR_COMPENSATION_PAYMENT_METHOD', ''),
(18, 1, 1, '2025-08-18 15:29:59', '2025-08-18 15:29:59', '', 'CONTRACTOR_TYPE', ''),
(19, 1, 1, '2025-08-18 15:30:20', '2025-08-21 11:38:08', '', 'CONTRACTOR_FILE_TYPE', ''),
(20, 1, 1, '2025-08-18 15:32:11', '2025-08-20 20:48:24', '', 'CONTRACTOR_CONTACT_TYPE', ''),
(21, 1, 1, '2025-08-18 15:32:30', '2025-08-18 15:32:30', '', 'CONTRACTOR_STATUS', ''),
(22, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'USER_PROFILE_PIC_STATUS', 'Status values for user profile pictures'),
(23, 1, 1, '2025-08-20 00:22:10', '2025-08-21 02:31:25', '', 'IMAGE_FILE_TYPES', ''),
(24, 1, 1, '2025-08-20 20:50:24', '2025-08-21 15:33:50', '', 'CONTRACTOR_CONTACT_RESPONSE_TYPE', 'Response Type\'s from a person'),
(25, 1, 1, '2025-08-20 20:55:43', '2025-08-20 20:58:49', '', 'CONTRACTOR_ACQUAINTANCE_TYPE', 'How do we know this Contractor?'),
(26, 1, 1, '2025-08-20 21:07:06', '2025-08-20 21:14:03', '', 'PERSON_PHONE_TYPE', ''),
(27, 1, 1, '2025-08-20 21:07:13', '2025-08-20 21:13:19', '', 'PERSON_ADDRESS_TYPE', ''),
(28, 1, 1, '2025-08-20 21:07:53', '2025-08-20 21:12:32', '', 'PERSON_ADDRESS_STATUS', ''),
(29, 1, 1, '2025-08-20 21:07:59', '2025-08-20 21:10:50', '', 'PERSON_PHONE_STATUS', ''),
(30, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 'US_STATES', 'United States states and DC'),
(31, 1, 1, '2025-08-22 08:16:54', '2025-08-22 08:18:20', '', 'PROJECT_TYPE', 'Normal Project, SoW, etc.');

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
(32, 1, 1, '2025-08-14 00:00:00', '2025-08-19 23:00:03', NULL, 11, 'In Progress', 'INPROGRESS', 1, '2025-08-13', NULL),
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
(58, 1, 1, '2025-08-17 11:03:06', '2025-08-17 11:03:06', NULL, 14, 'Low', 'LOW', 0, '2025-08-17', NULL),
(59, 1, 1, '2025-08-18 00:00:00', '2025-08-17 21:13:55', NULL, 15, 'Male', 'MALE', 1, '2025-08-17', NULL),
(60, 1, 1, '2025-08-18 00:00:00', '2025-08-17 21:13:57', NULL, 15, 'Female', 'FEMALE', 2, '2025-08-17', NULL),
(63, 1, 1, '2025-08-17 22:26:21', '2025-08-17 22:26:21', NULL, 5, 'Pending', 'PENDING', 0, '2025-08-17', NULL),
(64, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 16, 'Hourly', 'HOURLY', 1, '2025-08-18', NULL),
(65, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 16, 'Salary', 'SALARY', 2, '2025-08-18', NULL),
(66, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 17, 'Check', 'CHECK', 1, '2025-08-18', NULL),
(67, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 17, 'ACH', 'ACH', 2, '2025-08-18', NULL),
(68, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 17, 'Wire', 'WIRE', 3, '2025-08-18', NULL),
(69, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 18, 'Individual', 'INDIVIDUAL', 1, '2025-08-18', NULL),
(70, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 18, 'Company', 'COMPANY', 2, '2025-08-18', NULL),
(71, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 18, 'Agency', 'AGENCY', 3, '2025-08-18', NULL),
(72, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 19, 'Resume', 'RESUME', 1, '2025-08-18', NULL),
(73, 1, 1, '2025-08-18 00:00:00', '2025-08-21 01:54:31', NULL, 19, 'Atlis - Contract', 'ATLIS-CONTRACT', 2, '2025-08-18', NULL),
(74, 1, 1, '2025-08-18 00:00:00', '2025-08-21 01:45:07', NULL, 19, 'CJIS Certification', 'CJISCERTIFICATION', 3, '2025-08-18', NULL),
(75, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 20, 'Email', 'EMAIL', 1, '2025-08-18', NULL),
(76, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 20, 'Phone', 'PHONE', 2, '2025-08-18', NULL),
(77, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 20, 'Meeting', 'MEETING', 3, '2025-08-18', NULL),
(78, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 21, 'Draft', 'DRAFT', 1, '2025-08-18', NULL),
(79, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 21, 'Active', 'ACTIVE', 2, '2025-08-18', NULL),
(80, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 21, 'Suspended', 'SUSPENDED', 3, '2025-08-18', NULL),
(81, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 21, 'Archived', 'ARCHIVED', 4, '2025-08-18', NULL),
(82, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 22, 'Active', 'ACTIVE', 1, '2025-08-18', NULL),
(83, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 22, 'Inactive', 'INACTIVE', 2, '2025-08-18', NULL),
(87, 1, 1, '2025-08-19 23:20:48', '2025-08-19 23:20:48', NULL, 14, 'Critical !', 'CRITICAL', 0, '2025-08-18', NULL),
(88, 1, 1, '2025-08-20 00:22:57', '2025-08-20 00:24:15', NULL, 23, 'JPEG', 'image/jpeg', 0, '2025-08-19', NULL),
(89, 1, 1, '2025-08-20 00:23:04', '2025-08-20 00:24:25', NULL, 23, 'PNG', 'image/png', 0, '2025-08-19', NULL),
(90, 1, 1, '2025-08-20 00:23:08', '2025-08-20 00:24:12', NULL, 23, 'GIF', 'image/gif', 0, '2025-08-19', NULL),
(91, 1, 1, '2025-08-20 00:23:15', '2025-08-20 00:24:36', NULL, 23, 'WEBP', 'image/webp', 0, '2025-08-19', NULL),
(92, 1, 1, '2025-08-20 00:23:22', '2025-08-20 00:24:00', NULL, 23, 'BMP', 'image/bmp', 0, '2025-08-19', NULL),
(93, 1, 1, '2025-08-20 00:23:28', '2025-08-20 00:24:28', NULL, 23, 'SVG', 'image/svg+xml', 0, '2025-08-19', NULL),
(94, 1, 1, '2025-08-20 00:23:34', '2025-08-20 00:24:32', NULL, 23, 'TIFF', 'image/tiff', 0, '2025-08-19', NULL),
(95, 1, 1, '2025-08-20 00:23:41', '2025-08-21 02:31:25', NULL, 23, 'JPG', 'image/jpg', 0, '2025-08-19', NULL),
(96, 1, 1, '2025-08-20 00:45:53', '2025-08-20 00:45:53', NULL, 17, 'Direct Deposit', 'DD', 0, '2025-08-20', NULL),
(97, 1, 1, '2025-08-20 00:45:58', '2025-08-20 00:45:58', NULL, 17, 'Venmo', 'VENMO', 0, '2025-08-20', NULL),
(98, 1, 1, '2025-08-20 14:38:06', '2025-08-20 14:38:06', NULL, 16, 'Single Payment', 'SINGLE', 0, '2025-08-19', NULL),
(99, 1, 1, '2025-08-20 20:48:17', '2025-08-20 20:48:17', NULL, 20, 'Text Message', 'SMSTEXT', 0, '2025-08-19', NULL),
(100, 1, 1, '2025-08-20 20:55:56', '2025-08-20 20:55:56', NULL, 25, 'Family', 'FAMILY', 0, '2025-08-19', NULL),
(101, 1, 1, '2025-08-20 20:56:02', '2025-08-20 20:56:02', NULL, 25, 'Friend', 'FRIEND', 0, '2025-08-19', NULL),
(102, 1, 1, '2025-08-20 20:56:13', '2025-08-20 20:56:13', NULL, 25, 'Coworker', 'COWORKER', 0, '2025-08-19', NULL),
(103, 1, 1, '2025-08-20 20:56:27', '2025-08-20 20:56:27', NULL, 25, 'Random', 'RANDOM', 0, '2025-08-19', NULL),
(104, 1, 1, '2025-08-20 20:56:42', '2025-08-20 20:56:42', NULL, 25, 'Unknown', 'UNKNOWN', 0, '2025-08-19', NULL),
(105, 1, 1, '2025-08-20 21:10:20', '2025-08-20 21:10:20', NULL, 29, 'Active', 'ACTIVE', 0, '2025-08-20', NULL),
(106, 1, 1, '2025-08-20 21:10:26', '2025-08-20 21:10:26', NULL, 29, 'Previous', 'PREVIOUS', 0, '2025-08-20', NULL),
(107, 1, 1, '2025-08-20 21:10:32', '2025-08-20 21:10:32', NULL, 29, 'Unknown', 'UNKNOWN', 0, '2025-08-20', NULL),
(108, 1, 1, '2025-08-20 21:12:03', '2025-08-20 21:12:03', NULL, 28, 'Active', 'ACTIVE', 0, '2025-08-20', NULL),
(109, 1, 1, '2025-08-20 21:12:08', '2025-08-20 21:12:08', NULL, 28, 'Previous', 'PREVIOUS', 0, '2025-08-20', NULL),
(110, 1, 1, '2025-08-20 21:12:14', '2025-08-20 21:12:14', NULL, 28, 'Unknown', 'UNKNOWN', 0, '2025-08-20', NULL),
(111, 1, 1, '2025-08-20 21:12:49', '2025-08-20 21:12:49', NULL, 27, 'Work / Office', 'WORK-OFFICE', 0, '2025-08-20', NULL),
(112, 1, 1, '2025-08-20 21:12:56', '2025-08-20 21:12:56', NULL, 27, 'Home', 'HOME', 0, '2025-08-20', NULL),
(113, 1, 1, '2025-08-20 21:13:33', '2025-08-20 21:13:33', NULL, 26, 'Cell', 'CELL', 0, '2025-08-20', NULL),
(114, 1, 1, '2025-08-20 21:13:39', '2025-08-20 21:13:39', NULL, 26, 'Home', 'HOME', 0, '2025-08-20', NULL),
(115, 1, 1, '2025-08-20 21:13:44', '2025-08-20 21:13:44', NULL, 26, 'Office', 'OFFICE', 0, '2025-08-20', NULL),
(116, 1, 1, '2025-08-20 21:14:13', '2025-08-20 21:14:13', NULL, 24, 'Text', 'TEXT', 0, '2025-08-20', NULL),
(117, 1, 1, '2025-08-20 21:14:17', '2025-08-20 21:14:17', NULL, 24, 'Email', 'EMAIL', 0, '2025-08-20', NULL),
(118, 1, 1, '2025-08-20 21:14:22', '2025-08-20 21:14:38', NULL, 24, 'Phone Call', 'PHONECALL', 0, '2025-08-20', NULL),
(119, 1, 1, '2025-08-21 01:45:47', '2025-08-21 01:45:47', NULL, 19, 'Note', 'NOTE', 0, '2025-08-20', NULL),
(120, 1, 1, '2025-08-21 01:46:46', '2025-08-21 01:46:46', NULL, 19, 'Atlis - Background Consent', 'ATLIS-BACKGROUNDCONSENT', 0, '2025-08-21', NULL),
(121, 1, 1, '2025-08-21 01:47:01', '2025-08-21 01:47:01', NULL, 19, 'Atlis - Direct Deposit', 'ATLIS-DIRECTDEPOSIT', 0, '2025-08-21', NULL),
(122, 1, 1, '2025-08-21 01:47:10', '2025-08-21 01:47:10', NULL, 19, 'Atlis - W9', 'ATLIS-W9', 0, '2025-08-21', NULL),
(123, 1, 1, '2025-08-21 01:47:45', '2025-08-21 01:47:45', NULL, 19, 'Lake - AUP - #1', 'LAKE-AUP-1', 0, '2025-08-21', NULL),
(124, 1, 1, '2025-08-21 01:47:48', '2025-08-21 01:47:48', NULL, 19, 'Lake - AUP - #2', 'LAKE-AUP-2', 0, '2025-08-21', NULL),
(125, 1, 1, '2025-08-21 01:47:52', '2025-08-21 01:47:52', NULL, 19, 'Lake - AUP - #3', 'LAKE-AUP-3', 0, '2025-08-21', NULL),
(126, 1, 1, '2025-08-21 01:47:56', '2025-08-21 01:47:56', NULL, 19, 'Lake - AUP - #4', 'LAKE-AUP-4', 0, '2025-08-21', NULL),
(127, 1, 1, '2025-08-21 11:37:20', '2025-08-21 11:37:20', NULL, 19, 'Compensation - Note', 'COMPENSATION-NOTE', 0, '2025-08-21', NULL),
(128, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Alabama', 'AL', 1, '2025-08-21', NULL),
(129, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Alaska', 'AK', 2, '2025-08-21', NULL),
(130, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Arizona', 'AZ', 3, '2025-08-21', NULL),
(131, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Arkansas', 'AR', 4, '2025-08-21', NULL),
(132, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'California', 'CA', 5, '2025-08-21', NULL),
(133, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Colorado', 'CO', 6, '2025-08-21', NULL),
(134, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Connecticut', 'CT', 7, '2025-08-21', NULL),
(135, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Delaware', 'DE', 8, '2025-08-21', NULL),
(136, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'District of Columbia', 'DC', 9, '2025-08-21', NULL),
(137, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Florida', 'FL', 10, '2025-08-21', NULL),
(138, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Georgia', 'GA', 11, '2025-08-21', NULL),
(139, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Hawaii', 'HI', 12, '2025-08-21', NULL),
(140, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Idaho', 'ID', 13, '2025-08-21', NULL),
(141, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Illinois', 'IL', 14, '2025-08-21', NULL),
(142, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Indiana', 'IN', 15, '2025-08-21', NULL),
(143, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Iowa', 'IA', 16, '2025-08-21', NULL),
(144, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Kansas', 'KS', 17, '2025-08-21', NULL),
(145, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Kentucky', 'KY', 18, '2025-08-21', NULL),
(146, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Louisiana', 'LA', 19, '2025-08-21', NULL),
(147, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Maine', 'ME', 20, '2025-08-21', NULL),
(148, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Maryland', 'MD', 21, '2025-08-21', NULL),
(149, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Massachusetts', 'MA', 22, '2025-08-21', NULL),
(150, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Michigan', 'MI', 23, '2025-08-21', NULL),
(151, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Minnesota', 'MN', 24, '2025-08-21', NULL),
(152, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Mississippi', 'MS', 25, '2025-08-21', NULL),
(153, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Missouri', 'MO', 26, '2025-08-21', NULL),
(154, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Montana', 'MT', 27, '2025-08-21', NULL),
(155, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Nebraska', 'NE', 28, '2025-08-21', NULL),
(156, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Nevada', 'NV', 29, '2025-08-21', NULL),
(157, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'New Hampshire', 'NH', 30, '2025-08-21', NULL),
(158, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'New Jersey', 'NJ', 31, '2025-08-21', NULL),
(159, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'New Mexico', 'NM', 32, '2025-08-21', NULL),
(160, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'New York', 'NY', 33, '2025-08-21', NULL),
(161, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'North Carolina', 'NC', 34, '2025-08-21', NULL),
(162, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'North Dakota', 'ND', 35, '2025-08-21', NULL),
(163, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Ohio', 'OH', 36, '2025-08-21', NULL),
(164, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Oklahoma', 'OK', 37, '2025-08-21', NULL),
(165, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Oregon', 'OR', 38, '2025-08-21', NULL),
(166, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Pennsylvania', 'PA', 39, '2025-08-21', NULL),
(167, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Rhode Island', 'RI', 40, '2025-08-21', NULL),
(168, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'South Carolina', 'SC', 41, '2025-08-21', NULL),
(169, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'South Dakota', 'SD', 42, '2025-08-21', NULL),
(170, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Tennessee', 'TN', 43, '2025-08-21', NULL),
(171, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Texas', 'TX', 44, '2025-08-21', NULL),
(172, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Utah', 'UT', 45, '2025-08-21', NULL),
(173, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Vermont', 'VT', 46, '2025-08-21', NULL),
(174, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Virginia', 'VA', 47, '2025-08-21', NULL),
(175, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Washington', 'WA', 48, '2025-08-21', NULL),
(176, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'West Virginia', 'WV', 49, '2025-08-21', NULL),
(177, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Wisconsin', 'WI', 50, '2025-08-21', NULL),
(178, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'Wyoming', 'WY', 51, '2025-08-21', NULL),
(179, 1, 1, '2025-08-21 15:32:43', '2025-08-21 15:32:43', NULL, 24, 'Callback', 'CALLBACK', 0, '2025-08-21', NULL),
(180, 1, 1, '2025-08-21 15:32:54', '2025-08-21 15:32:54', NULL, 24, 'Email Reply', 'EMAILREPLY', 0, '2025-08-21', NULL),
(181, 1, 1, '2025-08-21 15:33:04', '2025-08-21 15:33:04', NULL, 24, 'Send Proposal', 'SENDPROPOSAL', 0, '2025-08-21', NULL),
(182, 1, 1, '2025-08-22 08:17:19', '2025-08-22 08:17:19', NULL, 31, 'Project', 'PROJECT', 0, '2025-08-22', NULL),
(183, 1, 1, '2025-08-22 08:17:32', '2025-08-22 08:17:32', NULL, 31, 'Statement of Work', 'STATEMENTOFWORK', 0, '2025-08-22', NULL);

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
(11, 1, 1, '2025-08-13 22:16:23', '2025-08-17 22:25:14', NULL, 30, 'COLOR-CLASS', 'atlis'),
(12, 1, 1, '2025-08-13 22:16:23', '2025-08-14 22:15:54', NULL, 31, 'COLOR-CLASS', 'success'),
(13, 1, 1, '2025-08-13 22:16:23', '2025-08-13 23:39:49', NULL, 32, 'COLOR-CLASS', 'primary'),
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
(32, 1, 1, '2025-08-14 22:16:05', '2025-08-17 22:25:11', NULL, 55, 'COLOR-CLASS', 'warning'),
(33, 1, 1, '2025-08-14 22:22:53', '2025-08-17 22:24:01', NULL, 35, 'COLOR-CLASS', 'warning'),
(34, 1, 1, '2025-08-17 11:03:22', '2025-08-17 11:03:22', NULL, 56, 'COLOR-CLASS', 'danger'),
(35, 1, 1, '2025-08-17 11:03:34', '2025-08-17 11:03:34', NULL, 58, 'COLOR-CLASS', 'primary'),
(36, 1, 1, '2025-08-17 11:03:44', '2025-08-17 11:03:44', NULL, 57, 'COLOR-CLASS', 'warning'),
(37, 1, 1, '2025-08-17 22:24:26', '2025-08-17 22:24:26', NULL, 35, 'DEFAULT', 'true'),
(38, 1, 1, '2025-08-17 22:24:39', '2025-08-17 22:24:39', NULL, 38, 'DEFAULT', 'true'),
(39, 1, 1, '2025-08-17 22:24:53', '2025-08-17 22:24:53', NULL, 57, 'DEFAULT', 'true'),
(40, 1, 1, '2025-08-17 22:25:20', '2025-08-17 22:25:20', NULL, 55, 'DEFAULT', 'true'),
(41, 1, 1, '2025-08-17 22:25:33', '2025-08-17 22:25:33', NULL, 10, 'DEFAULT', 'true'),
(42, 1, 1, '2025-08-17 22:25:45', '2025-08-17 22:25:45', NULL, 27, 'DEFAULT', 'true'),
(43, 1, 1, '2025-08-17 22:25:59', '2025-08-17 22:25:59', NULL, 13, 'DEFAULT', 'true'),
(44, 1, 1, '2025-08-17 22:26:05', '2025-08-17 22:26:05', NULL, 28, 'DEFAULT', 'true'),
(45, 1, 1, '2025-08-17 22:26:30', '2025-08-17 22:26:30', NULL, 63, 'COLOR-CLASS', 'warning'),
(46, 1, 1, '2025-08-17 22:26:34', '2025-08-17 22:26:34', NULL, 63, 'DEFAULT', 'true'),
(47, 1, 1, '2025-08-17 22:26:47', '2025-08-17 22:26:47', NULL, 59, 'DEFAULT', 'true'),
(48, 1, 1, '2025-08-17 22:26:59', '2025-08-17 22:26:59', NULL, 53, 'DEFAULT', 'true'),
(49, 1, 1, '2025-08-17 22:27:07', '2025-08-17 22:27:26', NULL, 53, 'COLOR-CLASS', 'danger'),
(50, 1, 1, '2025-08-17 22:27:30', '2025-08-17 22:27:30', NULL, 54, 'COLOR-CLASS', 'atlis'),
(51, 1, 1, '2025-08-17 22:27:39', '2025-08-17 22:27:39', NULL, 51, 'COLOR-CLASS', 'danger'),
(52, 1, 1, '2025-08-17 22:27:44', '2025-08-17 22:27:44', NULL, 51, 'DEFAULT', 'true'),
(53, 1, 1, '2025-08-17 22:27:48', '2025-08-17 22:27:48', NULL, 52, 'COLOR-CLASS', 'atlis'),
(54, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 78, 'COLOR-CLASS', 'secondary'),
(55, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 79, 'COLOR-CLASS', 'success'),
(56, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 80, 'COLOR-CLASS', 'warning'),
(57, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 81, 'COLOR-CLASS', 'dark'),
(58, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 69, 'DEFAULT', 'true'),
(59, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 78, 'DEFAULT', 'true'),
(61, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 64, 'COLOR-CLASS', 'primary'),
(62, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 65, 'COLOR-CLASS', 'success'),
(64, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 66, 'COLOR-CLASS', 'primary'),
(65, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 67, 'COLOR-CLASS', 'success'),
(66, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 68, 'COLOR-CLASS', 'warning'),
(67, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 75, 'DEFAULT', 'true'),
(68, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 75, 'COLOR-CLASS', 'primary'),
(69, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 76, 'COLOR-CLASS', 'success'),
(70, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 77, 'COLOR-CLASS', 'warning'),
(71, 1, 1, '2025-08-19 23:21:00', '2025-08-19 23:21:00', NULL, 87, 'COLOR-CLASS', 'danger'),
(72, 1, 1, '2025-08-20 00:46:08', '2025-08-20 00:46:08', NULL, 97, 'COLOR-CLASS', 'info'),
(73, 1, 1, '2025-08-20 00:46:11', '2025-08-20 00:46:11', NULL, 96, 'COLOR-CLASS', 'atlis'),
(75, 1, 1, '2025-08-20 14:37:41', '2025-08-20 14:37:41', NULL, 97, 'DEFAULT', 'true'),
(76, 1, 1, '2025-08-20 14:38:16', '2025-08-20 14:38:16', NULL, 98, 'COLOR-CLASS', 'atlis'),
(77, 1, 1, '2025-08-20 15:07:28', '2025-08-20 15:07:28', NULL, 98, 'DEFAULT', 'true'),
(78, 1, 1, '2025-08-20 20:48:24', '2025-08-20 20:48:24', NULL, 99, 'COLOR-CLASS', 'info'),
(79, 1, 1, '2025-08-20 20:57:39', '2025-08-20 20:57:39', NULL, 101, 'DEFAULT', 'true'),
(80, 1, 1, '2025-08-20 20:57:50', '2025-08-20 20:57:50', NULL, 100, 'COLOR-CLASS', 'atlis'),
(81, 1, 1, '2025-08-20 20:58:29', '2025-08-20 20:58:29', NULL, 102, 'COLOR-CLASS', 'info'),
(82, 1, 1, '2025-08-20 20:58:35', '2025-08-20 20:58:35', NULL, 101, 'COLOR-CLASS', 'success'),
(83, 1, 1, '2025-08-20 20:58:45', '2025-08-20 20:58:45', NULL, 103, 'COLOR-CLASS', 'warning'),
(84, 1, 1, '2025-08-20 20:58:49', '2025-08-20 20:58:49', NULL, 104, 'COLOR-CLASS', 'danger'),
(85, 1, 1, '2025-08-20 21:10:39', '2025-08-20 21:10:39', NULL, 105, 'COLOR-CLASS', 'success'),
(86, 1, 1, '2025-08-20 21:10:42', '2025-08-20 21:10:42', NULL, 106, 'COLOR-CLASS', 'warning'),
(87, 1, 1, '2025-08-20 21:10:45', '2025-08-20 21:10:45', NULL, 107, 'COLOR-CLASS', 'danger'),
(88, 1, 1, '2025-08-20 21:10:50', '2025-08-20 21:10:50', NULL, 105, 'DEFAULT', 'true'),
(89, 1, 1, '2025-08-20 21:12:18', '2025-08-20 21:12:18', NULL, 108, 'COLOR-CLASS', 'success'),
(90, 1, 1, '2025-08-20 21:12:23', '2025-08-20 21:12:23', NULL, 109, 'COLOR-CLASS', 'warning'),
(91, 1, 1, '2025-08-20 21:12:27', '2025-08-20 21:12:27', NULL, 110, 'COLOR-CLASS', 'danger'),
(92, 1, 1, '2025-08-20 21:12:32', '2025-08-20 21:12:32', NULL, 108, 'DEFAULT', 'true'),
(93, 1, 1, '2025-08-20 21:13:02', '2025-08-20 21:13:15', NULL, 112, 'COLOR-CLASS', 'primary'),
(94, 1, 1, '2025-08-20 21:13:10', '2025-08-20 21:13:10', NULL, 111, 'COLOR-CLASS', 'atlis'),
(95, 1, 1, '2025-08-20 21:13:19', '2025-08-20 21:13:19', NULL, 111, 'DEFAULT', 'true'),
(96, 1, 1, '2025-08-20 21:13:50', '2025-08-20 21:13:50', NULL, 113, 'COLOR-CLASS', 'success'),
(97, 1, 1, '2025-08-20 21:13:54', '2025-08-20 21:13:54', NULL, 114, 'COLOR-CLASS', 'warning'),
(98, 1, 1, '2025-08-20 21:13:58', '2025-08-20 21:13:58', NULL, 115, 'COLOR-CLASS', 'atlis'),
(99, 1, 1, '2025-08-20 21:14:03', '2025-08-20 21:14:03', NULL, 115, 'DEFAULT', 'true'),
(100, 1, 1, '2025-08-20 21:14:29', '2025-08-20 21:14:29', NULL, 117, 'COLOR-CLASS', 'atlis'),
(101, 1, 1, '2025-08-20 21:14:43', '2025-08-20 21:14:43', NULL, 118, 'COLOR-CLASS', 'warning'),
(102, 1, 1, '2025-08-20 21:14:49', '2025-08-20 21:14:49', NULL, 116, 'COLOR-CLASS', 'primary'),
(103, 1, 1, '2025-08-20 21:14:54', '2025-08-20 21:14:54', NULL, 117, 'DEFAULT', 'true'),
(104, 1, 1, '2025-08-21 01:45:13', '2025-08-21 01:45:13', NULL, 73, 'COLOR-CLASS', 'atlis'),
(105, 1, 1, '2025-08-21 01:45:20', '2025-08-21 01:45:20', NULL, 72, 'COLOR-CLASS', 'primary'),
(106, 1, 1, '2025-08-21 01:45:31', '2025-08-21 11:38:08', NULL, 74, 'COLOR-CLASS', 'info'),
(107, 1, 1, '2025-08-21 01:45:57', '2025-08-21 01:45:57', NULL, 119, 'COLOR-CLASS', 'success'),
(108, 1, 1, '2025-08-21 11:37:30', '2025-08-21 11:37:30', NULL, 127, 'COLOR-CLASS', 'success'),
(109, 1, 1, '2025-08-21 11:37:35', '2025-08-21 11:37:35', NULL, 122, 'COLOR-CLASS', 'atlis'),
(110, 1, 1, '2025-08-21 11:37:39', '2025-08-21 11:37:39', NULL, 121, 'COLOR-CLASS', 'atlis'),
(111, 1, 1, '2025-08-21 11:37:42', '2025-08-21 11:37:42', NULL, 120, 'COLOR-CLASS', 'atlis'),
(112, 1, 1, '2025-08-21 11:37:48', '2025-08-21 11:37:48', NULL, 123, 'COLOR-CLASS', 'warning'),
(114, 1, 1, '2025-08-21 11:37:56', '2025-08-21 11:37:56', NULL, 124, 'COLOR-CLASS', 'warning'),
(115, 1, 1, '2025-08-21 11:37:59', '2025-08-21 11:37:59', NULL, 125, 'COLOR-CLASS', 'warning'),
(116, 1, 1, '2025-08-21 11:38:01', '2025-08-21 11:38:01', NULL, 126, 'COLOR-CLASS', 'warning'),
(117, 1, 1, '2025-08-21 15:33:09', '2025-08-21 15:33:44', NULL, 179, 'COLOR-CLASS', 'info'),
(118, 1, 1, '2025-08-21 15:33:15', '2025-08-21 15:33:50', NULL, 180, 'COLOR-CLASS', 'primary'),
(119, 1, 1, '2025-08-21 15:33:21', '2025-08-21 15:33:21', NULL, 181, 'COLOR-CLASS', 'success'),
(120, 1, 1, '2025-08-22 08:18:11', '2025-08-22 08:18:11', NULL, 183, 'COLOR-CLASS', 'atlis'),
(121, 1, 1, '2025-08-22 08:18:16', '2025-08-22 08:18:16', NULL, 182, 'COLOR-CLASS', 'primary'),
(122, 1, 1, '2025-08-22 08:18:20', '2025-08-22 08:18:20', NULL, 182, 'DEFAULT', 'true');

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
(1, 1, 1, '2025-08-06 16:27:31', '2025-08-08 21:56:30', NULL, 1, 'Atlis Technologies', 1, 3, 'main_logo_dark_bg.png', '/module/agency/uploads/agency_1.png', 67568, 'image/png'),
(2, 1, 1, '2025-08-06 16:28:14', '2025-08-08 21:56:34', NULL, 2, '19th Circuit Court', NULL, 3, NULL, NULL, NULL, NULL),
(3, 1, 1, '2025-08-21 02:14:26', '2025-08-21 02:14:26', NULL, 2, 'Office of the Public Defender', 30, 28, NULL, NULL, NULL, NULL),
(4, 1, 1, '2025-08-21 02:16:22', '2025-08-21 02:16:22', NULL, 2, 'State\'s Attorney Office', 31, 28, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_contractors`
--

CREATE TABLE `module_contractors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `contractor_type_id` int(11) NOT NULL,
  `initial_contact_date` date DEFAULT NULL,
  `title_role` varchar(255) DEFAULT NULL,
  `acquaintance` text DEFAULT NULL,
  `acquaintance_type_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `contact_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_contractors`
--

INSERT INTO `module_contractors` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `person_id`, `status_id`, `contractor_type_id`, `initial_contact_date`, `title_role`, `acquaintance`, `acquaintance_type_id`, `start_date`, `end_date`, `contact_phone`, `contact_address`) VALUES
(1, 1, 1, '2025-08-19 23:23:43', '2025-08-19 23:23:43', NULL, 1, 78, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 1, '2025-08-19 23:23:51', '2025-08-20 14:39:03', NULL, 2, 79, 69, NULL, NULL, NULL, NULL, '2025-06-11', '2025-08-31', NULL, NULL),
(3, 4, 1, '2025-08-19 23:23:54', '2025-08-19 23:23:54', NULL, 5, 78, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 8, 1, '2025-08-20 15:13:26', '2025-08-21 01:56:50', NULL, 23, 78, 69, '2025-06-11', 'BI Analyst / Report Writer', 'Former JTI Employee.\r\nThomas and Amanda\'s old neighbor.\r\nWorked with John Wilkins at New Dawn Technologies.', 102, '2025-06-21', NULL, NULL, NULL),
(5, 9, 1, '2025-08-20 15:14:43', '2025-08-20 15:14:43', NULL, 24, 78, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 10, 1, '2025-08-20 20:47:36', '2025-08-20 20:47:36', NULL, 27, 78, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_contractors_compensation`
--

CREATE TABLE `module_contractors_compensation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `contractor_id` int(11) NOT NULL,
  `compensation_type_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `pay_date` datetime DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `effective_start` date NOT NULL,
  `effective_end` date DEFAULT NULL,
  `invoice_number` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_contractors_compensation`
--

INSERT INTO `module_contractors_compensation` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `contractor_id`, `compensation_type_id`, `payment_method_id`, `title`, `pay_date`, `file_id`, `amount`, `effective_start`, `effective_end`, `invoice_number`, `notes`) VALUES
(1, 1, 1, '2025-08-20 14:36:44', '2025-08-20 16:50:58', NULL, 2, 98, 97, '', '2025-06-30 16:50:33', NULL, 681.82, '2025-06-16', '2025-06-29', NULL, NULL),
(2, 1, 1, '2025-08-20 14:40:35', '2025-08-20 16:51:36', NULL, 2, 98, 97, '', '2025-08-15 16:51:08', NULL, 681.82, '2025-06-30', '2025-07-13', NULL, NULL),
(3, 1, 1, '2025-08-20 16:35:55', '2025-08-20 16:52:25', NULL, 2, 98, 97, '', '2025-07-28 16:52:14', NULL, 155.00, '2025-07-14', '2025-07-27', NULL, 'Separated the payments to use $155 from Venmo balance. - pay date was 7/28/25'),
(4, 1, 1, '2025-08-20 16:36:25', '2025-08-20 16:52:32', NULL, 2, 98, 97, '', '2025-08-12 16:52:29', NULL, 526.82, '2025-07-28', '2025-08-10', NULL, 'Separated the payments to use $155 from Venmo balance. - pay date was 7/28/25'),
(5, 1, 1, '2025-08-20 18:05:57', '2025-08-20 18:05:57', NULL, 4, 98, 97, 'First Payment', '2025-08-01 00:00:00', NULL, 500.00, '2025-08-01', '2025-08-01', NULL, 'I felt bad that the Reports SoW is taking forever and requiring an Addendum so I paid Kenny $500 to  keep him interested. He said up to this point, he\'s spent about 9 hours on work.'),
(6, 1, 1, '2025-08-20 20:51:08', '2025-08-20 20:51:08', NULL, 3, 98, 97, 'test', '2025-08-21 00:00:00', NULL, 555.00, '2025-08-27', NULL, 55, NULL),
(7, 1, 1, '2025-08-21 11:35:35', '2025-08-21 11:35:35', NULL, 2, 98, 97, 'Pay Period', '2025-08-21 00:00:00', NULL, 681.82, '2025-08-11', '2025-08-24', NULL, 'Sean requested to be paid 4 days early, so I sent $681.82 via Venmo today, Aug 21st, at 11:30am instead of the scheduled pay date of Aug 24th.  No worries.\r\nHe sent the request to me over DM\'s on Slack.');

-- --------------------------------------------------------

--
-- Table structure for table `module_contractors_contacts`
--

CREATE TABLE `module_contractors_contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `contractor_id` int(11) NOT NULL,
  `contact_type_id` int(11) NOT NULL,
  `contact_date` datetime DEFAULT current_timestamp(),
  `summary` text DEFAULT NULL,
  `contact_duration` int(11) DEFAULT NULL,
  `contact_result` text DEFAULT NULL,
  `related_module` varchar(255) DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_contractors_contacts`
--

INSERT INTO `module_contractors_contacts` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `contractor_id`, `contact_type_id`, `contact_date`, `summary`, `contact_duration`, `contact_result`, `related_module`, `related_id`) VALUES
(1, 1, 1, '2025-08-20 20:49:42', '2025-08-20 20:49:42', NULL, 6, 99, '2025-07-26 16:36:00', 'Initial Contact - Hey Emma, I hope things are going well for you. \r\nQuick question, are you interested in doing some side gig work building PowerBI / Tableau dashboards and other Business Intelligence products specifically for eSeries?\r\nCompensation would be around\r\n$100/hr and/or a residual %-based strategy.  Let me know as soon as possible when you can and we can setup a call to go over more details if you’re interested. If not, no hard feelings at all.\r\nThanks !', NULL, NULL, NULL, NULL),
(2, 1, 1, '2025-08-21 01:57:30', '2025-08-21 01:57:30', NULL, 4, 99, '2025-06-11 13:56:00', 'Pitched Kenny via text message. Said he\'s interested but on a trip right now and can talk later.', NULL, NULL, NULL, NULL),
(3, 1, 1, '2025-08-21 01:57:56', '2025-08-21 01:57:56', NULL, 4, 99, '2025-06-12 14:00:00', 'KENNY TEXT ME AND SAID HE\'S INTERESTED AND WILL REACH OUT ON MONDAY !', NULL, NULL, NULL, NULL),
(4, 1, 1, '2025-08-21 01:58:19', '2025-08-21 01:58:19', NULL, 4, 75, '2025-06-21 14:00:00', 'SENT KENNY FIRST CONTRACT AND DETAILS ABOUT SoW #172', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_contractors_contacts_response`
--

CREATE TABLE `module_contractors_contacts_response` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `contact_id` int(11) NOT NULL,
  `response_type_id` int(11) NOT NULL,
  `response_text` text DEFAULT NULL,
  `is_urgent` tinyint(1) DEFAULT 0,
  `deadline_date` datetime DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  `completed_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_contractors_contact_responses`
--

CREATE TABLE `module_contractors_contact_responses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `contact_id` int(11) NOT NULL,
  `response_type_id` int(11) NOT NULL,
  `is_urgent` tinyint(1) DEFAULT 0,
  `deadline` datetime DEFAULT NULL,
  `response_text` text DEFAULT NULL,
  `assigned_user_id` int(11) DEFAULT NULL,
  `completed_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_contractors_contact_responses`
--

INSERT INTO `module_contractors_contact_responses` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `contact_id`, `response_type_id`, `is_urgent`, `deadline`, `response_text`, `assigned_user_id`, `completed_date`) VALUES
(1, 1, 1, '2025-08-21 15:36:27', '2025-08-21 15:36:27', NULL, 1, 117, 1, '2025-08-20 16:39:00', 'No worries -- I certainly don\'t expect a response while on vacation !\r\nI definitely still have a need for a BI Analyst building dashboards. I can email you some more specifics if you want to provide me with your personal email address.', 1, NULL),
(2, 1, 1, '2025-08-21 15:37:03', '2025-08-21 15:37:03', NULL, 1, 117, 1, '2025-08-20 19:05:00', 'emmabaylor@gmail.com', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_contractors_files`
--

CREATE TABLE `module_contractors_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `contractor_id` int(11) NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `version` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_contractors_files`
--

INSERT INTO `module_contractors_files` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `contractor_id`, `file_type_id`, `file_name`, `file_path`, `version`, `description`) VALUES
(1, 1, 1, '2025-08-20 16:54:07', '2025-08-20 16:54:07', NULL, 2, 73, 'Atlis Technologies Work Agreement - With Summer 2025 - D_SIGNED.pdf', '/admin/contractors/uploads/2/Atlis_Technologies_Work_Agreement_-_With_Summer_2025_-_D_SIGNED.pdf', '1', '#3 - Summer 2025'),
(4, 1, 1, '2025-08-21 01:53:22', '2025-08-21 01:53:22', NULL, 4, 119, 'FIRST CONTACT.txt', '/admin/contractors/uploads/4/FIRST_CONTACT.txt', '1', 'First Contact'),
(5, 1, 1, '2025-08-21 01:54:03', '2025-08-21 01:54:03', NULL, 4, 119, 'INITIAL CALL.txt', '/admin/contractors/uploads/4/INITIAL_CALL.txt', '1', 'Initial Call'),
(6, 1, 1, '2025-08-21 01:55:48', '2025-08-21 01:55:48', NULL, 4, 73, 'KENNY__ATLIS_WORK_AGREEMENT-Signed.pdf', '/admin/contractors/uploads/4/KENNY__ATLIS_WORK_AGREEMENT-Signed.pdf', '1', '1st Contract with Atlis'),
(7, 1, 1, '2025-08-21 11:38:34', '2025-08-21 11:38:47', NULL, 2, 127, 'Aug_21st_2025 - request to be paid 4 days early.PNG', '/admin/contractors/uploads/2/Aug_21st_2025_-_request_to_be_paid_4_days_early.PNG', '1', 'Sean requested to be paid 4 days early, so I sent $681.82 via Venmo today, Aug 21st, at 11:30am instead of the scheduled pay date of Aug 24th. No worries. He sent the request to me over DM\'s on Slack.');

-- --------------------------------------------------------

--
-- Table structure for table `module_contractors_notes`
--

CREATE TABLE `module_contractors_notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `contractor_id` int(11) NOT NULL,
  `note_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_contractors_status_history`
--

CREATE TABLE `module_contractors_status_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `contractor_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `status_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 1, '2025-08-06 16:27:41', '2025-08-08 21:58:10', NULL, 1, 'Atlis', 1, 5),
(2, 1, 1, '2025-08-06 16:28:28', '2025-08-21 15:48:03', NULL, 2, 'Judicial Information Services & Technology', NULL, 5),
(3, 1, 1, '2025-08-06 16:28:37', '2025-08-08 21:58:10', NULL, 2, 'Business Operations', NULL, 5),
(4, 1, 1, '2025-08-06 16:28:48', '2025-08-08 21:58:10', NULL, 2, 'Court Clerks', NULL, 5),
(5, 1, 1, '2025-08-21 02:22:59', '2025-08-21 15:48:10', NULL, 3, 'Public Defender', 30, 6);

-- --------------------------------------------------------

--
-- Table structure for table `module_kanban_boards`
--

CREATE TABLE `module_kanban_boards` (
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
-- Dumping data for table `module_kanban_boards`
--

INSERT INTO `module_kanban_boards` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `description`) VALUES
(1, 1, 1, '2025-08-20 00:18:26', '2025-08-20 00:20:37', NULL, 'Dave Wilkins', NULL),
(2, 1, 1, '2025-08-20 00:18:30', '2025-08-20 00:20:28', NULL, 'Dave Wilkins', NULL),
(3, 1, 1, '2025-08-20 00:20:19', '2025-08-20 00:20:41', NULL, 'Dave Wilkins', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_kanban_board_projects`
--

CREATE TABLE `module_kanban_board_projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `board_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_kanban_board_projects`
--

INSERT INTO `module_kanban_board_projects` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `board_id`, `project_id`) VALUES
(2, 1, NULL, '2025-08-20 00:20:28', '2025-08-20 00:20:28', NULL, 2, 1),
(3, 1, NULL, '2025-08-20 00:20:37', '2025-08-20 00:20:37', NULL, 1, 2),
(4, 1, NULL, '2025-08-20 00:20:41', '2025-08-20 00:20:41', NULL, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `module_kanban_board_statuses`
--

CREATE TABLE `module_kanban_board_statuses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `board_id` int(11) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_kanban_board_statuses`
--

INSERT INTO `module_kanban_board_statuses` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `board_id`, `status_id`, `name`, `sort_order`) VALUES
(1, 1, NULL, '2025-08-20 00:20:19', '2025-08-20 00:20:19', NULL, 3, 32, '', 1),
(2, 1, NULL, '2025-08-20 00:20:19', '2025-08-20 00:20:19', NULL, 3, 34, '', 3),
(3, 1, NULL, '2025-08-20 00:20:19', '2025-08-20 00:20:19', NULL, 3, 35, '', 4);

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
(1, 1, 1, '2025-08-06 16:27:19', '2025-08-08 22:19:06', NULL, 'Atlis Technologies LLC', 1, 1),
(2, 1, 1, '2025-08-06 16:27:55', '2025-08-08 22:19:06', NULL, 'Lake County, IL', NULL, 1);

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
  `status` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects`
--

INSERT INTO `module_projects` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `agency_id`, `division_id`, `name`, `description`, `requirements`, `specifications`, `status`, `priority`, `type`, `start_date`, `complete_date`, `completed`) VALUES
(1, 1, 1, '2025-08-19 23:01:08', '2025-08-19 23:04:25', NULL, 2, 2, 'Emailing Sealed Documents (E.S.D)', '', '', '', 29, 56, NULL, '2025-08-01', NULL, 0),
(2, 1, 1, '2025-08-19 23:02:03', '2025-08-19 23:24:13', NULL, 2, 3, 'Bench View', '', '', '', 29, 58, NULL, '2025-08-01', NULL, 0),
(3, 1, 1, '2025-08-20 00:15:31', '2025-08-20 00:42:24', NULL, 2, 2, 'Fee Waiver Icon in Case Header', '', '', '', 31, 57, NULL, '2025-04-26', NULL, 0),
(4, 1, 1, '2025-08-21 15:38:14', '2025-08-21 15:38:14', NULL, 1, 1, 'ATLIS TECHNOLOGIES - CORE PROJECT', '', '', '', 29, NULL, NULL, '2025-08-21', NULL, 0),
(5, 1, 1, '2025-08-21 18:08:35', '2025-08-21 18:08:35', NULL, 2, 3, 'Judge Mass Reassignment', 'Hi Gia & Davey,\r\n\r\nDo you have any specific requirements or specifications for the Judge Mass Reassignment project? I don’t want to make this any more complex than necessary—at a high level, it should be straightforward. For the sake of example, Judge A is the retiring judge and Judge B is the newly assigned judge.\r\n\r\n\r\nThanks,\r\nDave\r\n', '1) What gets reassigned\r\n-	Reassign all future events currently assigned to Judge A over to Judge B.\r\no	“All” assumes no filters (Case Type, Event Type, etc.).\r\no	“Future” assumes we are not modifying past events.\r\n-	Should any case-level or caseAssignment fields also be updated (for Judge A and/or Judge B)?\r\n\r\n\r\n2) Audit, validation, and proof checking\r\n-	Do you need audit artifacts (e.g., before/after counts, per-case change logs with timestamp/user, downloadable CSV)?\r\n-	Should we add guardrails (e.g., exclude sealed/closed cases, skip in-progress or same-day events)?\r\n\r\n\r\n3) Execution & UX\r\n-	Once Judge A → Judge B is selected, should the process run automatically in the background, or would you prefer a preview/confirm step with progress tracking?\r\n-	Would a summary be useful (e.g., via Search, Report, or Email notification)?', ', '', 29, NULL, NULL, '2025-08-21', NULL, 0),
(6, 1, 1, '2025-08-21 22:22:02', '2025-08-21 22:22:02', NULL, 1, 1, 'McLean County, IL', '', '', '', 29, 56, NULL, '2025-08-21', NULL, 0),
(7, 1, 1, '2025-08-21 22:25:38', '2025-08-21 22:25:38', NULL, 1, 1, 'JIT 2025 User Conference', '', '', '', 30, 87, NULL, '2025-11-13', NULL, 0);

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
(1, 1, 1, '2025-08-19 23:01:17', '2025-08-19 23:01:17', NULL, 1, 1),
(2, 1, 1, '2025-08-19 23:02:15', '2025-08-19 23:02:15', NULL, 2, 1),
(3, 1, 1, '2025-08-19 23:24:40', '2025-08-19 23:24:40', NULL, 1, 6),
(4, 1, 1, '2025-08-19 23:24:41', '2025-08-19 23:24:41', NULL, 1, 5),
(5, 1, 1, '2025-08-19 23:24:44', '2025-08-19 23:24:44', NULL, 1, 2),
(6, 1, 1, '2025-08-20 00:17:19', '2025-08-20 00:17:19', NULL, 3, 1),
(7, 1, 1, '2025-08-20 00:17:23', '2025-08-20 00:17:23', NULL, 3, 6),
(8, 1, 1, '2025-08-20 00:17:29', '2025-08-20 00:17:29', NULL, 3, 5),
(9, 1, 1, '2025-08-21 15:31:33', '2025-08-21 15:31:33', NULL, 2, 2),
(10, 1, 1, '2025-08-21 15:38:17', '2025-08-21 15:38:17', NULL, 4, 1),
(11, 1, 1, '2025-08-21 15:38:19', '2025-08-21 15:38:19', NULL, 4, 2),
(12, 1, 1, '2025-08-21 22:22:09', '2025-08-21 22:22:09', NULL, 6, 1),
(13, 1, 1, '2025-08-21 22:22:12', '2025-08-21 22:22:12', NULL, 6, 2),
(14, 1, 1, '2025-08-21 22:29:57', '2025-08-21 22:29:57', NULL, 7, 1),
(15, 1, 1, '2025-08-21 22:30:01', '2025-08-21 22:30:01', NULL, 7, 2),
(16, 1, 1, '2025-08-21 22:30:04', '2025-08-21 22:30:04', NULL, 7, 4);

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
  `description` text DEFAULT NULL,
  `file_type_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects_files`
--

INSERT INTO `module_projects_files` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`, `note_id`, `description`, `file_type_id`, `status_id`, `sort_order`, `file_name`, `file_path`, `file_size`, `file_type`) VALUES
(1, 1, 1, '2025-08-20 00:40:59', '2025-08-20 00:40:59', NULL, 3, NULL, NULL, NULL, NULL, 0, 'Capture43434.PNG', '/module/project/uploads/project_3_1755672059_Capture43434.PNG', 136873, 'image/png'),
(2, 1, 1, '2025-08-20 00:40:59', '2025-08-20 00:40:59', NULL, 3, NULL, NULL, NULL, NULL, 0, 'DOCUMENT THIS WHAT I DID FOR LAKE FOR NEW ICON IN HEADER.txt', '/module/project/uploads/project_3_1755672059_DOCUMENT_THIS_WHAT_I_DID_FOR_LAKE_FOR_NEW_ICON_IN_HEADER.txt', 1910, 'text/plain'),
(3, 1, 1, '2025-08-20 00:40:59', '2025-08-20 00:40:59', NULL, 3, NULL, NULL, NULL, NULL, 0, 'Feedback from CC and Leah Balzer.txt', '/module/project/uploads/project_3_1755672059_Feedback_from_CC_and_Leah_Balzer.txt', 886, 'text/plain'),
(4, 1, 1, '2025-08-20 00:40:59', '2025-08-20 00:40:59', NULL, 3, NULL, NULL, NULL, NULL, 0, 'FeeWaiver Entity.PNG', '/module/project/uploads/project_3_1755672059_FeeWaiver_Entity.PNG', 291893, 'image/png'),
(5, 1, 1, '2025-08-20 00:40:59', '2025-08-20 00:40:59', NULL, 3, NULL, NULL, NULL, NULL, 0, 'unnamed (2).png', '/module/project/uploads/project_3_1755672059_unnamed__2_.png', 10562, 'image/png');

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
(1, 1, 1, '2025-08-21 22:23:10', '2025-08-21 22:23:10', NULL, 6, 'Sean Cadina will be Account Manager for McLean.'),
(4, 1, 1, '2025-08-21 22:27:53', '2025-08-21 22:28:09', NULL, 7, '<a class=\"fw-bold\" href=\"https://info.journaltech.com/uc2025\" target=_blank>JTI 2025 User Conference</a>'),
(5, 1, 1, '2025-08-21 22:29:33', '2025-08-21 22:29:33', NULL, 7, 'Registration: https://info.journaltech.com/uc2025-registration\r\n\r\nEvent Summary & Notes:\r\nWelcome Reception: Nov 12, 2025, 7:00 - 9:00 PM\r\nConference Dates: Nov 13-14, 2025\r\nConference Location: 4th Floor, Hudson Loft, 1200 S Hope St, Los Angeles, CA 90015\r\nEarly-Bird Registration (through July 15, 2025): $495\r\nStandard Registration (starting July 16-November 12, 2025): $595\r\nContact events@journaltech.com for group discounts of 3+ attendees of your organization.');

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
  `previous_status` int(11) DEFAULT NULL,
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

INSERT INTO `module_tasks` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`, `agency_id`, `division_id`, `name`, `description`, `requirements`, `specifications`, `status`, `previous_status`, `priority`, `start_date`, `due_date`, `complete_date`, `completed`, `completed_by`, `progress_percent`) VALUES
(1, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 'Probation Officer Role and Permissions in eCourt Portal', NULL, NULL, NULL, '35', NULL, '38', NULL, '2025-03-17', NULL, 0, NULL, 0),
(2, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 'GAL Role and Permissions in eCourt Portal', NULL, NULL, NULL, '35', NULL, '38', NULL, '2025-03-17', NULL, 0, NULL, 0),
(3, 1, 1, '2025-08-19 22:58:03', '2025-08-20 00:43:16', NULL, 3, 2, 2, 'Fee Waiver Icon in Case Header', NULL, NULL, NULL, '34', 34, '38', NULL, '2025-03-17', '2025-08-20', 1, 1, 100),
(4, 1, 1, '2025-08-19 22:58:03', '2025-08-21 09:52:20', NULL, NULL, 2, 2, 'New Judicial Assistant eCourt Role', NULL, NULL, NULL, '34', 34, '39', NULL, '2025-03-25', '2025-08-21', 1, 1, 100),
(6, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:59:41', NULL, NULL, 2, 2, 'Zoom Link', NULL, NULL, NULL, '32', NULL, NULL, NULL, '2025-03-24', NULL, 0, NULL, 0),
(7, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 'Write a SQL Query for Warrants?', NULL, NULL, NULL, '35', NULL, '37', NULL, '2025-03-26', NULL, 0, NULL, 0),
(8, 1, 1, '2025-08-19 22:58:03', '2025-08-21 09:52:19', NULL, NULL, 2, 2, 'Document View / Stamp Tool', NULL, NULL, NULL, '34', 34, '38', NULL, '2025-03-27', '2025-08-21', 1, 1, 100),
(9, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 'Judge Mass Reassignment', NULL, NULL, NULL, '32', NULL, '38', NULL, '2025-03-27', NULL, 0, NULL, 0),
(10, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 'AOIC Update to Report E and I - Quarterly Statistic Reports', NULL, NULL, NULL, '3', NULL, '39', NULL, '2025-04-01', NULL, 0, NULL, 0),
(11, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 'Report K Update', NULL, NULL, NULL, '3', NULL, '39', NULL, NULL, NULL, 0, NULL, 0),
(12, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 'New search form request: search by assigned judge and current attorney law firm', NULL, NULL, NULL, '3', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(13, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 'Block Restricted Documents from eProsecutor and eDefender', NULL, NULL, NULL, '3', NULL, '39', NULL, NULL, NULL, 0, NULL, 0),
(15, 1, 1, '2025-08-19 22:58:03', '2025-08-21 22:18:55', NULL, NULL, 2, 2, 'COURT CLERK DocDef REVIEW', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(16, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 'Interpreter Needed - UPDATE EVENT & WF', NULL, NULL, NULL, '32', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(17, 1, 1, '2025-08-19 23:01:26', '2025-08-20 00:13:56', NULL, 1, 2, 2, 'Initial Demo to Judge Novak - July 31st', NULL, NULL, NULL, '32', 32, '39', NULL, NULL, '2025-08-20', 1, 1, 100),
(18, 1, 1, '2025-08-19 23:02:12', '2025-08-21 15:31:46', NULL, 2, NULL, NULL, 'Bench View Discussion', NULL, NULL, NULL, '32', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(19, 1, 1, '2025-08-20 00:13:16', '2025-08-20 00:13:16', NULL, 1, NULL, NULL, 'Show [Seal Type] in Documents Viewer', NULL, NULL, NULL, '35', NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(20, 1, 1, '2025-08-20 00:21:07', '2025-08-20 00:42:11', NULL, 3, NULL, NULL, 'Create the Widget', NULL, NULL, NULL, '34', 32, '38', NULL, NULL, '2025-08-20', 1, 1, 100),
(22, 1, 1, '2025-08-21 18:09:03', '2025-08-21 18:09:25', NULL, 5, NULL, NULL, 'Email Davey & Gia about Specifications and Requirements', NULL, NULL, NULL, '32', NULL, '39', NULL, NULL, NULL, 0, NULL, 0),
(23, 1, 1, '2025-08-21 22:22:45', '2025-08-21 22:22:45', NULL, 6, NULL, NULL, 'Kick off meeting with McLean County, IL', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(24, 1, 1, '2025-08-21 22:24:14', '2025-08-21 22:24:14', NULL, 6, NULL, NULL, 'Reach out to RJ to get the proper Person/Contact to initiate', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(25, 1, 1, '2025-08-21 22:24:39', '2025-08-21 22:24:39', NULL, 6, NULL, NULL, 'Compile list of completed Projects & Tasks to demo', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(26, 1, 1, '2025-08-21 22:26:08', '2025-08-21 22:26:08', NULL, 7, NULL, NULL, 'Prepare Winnie to pitch Atlis\' support and post go-live services.', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(27, 1, 1, '2025-08-21 22:26:23', '2025-08-21 22:26:23', NULL, 7, NULL, NULL, 'Compile list of completed Projects & Tasks', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(28, 1, 1, '2025-08-21 22:26:43', '2025-08-21 22:26:43', NULL, 7, NULL, NULL, 'Business Cards / Way to introduce ourselves and Atlis', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0);

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
(1, 1, 1, '2025-03-11 14:08:41', '2025-08-19 22:58:03', NULL, 4, 'All Adoption cases are SEALED with a sealType of &#34;SEAL&#34;'),
(2, 1, 1, '2025-03-11 14:12:23', '2025-08-19 22:58:03', NULL, 4, 'Viewing sealed Cases and Documents are done in separate securities.'),
(3, 1, 1, '2025-03-11 14:26:15', '2025-08-19 22:58:03', NULL, 4, '- MiGarcia DirPerson created\r\n- User Created'),
(5, 1, 1, '2025-03-11 15:09:28', '2025-08-19 22:58:03', NULL, 4, 'Winnie asked to reduce the options in the LEFT \"Workspace\" NAV so Kasper gave her \"Public\"'),
(6, 1, 1, '2025-03-11 15:14:36', '2025-08-19 22:58:03', NULL, 4, 'I consulted Kasper as he did this.'),
(7, 1, 1, '2025-03-19 00:21:49', '2025-08-19 22:58:03', NULL, 8, 'Kasper emailed me and said he figured this out.'),
(8, 1, 1, '2025-04-08 14:04:57', '2025-08-19 22:58:03', NULL, 16, 'METADATA created on eCourt Test - 4/8/25\r\n\r\ncfInterpreterOrdered2\r\ncfInterpreterPresent2\r\ncfInterpreterRequired2\r\ncfInterpreterMemo2\r\n\r\ncfInterpreterOrdered3\r\ncfInterpreterPresent3\r\ncfInterpreterRequired3\r\ncfInterpreterMemo3'),
(9, 1, 1, '2025-04-09 16:22:02', '2025-08-19 22:58:03', NULL, 9, 'ISSUE TO CONSIDER: Some Judge\'s have multiple DirPerson, Persons, PersonIdentifiers, and Users.\r\n***issue particularly when using the LU-Judges or S-Judges and multiple are options to select... should just be 1 !'),
(10, 1, 1, '2025-04-09 17:06:52', '2025-08-19 22:58:03', NULL, 16, 'METADATA created in my Lake eCourt env.\r\nABOVE FORGOT THE \"Languages\" PLAIN FIELD.'),
(11, 1, 1, '2025-08-20 00:14:27', '2025-08-20 00:14:27', NULL, 19, 'Done through System Property.'),
(12, 1, 1, '2025-08-21 18:09:15', '2025-08-21 18:09:15', NULL, 22, 'Hi Gia & Davey,\r\n\r\nDo you have any specific requirements or specifications for the Judge Mass Reassignment project? I don’t want to make this any more complex than necessary—at a high level, it should be straightforward. For the sake of example, Judge A is the retiring judge and Judge B is the newly assigned judge.\r\n\r\n1) What gets reassigned\r\n-	Reassign all future events currently assigned to Judge A over to Judge B.\r\no	“All” assumes no filters (Case Type, Event Type, etc.).\r\no	“Future” assumes we are not modifying past events.\r\n-	Should any case-level or caseAssignment fields also be updated (for Judge A and/or Judge B)?\r\n\r\n\r\n2) Audit, validation, and proof checking\r\n-	Do you need audit artifacts (e.g., before/after counts, per-case change logs with timestamp/user, downloadable CSV)?\r\n-	Should we add guardrails (e.g., exclude sealed/closed cases, skip in-progress or same-day events)?\r\n\r\n\r\n3) Execution & UX\r\n-	Once Judge A → Judge B is selected, should the process run automatically in the background, or would you prefer a preview/confirm step with progress tracking?\r\n-	Would a summary be useful (e.g., via Search, Report, or Email notification)?\r\n\r\n\r\nThanks,\r\nDave');

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
(1, 1, 1, '2025-08-19 23:02:19', '2025-08-19 23:02:19', NULL, 18, 1),
(2, 1, NULL, '2025-08-20 00:12:26', '2025-08-20 00:12:26', NULL, 17, 1),
(3, 1, NULL, '2025-08-20 00:43:09', '2025-08-20 00:43:09', NULL, 3, 1),
(4, 1, 1, '2025-08-21 15:31:49', '2025-08-21 15:31:49', NULL, 18, 2);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `user_id`, `first_name`, `last_name`, `email`, `gender_id`, `organization_id`, `agency_id`, `division_id`, `dob`, `user_updated`, `date_created`, `date_updated`, `memo`) VALUES
(1, 1, 'Dave', 'Wilkins', NULL, 59, NULL, NULL, NULL, '1992-02-20', 1, '2025-08-08 21:52:52', '2025-08-19 23:03:53', NULL),
(2, 2, 'Sean', 'Cadina', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-15 00:11:11', '2025-08-19 23:23:09', NULL),
(5, 4, 'Tyler', 'Jessop', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-17 22:17:49', '2025-08-19 23:23:32', NULL),
(12, 5, 'RJ', 'Calara', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-19 23:21:53', '2025-08-19 23:21:53', NULL),
(13, 6, 'Kasper', 'Krynski', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-19 23:22:44', '2025-08-19 23:22:44', NULL),
(14, 7, 'Mileny', 'Valdez', NULL, 60, NULL, NULL, NULL, NULL, 1, '2025-08-19 23:27:09', '2025-08-19 23:27:09', NULL),
(23, 8, 'Kenny', 'Reynolds', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-20 14:44:46', '2025-08-20 14:44:46', NULL),
(24, 9, 'Richard', 'Sprague', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-20 15:14:36', '2025-08-20 15:14:36', NULL),
(27, 10, 'Emma', 'Baylor', NULL, 60, NULL, NULL, NULL, NULL, 1, '2025-08-20 20:47:24', '2025-08-20 20:47:24', NULL),
(30, NULL, 'Keith', 'Grant', 'KGrant@lakecountyil.gov', 59, 2, 3, NULL, NULL, 1, '2025-08-20 21:03:51', '2025-08-21 02:17:10', NULL),
(31, NULL, 'Lonnie', 'Renda', 'LRenda@LakeCountyIL.gov', 59, 2, 4, NULL, NULL, 1, '2025-08-21 02:15:50', '2025-08-21 02:17:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `person_addresses`
--

CREATE TABLE `person_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `address_line1` varchar(255) DEFAULT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person_addresses`
--

INSERT INTO `person_addresses` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `person_id`, `type_id`, `status_id`, `start_date`, `end_date`, `address_line1`, `address_line2`, `city`, `state_id`, `postal_code`, `country`) VALUES
(1, 1, 1, '2025-08-08 21:52:52', '2025-08-08 21:52:52', NULL, 1, 111, 108, '2025-08-08', NULL, '3124 S 340 W Nibley, UT 84321', NULL, NULL, NULL, NULL, NULL),
(2, 1, 1, '2025-08-20 14:44:46', '2025-08-20 14:44:46', NULL, 23, 111, 108, '2025-08-20', NULL, 'kennydrenolds@gmail.com', NULL, NULL, NULL, NULL, NULL),
(3, NULL, 1, '2025-08-21 02:12:22', '2025-08-21 02:12:22', NULL, 30, 111, 108, '2014-08-01', NULL, '123 Test 456 South', '', 'Logan', 172, '84321', 'USA');

-- --------------------------------------------------------

--
-- Table structure for table `person_phones`
--

CREATE TABLE `person_phones` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `phone_number` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person_phones`
--

INSERT INTO `person_phones` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `person_id`, `type_id`, `status_id`, `start_date`, `end_date`, `phone_number`) VALUES
(1, 1, 1, '2025-08-08 21:52:52', '2025-08-08 21:52:52', NULL, 1, 115, 105, '2025-08-08', NULL, '4357645615'),
(2, 1, 1, '2025-08-20 14:44:46', '2025-08-20 14:44:46', NULL, 23, 115, 105, '2025-08-20', NULL, '4357601327'),
(3, 1, 1, '2025-08-20 15:14:36', '2025-08-20 15:14:36', NULL, 24, 115, 105, '2025-08-20', NULL, '4358902363'),
(4, 1, 1, '2025-08-20 20:47:24', '2025-08-20 20:47:24', NULL, 27, 115, 105, '2025-08-20', NULL, '4436179726'),
(5, NULL, 1, '2025-08-21 02:15:50', '2025-08-21 02:15:50', NULL, 31, 115, 105, NULL, NULL, '(224) 236-7938');

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
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `current_profile_pic_id` int(11) DEFAULT NULL,
  `type` enum('ADMIN','USER') DEFAULT 'USER',
  `status` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `email`, `password`, `email_verified`, `current_profile_pic_id`, `type`, `status`, `last_login`) VALUES
(1, 1, 1, '2025-08-06 16:08:42', '2025-08-22 08:26:16', NULL, 'Dave@AtlisTechnologies.com', '$2y$10$DTIuXMqLvNh1N.Go53lZKeSh5.KoCRa3kjlfJ0yboVhbnvcTRmcn6', 1, 4, 'ADMIN', 1, '2025-08-21 11:33:59'),
(2, 1, 1, '2025-08-15 00:11:11', '2025-08-21 15:31:21', NULL, 'Sean@AtlisTechnologies.com', '$2y$10$Bk4sqfPb4G49fa9HepMbBOfOjz/wEtvFJBSHIz9HFMO0nzOFeeJ3u', 0, 2, 'USER', 1, NULL),
(4, 1, 1, '2025-08-17 22:17:49', '2025-08-19 23:23:32', NULL, 'soup@atlistechnologies.com', '$2y$10$ZfDbGKjkTQPmyHJSgRsAx.cln1OEhDNdAb8rgpV68fr9q/NWAU17O', 0, NULL, 'USER', 1, NULL),
(5, 1, 1, '2025-08-19 23:21:53', '2025-08-19 23:21:53', NULL, 'rcalara@lakecountyil.gov', '$2y$10$6ZS/zYF7mW3VZkEsiLyOBeiiJHfBrSLPEQveZpnfL5CeZV148k8vG', 0, NULL, 'USER', 1, NULL),
(6, 1, 1, '2025-08-19 23:22:44', '2025-08-19 23:22:44', NULL, 'kkrynski@lakecountyil.gov', '$2y$10$gQEtHURn4ktYNyKR4f/1qeusz29IqCYGVO1/n7TE9xSqO81kqxNYi', 0, NULL, 'USER', 1, NULL),
(7, 1, 1, '2025-08-19 23:27:09', '2025-08-19 23:27:09', NULL, 'milenyvaldez@AtlisTechnologies.com', '$2y$10$K3F6dYfzQbVGSoIXjWrOmucNiQwj9e/KOPK81f9NvE6YNu/V.pE6q', 0, NULL, 'USER', 1, NULL),
(8, 1, 1, '2025-08-20 14:44:46', '2025-08-20 14:45:17', NULL, 'kenny@AtlisTechnologies.com', '$2y$10$k4v0J28VQpsDQUBGsWd/VevbNh329jZiCY5NBxhzzBub6QdrvrZYK', 0, NULL, 'USER', 1, NULL),
(9, 1, 1, '2025-08-20 15:14:36', '2025-08-20 15:14:36', NULL, 'richardsprague3@gmail.com', '$2y$10$0oZA5Mfmqe5JMXzUDmaJyeCe4k1YF4jmRXGEtxPpW253QYyIXf/CK', 0, NULL, 'USER', 1, NULL),
(10, 1, 1, '2025-08-20 20:47:24', '2025-08-20 20:47:24', NULL, 'emmabaylor@gmail.com', '$2y$10$4B6tCgezPP5mDagAeMGT.uf/1cRo1AtfaxVALRbBWlzpvQNDIv7bi', 0, NULL, 'USER', 1, NULL);

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
(5, 1, 1, '2025-08-21 11:33:59', '2025-08-21 11:34:01', NULL, '988825', '2025-08-21 11:43:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_profile_pics`
--

CREATE TABLE `users_profile_pics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_hash` varchar(255) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_profile_pics`
--

INSERT INTO `users_profile_pics` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `file_name`, `file_path`, `file_size`, `file_type`, `file_hash`, `width`, `height`, `uploaded_by`, `status_id`) VALUES
(2, 2, 1, '2025-08-21 15:31:21', '2025-08-21 15:31:21', NULL, 'Sean_Cadina_1755811881.JPEG', 'module/users/uploads/Sean_Cadina_1755811881.JPEG', 148386, 'image/jpeg', 'db6b656882af3a187bce2bab7d48b07c10a4b3198db54179686f38d68006dbeb', 800, 800, 1, 82),
(4, 1, 1, '2025-08-21 22:14:15', '2025-08-22 08:26:16', NULL, '1_1755836055.JPEG', 'module/users/uploads/1_1755836055.JPEG', 143231, 'image/jpeg', 'f692123980cc18e618350c55f549f246d2cf73cf6e0632142019eb27bb34df3e', 513, 458, 1, 82),
(5, 1, 1, '2025-08-22 08:26:01', '2025-08-22 08:26:16', NULL, '535471462_1222365166585268_6061415345364469578_n_1755872761.JPEG', 'module/users/uploads/535471462_1222365166585268_6061415345364469578_n_1755872761.JPEG', 72399, 'image/jpeg', 'db5dc9b5e63e2d99f123f9e42ab5f902239c4f8f9ba2674c54e2084159fc5a51', 600, 596, 1, 83);

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
-- Indexes for table `admin_navigation_links`
--
ALTER TABLE `admin_navigation_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_navigation_links_user_id` (`user_id`),
  ADD KEY `fk_admin_navigation_links_user_updated` (`user_updated`);

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
-- Indexes for table `admin_role_permission_groups`
--
ALTER TABLE `admin_role_permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_arpg_role_group` (`role_id`,`permission_group_id`),
  ADD KEY `fk_arpg_permission_group_id` (`permission_group_id`);

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
-- Indexes for table `module_contractors`
--
ALTER TABLE `module_contractors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_module_contractors_person_id` (`person_id`),
  ADD KEY `fk_module_contractors_user_id` (`user_id`),
  ADD KEY `fk_module_contractors_user_updated` (`user_updated`),
  ADD KEY `fk_module_contractors_status_id` (`status_id`),
  ADD KEY `fk_module_contractors_contractor_type_id` (`contractor_type_id`),
  ADD KEY `fk_module_contractors_acquaintance_type_id` (`acquaintance_type_id`);

--
-- Indexes for table `module_contractors_compensation`
--
ALTER TABLE `module_contractors_compensation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_contractors_compensation_user_id` (`user_id`),
  ADD KEY `fk_module_contractors_compensation_user_updated` (`user_updated`),
  ADD KEY `fk_module_contractors_compensation_contractor_id` (`contractor_id`),
  ADD KEY `fk_module_contractors_compensation_type_id` (`compensation_type_id`),
  ADD KEY `fk_module_contractors_compensation_payment_method_id` (`payment_method_id`),
  ADD KEY `fk_module_contractors_compensation_file_id` (`file_id`);

--
-- Indexes for table `module_contractors_contacts`
--
ALTER TABLE `module_contractors_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_contractors_contacts_user_id` (`user_id`),
  ADD KEY `fk_module_contractors_contacts_user_updated` (`user_updated`),
  ADD KEY `fk_module_contractors_contacts_contractor_id` (`contractor_id`),
  ADD KEY `fk_module_contractors_contacts_type_id` (`contact_type_id`);

--
-- Indexes for table `module_contractors_contacts_response`
--
ALTER TABLE `module_contractors_contacts_response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_contractors_contacts_response_user_id` (`user_id`),
  ADD KEY `fk_module_contractors_contacts_response_contact_id` (`contact_id`),
  ADD KEY `fk_module_contractors_contacts_response_type_id` (`response_type_id`),
  ADD KEY `fk_module_contractors_contacts_response_assigned_to` (`assigned_to`),
  ADD KEY `fk_module_contractors_contacts_response_user_updated` (`user_updated`);

--
-- Indexes for table `module_contractors_contact_responses`
--
ALTER TABLE `module_contractors_contact_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_contractors_contact_responses_user_id` (`user_id`),
  ADD KEY `fk_module_contractors_contact_responses_user_updated` (`user_updated`),
  ADD KEY `fk_module_contractors_contact_responses_contact_id` (`contact_id`),
  ADD KEY `fk_module_contractors_contact_responses_type_id` (`response_type_id`),
  ADD KEY `fk_module_contractors_contact_responses_assigned_user_id` (`assigned_user_id`);

--
-- Indexes for table `module_contractors_files`
--
ALTER TABLE `module_contractors_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_contractors_files_user_id` (`user_id`),
  ADD KEY `fk_module_contractors_files_user_updated` (`user_updated`),
  ADD KEY `fk_module_contractors_files_contractor_id` (`contractor_id`),
  ADD KEY `fk_module_contractors_files_file_type_id` (`file_type_id`);

--
-- Indexes for table `module_contractors_notes`
--
ALTER TABLE `module_contractors_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_contractors_notes_user_id` (`user_id`),
  ADD KEY `fk_module_contractors_notes_user_updated` (`user_updated`),
  ADD KEY `fk_module_contractors_notes_contractor_id` (`contractor_id`);

--
-- Indexes for table `module_contractors_status_history`
--
ALTER TABLE `module_contractors_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_contractors_status_history_user_id` (`user_id`),
  ADD KEY `fk_module_contractors_status_history_user_updated` (`user_updated`),
  ADD KEY `fk_module_contractors_status_history_contractor_id` (`contractor_id`),
  ADD KEY `fk_module_contractors_status_history_status_id` (`status_id`);

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
-- Indexes for table `module_kanban_boards`
--
ALTER TABLE `module_kanban_boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_kanban_boards_user_id` (`user_id`),
  ADD KEY `fk_module_kanban_boards_user_updated` (`user_updated`);

--
-- Indexes for table `module_kanban_board_projects`
--
ALTER TABLE `module_kanban_board_projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_module_kanban_board_projects_board_project` (`board_id`,`project_id`),
  ADD KEY `fk_module_kanban_board_projects_user_id` (`user_id`),
  ADD KEY `fk_module_kanban_board_projects_user_updated` (`user_updated`),
  ADD KEY `fk_module_kanban_board_projects_board_id` (`board_id`),
  ADD KEY `fk_module_kanban_board_projects_project_id` (`project_id`);

--
-- Indexes for table `module_kanban_board_statuses`
--
ALTER TABLE `module_kanban_board_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_kanban_board_statuses_user_id` (`user_id`),
  ADD KEY `fk_module_kanban_board_statuses_user_updated` (`user_updated`),
  ADD KEY `fk_module_kanban_board_statuses_board_id` (`board_id`);

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
  ADD KEY `fk_module_projects_priority` (`priority`),
  ADD KEY `fk_module_projects_type` (`type`);

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
  ADD KEY `fk_module_projects_files_note_id` (`note_id`),
  ADD KEY `fk_module_projects_files_file_type_id` (`file_type_id`),
  ADD KEY `fk_module_projects_files_status_id` (`status_id`);

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
  ADD KEY `fk_person_user_updated` (`user_updated`),
  ADD KEY `fk_person_gender_id` (`gender_id`),
  ADD KEY `fk_person_organization_id` (`organization_id`),
  ADD KEY `fk_person_agency_id` (`agency_id`),
  ADD KEY `fk_person_division_id` (`division_id`);

--
-- Indexes for table `person_addresses`
--
ALTER TABLE `person_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_person_addresses_user_id` (`user_id`),
  ADD KEY `fk_person_addresses_user_updated` (`user_updated`),
  ADD KEY `fk_person_addresses_person_id` (`person_id`),
  ADD KEY `fk_person_addresses_type_id` (`type_id`),
  ADD KEY `fk_person_addresses_status_id` (`status_id`),
  ADD KEY `fk_person_addresses_state_id` (`state_id`);

--
-- Indexes for table `person_phones`
--
ALTER TABLE `person_phones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_person_phones_user_id` (`user_id`),
  ADD KEY `fk_person_phones_user_updated` (`user_updated`),
  ADD KEY `fk_person_phones_person_id` (`person_id`),
  ADD KEY `fk_person_phones_type_id` (`type_id`),
  ADD KEY `fk_person_phones_status_id` (`status_id`);

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
  ADD UNIQUE KEY `uk_users_email` (`email`),
  ADD KEY `fk_users_user_id` (`user_id`),
  ADD KEY `fk_users_user_updated` (`user_updated`),
  ADD KEY `fk_users_current_profile_pic_id` (`current_profile_pic_id`);

--
-- Indexes for table `users_2fa`
--
ALTER TABLE `users_2fa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_2fa_user_id` (`user_id`),
  ADD KEY `fk_users_2fa_user_updated` (`user_updated`);

--
-- Indexes for table `users_profile_pics`
--
ALTER TABLE `users_profile_pics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_profile_pics_user_id` (`user_id`),
  ADD KEY `fk_users_profile_pics_user_updated` (`user_updated`),
  ADD KEY `fk_users_profile_pics_uploaded_by` (`uploaded_by`),
  ADD KEY `fk_users_profile_pics_status_id` (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_audit_log`
--
ALTER TABLE `admin_audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `admin_navigation_links`
--
ALTER TABLE `admin_navigation_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `admin_permission_groups`
--
ALTER TABLE `admin_permission_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin_permission_group_permissions`
--
ALTER TABLE `admin_permission_group_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `admin_role_permission_groups`
--
ALTER TABLE `admin_role_permission_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=534;

--
-- AUTO_INCREMENT for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `module_agency`
--
ALTER TABLE `module_agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `module_contractors`
--
ALTER TABLE `module_contractors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module_contractors_compensation`
--
ALTER TABLE `module_contractors_compensation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `module_contractors_contacts`
--
ALTER TABLE `module_contractors_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `module_contractors_contacts_response`
--
ALTER TABLE `module_contractors_contacts_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_contractors_contact_responses`
--
ALTER TABLE `module_contractors_contact_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_contractors_files`
--
ALTER TABLE `module_contractors_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `module_contractors_notes`
--
ALTER TABLE `module_contractors_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_contractors_status_history`
--
ALTER TABLE `module_contractors_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_division`
--
ALTER TABLE `module_division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `module_kanban_boards`
--
ALTER TABLE `module_kanban_boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `module_kanban_board_projects`
--
ALTER TABLE `module_kanban_board_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `module_kanban_board_statuses`
--
ALTER TABLE `module_kanban_board_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `module_organization`
--
ALTER TABLE `module_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_projects`
--
ALTER TABLE `module_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `module_projects_assignments`
--
ALTER TABLE `module_projects_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `module_projects_files`
--
ALTER TABLE `module_projects_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `module_projects_notes`
--
ALTER TABLE `module_projects_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `module_tasks`
--
ALTER TABLE `module_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `module_tasks_files`
--
ALTER TABLE `module_tasks_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_tasks_notes`
--
ALTER TABLE `module_tasks_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `module_task_assignments`
--
ALTER TABLE `module_task_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `person_addresses`
--
ALTER TABLE `person_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `person_phones`
--
ALTER TABLE `person_phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users_2fa`
--
ALTER TABLE `users_2fa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_profile_pics`
--
ALTER TABLE `users_profile_pics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_navigation_links`
--
ALTER TABLE `admin_navigation_links`
  ADD CONSTRAINT `fk_admin_navigation_links_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_navigation_links_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `fk_admin_role_permissions_permission_group_id` FOREIGN KEY (`permission_group_id`) REFERENCES `admin_permission_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_role_permissions_role_id` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_role_permissions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_role_permissions_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_role_permission_groups`
--
ALTER TABLE `admin_role_permission_groups`
  ADD CONSTRAINT `fk_arpg_permission_group_id` FOREIGN KEY (`permission_group_id`) REFERENCES `admin_permission_groups` (`id`),
  ADD CONSTRAINT `fk_arpg_role_id` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`);

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
-- Constraints for table `module_agency`
--
ALTER TABLE `module_agency`
  ADD CONSTRAINT `fk_module_agency_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_agency_organization_id` FOREIGN KEY (`organization_id`) REFERENCES `module_organization` (`id`),
  ADD CONSTRAINT `fk_module_agency_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_agency_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_agency_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_contractors`
--
ALTER TABLE `module_contractors`
  ADD CONSTRAINT `fk_module_contractors_acquaintance_type_id` FOREIGN KEY (`acquaintance_type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_contractors_contractor_type_id` FOREIGN KEY (`contractor_type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_contractors_person_id` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_module_contractors_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_contractors_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_contractors_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_contractors_compensation`
--
ALTER TABLE `module_contractors_compensation`
  ADD CONSTRAINT `fk_module_contractors_compensation_contractor_id` FOREIGN KEY (`contractor_id`) REFERENCES `module_contractors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_contractors_compensation_payment_method_id` FOREIGN KEY (`payment_method_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_contractors_compensation_type_id` FOREIGN KEY (`compensation_type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_contractors_compensation_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_contractors_compensation_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_contractors_contacts`
--
ALTER TABLE `module_contractors_contacts`
  ADD CONSTRAINT `fk_module_contractors_contacts_contractor_id` FOREIGN KEY (`contractor_id`) REFERENCES `module_contractors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_contractors_contacts_type_id` FOREIGN KEY (`contact_type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_contractors_contacts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_contractors_contacts_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_contractors_contacts_response`
--
ALTER TABLE `module_contractors_contacts_response`
  ADD CONSTRAINT `fk_module_contractors_contacts_response_assigned_to` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_contractors_contacts_response_contact_id` FOREIGN KEY (`contact_id`) REFERENCES `module_contractors_contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_contractors_contacts_response_type_id` FOREIGN KEY (`response_type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_contractors_contacts_response_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_contractors_contacts_response_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_contractors_contact_responses`
--
ALTER TABLE `module_contractors_contact_responses`
  ADD CONSTRAINT `fk_module_contractors_contact_responses_assigned_user_id` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_contractors_contact_responses_contact_id` FOREIGN KEY (`contact_id`) REFERENCES `module_contractors_contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_contractors_contact_responses_type_id` FOREIGN KEY (`response_type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_contractors_contact_responses_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_contractors_contact_responses_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_contractors_files`
--
ALTER TABLE `module_contractors_files`
  ADD CONSTRAINT `fk_module_contractors_files_contractor_id` FOREIGN KEY (`contractor_id`) REFERENCES `module_contractors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_contractors_files_file_type_id` FOREIGN KEY (`file_type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_contractors_files_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_contractors_files_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_contractors_notes`
--
ALTER TABLE `module_contractors_notes`
  ADD CONSTRAINT `fk_module_contractors_notes_contractor_id` FOREIGN KEY (`contractor_id`) REFERENCES `module_contractors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_contractors_notes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_contractors_notes_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_contractors_status_history`
--
ALTER TABLE `module_contractors_status_history`
  ADD CONSTRAINT `fk_module_contractors_status_history_contractor_id` FOREIGN KEY (`contractor_id`) REFERENCES `module_contractors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_contractors_status_history_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_contractors_status_history_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_contractors_status_history_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_division`
--
ALTER TABLE `module_division`
  ADD CONSTRAINT `fk_module_division_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`),
  ADD CONSTRAINT `fk_module_division_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_division_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_division_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_division_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_kanban_board_projects`
--
ALTER TABLE `module_kanban_board_projects`
  ADD CONSTRAINT `fk_module_kanban_board_projects_board_id` FOREIGN KEY (`board_id`) REFERENCES `module_kanban_boards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_kanban_board_projects_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_kanban_board_statuses`
--
ALTER TABLE `module_kanban_board_statuses`
  ADD CONSTRAINT `fk_module_kanban_board_statuses_board_id` FOREIGN KEY (`board_id`) REFERENCES `module_kanban_boards` (`id`);

--
-- Constraints for table `module_organization`
--
ALTER TABLE `module_organization`
  ADD CONSTRAINT `fk_module_organization_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_organization_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_organization_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_organization_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_projects`
--
ALTER TABLE `module_projects`
  ADD CONSTRAINT `fk_module_projects_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`),
  ADD CONSTRAINT `fk_module_projects_division_id` FOREIGN KEY (`division_id`) REFERENCES `module_division` (`id`),
  ADD CONSTRAINT `fk_module_projects_priority_id` FOREIGN KEY (`priority`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_projects_status_id` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_projects_type_id` FOREIGN KEY (`type`) REFERENCES `lookup_list_items` (`id`);

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
  ADD CONSTRAINT `fk_module_projects_files_file_type_id` FOREIGN KEY (`file_type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_projects_files_note_id` FOREIGN KEY (`note_id`) REFERENCES `module_projects_notes` (`id`),
  ADD CONSTRAINT `fk_module_projects_files_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`),
  ADD CONSTRAINT `fk_module_projects_files_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`);

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

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `fk_person_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_person_division_id` FOREIGN KEY (`division_id`) REFERENCES `module_division` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_person_gender_id` FOREIGN KEY (`gender_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_person_organization_id` FOREIGN KEY (`organization_id`) REFERENCES `module_organization` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_person_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_person_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `person_addresses`
--
ALTER TABLE `person_addresses`
  ADD CONSTRAINT `fk_person_addresses_person_id` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_person_addresses_state_id` FOREIGN KEY (`state_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_person_addresses_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_person_addresses_type_id` FOREIGN KEY (`type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_person_addresses_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_person_addresses_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `person_phones`
--
ALTER TABLE `person_phones`
  ADD CONSTRAINT `fk_person_phones_person_id` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_person_phones_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_person_phones_type_id` FOREIGN KEY (`type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_person_phones_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_person_phones_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_current_profile_pic_id` FOREIGN KEY (`current_profile_pic_id`) REFERENCES `users_profile_pics` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users_profile_pics`
--
ALTER TABLE `users_profile_pics`
  ADD CONSTRAINT `fk_users_profile_pics_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_users_profile_pics_uploaded_by` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_profile_pics_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_profile_pics_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
