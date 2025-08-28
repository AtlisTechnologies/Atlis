-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2025 at 07:03 AM
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
(1, 1, 1, '2025-08-23 01:30:48', '2025-08-23 01:30:48', NULL, 'person', 30, 'UPDATE', 'Updated person', '{\"id\":30,\"user_id\":null,\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-20 21:03:51\",\"date_updated\":\"2025-08-21 02:17:10\",\"memo\":null}', '{\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(2, 1, 1, '2025-08-23 01:30:48', '2025-08-23 01:30:48', NULL, 'person_addresses', 3, 'UPDATE', 'Updated address', NULL, '{\":pid\":30,\":type_id\":111,\":status_id\":108,\":start_date\":\"2014-08-01\",\":end_date\":null,\":line1\":\"123 Test 456 South\",\":line2\":\"\",\":city\":\"Logan\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":3}'),
(3, 1, 1, '2025-08-23 01:30:51', '2025-08-23 01:30:51', NULL, 'person', 30, 'UPDATE', 'Updated person', '{\"id\":30,\"user_id\":null,\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-20 21:03:51\",\"date_updated\":\"2025-08-21 02:17:10\",\"memo\":null}', '{\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(4, 1, 1, '2025-08-23 01:30:51', '2025-08-23 01:30:51', NULL, 'person_addresses', 3, 'UPDATE', 'Updated address', NULL, '{\":pid\":30,\":type_id\":111,\":status_id\":108,\":start_date\":\"2014-08-01\",\":end_date\":null,\":line1\":\"123 Test 456 South\",\":line2\":\"\",\":city\":\"Logan\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USAt\",\":uid\":1,\":id\":3}'),
(5, 1, 1, '2025-08-23 01:30:55', '2025-08-23 01:30:55', NULL, 'person', 30, 'UPDATE', 'Updated person', '{\"id\":30,\"user_id\":null,\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-20 21:03:51\",\"date_updated\":\"2025-08-21 02:17:10\",\"memo\":null}', '{\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(6, 1, 1, '2025-08-23 01:30:55', '2025-08-23 01:30:55', NULL, 'person_addresses', 3, 'UPDATE', 'Updated address', NULL, '{\":pid\":30,\":type_id\":111,\":status_id\":108,\":start_date\":\"2014-08-01\",\":end_date\":null,\":line1\":\"123 Test 456 South\",\":line2\":\"\",\":city\":\"Logan\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":3}'),
(7, 1, 1, '2025-08-23 01:37:50', '2025-08-23 01:37:50', NULL, 'person', 30, 'UPDATE', 'Updated person', '{\"id\":30,\"user_id\":null,\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-20 21:03:51\",\"date_updated\":\"2025-08-21 02:17:10\",\"memo\":null}', '{\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":2,\"agency_id\":3,\"division_id\":5,\"dob\":null}'),
(8, 1, 1, '2025-08-23 01:37:50', '2025-08-23 01:37:50', NULL, 'person_addresses', 3, 'UPDATE', 'Updated address', NULL, '{\":pid\":30,\":type_id\":111,\":status_id\":108,\":start_date\":\"2014-08-01\",\":end_date\":null,\":line1\":\"123 Test 456 South\",\":line2\":\"\",\":city\":\"Logan\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":3}'),
(9, 1, 1, '2025-08-23 01:38:10', '2025-08-23 01:38:10', NULL, 'module_division', 9, 'CREATE', 'Created division', NULL, '{\"agency_id\":4,\"name\":\"State\'s Attorney Office\",\"main_person\":31,\"status\":27}'),
(10, 1, 1, '2025-08-23 01:38:34', '2025-08-23 01:38:34', NULL, 'person', 1, 'UPDATE', 'Updated person', '{\"id\":1,\"user_id\":1,\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"email\":null,\"gender_id\":59,\"organization_id\":1,\"agency_id\":1,\"division_id\":1,\"dob\":\"1992-02-20\",\"user_updated\":1,\"date_created\":\"2025-08-08 21:52:52\",\"date_updated\":\"2025-08-19 23:03:53\",\"memo\":null}', '{\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\"}'),
(11, 1, 1, '2025-08-23 01:38:34', '2025-08-23 01:38:34', NULL, 'person_addresses', 1, 'UPDATE', 'Updated address', NULL, '{\":pid\":1,\":type_id\":111,\":status_id\":108,\":start_date\":\"2025-08-08\",\":end_date\":null,\":line1\":\"3124 S 340 W\",\":line2\":\"\",\":city\":\"Nibley\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":1}'),
(12, 1, 1, '2025-08-23 01:38:34', '2025-08-23 01:38:34', NULL, 'person_phones', 1, 'UPDATE', 'Updated phone', NULL, '{\":pid\":1,\":type_id\":115,\":status_id\":105,\":start_date\":\"2025-08-08\",\":end_date\":null,\":number\":\"4357645615\",\":uid\":1,\":id\":1}'),
(13, 1, 1, '2025-08-23 01:38:42', '2025-08-23 01:38:42', NULL, 'person', 1, 'UPDATE', 'Updated person', '{\"id\":1,\"user_id\":1,\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"email\":null,\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\",\"user_updated\":1,\"date_created\":\"2025-08-08 21:52:52\",\"date_updated\":\"2025-08-23 01:38:34\",\"memo\":null}', '{\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\"}'),
(14, 1, 1, '2025-08-23 01:38:42', '2025-08-23 01:38:42', NULL, 'person_addresses', 1, 'UPDATE', 'Updated address', NULL, '{\":pid\":1,\":type_id\":111,\":status_id\":108,\":start_date\":\"1992-02-20\",\":end_date\":null,\":line1\":\"3124 S 340 W\",\":line2\":\"\",\":city\":\"Nibley\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":1}'),
(15, 1, 1, '2025-08-23 01:38:42', '2025-08-23 01:38:42', NULL, 'person_phones', 1, 'UPDATE', 'Updated phone', NULL, '{\":pid\":1,\":type_id\":115,\":status_id\":105,\":start_date\":\"2025-08-08\",\":end_date\":null,\":number\":\"4357645615\",\":uid\":1,\":id\":1}'),
(16, 1, 1, '2025-08-23 01:38:50', '2025-08-23 01:38:50', NULL, 'person', 1, 'UPDATE', 'Updated person', '{\"id\":1,\"user_id\":1,\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"email\":null,\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\",\"user_updated\":1,\"date_created\":\"2025-08-08 21:52:52\",\"date_updated\":\"2025-08-23 01:38:34\",\"memo\":null}', '{\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\"}'),
(17, 1, 1, '2025-08-23 01:38:50', '2025-08-23 01:38:50', NULL, 'person_addresses', 1, 'UPDATE', 'Updated address', NULL, '{\":pid\":1,\":type_id\":111,\":status_id\":108,\":start_date\":\"2022-07-01\",\":end_date\":null,\":line1\":\"3124 S 340 W\",\":line2\":\"\",\":city\":\"Nibley\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":1}'),
(18, 1, 1, '2025-08-23 01:38:50', '2025-08-23 01:38:50', NULL, 'person_phones', 1, 'UPDATE', 'Updated phone', NULL, '{\":pid\":1,\":type_id\":115,\":status_id\":105,\":start_date\":\"2025-08-08\",\":end_date\":null,\":number\":\"4357645615\",\":uid\":1,\":id\":1}'),
(19, 1, 1, '2025-08-23 02:27:57', '2025-08-23 02:27:57', NULL, 'module_contractors', 4, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"initial_contact_date\":\"2025-06-11\",\"title_role\":\"BI Analyst \\/ Report Writer\",\"acquaintance\":\"Former JTI Employee.\\r\\nThomas and Amanda\'s old neighbor.\\r\\nWorked with John Wilkins at New Dawn Technologies.\",\"acquaintance_type_id\":102,\"start_date\":\"2025-06-21\",\"end_date\":null}', '{\"status_id\":\"79\",\"initial_contact_date\":\"2025-06-11\",\"title_role\":\"BI Analyst \\/ Report Writer\",\"acquaintance\":\"Former JTI Employee.\\r\\nThomas and Amanda\'s old neighbor.\\r\\nWorked with John Wilkins at New Dawn Technologies.\",\"acquaintance_type_id\":\"102\",\"start_date\":\"2025-06-21\",\"end_date\":\"\"}'),
(20, 1, 1, '2025-08-23 02:28:02', '2025-08-23 02:28:02', NULL, 'module_contractors', 5, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"initial_contact_date\":null,\"title_role\":null,\"acquaintance\":null,\"acquaintance_type_id\":null,\"start_date\":null,\"end_date\":null}', '{\"status_id\":\"79\",\"initial_contact_date\":\"\",\"title_role\":\"\",\"acquaintance\":\"\",\"acquaintance_type_id\":\"\",\"start_date\":\"\",\"end_date\":\"\"}'),
(21, 1, 1, '2025-08-23 02:28:25', '2025-08-23 02:28:25', NULL, 'module_contractors', 1, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"initial_contact_date\":null,\"title_role\":null,\"acquaintance\":null,\"acquaintance_type_id\":null,\"start_date\":null,\"end_date\":null}', '{\"status_id\":\"79\",\"initial_contact_date\":\"\",\"title_role\":\"\",\"acquaintance\":\"\",\"acquaintance_type_id\":\"187\",\"start_date\":\"2024-10-01\",\"end_date\":\"\"}'),
(22, 1, 1, '2025-08-23 02:28:28', '2025-08-23 02:28:28', NULL, 'module_contractors', 1, 'UPDATE', 'Updated contractor', '{\"status_id\":79,\"initial_contact_date\":null,\"title_role\":null,\"acquaintance\":null,\"acquaintance_type_id\":187,\"start_date\":\"2024-10-01\",\"end_date\":null}', '{\"status_id\":\"79\",\"initial_contact_date\":\"\",\"title_role\":\"Owner\",\"acquaintance\":\"\",\"acquaintance_type_id\":\"187\",\"start_date\":\"2024-10-01\",\"end_date\":\"\"}'),
(23, 1, 1, '2025-08-23 02:29:21', '2025-08-23 02:29:21', NULL, 'person', 1, 'UPDATE', 'Updated person', '{\"id\":1,\"user_id\":1,\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"email\":null,\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\",\"user_updated\":1,\"date_created\":\"2025-08-08 21:52:52\",\"date_updated\":\"2025-08-23 01:38:34\",\"memo\":null}', '{\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\"}'),
(24, 1, 1, '2025-08-23 02:29:21', '2025-08-23 02:29:21', NULL, 'person_addresses', 1, 'UPDATE', 'Updated address', NULL, '{\":pid\":1,\":type_id\":111,\":status_id\":108,\":start_date\":\"2022-07-01\",\":end_date\":null,\":line1\":\"3124 S 340 W\",\":line2\":\"\",\":city\":\"Nibley\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":1}'),
(25, 1, 1, '2025-08-23 02:29:21', '2025-08-23 02:29:21', NULL, 'person_phones', 1, 'UPDATE', 'Updated phone', NULL, '{\":pid\":1,\":type_id\":115,\":status_id\":105,\":start_date\":\"2025-08-08\",\":end_date\":null,\":number\":\"4357645615\",\":uid\":1,\":id\":1}'),
(26, 1, 1, '2025-08-23 02:29:21', '2025-08-23 02:29:21', NULL, 'person_phones', 6, 'CREATE', 'Added phone', NULL, '{\":pid\":1,\":type_id\":114,\":status_id\":106,\":start_date\":\"1992-02-20\",\":end_date\":\"2011-05-13\",\":number\":\"4357520708\",\":uid\":1}'),
(27, 1, 1, '2025-08-23 02:29:47', '2025-08-23 02:29:47', NULL, 'person', 1, 'UPDATE', 'Updated person', '{\"id\":1,\"user_id\":1,\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"email\":null,\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\",\"user_updated\":1,\"date_created\":\"2025-08-08 21:52:52\",\"date_updated\":\"2025-08-23 01:38:34\",\"memo\":null}', '{\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\"}'),
(28, 1, 1, '2025-08-23 02:29:47', '2025-08-23 02:29:47', NULL, 'person_addresses', 1, 'UPDATE', 'Updated address', NULL, '{\":pid\":1,\":type_id\":111,\":status_id\":108,\":start_date\":\"2022-07-01\",\":end_date\":null,\":line1\":\"3124 S 340 W\",\":line2\":\"\",\":city\":\"Nibley\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":1}'),
(29, 1, 1, '2025-08-23 02:29:47', '2025-08-23 02:29:47', NULL, 'person_addresses', 4, 'CREATE', 'Added address', NULL, '{\":pid\":1,\":type_id\":112,\":status_id\":109,\":start_date\":null,\":end_date\":null,\":line1\":\"715 W 2600 S\",\":line2\":\"\",\":city\":\"Nibley\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"\",\":uid\":1}'),
(30, 1, 1, '2025-08-23 02:29:47', '2025-08-23 02:29:47', NULL, 'person_phones', 1, 'UPDATE', 'Updated phone', NULL, '{\":pid\":1,\":type_id\":115,\":status_id\":105,\":start_date\":\"2025-08-08\",\":end_date\":null,\":number\":\"4357645615\",\":uid\":1,\":id\":1}'),
(31, 1, 1, '2025-08-23 02:29:47', '2025-08-23 02:29:47', NULL, 'person_phones', 6, 'UPDATE', 'Updated phone', NULL, '{\":pid\":1,\":type_id\":114,\":status_id\":106,\":start_date\":\"1992-02-20\",\":end_date\":\"2011-05-13\",\":number\":\"4357520708\",\":uid\":1,\":id\":6}'),
(32, 1, 1, '2025-08-23 02:29:52', '2025-08-23 02:29:52', NULL, 'person', 1, 'UPDATE', 'Updated person', '{\"id\":1,\"user_id\":1,\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"email\":null,\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\",\"user_updated\":1,\"date_created\":\"2025-08-08 21:52:52\",\"date_updated\":\"2025-08-23 01:38:34\",\"memo\":null}', '{\"first_name\":\"Dave\",\"last_name\":\"Wilkins\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":\"1992-02-20\"}'),
(33, 1, 1, '2025-08-23 02:29:52', '2025-08-23 02:29:52', NULL, 'person_addresses', 1, 'UPDATE', 'Updated address', NULL, '{\":pid\":1,\":type_id\":111,\":status_id\":108,\":start_date\":\"2022-07-01\",\":end_date\":null,\":line1\":\"3124 S 340 W\",\":line2\":\"\",\":city\":\"Nibley\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":1}'),
(34, 1, 1, '2025-08-23 02:29:52', '2025-08-23 02:29:52', NULL, 'person_addresses', 4, 'UPDATE', 'Updated address', NULL, '{\":pid\":1,\":type_id\":112,\":status_id\":109,\":start_date\":null,\":end_date\":null,\":line1\":\"715 W 2600 S\",\":line2\":\"\",\":city\":\"Nibley\",\":state_id\":172,\":postal\":\"84321\",\":country\":\"USA\",\":uid\":1,\":id\":4}'),
(35, 1, 1, '2025-08-23 02:29:52', '2025-08-23 02:29:52', NULL, 'person_phones', 1, 'UPDATE', 'Updated phone', NULL, '{\":pid\":1,\":type_id\":115,\":status_id\":105,\":start_date\":\"2025-08-08\",\":end_date\":null,\":number\":\"4357645615\",\":uid\":1,\":id\":1}'),
(36, 1, 1, '2025-08-23 02:29:52', '2025-08-23 02:29:52', NULL, 'person_phones', 6, 'UPDATE', 'Updated phone', NULL, '{\":pid\":1,\":type_id\":114,\":status_id\":106,\":start_date\":\"1992-02-20\",\":end_date\":\"2011-05-13\",\":number\":\"4357520708\",\":uid\":1,\":id\":6}'),
(37, 1, 1, '2025-08-23 02:30:06', '2025-08-23 02:30:06', NULL, 'person', 30, 'UPDATE', 'Updated person', '{\"id\":30,\"user_id\":null,\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":2,\"agency_id\":3,\"division_id\":5,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-20 21:03:51\",\"date_updated\":\"2025-08-23 01:37:50\",\"memo\":null}', '{\"first_name\":\"Keith\",\"last_name\":\"Grant\",\"email\":\"KGrant@lakecountyil.gov\",\"gender_id\":59,\"organization_id\":2,\"agency_id\":3,\"division_id\":5,\"dob\":null}'),
(38, 1, 1, '2025-08-23 02:30:06', '2025-08-23 02:30:06', NULL, 'person_addresses', 3, 'DELETE', 'Deleted address', NULL, NULL),
(39, 1, 1, '2025-08-23 02:31:34', '2025-08-23 02:31:34', NULL, 'module_tasks_notes', 38, 'NOTE', '', '', 'Email sent with Lake\'s AUPs on 8/22/2025 at 3:48pm'),
(40, 1, 1, '2025-08-23 02:32:30', '2025-08-23 02:32:30', NULL, 'module_contractors_contacts', 8, 'CREATE', 'Added contact', '', '{\"contact_type_id\":75,\"summary\":\"EMAIL SENT AFTER CREATING HIS @ATLIS EMAIL ADDRESS.\\r\\n\\r\\nThomas,\\r\\n\\r\\nPlease review, sign, and return the attached Access Use Policies for the 19th Circuit Court of Lake County, IL. These will give you permission to access their systems and view confidential data on a CJIS. (Criminal Justice Information System) Some of these documents may seem (well, they are) unnecessary as they won\'t be lending you a laptop or phone, but I guess it\'s all required. They will also perform a background check, with your consent.\\r\\n\\r\\nI recommend using the free program PDF24 https:\\/\\/www.pdf24.org\\/en\\/ for any and all edits you make to a PDF. (I don\'t have Adobe pro)\\r\\n\\r\\nPlease notice on the document titled \\\"Electronic Communications-Acceptable  Cell Phone-SmartPhone Usage  Policy -7-2016\\\" you are asked to sign and date two different pages:\\r\\nThe 2nd to last and 3rd to last pages. Do not sign the very last page \\u2014 that is for the Chief Judge.\\r\\n\\r\\nLet me know if you have any questions or concerns.\\r\\n\\r\\nDon\'t let the Court-jargon scare you; it\'s taken me 8 years to learn the Judicial systems... they can be very complex and confusing.\"}'),
(41, 1, 1, '2025-08-23 10:55:54', '2025-08-23 10:55:54', NULL, 'person', 58, 'CREATE', 'Created person', NULL, '{\"user_id\":13,\"first_name\":\"Zach\",\"last_name\":\"Jenks\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(42, 1, 1, '2025-08-23 10:57:03', '2025-08-23 10:57:03', NULL, 'person', 58, 'UPDATE', 'Updated person', '{\"id\":58,\"user_id\":13,\"first_name\":\"Zach\",\"last_name\":\"Jenks\",\"email\":null,\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-23 10:55:54\",\"date_updated\":\"2025-08-23 10:55:54\",\"memo\":null}', '{\"first_name\":\"Zach\",\"last_name\":\"Jenks\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(43, 1, 1, '2025-08-23 10:57:03', '2025-08-23 10:57:03', NULL, 'person_phones', 7, 'CREATE', 'Added phone', NULL, '{\":pid\":58,\":type_id\":113,\":status_id\":105,\":start_date\":\"2025-08-23\",\":end_date\":null,\":number\":\"8017875849\",\":uid\":1}'),
(44, 1, 1, '2025-08-23 10:57:10', '2025-08-23 10:57:10', NULL, 'module_contractors', 8, 'CREATE', 'Created contractor', NULL, '{\"user_id\":13,\"person_id\":58}'),
(45, 1, 1, '2025-08-23 10:57:42', '2025-08-23 10:57:42', NULL, 'module_contractors', 8, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"initial_contact_date\":null,\"title_role\":null,\"acquaintance\":null,\"acquaintance_type_id\":null,\"start_date\":null,\"end_date\":null}', '{\"status_id\":\"78\",\"initial_contact_date\":\"2025-08-23\",\"title_role\":\"\",\"acquaintance\":\"Zach is an ex-JTI employee. He worked on the eCourt Implementation team(s). Very skilled.\",\"acquaintance_type_id\":\"102\",\"start_date\":\"\",\"end_date\":\"\"}'),
(46, 1, 1, '2025-08-23 10:58:36', '2025-08-23 10:58:36', NULL, 'module_contractors_contacts', 9, 'CREATE', 'Added contact', '', '{\"contact_type_id\":76,\"summary\":\"Sean Cadina had a phone call with Zach that went great. Zach appears to be very excited and interested in joining Atlis. Zach mentioned he has many contacts (about 9) of agencies \\/ potential customers.\"}'),
(47, 1, 1, '2025-08-23 10:59:38', '2025-08-23 10:59:38', NULL, 'module_contractors_contacts', 10, 'CREATE', 'Added contact', '', '{\"contact_type_id\":99,\"summary\":\"Dave\'s Initial out reach to Zach via text message. Asking if he\'s got time for a 10 min call today or this weekend.\"}'),
(48, 1, 1, '2025-08-23 11:04:30', '2025-08-23 11:04:30', NULL, 'module_projects_questions', 2, 'QUESTION', '', '', 'What was was the color of George Washington\'s white horse?'),
(49, 1, 1, '2025-08-23 11:04:36', '2025-08-23 11:04:36', NULL, 'module_projects_answers', 2, 'ANSWER', '', '', 'White, dummy.'),
(50, 1, 1, '2025-08-23 11:04:46', '2025-08-23 11:04:46', NULL, 'module_projects_answers', 3, 'ANSWER', '', '', 'Yeah, it was obviously white.'),
(51, 1, 1, '2025-08-23 12:00:40', '2025-08-23 12:00:40', NULL, 'module_projects', 20, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"6\",\"division_id\":\"8\",\"is_private\":0,\"name\":\"DAVE - AROUND THE HOUSE\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"29\",\"priority\":\"56\",\"type\":\"182\",\"start_date\":\"2025-08-23\"}'),
(52, 1, 1, '2025-08-23 12:11:39', '2025-08-23 12:11:39', NULL, 'admin_permissions', 69, 'CREATE', 'Created permission', NULL, '{\"module\":\"calendar\",\"action\":\"create\"}'),
(53, 1, 1, '2025-08-23 12:11:41', '2025-08-23 12:11:41', NULL, 'admin_permissions', 70, 'CREATE', 'Created permission', NULL, '{\"module\":\"calendar\",\"action\":\"read\"}'),
(54, 1, 1, '2025-08-23 12:11:45', '2025-08-23 12:11:45', NULL, 'admin_permissions', 71, 'CREATE', 'Created permission', NULL, '{\"module\":\"calendar\",\"action\":\"update\"}'),
(55, 1, 1, '2025-08-23 12:11:50', '2025-08-23 12:11:50', NULL, 'admin_permissions', 72, 'CREATE', 'Created permission', NULL, '{\"module\":\"calendar\",\"action\":\"delete\"}'),
(56, 1, 1, '2025-08-23 12:12:24', '2025-08-23 12:12:24', NULL, 'admin_roles', 44, 'CREATE', 'Created role', NULL, '{\"name\":\"Feedback\",\"description\":\"Permissions for managing feedback records.\"}'),
(57, 1, 1, '2025-08-23 12:12:24', '2025-08-23 12:12:24', NULL, 'admin_role_permission_groups', 44, 'SYNC', 'Updated role group assignments', '[]', '[]'),
(58, 1, 1, '2025-08-23 12:12:39', '2025-08-23 12:12:39', NULL, 'admin_roles', 45, 'CREATE', 'Created role', NULL, '{\"name\":\"Calendar\",\"description\":\"Permissions for managing calendar records.\"}'),
(59, 1, 1, '2025-08-23 12:12:39', '2025-08-23 12:12:39', NULL, 'admin_role_permission_groups', 45, 'SYNC', 'Updated role group assignments', '[]', '[]'),
(60, 1, 1, '2025-08-23 12:12:42', '2025-08-23 12:12:42', NULL, 'admin_role_permission_groups', 39, 'DELETE', 'Removed role group assignments', '[]', '[]'),
(61, 1, 1, '2025-08-23 12:12:42', '2025-08-23 12:12:42', NULL, 'admin_roles', 39, 'DELETE', 'Deleted role', NULL, NULL),
(62, 1, 1, '2025-08-23 12:12:44', '2025-08-23 12:12:44', NULL, 'admin_role_permission_groups', 38, 'DELETE', 'Removed role group assignments', '[]', '[]'),
(63, 1, 1, '2025-08-23 12:12:44', '2025-08-23 12:12:44', NULL, 'admin_roles', 38, 'DELETE', 'Deleted role', NULL, NULL),
(64, 1, 1, '2025-08-23 12:12:46', '2025-08-23 12:12:46', NULL, 'admin_role_permission_groups', 40, 'DELETE', 'Removed role group assignments', '[]', '[]'),
(65, 1, 1, '2025-08-23 12:12:46', '2025-08-23 12:12:46', NULL, 'admin_roles', 40, 'DELETE', 'Deleted role', NULL, NULL),
(66, 1, 1, '2025-08-23 12:12:47', '2025-08-23 12:12:47', NULL, 'admin_role_permission_groups', 41, 'DELETE', 'Removed role group assignments', '[]', '[]'),
(67, 1, 1, '2025-08-23 12:12:47', '2025-08-23 12:12:47', NULL, 'admin_roles', 41, 'DELETE', 'Deleted role', NULL, NULL),
(68, 1, 1, '2025-08-23 12:12:49', '2025-08-23 12:12:49', NULL, 'admin_role_permission_groups', 42, 'DELETE', 'Removed role group assignments', '[]', '[]'),
(69, 1, 1, '2025-08-23 12:12:49', '2025-08-23 12:12:49', NULL, 'admin_roles', 42, 'DELETE', 'Deleted role', NULL, NULL),
(70, 1, 1, '2025-08-23 12:12:51', '2025-08-23 12:12:51', NULL, 'admin_role_permission_groups', 37, 'DELETE', 'Removed role group assignments', '[]', '[]'),
(71, 1, 1, '2025-08-23 12:12:51', '2025-08-23 12:12:51', NULL, 'admin_roles', 37, 'DELETE', 'Deleted role', NULL, NULL),
(72, 1, 1, '2025-08-23 12:12:52', '2025-08-23 12:12:52', NULL, 'admin_role_permission_groups', 43, 'DELETE', 'Removed role group assignments', '[]', '[]'),
(73, 1, 1, '2025-08-23 12:12:52', '2025-08-23 12:12:52', NULL, 'admin_roles', 43, 'DELETE', 'Deleted role', NULL, NULL),
(74, 1, 1, '2025-08-23 12:13:07', '2025-08-23 12:13:07', NULL, 'admin_role_permission_groups', 1, 'SYNC', 'Updated role group assignments', '[1,2,3,4,5,6,7,8,9,10,11]', '[3,10,6,12,11,5,2,8,4,7,9,1]'),
(75, 1, 1, '2025-08-23 12:13:07', '2025-08-23 12:13:07', NULL, 'admin_role_permission_groups', 10, 'SYNC', 'Updated role group assignments', '[2,3,5,6,8,9,11]', '[3,6,11,5,2,8,9]'),
(76, 1, 1, '2025-08-23 12:13:07', '2025-08-23 12:13:07', NULL, 'admin_role_permission_groups', 11, 'SYNC', 'Updated role group assignments', '[8,9,11]', '[11,8,9]'),
(77, 1, 1, '2025-08-23 12:13:07', '2025-08-23 12:13:07', NULL, 'admin_role_permission_groups', 12, 'SYNC', 'Updated role group assignments', '[8,9,11]', '[11,8,9]'),
(78, 1, 1, '2025-08-23 12:13:07', '2025-08-23 12:13:07', NULL, 'admin_role_permission_groups', 13, 'SYNC', 'Updated role group assignments', '[10,11]', '[10,11]'),
(79, 1, 1, '2025-08-23 12:13:07', '2025-08-23 12:13:07', NULL, 'admin_role_permission_groups', 14, 'SYNC', 'Updated role group assignments', '[10,11]', '[10,11]'),
(80, 1, 1, '2025-08-23 12:13:07', '2025-08-23 12:13:07', NULL, 'admin_role_permission_groups', 44, 'SYNC', 'Updated role group assignments', '[]', '[]'),
(81, 1, 1, '2025-08-23 12:13:07', '2025-08-23 12:13:07', NULL, 'admin_role_permission_groups', 45, 'SYNC', 'Updated role group assignments', '[]', '[]'),
(82, 1, 1, '2025-08-23 12:13:27', '2025-08-23 12:13:27', NULL, 'admin_role_permission_groups', 44, 'DELETE', 'Removed role group assignments', '[]', '[]'),
(83, 1, 1, '2025-08-23 12:13:27', '2025-08-23 12:13:27', NULL, 'admin_roles', 44, 'DELETE', 'Deleted role', NULL, NULL),
(84, 1, 1, '2025-08-23 12:13:32', '2025-08-23 12:13:32', NULL, 'admin_role_permission_groups', 45, 'DELETE', 'Removed role group assignments', '[]', '[]'),
(85, 1, 1, '2025-08-23 12:13:32', '2025-08-23 12:13:32', NULL, 'admin_roles', 45, 'DELETE', 'Deleted role', NULL, NULL),
(86, 1, 1, '2025-08-23 15:00:41', '2025-08-23 15:00:41', NULL, 'person', 59, 'CREATE', 'Created person', NULL, '{\"user_id\":14,\"first_name\":\"Nancy\",\"last_name\":\"Crandall\",\"gender_id\":60,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(87, 1, 1, '2025-08-23 15:00:58', '2025-08-23 15:00:58', NULL, 'person', 59, 'UPDATE', 'Updated person', '{\"id\":59,\"user_id\":14,\"first_name\":\"Nancy\",\"last_name\":\"Crandall\",\"email\":null,\"gender_id\":60,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-23 15:00:41\",\"date_updated\":\"2025-08-23 15:00:41\",\"memo\":null}', '{\"first_name\":\"Nancy\",\"last_name\":\"Crandall\",\"gender_id\":60,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(88, 1, 1, '2025-08-23 15:01:24', '2025-08-23 15:01:24', NULL, 'person', 59, 'UPDATE', 'Updated person', '{\"id\":59,\"user_id\":14,\"first_name\":\"Nancy\",\"last_name\":\"Crandall\",\"email\":null,\"gender_id\":60,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-23 15:00:41\",\"date_updated\":\"2025-08-23 15:00:41\",\"memo\":null}', '{\"first_name\":\"Nancy\",\"last_name\":\"Crandall\",\"gender_id\":60,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(89, 1, 1, '2025-08-23 15:01:24', '2025-08-23 15:01:24', NULL, 'person_phones', 8, 'CREATE', 'Added phone', NULL, '{\":pid\":59,\":type_id\":113,\":status_id\":105,\":start_date\":\"2025-08-23\",\":end_date\":null,\":number\":\"6514921467\",\":uid\":1}'),
(90, 1, 1, '2025-08-23 15:03:55', '2025-08-23 15:03:55', NULL, 'person', 27, 'UPDATE', 'Updated person', '{\"id\":27,\"user_id\":10,\"first_name\":\"Emma\",\"last_name\":\"Baylor\",\"email\":null,\"gender_id\":60,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-20 20:47:24\",\"date_updated\":\"2025-08-20 20:47:24\",\"memo\":null}', '{\"first_name\":\"Emma\",\"last_name\":\"Baylor\",\"gender_id\":60,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(91, 1, 1, '2025-08-23 15:03:55', '2025-08-23 15:03:55', NULL, 'person_phones', 4, 'UPDATE', 'Updated phone', NULL, '{\":pid\":27,\":type_id\":115,\":status_id\":105,\":start_date\":\"2025-08-20\",\":end_date\":null,\":number\":\"4436179726\",\":uid\":1,\":id\":4}'),
(92, 1, 1, '2025-08-23 15:54:59', '2025-08-23 15:54:59', NULL, 'module_projects_notes', 15, 'NOTE', '', '', 'For fiscal year 2025, the per diem rate for Los Angeles is $191 per night for lodging and $86 per day for Meals and Incidental Expenses (M&IE), totaling $277 per day. These rates are set by the General Services Administration (GSA) for official government travel and are higher than the standard rate due to Los Angeles\' high cost of living. \r\nBreakdown of the Los Angeles Per Diem Rate (FY 2025) \r\nLodging: $191\r\nMeals and Incidental Expenses (M&IE): $86\r\nTotal: $277\r\nKey Points\r\nGSA Rates:\r\nThese rates are for federal government employees traveling for official business. \r\nHigh-Cost Area:\r\nLos Angeles is considered a high-cost area, which results in a higher per diem allowance compared to the standard rate. \r\nEmployer\'s Accountable Plan:\r\nFor non-government employees, employer\'s accountable plans often use these GSA rates to reimburse employees for travel expenses. \r\nFirst and Last Day:\r\nOn your first and last day of travel, you may only be eligible for 75% of the M&IE rate.'),
(93, 1, 1, '2025-08-23 15:55:21', '2025-08-23 15:55:21', NULL, 'module_projects_notes', 16, 'NOTE', '', '', 'https://www.gsa.gov/travel/plan-book/per-diem-rates'),
(94, 1, 1, '2025-08-23 17:00:58', '2025-08-23 17:00:58', NULL, 'module_feedback', 1, 'CREATE', 'Created feedback', NULL, '{\"title\":\"Pages are broken\",\"description\":\"Broken pages\",\"type\":189}'),
(95, 1, 1, '2025-08-23 17:01:39', '2025-08-23 17:01:39', NULL, 'module_feedback', 2, 'CREATE', 'Created feedback', NULL, '{\"title\":\"test\",\"description\":\"test\",\"type\":192}'),
(96, 1, 1, '2025-08-23 17:01:51', '2025-08-23 17:01:51', NULL, 'module_feedback', 3, 'CREATE', 'Created feedback', NULL, '{\"title\":\"asd\",\"description\":\"asd\",\"type\":192}'),
(97, 1, 1, '2025-08-23 17:02:21', '2025-08-23 17:02:21', NULL, 'module_feedback', 4, 'CREATE', 'Created feedback', NULL, '{\"title\":\"asfd\",\"description\":\"asdf\",\"type\":191}'),
(98, 1, 1, '2025-08-23 17:03:11', '2025-08-23 17:03:11', NULL, 'module_feedback', 5, 'CREATE', 'Created feedback', NULL, '{\"title\":\"sdf\",\"description\":\"df\",\"type\":192}'),
(99, 1, 1, '2025-08-23 17:03:18', '2025-08-23 17:03:18', NULL, 'module_feedback', 6, 'CREATE', 'Created feedback', NULL, '{\"title\":\"sdf\",\"description\":\"df\",\"type\":192}'),
(100, 1, 1, '2025-08-23 17:04:03', '2025-08-23 17:04:03', NULL, 'module_feedback', 5, 'DELETE', 'Deleted feedback', '{\"title\":\"sdf\",\"description\":\"df\",\"type\":192}', ''),
(101, 1, 1, '2025-08-23 17:04:05', '2025-08-23 17:04:05', NULL, 'module_feedback', 6, 'DELETE', 'Deleted feedback', '{\"title\":\"sdf\",\"description\":\"df\",\"type\":192}', ''),
(102, 1, 1, '2025-08-23 17:44:36', '2025-08-23 17:44:36', NULL, 'person', 60, 'CREATE', 'Created person', NULL, '{\"user_id\":15,\"first_name\":\"Chris\",\"last_name\":\"Docstader\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(103, 1, 1, '2025-08-23 17:45:11', '2025-08-23 17:45:11', NULL, 'module_contractors', 9, 'CREATE', 'Created contractor', NULL, '{\"user_id\":15,\"person_id\":60}'),
(104, 1, 1, '2025-08-23 17:48:09', '2025-08-23 17:48:09', NULL, 'module_contractors', 9, 'UPDATE', 'Updated contractor', '{\"status_id\":78,\"initial_contact_date\":null,\"title_role\":null,\"acquaintance\":null,\"acquaintance_type_id\":null,\"start_date\":null,\"end_date\":null}', '{\"status_id\":\"78\",\"initial_contact_date\":\"2025-08-23\",\"title_role\":\"\",\"acquaintance\":\"Ex-JTI Employee\",\"acquaintance_type_id\":\"102\",\"start_date\":\"\",\"end_date\":\"\"}'),
(105, 1, 1, '2025-08-23 17:48:45', '2025-08-23 17:48:45', NULL, 'module_contractors_contacts', 11, 'CREATE', 'Added contact', '', '{\"contact_type_id\":99,\"summary\":\"Text Doc this morning to ask if he can take a 5 minute phone call.  I want to ask him about BI.\"}'),
(106, 1, 1, '2025-08-23 17:53:36', '2025-08-23 17:53:36', NULL, 'module_projects', 21, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"6\",\"division_id\":\"8\",\"is_private\":0,\"name\":\"DAVE - FILE CABINET\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"29\",\"priority\":\"57\",\"type\":\"182\",\"start_date\":\"2025-08-23\"}'),
(107, 1, 1, '2025-08-23 19:16:04', '2025-08-23 19:16:04', NULL, 'person', 61, 'CREATE', 'Created person', NULL, '{\"user_id\":16,\"first_name\":\"test\",\"last_name\":\"test\",\"gender_id\":60,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(108, 1, 1, '2025-08-23 19:19:05', '2025-08-23 19:19:05', NULL, 'person', 62, 'CREATE', 'Created person', NULL, '{\"user_id\":17,\"first_name\":\"test\",\"last_name\":\"test\",\"gender_id\":60,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(109, 1, 1, '2025-08-23 20:18:17', '2025-08-23 20:18:17', NULL, 'module_contractors_files', 12, 'UPLOAD', '', '', '{\"file\":\"Third Party Network Access Request Form.pdf\",\"version\":1}'),
(110, 1, 1, '2025-08-23 20:18:24', '2025-08-23 20:18:24', NULL, 'module_contractors_files', 13, 'UPLOAD', '', '', '{\"file\":\"Electronic Communications-Acceptable  Cell Phone-SmartPhone Usage  Policy -7-2016.pdf\",\"version\":1}'),
(111, 1, 1, '2025-08-23 20:18:32', '2025-08-23 20:18:32', NULL, 'module_contractors_files', 14, 'UPLOAD', '', '', '{\"file\":\"CONSENT FOR BACKGROUND CHECK - Lake County, IL.pdf\",\"version\":1}'),
(112, 1, 1, '2025-08-23 20:18:47', '2025-08-23 20:18:47', NULL, 'module_contractors_files', 15, 'UPLOAD', '', '', '{\"file\":\"9.4 Acceptable Use Policy CONTINGENT WORKERwith Signature Lines.pdf\",\"version\":1}'),
(113, 1, 1, '2025-08-23 20:19:21', '2025-08-23 20:19:21', NULL, 'module_contractors_files', 16, 'UPLOAD', '', '', '{\"file\":\"ATLIS TECHNOLOGIES WORK AGREEMENT - THOMAS WILKINS - ATLIS_SIGNED.pdf\",\"version\":1}'),
(114, 1, 1, '2025-08-23 20:20:08', '2025-08-23 20:20:08', NULL, 'module_contractors_notes', 3, 'NOTE', '', '', 'Sent a signed work agreement in the contract said 5 hours per week at $60/hr.'),
(115, 1, 1, '2025-08-23 20:21:02', '2025-08-23 20:21:02', NULL, 'module_contractors_notes', 4, 'NOTE', '', '', 'Sent a signed work agreement and in the contract put in 5 hours per week at $58/hr and to invoice every ~2 weeks.'),
(116, 1, 1, '2025-08-23 20:24:10', '2025-08-23 20:24:10', NULL, 'module_contractors_notes', 5, 'NOTE', '', '', 'Richard has helped Atlis for I\'m guessing around 8 hours of creating templates for contracts. I need to compensate him somehow soon. I also need him, or a different technical contract writer, to be much more involved.'),
(117, 1, 1, '2025-08-23 20:24:27', '2025-08-23 20:24:27', NULL, 'module_contractors_notes', 6, 'NOTE', '', '', 'I NEED TO UPDATE RICHARD\'S WORK AGREEMENT WITH ATLIS.'),
(118, 1, 1, '2025-08-23 20:25:05', '2025-08-23 20:25:05', NULL, 'module_projects', 22, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"1\",\"is_private\":0,\"name\":\"ATLIS TECHNOLOGIES - CORPORATE PROJECTS\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"29\",\"priority\":\"87\",\"type\":\"182\",\"start_date\":\"2025-08-23\"}'),
(119, 1, 1, '2025-08-23 21:57:02', '2025-08-23 21:57:02', NULL, 'module_tasks_notes', 39, 'NOTE', '', '', 'Fixed tonight. Eamon helped me. Emry saw and got jealous as she was reading with Ashlin. She cried and said she wants to help me.'),
(120, 1, 1, '2025-08-24 01:18:09', '2025-08-24 01:18:09', NULL, 'module_projects_questions', 3, 'QUESTION', '', '', 'Who is Dave Wilkins ?'),
(121, 1, 1, '2025-08-24 01:18:18', '2025-08-24 01:18:18', NULL, 'module_projects_answers', 4, 'ANSWER', '', '', 'Bob Saggit.'),
(122, 1, 1, '2025-08-24 01:34:36', '2025-08-24 01:34:36', NULL, 'module_tasks_questions', 1, 'QUESTION', '', '', 'What color per seal type ?'),
(123, 1, 1, '2025-08-24 01:34:50', '2025-08-24 01:34:50', NULL, 'module_tasks_answers', 1, 'ANSWER', '', '', 'Whatever color you pick from Bootstrap.'),
(124, 1, 1, '2025-08-24 01:35:10', '2025-08-24 01:35:10', NULL, 'module_projects_answers', 5, 'ANSWER', '', '', 'Next !'),
(125, 1, 1, '2025-08-24 01:35:21', '2025-08-24 01:35:21', NULL, 'module_projects_questions', 4, 'QUESTION', '', '', 'Question #2 !'),
(126, 1, 1, '2025-08-24 02:05:55', '2025-08-24 02:05:55', NULL, 'module_tasks_questions', 2, 'QUESTION', '', '', 'Should this be a PUBLIC or ADMIN module ?'),
(127, 1, 1, '2025-08-24 02:07:05', '2025-08-24 02:07:05', NULL, 'module_tasks_questions', 3, 'QUESTION', '', '', 'What layer/level or the Organizational hierarchy should the financial components be tracked at? Organization --> Agency --> Division. 🤔'),
(128, 1, 1, '2025-08-24 02:09:04', '2025-08-24 02:09:04', NULL, 'module_projects_questions', 5, 'QUESTION', '', '', 'test'),
(129, 1, 1, '2025-08-24 02:09:11', '2025-08-24 02:09:11', NULL, 'module_projects_answers', 6, 'ANSWER', '', '', 'test 2'),
(130, 1, 1, '2025-08-24 02:14:48', '2025-08-24 02:14:48', NULL, 'module_feedback', 4, 'DELETE', 'Deleted feedback', '{\"title\":\"asfd\",\"description\":\"asdf\",\"type\":191}', ''),
(131, 1, 1, '2025-08-24 02:14:50', '2025-08-24 02:14:50', NULL, 'module_feedback', 3, 'DELETE', 'Deleted feedback', '{\"title\":\"asd\",\"description\":\"asd\",\"type\":192}', ''),
(132, 1, 1, '2025-08-24 02:14:51', '2025-08-24 02:14:51', NULL, 'module_feedback', 2, 'DELETE', 'Deleted feedback', '{\"title\":\"test\",\"description\":\"test\",\"type\":192}', ''),
(133, 1, 1, '2025-08-24 02:16:21', '2025-08-24 02:16:21', NULL, 'module_tasks_notes', 40, 'NOTE', '', '', 'I purchased some SUPER SPECOSIA'),
(134, 1, 1, '2025-08-24 02:52:16', '2025-08-24 02:52:16', NULL, 'module_projects_questions', 1, 'UPDATE', '', 'This is the first question !', 'This is the first question ! ! !'),
(135, 1, 1, '2025-08-24 02:52:21', '2025-08-24 02:52:21', NULL, 'module_projects_answers', 1, 'UPDATE', '', 'Yes', 'Yes !!!'),
(136, 1, 1, '2025-08-24 02:55:46', '2025-08-24 02:55:46', NULL, 'module_tasks_notes', 41, 'NOTE', '', '', 'I purchased from: https://kures.co/\r\nKratom72!@'),
(137, 1, 1, '2025-08-24 09:55:07', '2025-08-24 09:55:07', NULL, 'module_projects_files', 7, 'UPLOAD', '', '', '{\"file\":\"Screen Shot 2021-08-04 at 4.20.27 PM (1).png\"}'),
(138, 1, 1, '2025-08-24 09:55:20', '2025-08-24 09:55:20', NULL, 'module_projects_files', 8, 'UPLOAD', '', '', '{\"file\":\"7-hydroxymitragynin_7-oh_an_assessment_of_the_scientific_data_and_toxicological_concerns_around_an_emerging_opioid_threat.pdf\"}'),
(139, 1, 1, '2025-08-24 11:32:06', '2025-08-24 11:32:06', NULL, 'module_projects', 23, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"1\",\"is_private\":0,\"name\":\"INITIAL CALL WITH ZACH JENKS\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"55\",\"priority\":\"58\",\"type\":\"182\",\"start_date\":\"2025-08-24\"}'),
(140, 1, 1, '2025-08-24 11:33:34', '2025-08-24 11:33:34', NULL, 'module_tasks_notes', 42, 'NOTE', '', '', '- ONLY FEW PEOPLE HAVE ACCESS TO PROD ENVS'),
(141, 1, 1, '2025-08-24 15:42:01', '2025-08-24 15:42:01', NULL, 'module_projects_answers', 1, 'DELETE', '', '', 'Yes !!!'),
(142, 1, 1, '2025-08-24 15:42:01', '2025-08-24 15:42:01', NULL, 'module_projects_answers', 5, 'DELETE', '', '', 'Next !'),
(143, 1, 1, '2025-08-24 15:42:01', '2025-08-24 15:42:01', NULL, 'module_projects_questions', 1, 'DELETE', '', '', 'This is the first question ! ! !'),
(144, 1, 1, '2025-08-24 15:42:05', '2025-08-24 15:42:05', NULL, 'module_projects_questions', 4, 'DELETE', '', '', 'Question #2 !'),
(145, 1, 1, '2025-08-24 17:31:39', '2025-08-24 17:31:39', NULL, 'module_tasks_notes', 43, 'NOTE', '', '', 'Created Atlis@Atlistechnologies.com'),
(146, 1, 1, '2025-08-24 18:22:30', '2025-08-24 18:22:30', NULL, 'module_products_services', 6, 'CREATE', 'Created product/service', NULL, '{\"name\":\"test\"}'),
(147, 1, 1, '2025-08-24 18:22:49', '2025-08-24 18:22:49', NULL, 'module_products_services', 7, 'CREATE', 'Created product/service', NULL, '{\"name\":\"test\"}'),
(148, 1, 1, '2025-08-24 18:23:00', '2025-08-24 18:23:00', NULL, 'module_products_services', 8, 'CREATE', 'Created product/service', NULL, '{\"name\":\"test\"}'),
(149, 1, 1, '2025-08-24 18:25:55', '2025-08-24 18:25:55', NULL, 'person', 63, 'CREATE', 'Created person', NULL, '{\"user_id\":18,\"first_name\":\"Alisha\",\"last_name\":\"Wilkins\",\"gender_id\":60,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(150, 1, 1, '2025-08-24 18:25:55', '2025-08-24 18:25:55', NULL, 'person_phones', 9, 'CREATE', 'Added phone', NULL, '{\":pid\":63,\":type_id\":113,\":status_id\":105,\":start_date\":\"2025-08-24\",\":end_date\":null,\":number\":\"4352130627\",\":uid\":1}'),
(151, 1, 1, '2025-08-24 18:26:07', '2025-08-24 18:26:07', NULL, 'module_contractors', 10, 'CREATE', 'Created contractor', NULL, '{\"user_id\":18,\"person_id\":63}'),
(152, 1, 1, '2025-08-24 18:51:18', '2025-08-24 18:51:18', NULL, 'module_contractors_contacts', 12, 'CREATE', 'Added contact', '', '{\"contact_type_id\":75,\"summary\":\"Hi Alisha,\\r\\nI am in need to offload some work that I could do, but just don\'t have time. I believe your expertise could help if this is something you\'re interested in.\\r\\nI recently rebranded from ATLIS to Atlis Technologies, and I\\u2019d love your professional help pulling together a proper Brand Kit and setting up some lightweight social media presence.\\r\\nFor the Brand Kit, I\\u2019m looking for:\\r\\nColor Palette: Primary brand color (#00948E), secondary colors, neutrals, and accent colors (with HEX, RGB, and CMYK codes).\\r\\nTypography: Recommended fonts (headlines, body text, digital use, print use).\\r\\nLogo Variations: Full logo, icon-only, text-only, light\\/dark backgrounds, favicon.\\r\\nImage & Photography Style: Example guidelines (stock images vs custom, filters, tone).\\r\\nBrand Voice & Tone: A few sentences describing how Atlis Technologies should \\u201csound\\u201d in writing.\\r\\nUsage Guidelines: Do\\u2019s and don\\u2019ts for logo, spacing, color ratios, etc.\\r\\n\\r\\nOn the Social Media side, the goal isn\\u2019t marketing but recognition, so just the basics:\\r\\nCreate SM Accounts for top Networks: Facebook, X, YouTube, etc. (you already have Instagram).\\r\\nProfile & Cover Images: Sized correctly for each platform, with consistent branding.\\r\\nOne Introductory Post Per Platform: Something light, maybe an IT joke or clever \\u201cWe\\u2019re here\\u201d post.\\r\\nBio\\/About Sections: Few caveats here which we\'ll have to review together.\\r\\nHandle Consistency: Secure @AtlisTechnologies (or the closest match) across platforms. (let me know if @AtlisTechnologies is not available)\\r\\nEmail, Online, & Document Graphics: Branded header\\/footer images for email signatures, newsletters, proposals, contracts, agreements, etc.\\r\\n\\r\\nI\'m sure you can find other items as well. I trust your expertise and creative touch \\u2014 I just want Atlis Technologies to look sharp and consistent across the interwebz. \\r\\nI can provide you with things that you need \\u2014 let me know if there is anything else you would need:\\r\\nAccess to the Social Media email address: socialmedia@AtlisTechnologies.com\\r\\nFew branding items I do have\\r\\n\\u2002\\u2002\\u2002\\u2002Main brand color: #00948E\\r\\nFont face (.ttf or .otf) for logo\\r\\nFew other things I can\'t think of right now.\\r\\nWhat is the best and easiest way to compensate?  Dollar$ per hour? Lump sum? (I hate time tracking...)\\r\\nLet me know your thoughts; I\'m open to hear your preferences.\"}'),
(153, 1, 1, '2025-08-24 19:07:18', '2025-08-24 19:07:18', NULL, 'module_products_services', 6, 'UPDATE', 'Updated product/service', '{\"name\":\"test\",\"type_id\":null,\"status_id\":0,\"description\":\"test\",\"price\":null,\"memo\":\"\"}', '{\"name\":\"Business Intelligence\",\"type_id\":215,\"status_id\":235,\"description\":\"test\",\"price\":69.69,\"memo\":\"test\"}'),
(154, 1, 1, '2025-08-24 19:27:13', '2025-08-24 19:27:13', NULL, 'module_organization_persons', 2, 'DELETE', 'Removed person', NULL, NULL),
(155, 1, 1, '2025-08-24 19:27:16', '2025-08-24 19:27:16', NULL, 'module_organization', 2, 'UPDATE', 'Updated organization', '{\"name\":\"Lake County, IL\",\"main_person\":30,\"status\":1,\"file_name\":null,\"file_path\":null,\"file_size\":null,\"file_type\":null}', '{\"name\":\"Lake County, IL\",\"main_person\":null,\"status\":1}'),
(156, 1, 1, '2025-08-24 19:28:08', '2025-08-24 19:28:08', NULL, 'module_division_persons', 4, 'CREATE', 'Assigned person', NULL, '{\"division_id\":2,\"person_id\":57,\"role_id\":186,\"is_lead\":0}'),
(157, 1, 1, '2025-08-24 19:28:11', '2025-08-24 19:28:11', NULL, 'module_division_persons', 4, 'DELETE', 'Removed person', NULL, NULL),
(158, 1, 1, '2025-08-24 19:28:15', '2025-08-24 19:28:15', NULL, 'module_division_persons', 5, 'CREATE', 'Assigned person', NULL, '{\"division_id\":2,\"person_id\":57,\"role_id\":186,\"is_lead\":1}'),
(159, 1, 1, '2025-08-24 19:28:18', '2025-08-24 19:28:18', NULL, 'module_division', 2, 'UPDATE', 'Updated division', '{\"agency_id\":2,\"name\":\"Judicial Information Services & Technology\",\"main_person\":null,\"status\":5,\"file_name\":null,\"file_path\":null,\"file_size\":null,\"file_type\":null}', '{\"agency_id\":2,\"name\":\"Judicial Information Services & Technology\",\"main_person\":57,\"status\":5}'),
(160, 1, 1, '2025-08-24 19:28:37', '2025-08-24 19:28:37', NULL, 'module_agency', 2, 'UPDATE', 'Updated agency', '{\"organization_id\":2,\"name\":\"19th Circuit Court\",\"main_person\":null,\"status\":3,\"file_name\":null,\"file_path\":null,\"file_size\":null,\"file_type\":null}', '{\"organization_id\":2,\"name\":\"19th Circuit Court\",\"main_person\":null,\"status\":3}'),
(161, 1, 1, '2025-08-24 19:28:37', '2025-08-24 19:28:37', NULL, 'module_agency', 2, 'UPLOAD', 'Uploaded agency file', NULL, '{\"file_name\":\"LakeCountyIL_Logo.png\",\"file_path\":\"2440863a92437531028982668632197e.png\",\"file_size\":375629,\"file_type\":\"image\\/png\"}'),
(162, 1, 1, '2025-08-24 19:50:47', '2025-08-24 19:50:47', NULL, 'module_products_services', 6, 'UPDATE', 'Updated product/service', '{\"name\":\"Business Intelligence\",\"type_id\":215,\"status_id\":235,\"description\":\"test\",\"price\":\"69.69\",\"memo\":\"test\"}', '{\"name\":\"Business Intelligence\",\"type_id\":215,\"status_id\":235,\"description\":\"test\",\"price\":69.69,\"memo\":\"test 2\"}'),
(163, 1, 1, '2025-08-24 21:44:13', '2025-08-24 21:44:13', NULL, 'module_projects_notes', 17, 'NOTE', '', '', 'Met with Kenny tonight. 8/24/25 at 9pm. We reviewed our new tasks from the Addendum / new scope.  Biggest hurdle will be getting new metadata created and scheduling a Restart in PROD.'),
(164, 1, 1, '2025-08-24 21:44:13', '2025-08-24 21:44:13', NULL, 'module_projects_files', 9, 'UPLOAD', '', '', '{\"file\":\"SoW #172 - RESTART ASSIGNMENTS.xlsx\"}'),
(165, 1, 1, '2025-08-24 21:45:07', '2025-08-24 21:45:07', NULL, 'module_projects_notes', 18, 'NOTE', '', '', 'Data Dictionary - as of Aug 24th, 2025.'),
(166, 1, 1, '2025-08-24 21:45:07', '2025-08-24 21:45:07', NULL, 'module_projects_files', 10, 'UPLOAD', '', '', '{\"file\":\"DataDictionary-LakeCountyCourt(n1)-2025-08-24.xls\"}'),
(167, 1, 1, '2025-08-24 21:45:29', '2025-08-24 21:45:29', NULL, 'module_projects_notes', 19, 'NOTE', '', '', 'CASE_STATUS Lookup List export (xml and xls)'),
(168, 1, 1, '2025-08-24 21:45:29', '2025-08-24 21:45:29', NULL, 'module_projects_files', 11, 'UPLOAD', '', '', '{\"file\":\"lookuplists-CASE_STATUS-LakeCountyCourt(n1)-2025-08-24.xls\"}'),
(169, 1, 1, '2025-08-24 21:45:29', '2025-08-24 21:45:29', NULL, 'module_projects_files', 12, 'UPLOAD', '', '', '{\"file\":\"lookuplists-CASE_STATUS-LakeCountyCourt(n1)-2025-08-24.xml\"}'),
(170, 1, 1, '2025-08-24 21:46:24', '2025-08-24 21:46:24', NULL, 'module_tasks_notes', 44, 'NOTE', '', '', 'DATABASE ROW COUNTS'),
(171, 1, 1, '2025-08-24 21:46:24', '2025-08-24 21:46:24', NULL, 'module_tasks_files', 6, 'UPLOAD', '', '', '{\"file\":\"ENTIRE DATABASE ROWS (1).sql\"}'),
(172, 1, 1, '2025-08-24 21:47:13', '2025-08-24 21:47:13', NULL, 'module_tasks_notes', 45, 'NOTE', '', '', 'NOTES / AGENDA FOR DEMO TO JUDGE NOVAK MEETING.'),
(173, 1, 1, '2025-08-24 21:47:13', '2025-08-24 21:47:13', NULL, 'module_tasks_files', 7, 'UPLOAD', '', '', '{\"file\":\"_DEMO TO JUDGE NOVAK.xlsx\"}'),
(174, 1, 1, '2025-08-24 22:35:48', '2025-08-24 22:35:48', NULL, 'module_projects_files', 13, 'UPLOAD', '', '', '{\"file\":\"_BENCH VIEW_.xlsx\"}'),
(175, 1, 1, '2025-08-24 22:35:51', '2025-08-24 22:35:51', NULL, 'module_projects_files', 14, 'UPLOAD', '', '', '{\"file\":\"Seal Type Badge in Doc Viewer\"}'),
(176, 1, 1, '2025-08-24 23:41:22', '2025-08-24 23:41:22', NULL, 'module_tasks_notes', 46, 'NOTE', '', '', 'JUST RENT DEDICATED SERVERS...... \r\nI REALLY DON\'T WANT ALL OF THE TROUBLE OF NETWORKING IN MY HOUSE......'),
(177, 1, 1, '2025-08-25 01:05:07', '2025-08-25 01:05:07', NULL, 'module_agency', 1, 'REMOVE_FILE', 'Removed agency file', '{\"file_name\":\"main_logo_dark_bg.png\",\"file_path\":\"\\/module\\/agency\\/uploads\\/agency_1.png\"}', NULL),
(178, 1, 1, '2025-08-25 01:05:34', '2025-08-25 01:05:34', NULL, 'module_organization', 1, 'UPDATE', 'Updated organization', '{\"name\":\"Atlis Technologies LLC\",\"main_person\":1,\"status\":1,\"file_name\":null,\"file_path\":null,\"file_size\":null,\"file_type\":null}', '{\"name\":\"Atlis Technologies LLC\",\"main_person\":1,\"status\":1}');
INSERT INTO `admin_audit_log` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `table_name`, `record_id`, `action`, `details`, `old_value`, `new_value`) VALUES
(179, 1, 1, '2025-08-25 01:05:34', '2025-08-25 01:05:34', NULL, 'module_organization', 1, 'UPLOAD', 'Uploaded organization file', NULL, '{\"file_name\":\"main_logo_AT_white_text_no_bg.png\",\"file_path\":\"4d07f9f8f55dba1a72df1eb6528f3bdd.png\",\"file_size\":79967,\"file_type\":\"image\\/png\"}'),
(180, 1, 1, '2025-08-25 01:05:39', '2025-08-25 01:05:39', NULL, 'module_organization', 1, 'REMOVE_FILE', 'Removed organization file', '{\"file_name\":\"main_logo_AT_white_text_no_bg.png\",\"file_path\":\"4d07f9f8f55dba1a72df1eb6528f3bdd.png\"}', NULL),
(181, 1, 1, '2025-08-25 01:05:45', '2025-08-25 01:05:45', NULL, 'module_organization', 1, 'UPDATE', 'Updated organization', '{\"name\":\"Atlis Technologies LLC\",\"main_person\":1,\"status\":1,\"file_name\":null,\"file_path\":null,\"file_size\":null,\"file_type\":null}', '{\"name\":\"Atlis Technologies LLC\",\"main_person\":1,\"status\":1}'),
(182, 1, 1, '2025-08-25 01:05:45', '2025-08-25 01:05:45', NULL, 'module_organization', 1, 'UPLOAD', 'Uploaded organization file', NULL, '{\"file_name\":\"main_logo_AT_dark_text_white_bg.png\",\"file_path\":\"2b38147e1806b4784eb93b035ffc6ed6.png\",\"file_size\":82972,\"file_type\":\"image\\/png\"}'),
(183, 1, 1, '2025-08-25 01:06:00', '2025-08-25 01:06:00', NULL, 'module_agency', 1, 'UPDATE', 'Updated agency', '{\"organization_id\":1,\"name\":\"Atlis Technologies\",\"main_person\":1,\"status\":3,\"file_name\":null,\"file_path\":null,\"file_size\":null,\"file_type\":null}', '{\"organization_id\":1,\"name\":\"Atlis Technologies\",\"main_person\":1,\"status\":3}'),
(184, 1, 1, '2025-08-25 01:06:00', '2025-08-25 01:06:00', NULL, 'module_agency', 1, 'UPLOAD', 'Uploaded agency file', NULL, '{\"file_name\":\"Logo_Top_Atlis_Technologies_1300x1300_300dpi_white_text_dark_bg.png\",\"file_path\":\"0040e65cb7c95b73129ea77e0b7d9175.png\",\"file_size\":128317,\"file_type\":\"image\\/png\"}'),
(185, 1, 1, '2025-08-25 01:06:12', '2025-08-25 01:06:12', NULL, 'module_division', 1, 'UPDATE', 'Updated division', '{\"agency_id\":1,\"name\":\"Atlis\",\"main_person\":1,\"status\":5,\"file_name\":null,\"file_path\":null,\"file_size\":null,\"file_type\":null}', '{\"agency_id\":1,\"name\":\"Atlis\",\"main_person\":1,\"status\":5}'),
(186, 1, 1, '2025-08-25 01:06:12', '2025-08-25 01:06:12', NULL, 'module_division', 1, 'UPLOAD', 'Uploaded division file', NULL, '{\"file_name\":\"main_logo.png\",\"file_path\":\"79c33383fb29f1fa912221172d822412.png\",\"file_size\":65851,\"file_type\":\"image\\/png\"}'),
(187, 1, 1, '2025-08-25 01:23:09', '2025-08-25 01:23:09', NULL, 'module_meeting', 8, 'CREATE', '', '', 'Created meeting'),
(188, 1, 1, '2025-08-25 01:49:09', '2025-08-25 01:49:09', NULL, 'module_projects_notes', 20, 'NOTE', '', '', 'Done. It\'s official.'),
(189, 1, 1, '2025-08-25 01:50:06', '2025-08-25 01:50:06', NULL, 'module_feedback', 1, 'DELETE', 'Deleted feedback', '{\"title\":\"Pages are broken\",\"description\":\"Broken pages\",\"type\":189}', ''),
(190, 1, 1, '2025-08-25 01:51:16', '2025-08-25 01:51:16', NULL, 'module_feedback', 7, 'CREATE', 'Created feedback', NULL, '{\"title\":\"Project --> Task Assignment Removes\",\"description\":\"When checking or unchecking a Task on the Projects Details view, the assigned user(s) Profile Pictures are removed though they don\'t actually get removed in the database.\",\"type\":189}'),
(192, 1, 1, '2025-08-25 01:59:20', '2025-08-25 01:59:20', NULL, 'module_meeting', 9, 'CREATE', '', '', 'Created meeting'),
(193, 1, 1, '2025-08-25 01:59:20', '2025-08-25 01:59:20', NULL, 'module_meeting_agenda', 1, 'CREATE', '', '', 'Report K'),
(194, 1, 1, '2025-08-25 01:59:20', '2025-08-25 01:59:20', NULL, 'module_meeting_agenda', 2, 'CREATE', '', '', 'Report K'),
(195, 1, 1, '2025-08-25 01:59:20', '2025-08-25 01:59:20', NULL, 'module_meeting_questions', 1, 'CREATE', '', '', 'When should we schedule the restart?'),
(196, 1, 1, '2025-08-25 01:59:20', '2025-08-25 01:59:20', NULL, 'module_meeting_questions', 2, 'CREATE', '', '', 'When should we schedule the restart?'),
(197, 1, 1, '2025-08-25 02:01:38', '2025-08-25 02:01:38', NULL, 'module_feedback', 8, 'CREATE', 'Created feedback', NULL, '{\"title\":\"MEETINGS Module - several bugs\",\"description\":\"- Can\'t edit a Meeting\\r\\n- Agenda items not showing\\r\\n- Attendees not saving or showing\\r\\n- Attachments not saving.\",\"type\":189}'),
(198, 1, 1, '2025-08-25 02:03:13', '2025-08-25 02:03:13', NULL, 'module_feedback', 9, 'CREATE', 'Created feedback', NULL, '{\"title\":\"Edit Product\\/Service\",\"description\":\"- On Edit Product\\/Service, Dropzone JS isn\'t working\",\"type\":189}'),
(199, 1, 1, '2025-08-25 02:20:36', '2025-08-25 02:20:36', NULL, 'person', 23, 'UPDATE', 'Updated person', '{\"id\":23,\"user_id\":8,\"first_name\":\"Kenny\",\"last_name\":\"Reynolds\",\"email\":null,\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-20 14:44:46\",\"date_updated\":\"2025-08-20 14:44:46\",\"memo\":null}', '{\"first_name\":\"Kenny\",\"last_name\":\"Reynolds\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(200, 1, 1, '2025-08-25 02:20:36', '2025-08-25 02:20:36', NULL, 'person_addresses', 2, 'UPDATE', 'Updated address', NULL, '{\":pid\":23,\":type_id\":111,\":status_id\":108,\":start_date\":\"2025-08-20\",\":end_date\":null,\":line1\":\"kennydrenolds@gmail.com\",\":line2\":\"\",\":city\":\"\",\":state_id\":null,\":postal\":\"\",\":country\":\"USA\",\":uid\":1,\":id\":2}'),
(201, 1, 1, '2025-08-25 02:20:36', '2025-08-25 02:20:36', NULL, 'person_phones', 2, 'UPDATE', 'Updated phone', NULL, '{\":pid\":23,\":type_id\":115,\":status_id\":105,\":start_date\":\"2025-08-20\",\":end_date\":null,\":number\":\"4357601327\",\":uid\":1,\":id\":2}'),
(202, 1, 1, '2025-08-25 02:20:36', '2025-08-25 02:20:36', NULL, 'admin_user_roles', 19, 'CREATE', 'Assigned role', NULL, '{\"user_account_id\":8,\"role_id\":12}'),
(203, 1, 1, '2025-08-25 13:13:16', '2025-08-25 13:13:16', NULL, 'module_meeting', 10, 'CREATE', '', '', 'Created meeting'),
(204, 1, 1, '2025-08-25 13:13:16', '2025-08-25 13:13:16', NULL, 'module_meeting_questions', 3, 'CREATE', '', '', 'Overall question is, are you interested in Contracting with my business, Atlis Technologies, to build this B.I. product/service?'),
(205, 1, 1, '2025-08-25 22:45:25', '2025-08-25 22:45:25', NULL, 'admin_task', 1, 'CREATE', 'Quick add', NULL, '{\"name\":\"Test #1\"}'),
(206, 1, 1, '2025-08-25 23:05:22', '2025-08-25 23:05:22', NULL, 'admin_task', 2, 'CREATE', 'Quick add', NULL, '{\"name\":\"test\"}'),
(207, 1, 1, '2025-08-25 23:05:25', '2025-08-25 23:05:25', NULL, 'admin_task', 3, 'CREATE', 'Quick add', NULL, '{\"name\":\"test 2\"}'),
(208, 1, 1, '2025-08-25 23:25:13', '2025-08-25 23:25:13', NULL, 'module_meeting', 11, 'CREATE', '', '', 'Created meeting'),
(209, 1, 1, '2025-08-25 23:25:13', '2025-08-25 23:25:13', NULL, 'module_meeting_questions', 4, 'CREATE', '', '', 'JOSEPH, WHERE DO YOU RECOMMEND WE START ?'),
(210, 1, 1, '2025-08-25 23:25:13', '2025-08-25 23:25:13', NULL, 'module_meeting_questions', 5, 'CREATE', '', '', 'Do you need a PC to work on? Laptop or Desktop?'),
(211, 1, 1, '2025-08-26 00:00:28', '2025-08-26 00:00:28', NULL, 'module_meeting', 12, 'CREATE', '', '', 'Created meeting'),
(212, 1, 1, '2025-08-26 00:05:34', '2025-08-26 00:05:34', NULL, 'module_meeting', 1, 'CREATE', '', '', 'Created meeting'),
(213, 1, 1, '2025-08-26 00:05:34', '2025-08-26 00:05:34', NULL, 'module_meeting_agenda', 1, 'CREATE', '', '', 'JTI User Conference'),
(214, 1, 1, '2025-08-26 00:05:34', '2025-08-26 00:05:34', NULL, 'module_meeting_questions', 1, 'CREATE', '', '', 'JOSEPH, WHERE DO YOU RECOMMEND WE START ?'),
(215, 1, 1, '2025-08-26 00:22:46', '2025-08-26 00:22:46', NULL, 'person', 5, 'UPDATE', 'Updated person', '{\"id\":5,\"user_id\":4,\"first_name\":\"Tyler\",\"last_name\":\"Jessop\",\"email\":null,\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null,\"user_updated\":1,\"date_created\":\"2025-08-17 22:17:49\",\"date_updated\":\"2025-08-19 23:23:32\",\"memo\":null}', '{\"first_name\":\"Tyler\",\"last_name\":\"Jessop\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(216, 1, 1, '2025-08-26 00:22:46', '2025-08-26 00:22:46', NULL, 'admin_user_roles', 20, 'CREATE', 'Assigned role', NULL, '{\"user_account_id\":4,\"role_id\":10}'),
(217, 1, 1, '2025-08-26 00:26:11', '2025-08-26 00:26:11', NULL, 'admin_task', 4, 'CREATE', 'Quick add', NULL, '{\"name\":\"test test test\"}'),
(218, 1, 1, '2025-08-26 00:31:30', '2025-08-26 00:31:30', NULL, 'admin_task', 4, 'UPDATE', 'Updated task', '{\"id\":4,\"user_id\":1,\"user_updated\":1,\"date_created\":\"2025-08-26 00:26:11\",\"date_updated\":\"2025-08-26 00:26:11\",\"memo\":null,\"name\":\"test test test\",\"description\":null,\"type_id\":null,\"category_id\":null,\"sub_category_id\":null,\"status_id\":null,\"priority_id\":null,\"start_date\":null,\"due_date\":null,\"is_completed\":0,\"completed_date\":null}', '{\"name\":\"test test test\"}'),
(219, 1, 1, '2025-08-26 13:26:44', '2025-08-26 13:26:44', NULL, 'module_meeting', 2, 'CREATE', '', '', 'Created meeting'),
(220, 1, 1, '2025-08-26 13:30:48', '2025-08-26 13:30:48', NULL, 'module_meeting', 3, 'CREATE', '', '', 'Created meeting'),
(221, 1, 1, '2025-08-26 13:30:48', '2025-08-26 13:30:48', NULL, 'module_meeting_agenda', 2, 'CREATE', '', '', 'Meeting with Davey and Soup for Mass Judge Reassignment + BNX17BNX18 Report'),
(222, 1, 1, '2025-08-26 13:30:48', '2025-08-26 13:30:48', NULL, 'module_meeting_agenda', 3, 'CREATE', '', '', 'Utah Prosecution Council'),
(223, 1, 1, '2025-08-26 13:30:48', '2025-08-26 13:30:48', NULL, 'module_meeting_agenda', 4, 'CREATE', '', '', 'Atlisware hosting / VPN'),
(224, 1, 1, '2025-08-26 13:30:48', '2025-08-26 13:30:48', NULL, 'module_meeting_questions', 2, 'CREATE', '', '', 'Can you make it to the JTI User Conference?'),
(225, 1, 1, '2025-08-26 13:30:48', '2025-08-26 13:30:48', NULL, 'module_meeting_attendees', 1, 'CREATE', '', '', 'Added attendee'),
(226, 1, 1, '2025-08-26 13:34:20', '2025-08-26 13:34:20', NULL, 'module_meeting_files', 1, 'UPLOAD', '', '', '{\"file\":\"joke-missed.gif\"}'),
(227, 1, 1, '2025-08-26 13:36:41', '2025-08-26 13:36:41', NULL, 'module_projects_notes', 21, 'NOTE', '', '', 'test'),
(228, 1, 1, '2025-08-26 13:36:41', '2025-08-26 13:36:41', NULL, 'module_projects_files', 15, 'UPLOAD', '', '', '{\"file\":\"joke-missed.gif\"}'),
(229, 1, 1, '2025-08-26 22:38:30', '2025-08-26 22:38:30', NULL, 'module_projects', 24, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"2\",\"division_id\":\"2\",\"is_private\":0,\"name\":\"***NEWEST*** CURRENT PROJECTS !\",\"description\":\"HIGHEST PRIORITY OF CURRENT PROJECTS FOR LAKE COUNTY, IL 19TH CIRCUIT COURT\\r\\nINCLUDING 3 DIFFERENT DEPARTMENTS: JIS, BIZ OPS, AND COURT CLERKS\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"29\",\"priority\":\"87\",\"type\":\"182\",\"start_date\":\"2025-08-26\"}'),
(230, 1, 1, '2025-08-26 22:42:00', '2025-08-26 22:42:00', NULL, 'module_projects', 26, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"1\",\"is_private\":0,\"name\":\"test 1\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"55\",\"priority\":\"58\",\"type\":\"182\",\"start_date\":\"\"}'),
(231, 1, 1, '2025-08-26 22:46:48', '2025-08-26 22:46:48', NULL, 'module_projects', 27, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"1\",\"is_private\":0,\"name\":\"test 3\",\"description\":\"\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"55\",\"priority\":\"58\",\"type\":\"182\",\"start_date\":\"\"}'),
(232, 1, 1, '2025-08-26 22:46:57', '2025-08-26 22:46:57', NULL, 'module_projects', 28, 'CREATE', 'Created project', NULL, '{\"agency_id\":\"1\",\"division_id\":\"8\",\"is_private\":0,\"name\":\"sadfasdf\",\"description\":\"asdfsadf\",\"requirements\":\"\",\"specifications\":\"\",\"status\":\"55\",\"priority\":\"58\",\"type\":\"182\",\"start_date\":\"\"}'),
(233, 1, 1, '2025-08-27 00:01:23', '2025-08-27 00:01:23', NULL, 'module_meeting', 1, 'CREATE', '', '', 'Created meeting'),
(234, 1, 1, '2025-08-27 00:47:41', '2025-08-27 00:47:41', NULL, 'module_meeting', 1, 'CREATE', '', '', 'Created meeting'),
(235, 1, 1, '2025-08-27 01:06:09', '2025-08-27 01:06:09', NULL, 'admin_role_permission_groups', 1, 'SYNC', 'Updated role group assignments', '[1,2,3,4,5,6,7,8,9,10,11,13,16,18]', '[18,3,13,20,10,19,6,12,17,11,15,5,2,16,8,4,7,9,1]'),
(236, 1, 1, '2025-08-27 01:06:09', '2025-08-27 01:06:09', NULL, 'admin_role_permission_groups', 10, 'SYNC', 'Updated role group assignments', '[2,3,5,6,8,9,11,13]', '[3,13,6,11,5,2,8,9]'),
(237, 1, 1, '2025-08-27 01:06:09', '2025-08-27 01:06:09', NULL, 'admin_role_permission_groups', 11, 'SYNC', 'Updated role group assignments', '[8,9,11,13]', '[13,11,8,9]'),
(238, 1, 1, '2025-08-27 01:06:09', '2025-08-27 01:06:09', NULL, 'admin_role_permission_groups', 12, 'SYNC', 'Updated role group assignments', '[8,9,11,13]', '[13,11,8,9]'),
(239, 1, 1, '2025-08-27 01:06:09', '2025-08-27 01:06:09', NULL, 'admin_role_permission_groups', 13, 'SYNC', 'Updated role group assignments', '[10,11]', '[10,11]'),
(240, 1, 1, '2025-08-27 01:06:09', '2025-08-27 01:06:09', NULL, 'admin_role_permission_groups', 14, 'SYNC', 'Updated role group assignments', '[10,11]', '[10,11]'),
(241, 1, 1, '2025-08-27 01:06:09', '2025-08-27 01:06:09', NULL, 'admin_role_permission_groups', 15, 'SYNC', 'Updated role group assignments', '[16]', '[16]'),
(242, 1, 1, '2025-08-27 01:12:59', '2025-08-27 01:12:59', NULL, 'module_meeting', 1, 'CREATE', 'Created meeting', '', '{\"title\":\"Dave + Sean\"}'),
(243, 1, 1, '2025-08-27 01:14:21', '2025-08-27 01:14:21', NULL, 'module_meeting', 1, 'UPDATE', 'Updated meeting', '', ''),
(244, 1, 1, '2025-08-27 01:15:46', '2025-08-27 01:15:46', NULL, 'module_meeting_attendees', 1, 'CREATE', 'Added attendee', '', '{\"user_id\":1}'),
(245, 1, 1, '2025-08-27 01:16:19', '2025-08-27 01:16:19', NULL, 'module_meeting', 1, 'UPDATE', 'Updated meeting', '', ''),
(246, 1, 1, '2025-08-27 01:16:26', '2025-08-27 01:16:26', NULL, 'module_meeting', 1, 'UPDATE', 'Updated meeting', '', ''),
(247, 1, 1, '2025-08-27 01:52:51', '2025-08-27 01:52:51', NULL, 'module_meeting_files', 1, 'UPLOAD', '', '', '{\"file\":\"meeting_3_1756236860_joke-missed.gif\"}'),
(248, 1, 1, '2025-08-27 01:54:21', '2025-08-27 01:54:21', NULL, 'module_meeting', 1, 'CREATE', 'Created meeting', '', '{\"title\":\"Dave + Sean\"}'),
(249, 1, 1, '2025-08-27 01:55:31', '2025-08-27 01:55:31', NULL, 'module_meeting', 1, 'UPDATE', 'Updated meeting', '', '{\"title\":\"Dave + Sean\"}'),
(250, 1, 1, '2025-08-27 01:55:31', '2025-08-27 01:55:31', NULL, 'module_meeting_agenda', 1, 'CREATE', 'Added agenda item', '', '{\"title\":\"- I\'ll follow up with Winnie on 5 hours.\"}'),
(251, 1, 1, '2025-08-27 01:55:31', '2025-08-27 01:55:31', NULL, 'module_meeting_agenda', 2, 'CREATE', 'Added agenda item', '', '{\"title\":\"call with Docstader\"}'),
(252, 1, 1, '2025-08-27 01:55:31', '2025-08-27 01:55:31', NULL, 'module_meeting_agenda', 3, 'CREATE', 'Added agenda item', '', '{\"title\":\"RESTART WITH LAKE\"}'),
(253, 1, 1, '2025-08-27 01:55:31', '2025-08-27 01:55:31', NULL, 'module_meeting_questions', 1, 'CREATE', 'Added question', '', '{\"question\":\"Can you make it to the JTI User Conference?\"}'),
(254, 1, 1, '2025-08-27 01:55:31', '2025-08-27 01:55:31', NULL, 'module_meeting_questions', 2, 'CREATE', 'Added question', '', '{\"question\":\"Do you need a laptop or monitors?\"}'),
(255, 1, 1, '2025-08-27 01:55:31', '2025-08-27 01:55:31', NULL, 'module_meeting_attendees', 1, 'CREATE', 'Added attendee', '', '{\"user_id\":1}'),
(256, 1, 1, '2025-08-27 01:55:31', '2025-08-27 01:55:31', NULL, 'module_meeting_attendees', 2, 'CREATE', 'Added attendee', '', '{\"user_id\":2}'),
(257, 1, 1, '2025-08-27 01:55:31', '2025-08-27 01:55:31', NULL, 'module_meeting_files', 1, 'UPLOAD', 'Uploaded file', '', '{\"file\":\"meeting_3_1756236860_joke-missed.gif\"}'),
(258, 1, 1, '2025-08-27 01:57:02', '2025-08-27 01:57:02', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"\"}'),
(259, 1, 1, '2025-08-27 01:57:02', '2025-08-27 01:57:02', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"\"}'),
(260, 1, 1, '2025-08-27 01:57:02', '2025-08-27 01:57:02', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"\"}'),
(261, 1, 1, '2025-08-27 01:58:33', '2025-08-27 01:58:33', NULL, 'module_meeting', 1, 'UPDATE', 'Updated meeting', '', '{\"title\":\"Dave + Sean\"}'),
(262, 1, 1, '2025-08-27 01:58:33', '2025-08-27 01:58:33', NULL, 'module_meeting_agenda', 4, 'CREATE', 'Added agenda item', '', '{\"title\":\"test\"}'),
(263, 1, 1, '2025-08-27 01:58:33', '2025-08-27 01:58:33', NULL, 'module_meeting_agenda', 5, 'CREATE', 'Added agenda item', '', '{\"title\":\"test 2\"}'),
(264, 1, 1, '2025-08-27 01:58:33', '2025-08-27 01:58:33', NULL, 'module_meeting_agenda', 6, 'CREATE', 'Added agenda item', '', '{\"title\":\"test 3\"}'),
(265, 1, 1, '2025-08-27 01:58:33', '2025-08-27 01:58:33', NULL, 'module_meeting_questions', 3, 'CREATE', 'Added question', '', '{\"question\":\"Can you make it to the JTI User Conference?\"}'),
(266, 1, 1, '2025-08-27 01:58:33', '2025-08-27 01:58:33', NULL, 'module_meeting_questions', 4, 'CREATE', 'Added question', '', '{\"question\":\"Do you need a laptop or monitors?\"}'),
(267, 1, 1, '2025-08-27 01:58:33', '2025-08-27 01:58:33', NULL, 'module_meeting_attendees', 3, 'CREATE', 'Added attendee', '', '{\"user_id\":1}'),
(268, 1, 1, '2025-08-27 01:58:33', '2025-08-27 01:58:33', NULL, 'module_meeting_attendees', 4, 'CREATE', 'Added attendee', '', '{\"user_id\":2}'),
(269, 1, 1, '2025-08-27 02:07:07', '2025-08-27 02:07:07', NULL, 'module_meeting', 1, 'CREATE', 'Created meeting', '', '{\"title\":\"Dave + Sean\"}'),
(270, 1, 1, '2025-08-27 02:07:44', '2025-08-27 02:07:44', NULL, 'module_meeting', 1, 'UPDATE', 'Updated meeting', '', '{\"title\":\"Dave + Sean\"}'),
(271, 1, 1, '2025-08-27 02:07:44', '2025-08-27 02:07:44', NULL, 'module_meeting_agenda', 1, 'CREATE', 'Added agenda item', '', '{\"title\":\"Test 1\"}'),
(272, 1, 1, '2025-08-27 02:07:44', '2025-08-27 02:07:44', NULL, 'module_meeting_agenda', 2, 'CREATE', 'Added agenda item', '', '{\"title\":\"Test 2\"}'),
(273, 1, 1, '2025-08-27 02:07:44', '2025-08-27 02:07:44', NULL, 'module_meeting_agenda', 3, 'CREATE', 'Added agenda item', '', '{\"title\":\"Test 3\"}'),
(274, 1, 1, '2025-08-27 02:07:44', '2025-08-27 02:07:44', NULL, 'module_meeting_agenda', 4, 'CREATE', 'Added agenda item', '', '{\"title\":\"Test 4\"}'),
(275, 1, 1, '2025-08-27 02:07:44', '2025-08-27 02:07:44', NULL, 'module_meeting_questions', 1, 'CREATE', 'Added question', '', '{\"question\":\"When should we schedule the restart?\"}'),
(276, 1, 1, '2025-08-27 02:07:44', '2025-08-27 02:07:44', NULL, 'module_meeting_questions', 2, 'CREATE', 'Added question', '', '{\"question\":\"Overall question is, are you interested in Contracting with my business, Atlis Technologies, to build this B.I. product\\/service?\"}'),
(277, 1, 1, '2025-08-27 02:07:44', '2025-08-27 02:07:44', NULL, 'module_meeting_attendees', 1, 'CREATE', 'Added attendee', '', '{\"user_id\":1}'),
(278, 1, 1, '2025-08-27 02:07:44', '2025-08-27 02:07:44', NULL, 'module_meeting_attendees', 2, 'CREATE', 'Added attendee', '', '{\"user_id\":2}'),
(279, 1, 1, '2025-08-27 02:07:44', '2025-08-27 02:07:44', NULL, 'module_meeting_files', 1, 'UPLOAD', 'Uploaded file', '', '{\"file\":\"meeting_3_1756236860_joke-missed.gif\"}'),
(280, 1, 1, '2025-08-27 18:30:54', '2025-08-27 18:30:54', NULL, 'module_meeting', 2, 'CREATE', 'Created meeting', '', '{\"title\":\"DEMO MY IDEA FOR NEW BENCH VIEW\"}'),
(281, 1, 1, '2025-08-27 18:31:32', '2025-08-27 18:31:32', NULL, 'module_meeting', 3, 'CREATE', 'Created meeting', '', '{\"title\":\"SPEC, REQ, AND SCOPE DISCOVERY FOR MASS JUDGE REASSIGNMENT\"}'),
(282, 1, 1, '2025-08-27 18:32:05', '2025-08-27 18:32:05', NULL, 'person', 64, 'CREATE', 'Created person', NULL, '{\"user_id\":19,\"first_name\":\"Davey\",\"last_name\":\"Rivers\",\"gender_id\":59,\"organization_id\":null,\"agency_id\":null,\"division_id\":null,\"dob\":null}'),
(283, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 'admin_role_permission_groups', 1, 'SYNC', 'Updated role group assignments', '[1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,17,18,19,20]', '[18,24,26,25,3,13,20,10,19,6,12,17,21,22,11,15,5,2,16,8,4,7,9,23,1]'),
(284, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 'admin_role_permission_groups', 10, 'SYNC', 'Updated role group assignments', '[2,3,5,6,8,9,11,13]', '[3,13,6,11,5,2,8,9]'),
(285, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 'admin_role_permission_groups', 11, 'SYNC', 'Updated role group assignments', '[8,9,11,13]', '[13,11,8,9]'),
(286, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 'admin_role_permission_groups', 12, 'SYNC', 'Updated role group assignments', '[8,9,11,13]', '[13,11,8,9]'),
(287, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 'admin_role_permission_groups', 13, 'SYNC', 'Updated role group assignments', '[10,11]', '[10,11]'),
(288, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 'admin_role_permission_groups', 14, 'SYNC', 'Updated role group assignments', '[10,11]', '[10,11]'),
(289, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 'admin_role_permission_groups', 15, 'SYNC', 'Updated role group assignments', '[16]', '[16]'),
(290, 1, 1, '2025-08-27 21:39:15', '2025-08-27 21:39:15', NULL, 'module_meeting', 1, 'CREATE', 'Created meeting', '', '{\"title\":\"Atlis - Dave + Sean\"}'),
(291, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 'module_meeting', 1, 'UPDATE', 'Updated meeting', '', '{\"title\":\"Atlis - Dave + Sean\"}'),
(292, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 'module_meeting_agenda', 1, 'CREATE', 'Added agenda item', '', '{\"title\":\"test 1\"}'),
(293, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 'module_meeting_agenda', 2, 'CREATE', 'Added agenda item', '', '{\"title\":\"test 2\"}'),
(294, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 'module_meeting_agenda', 3, 'CREATE', 'Added agenda item', '', '{\"title\":\"test 3\"}'),
(295, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 'module_meeting_questions', 1, 'CREATE', 'Added question', '', '{\"question\":\"When should we schedule the restart?\"}'),
(296, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 'module_meeting_questions', 2, 'CREATE', 'Added question', '', '{\"question\":\"JOSEPH, WHERE DO YOU RECOMMEND WE START ?\"}'),
(297, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 'module_meeting_attendees', 1, 'CREATE', 'Added attendee', '', '{\"user_id\":1}'),
(298, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 'module_meeting_attendees', 2, 'CREATE', 'Added attendee', '', '{\"user_id\":2}'),
(299, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 'module_meeting_files', 1, 'UPLOAD', 'Uploaded file', '', '{\"file\":\"meeting_3_1756236860_joke-missed.gif\"}'),
(300, 1, 1, '2025-08-27 21:49:15', '2025-08-27 21:49:15', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(301, 1, 1, '2025-08-27 21:49:15', '2025-08-27 21:49:15', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(302, 1, 1, '2025-08-27 21:49:15', '2025-08-27 21:49:15', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(303, 1, 1, '2025-08-27 21:49:17', '2025-08-27 21:49:17', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(304, 1, 1, '2025-08-27 21:49:17', '2025-08-27 21:49:17', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(305, 1, 1, '2025-08-27 21:49:17', '2025-08-27 21:49:17', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(306, 1, 1, '2025-08-27 21:49:26', '2025-08-27 21:49:26', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(307, 1, 1, '2025-08-27 21:52:16', '2025-08-27 21:52:16', NULL, 'module_projects', 29, 'CREATE', 'Created project from meeting', NULL, '{\"name\":\"test 69\"}'),
(308, 1, 1, '2025-08-27 22:18:32', '2025-08-27 22:18:32', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(309, 1, 1, '2025-08-27 22:18:32', '2025-08-27 22:18:32', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(310, 1, 1, '2025-08-27 22:18:32', '2025-08-27 22:18:32', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(311, 1, 1, '2025-08-27 22:18:33', '2025-08-27 22:18:33', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(312, 1, 1, '2025-08-27 22:18:33', '2025-08-27 22:18:33', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(313, 1, 1, '2025-08-27 22:18:33', '2025-08-27 22:18:33', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(314, 1, 1, '2025-08-27 22:18:37', '2025-08-27 22:18:37', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(315, 1, 1, '2025-08-27 22:18:37', '2025-08-27 22:18:37', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(316, 1, 1, '2025-08-27 22:18:38', '2025-08-27 22:18:38', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(317, 1, 1, '2025-08-27 22:18:40', '2025-08-27 22:18:40', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(318, 1, 1, '2025-08-27 22:18:40', '2025-08-27 22:18:40', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(319, 1, 1, '2025-08-27 22:18:40', '2025-08-27 22:18:40', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(320, 1, 1, '2025-08-27 22:18:43', '2025-08-27 22:18:43', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(321, 1, 1, '2025-08-27 22:18:43', '2025-08-27 22:18:43', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(322, 1, 1, '2025-08-27 22:18:43', '2025-08-27 22:18:43', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(323, 1, 1, '2025-08-27 22:18:50', '2025-08-27 22:18:50', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(324, 1, 1, '2025-08-27 22:18:50', '2025-08-27 22:18:50', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(325, 1, 1, '2025-08-27 22:18:50', '2025-08-27 22:18:50', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(326, 1, 1, '2025-08-27 22:18:57', '2025-08-27 22:18:57', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(327, 1, 1, '2025-08-27 22:18:57', '2025-08-27 22:18:57', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(328, 1, 1, '2025-08-27 22:18:57', '2025-08-27 22:18:57', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(329, 1, 1, '2025-08-27 22:19:04', '2025-08-27 22:19:04', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(330, 1, 1, '2025-08-27 22:19:04', '2025-08-27 22:19:04', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(331, 1, 1, '2025-08-27 22:19:04', '2025-08-27 22:19:04', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(332, 1, 1, '2025-08-27 22:19:09', '2025-08-27 22:19:09', NULL, 'module_meeting_agenda', 2, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 2\"}'),
(333, 1, 1, '2025-08-27 22:19:09', '2025-08-27 22:19:09', NULL, 'module_meeting_agenda', 1, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 1\"}'),
(334, 1, 1, '2025-08-27 22:19:09', '2025-08-27 22:19:09', NULL, 'module_meeting_agenda', 3, 'UPDATE', 'Updated agenda item', '', '{\"title\":\"test 3\"}'),
(335, 1, 1, '2025-08-27 22:19:33', '2025-08-27 22:19:33', NULL, 'module_meeting_files', 1, 'DELETE', 'Deleted file', '{\"file\":\"meeting_3_1756236860_joke-missed.gif\"}', '');

-- --------------------------------------------------------

--
-- Table structure for table `admin_corporate`
--

CREATE TABLE `admin_corporate` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `legal_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `ein` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_corporate_files`
--

CREATE TABLE `admin_corporate_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `corporate_id` int(11) NOT NULL,
  `note_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_corporate_notes`
--

CREATE TABLE `admin_corporate_notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `corporate_id` int(11) NOT NULL,
  `note_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_finances_invoices`
--

CREATE TABLE `admin_finances_invoices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `corporate_id` int(11) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `bill_to` varchar(255) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_finances_invoice_items`
--

CREATE TABLE `admin_finances_invoice_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `invoice_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `time_entry_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_finances_invoice_sow`
--

CREATE TABLE `admin_finances_invoice_sow` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `invoice_id` int(11) NOT NULL,
  `statement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_finances_statements_of_work`
--

CREATE TABLE `admin_finances_statements_of_work` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `corporate_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Dashboard', 'index.php', 'home', 0, 1, 1, '2025-08-20 00:00:00', '2025-08-25 00:43:46', NULL),
(2, 'Users', 'users/index.php', 'user', 3, 1, 1, '2025-08-20 00:00:00', '2025-08-25 00:43:46', NULL),
(3, 'Persons', 'person/index.php', 'users', 5, 1, 1, '2025-08-20 00:00:00', '2025-08-25 00:43:46', NULL),
(4, 'Contractors', 'contractors/index.php', 'briefcase', 4, 1, 1, '2025-08-20 00:00:00', '2025-08-25 00:43:46', NULL),
(5, 'Lookup Lists', 'lookup-lists/index.php', 'list', 1, 1, 1, '2025-08-20 00:00:00', '2025-08-25 00:43:46', NULL),
(6, 'Roles', 'roles/index.php', 'shield', 8, 1, 1, '2025-08-20 00:00:00', '2025-08-25 00:43:46', NULL),
(7, 'System Properties', 'system-properties/index.php', 'sliders', 10, 1, 1, '2025-08-20 00:00:00', '2025-08-25 00:43:08', NULL),
(8, 'Navigation Links', 'navigation.php', 'settings', 11, 1, 1, '2025-08-20 00:37:23', '2025-08-25 00:43:05', NULL),
(9, 'Orgs', 'orgs/index.php', 'layers', 2, 1, 1, '2025-08-21 02:22:27', '2025-08-25 00:43:46', NULL),
(11, 'Meetings', 'meetings/index.php', 'cpu', 7, 1, 1, '2025-08-26 00:00:00', '2025-08-25 00:43:46', NULL),
(12, 'Branding', 'branding/index.php', 'aperture', 6, 1, 1, '2025-08-24 01:53:50', '2025-08-25 00:43:46', NULL),
(13, 'Products & Services', 'products-services/index.php', 'box', 9, 1, 1, '2025-08-27 00:00:00', '2025-08-25 00:43:46', NULL),
(15, 'Finances', 'finances/index.php', 'dollar-sign', 12, 1, 1, '2025-08-25 00:40:13', '2025-08-25 00:43:46', NULL),
(19, 'Tasks', 'tasks/index.php', 'check-square', 13, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL),
(20, 'Corporate', 'corporate/index.php', 'briefcase', 14, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL),
(21, 'Finances › Invoices', 'corporate/finances/invoices/index.php', 'file-text', 15, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:23:00', NULL),
(22, 'Finances › Statements of Work', 'corporate/finances/statements-of-work/index.php', 'file', 16, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:22:52', NULL),
(23, 'Time Tracking', 'corporate/time-tracking/index.php', 'clock', 17, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL),
(24, 'Strategy', 'corporate/strategy/index.php', 'target', 18, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:58:39', NULL);

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
(64, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 'kanban', 'delete'),
(65, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 'feedback', 'create'),
(66, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 'feedback', 'read'),
(67, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 'feedback', 'update'),
(68, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 'feedback', 'delete'),
(69, 1, 1, '2025-08-24 00:00:00', '2025-08-24 00:00:00', NULL, 'calendar', 'create'),
(70, 1, 1, '2025-08-24 00:00:00', '2025-08-24 00:00:00', NULL, 'calendar', 'read'),
(71, 1, 1, '2025-08-24 00:00:00', '2025-08-24 00:00:00', NULL, 'calendar', 'update'),
(72, 1, 1, '2025-08-24 00:00:00', '2025-08-24 00:00:00', NULL, 'calendar', 'delete'),
(77, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'meeting', 'create'),
(78, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'meeting', 'read'),
(79, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'meeting', 'update'),
(80, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'meeting', 'delete'),
(81, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 'products_services', 'create'),
(82, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 'products_services', 'read'),
(83, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 'products_services', 'update'),
(84, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 'products_services', 'delete'),
(85, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'finances', 'create'),
(86, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'finances', 'read'),
(87, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'finances', 'update'),
(88, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'finances', 'delete'),
(89, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'sow', 'create'),
(90, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'sow', 'read'),
(91, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'sow', 'update'),
(92, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'sow', 'delete'),
(93, 1, 1, '2025-08-25 00:19:00', '2025-08-25 00:19:00', NULL, 'calendar', 'sync'),
(100, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task', 'create'),
(101, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task', 'read'),
(102, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task', 'update'),
(103, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task', 'delete'),
(104, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_assignment', 'create'),
(105, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_assignment', 'read'),
(106, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_assignment', 'update'),
(107, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_assignment', 'delete'),
(108, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_file', 'create'),
(109, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_file', 'read'),
(110, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_file', 'update'),
(111, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_file', 'delete'),
(112, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_comment', 'create'),
(113, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_comment', 'read'),
(114, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_comment', 'update'),
(115, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'admin_task_comment', 'delete'),
(116, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'corporate', 'create'),
(117, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'corporate', 'read'),
(118, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'corporate', 'update'),
(119, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'corporate', 'delete'),
(120, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 'conference', 'create'),
(121, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 'conference', 'read'),
(122, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 'conference', 'update'),
(123, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 'conference', 'delete'),
(124, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_finances_invoices', 'create'),
(125, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_finances_invoices', 'read'),
(126, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_finances_invoices', 'update'),
(127, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_finances_invoices', 'delete'),
(128, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_finances_statements_of_work', 'create'),
(129, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_finances_statements_of_work', 'read'),
(130, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_finances_statements_of_work', 'update'),
(131, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_finances_statements_of_work', 'delete'),
(132, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_time_tracking', 'create'),
(133, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_time_tracking', 'read'),
(134, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_time_tracking', 'update'),
(135, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'admin_time_tracking', 'delete'),
(136, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy', 'create'),
(137, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy', 'read'),
(138, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy', 'update'),
(139, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy', 'delete'),
(140, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_tag', 'create'),
(141, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_tag', 'read'),
(142, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_tag', 'update'),
(143, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_tag', 'delete'),
(144, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_collaborator', 'create'),
(145, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_collaborator', 'read'),
(146, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_collaborator', 'update'),
(147, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_collaborator', 'delete'),
(148, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_objective', 'create'),
(149, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_objective', 'read'),
(150, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_objective', 'update'),
(151, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_objective', 'delete'),
(152, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_key_result', 'create'),
(153, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_key_result', 'read'),
(154, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_key_result', 'update'),
(155, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_key_result', 'delete'),
(156, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_note', 'create'),
(157, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_note', 'read'),
(158, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_note', 'update'),
(159, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_note', 'delete'),
(160, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_file', 'create'),
(161, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_file', 'read'),
(162, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_file', 'update'),
(163, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'strategy_file', 'delete');

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
(11, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 'Kanban Boards', 'Permissions for managing kanban boards'),
(12, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 'Feedback', 'Permissions for managing feedback'),
(13, 1, 1, '2025-08-24 00:00:00', '2025-08-24 00:00:00', NULL, 'Calendar', 'Permissions for managing calendar'),
(15, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'Meetings', 'Permissions for managing meetings'),
(16, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 'Products & Services', 'Permissions for managing products and services'),
(17, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'Finances', 'Permissions for finance module'),
(18, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 'Admin Tasks', 'Permissions for managing administrative tasks'),
(19, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 'Corporate', 'Permissions for managing corporate records'),
(20, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 'Conferences', 'Permissions for managing conferences'),
(21, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'Finances Invoices', 'Permissions for managing invoices'),
(22, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'Finances Statements of Work', 'Permissions for managing statements of work'),
(23, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'Time Tracking', 'Permissions for managing time tracking'),
(24, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'admin_strategy', 'Permissions for managing strategies'),
(25, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'admin_strategy_notes', 'Permissions for managing strategy notes'),
(26, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 'admin_strategy_files', 'Permissions for managing strategy files');

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
(64, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 11, 64),
(65, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 12, 65),
(66, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 12, 66),
(67, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 12, 67),
(68, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 12, 68),
(69, 1, 1, '2025-08-24 00:00:00', '2025-08-24 00:00:00', NULL, 13, 69),
(70, 1, 1, '2025-08-24 00:00:00', '2025-08-24 00:00:00', NULL, 13, 70),
(71, 1, 1, '2025-08-24 00:00:00', '2025-08-24 00:00:00', NULL, 13, 71),
(72, 1, 1, '2025-08-24 00:00:00', '2025-08-24 00:00:00', NULL, 13, 72),
(77, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 15, 77),
(78, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 15, 78),
(79, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 15, 79),
(80, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 15, 80),
(81, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 16, 81),
(82, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 16, 82),
(83, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 16, 83),
(84, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 16, 84),
(85, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 17, 85),
(86, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 17, 88),
(87, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 17, 86),
(88, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 17, 87),
(89, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 17, 89),
(90, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 17, 92),
(91, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 17, 90),
(92, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 17, 91),
(100, 1, 1, '2025-08-25 00:19:00', '2025-08-25 00:19:00', NULL, 13, 93),
(103, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 100),
(104, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 103),
(105, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 101),
(106, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 102),
(107, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 104),
(108, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 107),
(109, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 105),
(110, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 106),
(111, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 112),
(112, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 115),
(113, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 113),
(114, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 114),
(115, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 108),
(116, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 111),
(117, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 109),
(118, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 18, 110),
(119, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 19, 116),
(120, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 19, 117),
(121, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 19, 118),
(122, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 19, 119),
(123, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 20, 120),
(124, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 20, 121),
(125, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 20, 122),
(126, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 20, 123),
(127, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 21, 124),
(128, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 21, 125),
(129, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 21, 126),
(130, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 21, 127),
(131, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 22, 128),
(132, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 22, 129),
(133, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 22, 130),
(134, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 22, 131),
(135, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 23, 132),
(136, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 23, 133),
(137, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 23, 134),
(138, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 23, 135),
(139, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 136),
(140, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 137),
(141, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 138),
(142, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 139),
(143, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 140),
(144, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 141),
(145, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 142),
(146, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 143),
(147, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 144),
(148, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 145),
(149, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 146),
(150, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 147),
(151, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 148),
(152, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 149),
(153, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 150),
(154, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 151),
(155, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 152),
(156, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 153),
(157, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 154),
(158, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 24, 155),
(159, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 25, 156),
(160, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 25, 157),
(161, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 25, 158),
(162, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 25, 159),
(163, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 26, 160),
(164, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 26, 161),
(165, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 26, 162),
(166, 1, 1, '2025-08-27 21:13:28', '2025-08-27 21:13:28', NULL, 26, 163);

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
(14, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'Contractor Manager', ''),
(15, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 'Products & Services Manager', '');

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
(37, 1, 1, '2025-08-19 00:00:00', '2025-08-19 00:00:00', NULL, 14, 11),
(38, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 1, 12),
(39, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 10, 12),
(40, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 11, 12),
(41, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 12, 12),
(42, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 13, 12),
(43, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 14, 12),
(44, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 1, 16),
(45, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 15, 16),
(46, 1, 1, '2025-08-25 22:43:05', '2025-08-25 22:43:05', NULL, 1, 18),
(47, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 1, 20);

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
(111, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 18),
(112, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 24),
(113, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 26),
(114, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 25),
(115, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 3),
(116, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 13),
(117, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 20),
(118, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 10),
(119, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 19),
(120, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 6),
(121, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 12),
(122, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 17),
(123, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 21),
(124, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 22),
(125, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 11),
(126, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 15),
(127, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 5),
(128, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 2),
(129, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 16),
(130, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 8),
(131, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 4),
(132, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 7),
(133, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 9),
(134, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 23),
(135, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 1, 1),
(136, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 10, 3),
(137, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 10, 13),
(138, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 10, 6),
(139, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 10, 11),
(140, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 10, 5),
(141, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 10, 2),
(142, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 10, 8),
(143, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 10, 9),
(144, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 11, 13),
(145, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 11, 11),
(146, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 11, 8),
(147, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 11, 9),
(148, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 12, 13),
(149, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 12, 11),
(150, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 12, 8),
(151, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 12, 9),
(152, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 13, 10),
(153, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 13, 11),
(154, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 14, 10),
(155, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 14, 11),
(156, 1, 1, '2025-08-27 21:23:09', '2025-08-27 21:23:09', NULL, 15, 16);

-- --------------------------------------------------------

--
-- Table structure for table `admin_task`
--

CREATE TABLE `admin_task` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  `completed_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_task`
--

INSERT INTO `admin_task` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `description`, `type_id`, `category_id`, `sub_category_id`, `status_id`, `priority_id`, `start_date`, `due_date`, `is_completed`, `completed_date`) VALUES
(1, 1, 1, '2025-08-25 22:45:25', '2025-08-25 22:45:25', NULL, 'Test #1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(2, 1, 1, '2025-08-25 23:05:22', '2025-08-25 23:05:22', NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(3, 1, 1, '2025-08-25 23:05:25', '2025-08-25 23:05:25', NULL, 'test 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(4, 1, 1, '2025-08-26 00:26:11', '2025-08-26 00:31:30', '', 'test test test', '', 264, 267, 269, 277, 273, '2025-08-25 00:00:00', '2025-08-25 00:00:00', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_task_assignments`
--

CREATE TABLE `admin_task_assignments` (
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
-- Dumping data for table `admin_task_assignments`
--

INSERT INTO `admin_task_assignments` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `task_id`, `assigned_user_id`) VALUES
(1, 1, 1, '2025-08-25 22:45:25', '2025-08-25 22:45:25', NULL, 1, 1),
(2, 1, 1, '2025-08-25 23:05:22', '2025-08-25 23:05:22', NULL, 2, 1),
(3, 1, 1, '2025-08-25 23:05:25', '2025-08-25 23:05:25', NULL, 3, 1),
(5, 1, 1, '2025-08-26 00:31:30', '2025-08-26 00:31:30', NULL, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_task_comments`
--

CREATE TABLE `admin_task_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `comment_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_task_files`
--

CREATE TABLE `admin_task_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_task_relations`
--

CREATE TABLE `admin_task_relations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `related_module` varchar(255) NOT NULL,
  `related_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_time_tracking_entries`
--

CREATE TABLE `admin_time_tracking_entries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `corporate_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `work_date` date NOT NULL,
  `hours` decimal(10,2) NOT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(18, 1, 1, '2025-08-15 00:11:51', '2025-08-15 00:11:51', NULL, 2, 9),
(19, 1, 1, '2025-08-25 02:20:36', '2025-08-25 02:20:36', NULL, 8, 12),
(20, 1, 1, '2025-08-26 00:22:46', '2025-08-26 00:22:46', NULL, 4, 10);

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
(1, 1, 1, '2025-08-23 01:43:48', '2025-08-23 01:43:48', NULL, 'module_projects', 4, 'UPDATE', 'Updated project'),
(2, 1, 1, '2025-08-23 01:47:50', '2025-08-23 01:47:50', NULL, 'module_projects', 15, 'UPDATE', 'Updated project'),
(3, 1, 1, '2025-08-23 01:47:59', '2025-08-23 01:47:59', NULL, 'module_projects', 12, 'UPDATE', 'Updated project'),
(4, 1, 1, '2025-08-23 01:48:19', '2025-08-23 01:48:19', NULL, 'module_projects', 10, 'UPDATE', 'Updated project'),
(5, 1, 1, '2025-08-23 01:48:43', '2025-08-23 01:48:43', NULL, 'module_projects_assignments', 21, 'ASSIGN', 'Assigned user'),
(6, 1, 1, '2025-08-23 01:48:51', '2025-08-23 01:48:51', NULL, 'module_projects_assignments', 22, 'ASSIGN', 'Assigned user'),
(7, 1, 1, '2025-08-23 01:48:55', '2025-08-23 01:48:55', NULL, 'module_projects', 14, 'UPDATE', 'Updated project'),
(8, 1, 1, '2025-08-23 01:50:27', '2025-08-23 01:50:27', NULL, 'module_tasks', 39, 'UPDATE', 'Completed task'),
(9, 1, 1, '2025-08-23 01:50:41', '2025-08-23 01:50:41', NULL, 'module_tasks', 60, 'UPDATE', 'Completed task'),
(10, 1, 1, '2025-08-23 01:50:46', '2025-08-23 01:50:46', NULL, 'module_tasks', 61, 'UPDATE', 'Completed task'),
(11, 1, 1, '2025-08-23 01:50:51', '2025-08-23 01:50:51', NULL, 'module_tasks', 54, 'UPDATE', 'Marked task incomplete'),
(12, 1, 1, '2025-08-23 01:50:51', '2025-08-23 01:50:51', NULL, 'module_tasks', 54, 'UPDATE', 'Completed task'),
(13, 1, 1, '2025-08-23 01:50:53', '2025-08-23 01:50:53', NULL, 'module_tasks', 51, 'UPDATE', 'Marked task incomplete'),
(14, 1, 1, '2025-08-23 01:50:53', '2025-08-23 01:50:53', NULL, 'module_tasks', 51, 'UPDATE', 'Completed task'),
(15, 1, 1, '2025-08-23 02:30:30', '2025-08-23 02:30:30', NULL, 'module_tasks', 40, 'UPDATE', 'Completed task'),
(16, 1, 1, '2025-08-23 02:30:45', '2025-08-23 02:30:45', NULL, 'module_task_assignments', 6, 'ASSIGN', 'Assigned user'),
(17, 1, 1, '2025-08-23 02:59:48', '2025-08-23 02:59:48', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(18, 1, 1, '2025-08-23 03:00:50', '2025-08-23 03:00:50', NULL, 'module_tasks', 65, 'CREATE', 'Created task'),
(19, 1, 1, '2025-08-23 03:01:24', '2025-08-23 03:01:24', NULL, 'module_tasks', 66, 'CREATE', 'Created task'),
(20, 1, 1, '2025-08-23 03:01:52', '2025-08-23 03:01:52', NULL, 'module_tasks', 67, 'CREATE', 'Created task'),
(21, 1, 1, '2025-08-23 11:07:04', '2025-08-23 11:07:04', NULL, 'lookup_lists', 37, 'CREATE', 'Created lookup list'),
(22, 1, 1, '2025-08-23 11:07:08', '2025-08-23 11:07:08', NULL, 'lookup_lists', 38, 'CREATE', 'Created lookup list'),
(23, 1, 1, '2025-08-23 11:07:49', '2025-08-23 11:07:49', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(24, 1, 1, '2025-08-23 11:07:56', '2025-08-23 11:07:56', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(25, 1, 1, '2025-08-23 11:08:03', '2025-08-23 11:08:03', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(26, 1, 1, '2025-08-23 11:08:08', '2025-08-23 11:08:08', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(27, 1, 1, '2025-08-23 11:08:17', '2025-08-23 11:08:17', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(28, 1, 1, '2025-08-23 11:08:33', '2025-08-23 11:08:33', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(29, 1, 1, '2025-08-23 11:08:38', '2025-08-23 11:08:38', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(30, 1, 1, '2025-08-23 11:08:59', '2025-08-23 11:08:59', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(31, 1, 1, '2025-08-23 11:09:03', '2025-08-23 11:09:03', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(32, 1, 1, '2025-08-23 11:09:18', '2025-08-23 11:09:18', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(33, 1, 1, '2025-08-23 11:09:31', '2025-08-23 11:09:31', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(34, 1, 1, '2025-08-23 11:09:35', '2025-08-23 11:09:35', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(35, 1, 1, '2025-08-23 11:09:41', '2025-08-23 11:09:41', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(36, 1, 1, '2025-08-23 11:09:45', '2025-08-23 11:09:45', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(37, 1, 1, '2025-08-23 11:09:54', '2025-08-23 11:09:54', NULL, 'lookup_list_item_attributes', 129, 'UPDATE', 'Updated item attribute'),
(38, 1, 1, '2025-08-23 11:10:01', '2025-08-23 11:10:01', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(39, 1, 1, '2025-08-23 12:00:50', '2025-08-23 12:00:50', NULL, 'module_tasks', 68, 'CREATE', 'Created task'),
(40, 1, 1, '2025-08-23 12:01:00', '2025-08-23 12:01:00', NULL, 'module_tasks', 69, 'CREATE', 'Created task'),
(41, 1, 1, '2025-08-23 12:01:15', '2025-08-23 12:01:15', NULL, 'module_tasks', 70, 'CREATE', 'Created task'),
(42, 1, 1, '2025-08-23 12:03:54', '2025-08-23 12:03:54', NULL, 'module_projects_assignments', 23, 'ASSIGN', 'Assigned user'),
(43, 1, 1, '2025-08-23 12:03:58', '2025-08-23 12:03:58', NULL, 'module_task_assignments', 7, 'ASSIGN', 'Assigned user'),
(44, 1, 1, '2025-08-23 12:08:29', '2025-08-23 12:08:29', NULL, 'module_task_assignments', 8, 'ASSIGN', 'Assigned user'),
(45, 1, 1, '2025-08-23 12:08:32', '2025-08-23 12:08:32', NULL, 'module_task_assignments', 9, 'ASSIGN', 'Assigned user'),
(46, 1, 1, '2025-08-23 12:08:49', '2025-08-23 12:08:49', NULL, 'module_projects_assignments', 24, 'ASSIGN', 'Assigned user'),
(47, 1, 1, '2025-08-23 12:08:58', '2025-08-23 12:08:58', NULL, 'module_task_assignments', 10, 'ASSIGN', 'Assigned user'),
(48, 1, 1, '2025-08-23 12:09:06', '2025-08-23 12:09:06', NULL, 'module_task_assignments', 11, 'ASSIGN', 'Assigned user'),
(49, 1, 1, '2025-08-23 12:09:08', '2025-08-23 12:09:08', NULL, 'module_task_assignments', 12, 'ASSIGN', 'Assigned user'),
(50, 1, 1, '2025-08-23 12:09:10', '2025-08-23 12:09:10', NULL, 'module_task_assignments', 13, 'ASSIGN', 'Assigned user'),
(51, 1, 1, '2025-08-23 12:09:13', '2025-08-23 12:09:13', NULL, 'module_task_assignments', 14, 'ASSIGN', 'Assigned user'),
(52, 1, 1, '2025-08-23 12:09:26', '2025-08-23 12:09:26', NULL, 'module_task_assignments', 15, 'ASSIGN', 'Assigned user'),
(53, 1, 1, '2025-08-23 12:09:28', '2025-08-23 12:09:28', NULL, 'module_task_assignments', 16, 'ASSIGN', 'Assigned user'),
(54, 1, 1, '2025-08-23 12:09:30', '2025-08-23 12:09:30', NULL, 'module_task_assignments', 17, 'ASSIGN', 'Assigned user'),
(55, 1, 1, '2025-08-23 15:46:16', '2025-08-23 15:46:16', NULL, 'module_tasks', 71, 'CREATE', 'Created task'),
(56, 1, 1, '2025-08-23 15:58:35', '2025-08-23 15:58:35', NULL, 'lookup_lists', 39, 'CREATE', 'Created lookup list'),
(57, 1, 1, '2025-08-23 15:58:41', '2025-08-23 15:58:41', NULL, 'lookup_lists', 40, 'CREATE', 'Created lookup list'),
(58, 1, 1, '2025-08-23 15:58:44', '2025-08-23 15:58:44', NULL, 'lookup_lists', 41, 'CREATE', 'Created lookup list'),
(59, 1, 1, '2025-08-23 15:59:09', '2025-08-23 15:59:09', NULL, 'lookup_lists', 41, 'UPDATE', 'Updated lookup list'),
(60, 1, 1, '2025-08-23 15:59:23', '2025-08-23 15:59:23', NULL, 'lookup_lists', 40, 'UPDATE', 'Updated lookup list'),
(61, 1, 1, '2025-08-23 15:59:37', '2025-08-23 15:59:37', NULL, 'lookup_lists', 39, 'UPDATE', 'Updated lookup list'),
(62, 1, 1, '2025-08-23 16:05:47', '2025-08-23 16:05:47', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(63, 1, 1, '2025-08-23 16:05:54', '2025-08-23 16:05:54', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(64, 1, 1, '2025-08-23 16:06:03', '2025-08-23 16:06:03', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(65, 1, 1, '2025-08-23 16:06:10', '2025-08-23 16:06:10', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(66, 1, 1, '2025-08-23 16:06:27', '2025-08-23 16:06:27', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(67, 1, 1, '2025-08-23 16:06:41', '2025-08-23 16:06:41', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(68, 1, 1, '2025-08-23 16:06:49', '2025-08-23 16:06:49', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(69, 1, 1, '2025-08-23 16:06:56', '2025-08-23 16:06:56', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(70, 1, 1, '2025-08-23 16:07:10', '2025-08-23 16:07:10', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(71, 1, 1, '2025-08-23 16:07:18', '2025-08-23 16:07:18', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(72, 1, 1, '2025-08-23 16:07:26', '2025-08-23 16:07:26', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(73, 1, 1, '2025-08-23 16:07:59', '2025-08-23 16:07:59', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(74, 1, 1, '2025-08-23 16:08:06', '2025-08-23 16:08:06', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(75, 1, 1, '2025-08-23 16:08:11', '2025-08-23 16:08:11', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(76, 1, 1, '2025-08-23 16:08:23', '2025-08-23 16:08:23', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(77, 1, 1, '2025-08-23 16:08:27', '2025-08-23 16:08:27', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(78, 1, 1, '2025-08-23 16:08:37', '2025-08-23 16:08:37', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(79, 1, 1, '2025-08-23 16:08:44', '2025-08-23 16:08:44', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(80, 1, 1, '2025-08-23 16:08:51', '2025-08-23 16:08:51', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(81, 1, 1, '2025-08-23 16:19:03', '2025-08-23 16:19:03', NULL, 'lookup_list_item_relations', 208, 'CREATE', 'Created relation'),
(82, 1, 1, '2025-08-23 16:25:45', '2025-08-23 16:25:45', NULL, 'module_meeting', 0, 'CREATE', 'Created meeting'),
(83, 1, 1, '2025-08-23 16:48:49', '2025-08-23 16:48:49', NULL, 'module_meeting', 1, 'CREATE', 'Created meeting'),
(84, 1, 1, '2025-08-23 16:49:54', '2025-08-23 16:49:54', NULL, 'module_meeting', 2, 'CREATE', 'Created meeting'),
(85, 1, 1, '2025-08-23 17:10:00', '2025-08-23 17:10:00', NULL, 'module_meeting', 3, 'CREATE', 'Created meeting'),
(86, 1, 1, '2025-08-23 17:53:50', '2025-08-23 17:53:50', NULL, 'module_tasks', 72, 'CREATE', 'Created task'),
(87, 1, 1, '2025-08-23 17:53:53', '2025-08-23 17:53:53', NULL, 'module_projects_assignments', 25, 'ASSIGN', 'Assigned user'),
(88, 1, 1, '2025-08-23 17:53:56', '2025-08-23 17:53:56', NULL, 'module_projects', 21, 'UPDATE', 'Updated project'),
(89, 1, 1, '2025-08-23 19:17:29', '2025-08-23 19:17:29', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(90, 1, 1, '2025-08-23 19:17:32', '2025-08-23 19:17:32', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(91, 1, 1, '2025-08-23 19:17:37', '2025-08-23 19:17:37', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(92, 1, 1, '2025-08-23 19:17:41', '2025-08-23 19:17:41', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(93, 1, 1, '2025-08-23 19:17:59', '2025-08-23 19:17:59', NULL, 'system_properties', 5, 'UPDATE', 'Updated system property'),
(94, 16, 16, '2025-08-23 19:18:07', '2025-08-23 19:18:07', NULL, 'users', 16, 'LOGIN', 'User logged in'),
(95, 16, 16, '2025-08-23 19:18:08', '2025-08-23 19:18:08', NULL, 'users', 16, 'LOGOUT', 'User logged out'),
(96, 1, 1, '2025-08-23 19:19:40', '2025-08-23 19:19:40', NULL, 'users', 1, 'LOGOUT', 'User logged out'),
(97, 1, 1, '2025-08-23 19:19:46', '2025-08-23 19:19:46', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(98, 1, 1, '2025-08-23 19:21:48', '2025-08-23 19:21:48', NULL, 'system_properties', 5, 'UPDATE', 'Updated system property'),
(99, 4, 4, '2025-08-23 19:24:20', '2025-08-23 19:24:20', NULL, 'users', 4, 'LOGIN', 'User logged in'),
(100, 1, 1, '2025-08-23 20:16:33', '2025-08-23 20:16:33', NULL, 'lookup_list_items', 123, 'UPDATE', 'Updated lookup list item'),
(101, 1, 1, '2025-08-23 20:16:54', '2025-08-23 20:16:54', NULL, 'lookup_list_items', 124, 'UPDATE', 'Updated lookup list item'),
(102, 1, 1, '2025-08-23 20:17:18', '2025-08-23 20:17:18', NULL, 'lookup_list_items', 125, 'UPDATE', 'Updated lookup list item'),
(103, 1, 1, '2025-08-23 20:17:36', '2025-08-23 20:17:36', NULL, 'lookup_list_items', 126, 'UPDATE', 'Updated lookup list item'),
(104, 1, 1, '2025-08-23 20:17:42', '2025-08-23 20:17:42', NULL, 'lookup_list_items', 125, 'UPDATE', 'Updated lookup list item'),
(105, 1, 1, '2025-08-23 20:17:56', '2025-08-23 20:17:56', NULL, 'lookup_list_items', 123, 'UPDATE', 'Updated lookup list item'),
(106, 1, 1, '2025-08-23 20:25:52', '2025-08-23 20:25:52', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(107, 1, 1, '2025-08-23 20:26:00', '2025-08-23 20:26:00', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(108, 1, 1, '2025-08-23 20:26:14', '2025-08-23 20:26:14', NULL, 'module_projects', 4, 'UPDATE', 'Updated project'),
(109, 1, 1, '2025-08-23 20:55:32', '2025-08-23 20:55:32', NULL, 'module_tasks', 73, 'CREATE', 'Created task'),
(110, 1, 1, '2025-08-23 20:55:40', '2025-08-23 20:55:40', NULL, 'module_tasks', 74, 'CREATE', 'Created task'),
(111, 1, 1, '2025-08-23 20:55:50', '2025-08-23 20:55:50', NULL, 'module_tasks', 75, 'CREATE', 'Created task'),
(112, 1, 1, '2025-08-23 21:56:27', '2025-08-23 21:56:27', NULL, 'module_tasks', 73, 'UPDATE', 'Completed task'),
(113, 1, 1, '2025-08-24 00:30:08', '2025-08-24 00:30:08', NULL, 'module_task_assignments', 18, 'ASSIGN', 'Assigned user'),
(114, 1, 1, '2025-08-24 00:30:11', '2025-08-24 00:30:11', NULL, 'module_task_assignments', 19, 'ASSIGN', 'Assigned user'),
(115, 1, 1, '2025-08-24 00:30:15', '2025-08-24 00:30:15', NULL, 'module_task_assignments', 20, 'ASSIGN', 'Assigned user'),
(116, 1, 1, '2025-08-24 00:31:28', '2025-08-24 00:31:28', NULL, 'module_task_assignments', 21, 'ASSIGN', 'Assigned user'),
(117, 1, 1, '2025-08-24 00:31:39', '2025-08-24 00:31:39', NULL, 'module_task_assignments', 22, 'ASSIGN', 'Assigned user'),
(118, 1, 1, '2025-08-24 00:31:42', '2025-08-24 00:31:42', NULL, 'module_task_assignments', 23, 'ASSIGN', 'Assigned user'),
(119, 1, 1, '2025-08-24 01:42:46', '2025-08-24 01:42:46', NULL, 'module_projects_assignments', 26, 'ASSIGN', 'Assigned user'),
(120, 1, 1, '2025-08-24 01:50:12', '2025-08-24 01:50:12', NULL, 'module_tasks', 76, 'CREATE', 'Created task'),
(121, 1, 1, '2025-08-24 01:50:45', '2025-08-24 01:50:45', NULL, 'module_tasks', 77, 'CREATE', 'Created task'),
(122, 1, 1, '2025-08-24 01:50:52', '2025-08-24 01:50:52', NULL, 'module_task_assignments', 24, 'ASSIGN', 'Assigned user'),
(123, 1, 1, '2025-08-24 01:50:52', '2025-08-24 01:50:52', NULL, 'module_task_assignments', 25, 'ASSIGN', 'Assigned user'),
(124, 1, 1, '2025-08-24 01:50:54', '2025-08-24 01:50:54', NULL, 'module_task_assignments', 26, 'ASSIGN', 'Assigned user'),
(125, 1, 1, '2025-08-24 01:50:55', '2025-08-24 01:50:55', NULL, 'module_task_assignments', 27, 'ASSIGN', 'Assigned user'),
(126, 1, 1, '2025-08-24 01:50:56', '2025-08-24 01:50:56', NULL, 'module_task_assignments', 28, 'ASSIGN', 'Assigned user'),
(127, 1, 1, '2025-08-24 01:51:10', '2025-08-24 01:51:10', NULL, 'module_task_assignments', 29, 'ASSIGN', 'Assigned user'),
(128, 1, 1, '2025-08-24 01:51:12', '2025-08-24 01:51:12', NULL, 'module_task_assignments', 30, 'ASSIGN', 'Assigned user'),
(129, 1, 1, '2025-08-24 02:05:43', '2025-08-24 02:05:43', NULL, 'module_tasks', 78, 'CREATE', 'Created task'),
(130, 1, 1, '2025-08-24 02:05:44', '2025-08-24 02:05:44', NULL, 'module_task_assignments', 31, 'ASSIGN', 'Assigned user'),
(131, 1, 1, '2025-08-24 02:16:02', '2025-08-24 02:16:02', NULL, 'module_tasks', 46, 'UPDATE', 'Updated task'),
(132, 1, 1, '2025-08-24 02:54:17', '2025-08-24 02:54:17', NULL, 'module_task_assignments', 32, 'ASSIGN', 'Assigned user'),
(133, 1, 1, '2025-08-24 02:54:17', '2025-08-24 02:54:17', NULL, 'module_task_assignments', 33, 'ASSIGN', 'Assigned user'),
(134, 1, 1, '2025-08-24 02:54:24', '2025-08-24 02:54:24', NULL, 'module_task_assignments', 34, 'ASSIGN', 'Assigned user'),
(135, 1, 1, '2025-08-24 02:54:26', '2025-08-24 02:54:26', NULL, 'module_task_assignments', 35, 'ASSIGN', 'Assigned user'),
(136, 1, 1, '2025-08-24 02:54:27', '2025-08-24 02:54:27', NULL, 'module_task_assignments', 36, 'ASSIGN', 'Assigned user'),
(137, 1, 1, '2025-08-24 02:54:27', '2025-08-24 02:54:27', NULL, 'module_task_assignments', 37, 'ASSIGN', 'Assigned user'),
(138, 1, 1, '2025-08-24 02:54:30', '2025-08-24 02:54:30', NULL, 'module_tasks', 38, 'UPDATE', 'Updated task status'),
(139, 1, 1, '2025-08-24 02:54:33', '2025-08-24 02:54:33', NULL, 'module_tasks', 38, 'UPDATE', 'Updated task priority'),
(140, 1, 1, '2025-08-24 02:54:36', '2025-08-24 02:54:36', NULL, 'module_tasks', 38, 'UPDATE', 'Updated task'),
(141, 1, 1, '2025-08-24 02:54:55', '2025-08-24 02:54:55', NULL, 'module_tasks', 38, 'UPDATE', 'Updated task'),
(142, 1, 1, '2025-08-24 10:05:28', '2025-08-24 10:05:28', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(143, 1, 1, '2025-08-24 10:06:10', '2025-08-24 10:06:10', NULL, 'module_tasks', 79, 'CREATE', 'Created task'),
(144, 1, 1, '2025-08-24 10:06:43', '2025-08-24 10:06:43', NULL, 'module_task_assignments', 38, 'ASSIGN', 'Assigned user'),
(145, 1, 1, '2025-08-24 10:06:44', '2025-08-24 10:06:44', NULL, 'module_task_assignments', 39, 'ASSIGN', 'Assigned user'),
(146, 1, 1, '2025-08-24 10:06:52', '2025-08-24 10:06:52', NULL, 'module_task_assignments', 40, 'ASSIGN', 'Assigned user'),
(147, 1, 1, '2025-08-24 10:07:17', '2025-08-24 10:07:17', NULL, 'module_tasks', 79, 'UPDATE', 'Updated task status'),
(148, 1, 1, '2025-08-24 10:07:20', '2025-08-24 10:07:20', NULL, 'module_tasks', 79, 'UPDATE', 'Updated task priority'),
(149, 1, 1, '2025-08-24 11:31:57', '2025-08-24 11:31:57', NULL, 'module_tasks', 80, 'CREATE', 'Created task'),
(150, 1, 1, '2025-08-24 11:31:58', '2025-08-24 11:31:58', NULL, 'module_task_assignments', 41, 'ASSIGN', 'Assigned user'),
(151, 1, 1, '2025-08-24 11:32:23', '2025-08-24 11:32:23', NULL, 'module_tasks', 81, 'CREATE', 'Created task'),
(152, 1, 1, '2025-08-24 11:32:34', '2025-08-24 11:32:34', NULL, 'module_tasks', 82, 'CREATE', 'Created task'),
(153, 1, 1, '2025-08-24 11:32:40', '2025-08-24 11:32:40', NULL, 'module_tasks', 83, 'CREATE', 'Created task'),
(154, 1, 1, '2025-08-24 11:32:50', '2025-08-24 11:32:50', NULL, 'module_tasks', 84, 'CREATE', 'Created task'),
(155, 1, 1, '2025-08-24 11:33:20', '2025-08-24 11:33:20', NULL, 'module_tasks', 85, 'CREATE', 'Created task'),
(156, 1, 1, '2025-08-24 11:33:39', '2025-08-24 11:33:39', NULL, 'module_tasks', 85, 'UPDATE', 'Updated task status'),
(157, 1, 1, '2025-08-24 11:33:43', '2025-08-24 11:33:43', NULL, 'module_task_assignments', 42, 'ASSIGN', 'Assigned user'),
(158, 1, 1, '2025-08-24 11:33:44', '2025-08-24 11:33:44', NULL, 'module_task_assignments', 43, 'ASSIGN', 'Assigned user'),
(159, 1, 1, '2025-08-24 11:33:45', '2025-08-24 11:33:45', NULL, 'module_task_assignments', 44, 'ASSIGN', 'Assigned user'),
(160, 1, 1, '2025-08-24 11:33:54', '2025-08-24 11:33:54', NULL, 'module_task_assignments', 45, 'ASSIGN', 'Assigned user'),
(161, 1, 1, '2025-08-24 14:34:13', '2025-08-24 14:34:13', NULL, 'users', 1, 'LOGOUT', 'User logged out'),
(162, 1, 1, '2025-08-24 14:34:37', '2025-08-24 14:34:37', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(163, 1, 1, '2025-08-24 15:44:08', '2025-08-24 15:44:08', NULL, 'module_projects', 18, 'UPDATE', 'Updated status to 29'),
(164, 1, 1, '2025-08-24 16:57:23', '2025-08-24 16:57:23', NULL, 'module_tasks', 86, 'CREATE', 'Created task'),
(165, 1, 1, '2025-08-24 17:31:27', '2025-08-24 17:31:27', NULL, 'module_tasks', 87, 'CREATE', 'Created task'),
(166, 1, 1, '2025-08-24 17:31:29', '2025-08-24 17:31:29', NULL, 'module_task_assignments', 46, 'ASSIGN', 'Assigned user'),
(167, 1, 1, '2025-08-24 19:01:04', '2025-08-24 19:01:04', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(168, 1, 1, '2025-08-24 19:02:33', '2025-08-24 19:02:33', NULL, 'lookup_list_items', 232, 'DELETE', 'Deleted lookup list item'),
(169, 1, 1, '2025-08-24 19:03:24', '2025-08-24 19:03:24', NULL, 'lookup_lists', 47, 'CREATE', 'Created lookup list'),
(170, 1, 1, '2025-08-24 19:03:28', '2025-08-24 19:03:28', NULL, 'lookup_lists', 48, 'CREATE', 'Created lookup list'),
(171, 1, 1, '2025-08-24 19:03:43', '2025-08-24 19:03:43', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(172, 1, 1, '2025-08-24 19:03:49', '2025-08-24 19:03:49', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(173, 1, 1, '2025-08-24 19:03:53', '2025-08-24 19:03:53', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(174, 1, 1, '2025-08-24 19:03:57', '2025-08-24 19:03:57', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(175, 1, 1, '2025-08-24 19:04:07', '2025-08-24 19:04:07', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(176, 1, 1, '2025-08-24 19:04:12', '2025-08-24 19:04:12', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(177, 1, 1, '2025-08-24 19:04:16', '2025-08-24 19:04:16', NULL, 'lookup_list_item_attributes', 0, 'CREATE', 'Created item attribute'),
(178, 1, 1, '2025-08-24 20:41:20', '2025-08-24 20:41:20', NULL, 'module_tasks', 46, 'UPDATE', 'Completed task'),
(179, 1, 1, '2025-08-24 21:29:04', '2025-08-24 21:29:04', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(180, 1, 1, '2025-08-24 21:29:33', '2025-08-24 21:29:33', NULL, 'module_projects_assignments', 27, 'ASSIGN', 'Assigned user'),
(181, 1, 1, '2025-08-24 21:46:06', '2025-08-24 21:46:06', NULL, 'module_tasks', 88, 'CREATE', 'Created task'),
(182, 1, 1, '2025-08-24 21:46:08', '2025-08-24 21:46:08', NULL, 'module_task_assignments', 47, 'ASSIGN', 'Assigned user'),
(183, 1, 1, '2025-08-24 21:46:28', '2025-08-24 21:46:28', NULL, 'module_tasks', 88, 'UPDATE', 'Updated task status'),
(184, 1, 1, '2025-08-24 21:46:31', '2025-08-24 21:46:31', NULL, 'module_tasks', 88, 'UPDATE', 'Updated task status'),
(185, 1, 1, '2025-08-24 21:46:32', '2025-08-24 21:46:32', NULL, 'module_tasks', 88, 'UPDATE', 'Updated task priority'),
(186, 1, 1, '2025-08-24 21:46:33', '2025-08-24 21:46:33', NULL, 'module_tasks', 88, 'UPDATE', 'Updated task'),
(187, 1, 1, '2025-08-24 23:40:28', '2025-08-24 23:40:28', NULL, 'module_tasks', 89, 'CREATE', 'Created task'),
(188, 1, 1, '2025-08-24 23:40:30', '2025-08-24 23:40:30', NULL, 'module_task_assignments', 48, 'ASSIGN', 'Assigned user'),
(189, 1, 1, '2025-08-24 23:40:32', '2025-08-24 23:40:32', NULL, 'module_tasks', 89, 'UPDATE', 'Updated task status'),
(190, 1, 1, '2025-08-24 23:40:33', '2025-08-24 23:40:33', NULL, 'module_tasks', 89, 'UPDATE', 'Updated task priority'),
(191, 1, 1, '2025-08-25 00:35:20', '2025-08-25 00:35:20', NULL, 'lookup_list_items', 0, 'CREATE', 'Created lookup list item'),
(192, 1, 1, '2025-08-25 01:29:19', '2025-08-25 01:29:19', NULL, 'lookup_lists', 43, 'UPDATE', 'Updated lookup list'),
(193, 1, 1, '2025-08-25 01:29:28', '2025-08-25 01:29:28', NULL, 'lookup_lists', 54, 'CREATE', 'Created lookup list'),
(194, 1, 1, '2025-08-25 01:45:19', '2025-08-25 01:45:19', NULL, 'lookup_lists', 55, 'CREATE', 'Created lookup list'),
(195, 1, 1, '2025-08-25 01:48:50', '2025-08-25 01:48:50', NULL, 'module_tasks', 41, 'UPDATE', 'Completed task'),
(196, 1, 1, '2025-08-25 01:48:50', '2025-08-25 01:48:50', NULL, 'module_tasks', 41, 'UPDATE', 'Completed task'),
(197, 1, 1, '2025-08-25 01:48:53', '2025-08-25 01:48:53', NULL, 'module_tasks', 42, 'UPDATE', 'Completed task'),
(198, 1, 1, '2025-08-25 01:48:55', '2025-08-25 01:48:55', NULL, 'module_tasks', 43, 'UPDATE', 'Completed task'),
(199, 1, 1, '2025-08-25 01:48:56', '2025-08-25 01:48:56', NULL, 'module_task_assignments', 49, 'ASSIGN', 'Assigned user'),
(200, 1, 1, '2025-08-25 01:49:19', '2025-08-25 01:49:19', NULL, 'module_projects', 14, 'UPDATE', 'Updated status to 31'),
(201, 1, 1, '2025-08-25 01:49:48', '2025-08-25 01:49:48', NULL, 'module_tasks', 40, 'UPDATE', 'Marked task incomplete'),
(202, 1, 1, '2025-08-25 01:49:53', '2025-08-25 01:49:53', NULL, 'module_tasks', 40, 'UPDATE', 'Completed task'),
(203, 1, 1, '2025-08-25 01:50:29', '2025-08-25 01:50:29', NULL, 'module_tasks', 40, 'UPDATE', 'Marked task incomplete'),
(204, 1, 1, '2025-08-25 01:50:34', '2025-08-25 01:50:34', NULL, 'module_tasks', 40, 'UPDATE', 'Completed task'),
(205, 1, 1, '2025-08-25 01:51:24', '2025-08-25 01:51:24', NULL, 'module_tasks', 40, 'UPDATE', 'Marked task incomplete'),
(206, 1, 1, '2025-08-25 01:51:26', '2025-08-25 01:51:26', NULL, 'module_tasks', 40, 'UPDATE', 'Completed task'),
(207, 1, 1, '2025-08-25 01:51:37', '2025-08-25 01:51:37', NULL, 'module_projects', 15, 'UPDATE', 'Updated status to 29'),
(208, 1, 1, '2025-08-25 01:54:03', '2025-08-25 01:54:03', NULL, 'lookup_list_items', 262, 'CREATE', 'Created lookup list item'),
(209, 1, 1, '2025-08-25 01:54:12', '2025-08-25 01:54:12', NULL, 'lookup_list_items', 263, 'CREATE', 'Created lookup list item'),
(210, 1, 1, '2025-08-25 02:03:46', '2025-08-25 02:03:46', NULL, 'module_tasks', 90, 'CREATE', 'Created task'),
(211, 1, 1, '2025-08-25 02:03:50', '2025-08-25 02:03:50', NULL, 'module_task_assignments', 50, 'ASSIGN', 'Assigned user'),
(212, 1, 1, '2025-08-25 02:04:01', '2025-08-25 02:04:01', NULL, 'module_tasks', 87, 'UPDATE', 'Updated task status'),
(213, 1, 1, '2025-08-25 02:04:09', '2025-08-25 02:04:09', NULL, 'module_tasks', 87, 'UPDATE', 'Completed task'),
(214, 8, 8, '2025-08-25 02:20:03', '2025-08-25 02:20:03', NULL, 'users', 8, 'LOGIN', 'User logged in'),
(215, 1, 1, '2025-08-25 12:57:51', '2025-08-25 12:57:51', NULL, 'lookup_lists', 56, 'CREATE', 'Created lookup list'),
(216, 1, 1, '2025-08-25 12:58:02', '2025-08-25 12:58:02', NULL, 'lookup_lists', 57, 'CREATE', 'Created lookup list'),
(217, 1, 1, '2025-08-25 12:58:09', '2025-08-25 12:58:09', NULL, 'lookup_lists', 58, 'CREATE', 'Created lookup list'),
(218, 1, 1, '2025-08-25 12:59:21', '2025-08-25 12:59:21', NULL, 'lookup_lists', 59, 'CREATE', 'Created lookup list'),
(219, 1, 1, '2025-08-25 13:01:12', '2025-08-25 13:01:12', NULL, 'lookup_lists', 60, 'CREATE', 'Created lookup list'),
(220, 1, 1, '2025-08-25 13:02:26', '2025-08-25 13:02:26', NULL, 'lookup_list_items', 264, 'CREATE', 'Created lookup list item'),
(221, 1, 1, '2025-08-25 13:02:34', '2025-08-25 13:02:34', NULL, 'lookup_list_items', 265, 'CREATE', 'Created lookup list item'),
(222, 1, 1, '2025-08-25 13:03:13', '2025-08-25 13:03:13', NULL, 'lookup_list_items', 266, 'CREATE', 'Created lookup list item'),
(223, 1, 1, '2025-08-25 13:03:32', '2025-08-25 13:03:32', NULL, 'lookup_list_items', 267, 'CREATE', 'Created lookup list item'),
(224, 1, 1, '2025-08-25 13:04:22', '2025-08-25 13:04:22', NULL, 'lookup_list_items', 268, 'CREATE', 'Created lookup list item'),
(225, 1, 1, '2025-08-25 13:04:33', '2025-08-25 13:04:33', NULL, 'lookup_lists', 61, 'CREATE', 'Created lookup list'),
(226, 1, 1, '2025-08-25 13:05:22', '2025-08-25 13:05:22', NULL, 'lookup_list_items', 269, 'CREATE', 'Created lookup list item'),
(227, 1, 1, '2025-08-25 14:02:04', '2025-08-25 14:02:04', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(228, 1, 1, '2025-08-25 18:21:55', '2025-08-25 18:21:55', NULL, 'users', 1, 'LOGIN', 'User logged in'),
(229, 4, 4, '2025-08-26 00:22:13', '2025-08-26 00:22:13', NULL, 'users', 4, 'LOGIN', 'User logged in'),
(230, 4, 4, '2025-08-26 00:22:49', '2025-08-26 00:22:49', NULL, 'users', 4, 'LOGOUT', 'User logged out'),
(231, 4, 4, '2025-08-26 00:22:57', '2025-08-26 00:22:57', NULL, 'users', 4, 'LOGIN', 'User logged in'),
(232, 1, 1, '2025-08-26 00:27:03', '2025-08-26 00:27:03', NULL, 'lookup_list_items', 272, 'CREATE', 'Created lookup list item'),
(233, 1, 1, '2025-08-26 00:28:08', '2025-08-26 00:28:08', NULL, 'lookup_list_items', 273, 'CREATE', 'Created lookup list item'),
(234, 1, 1, '2025-08-26 00:28:21', '2025-08-26 00:28:21', NULL, 'lookup_list_items', 274, 'CREATE', 'Created lookup list item'),
(235, 1, 1, '2025-08-26 00:29:34', '2025-08-26 00:29:34', NULL, 'lookup_list_items', 275, 'CREATE', 'Created lookup list item'),
(236, 1, 1, '2025-08-26 00:30:41', '2025-08-26 00:30:41', NULL, 'lookup_list_items', 276, 'CREATE', 'Created lookup list item'),
(237, 1, 1, '2025-08-26 00:30:51', '2025-08-26 00:30:51', NULL, 'lookup_list_items', 277, 'CREATE', 'Created lookup list item'),
(238, 1, 1, '2025-08-26 00:30:56', '2025-08-26 00:30:56', NULL, 'lookup_list_items', 278, 'CREATE', 'Created lookup list item'),
(239, 1, 1, '2025-08-26 00:31:05', '2025-08-26 00:31:05', NULL, 'lookup_list_items', 278, 'UPDATE', 'Updated lookup list item'),
(240, 1, 1, '2025-08-26 00:37:43', '2025-08-26 00:37:43', NULL, 'lookup_list_items', 279, 'CREATE', 'Created lookup list item'),
(241, 1, 1, '2025-08-26 00:37:59', '2025-08-26 00:37:59', NULL, 'lookup_list_items', 280, 'CREATE', 'Created lookup list item'),
(242, 1, 1, '2025-08-26 22:29:20', '2025-08-26 22:29:20', NULL, 'lookup_list_items', 281, 'CREATE', 'Created lookup list item'),
(243, 1, 1, '2025-08-26 22:29:20', '2025-08-26 22:29:20', NULL, 'lookup_list_items', 282, 'CREATE', 'Created lookup list item'),
(244, 1, 1, '2025-08-27 00:53:12', '2025-08-27 00:53:12', NULL, 'lookup_list_items', 200, 'DELETE', 'Deleted lookup list item'),
(245, 1, 1, '2025-08-27 00:53:17', '2025-08-27 00:53:17', NULL, 'lookup_list_items', 203, 'DELETE', 'Deleted lookup list item'),
(246, 1, 1, '2025-08-27 00:53:24', '2025-08-27 00:53:24', NULL, 'lookup_list_item_attributes', 148, 'CREATE', 'Created item attribute'),
(247, 1, 1, '2025-08-27 00:53:28', '2025-08-27 00:53:28', NULL, 'lookup_list_item_attributes', 149, 'CREATE', 'Created item attribute'),
(248, 1, 1, '2025-08-27 00:53:31', '2025-08-27 00:53:31', NULL, 'lookup_list_item_attributes', 150, 'CREATE', 'Created item attribute'),
(249, 1, 1, '2025-08-27 00:53:36', '2025-08-27 00:53:36', NULL, 'lookup_list_item_attributes', 151, 'CREATE', 'Created item attribute'),
(250, 1, 1, '2025-08-27 00:58:54', '2025-08-27 00:58:54', NULL, 'lookup_list_items', 289, 'CREATE', 'Created lookup list item'),
(251, 1, 1, '2025-08-27 00:59:03', '2025-08-27 00:59:03', NULL, 'lookup_list_items', 290, 'CREATE', 'Created lookup list item'),
(252, 1, 1, '2025-08-27 00:59:19', '2025-08-27 00:59:19', NULL, 'lookup_list_items', 291, 'CREATE', 'Created lookup list item'),
(253, 1, 1, '2025-08-27 00:59:29', '2025-08-27 00:59:29', NULL, 'lookup_list_items', 292, 'CREATE', 'Created lookup list item'),
(254, 1, 1, '2025-08-27 00:59:38', '2025-08-27 00:59:38', NULL, 'lookup_list_item_attributes', 152, 'CREATE', 'Created item attribute'),
(255, 1, 1, '2025-08-27 00:59:46', '2025-08-27 00:59:46', NULL, 'lookup_list_item_attributes', 153, 'CREATE', 'Created item attribute'),
(256, 1, 1, '2025-08-27 00:59:50', '2025-08-27 00:59:50', NULL, 'lookup_list_item_attributes', 154, 'CREATE', 'Created item attribute'),
(257, 1, 1, '2025-08-27 00:59:59', '2025-08-27 00:59:59', NULL, 'lookup_lists', 55, 'DELETE', 'Deleted lookup list'),
(258, 1, 1, '2025-08-27 01:00:11', '2025-08-27 01:00:11', NULL, 'lookup_lists', 54, 'DELETE', 'Deleted lookup list'),
(259, 1, 1, '2025-08-27 19:44:13', '2025-08-27 19:44:13', NULL, 'lookup_list_items', 297, 'CREATE', 'Created lookup list item'),
(260, 1, 1, '2025-08-27 19:44:19', '2025-08-27 19:44:19', NULL, 'lookup_list_item_attributes', 155, 'CREATE', 'Created item attribute'),
(261, 4, 4, '2025-08-27 21:20:51', '2025-08-27 21:20:51', NULL, 'users', 4, 'LOGIN', 'User logged in'),
(262, 1, 1, '2025-08-27 21:40:39', '2025-08-27 21:40:39', NULL, 'system_properties', 9, 'CREATE', 'Created system property'),
(263, 1, 1, '2025-08-27 21:43:02', '2025-08-27 21:43:02', NULL, 'lookup_list_item_attributes', 136, 'UPDATE', 'Updated item attribute'),
(264, 1, 1, '2025-08-27 21:43:19', '2025-08-27 21:43:19', NULL, 'lookup_list_items', 204, 'UPDATE', 'Updated lookup list item'),
(265, 1, 1, '2025-08-27 21:44:03', '2025-08-27 21:44:03', NULL, 'lookup_list_items', 297, 'UPDATE', 'Updated lookup list item'),
(266, 1, 1, '2025-08-27 21:45:33', '2025-08-27 21:45:33', NULL, 'lookup_list_item_attributes', 149, 'DELETE', 'Deleted item attribute'),
(267, 1, 1, '2025-08-27 21:45:35', '2025-08-27 21:45:35', NULL, 'lookup_list_items', 201, 'DELETE', 'Deleted lookup list item'),
(268, 1, 1, '2025-08-27 21:46:26', '2025-08-27 21:46:26', NULL, 'lookup_list_item_attributes', 156, 'CREATE', 'Created item attribute'),
(269, 1, 1, '2025-08-27 21:46:33', '2025-08-27 21:46:33', NULL, 'lookup_list_item_attributes', 157, 'CREATE', 'Created item attribute'),
(270, 1, 1, '2025-08-27 21:46:38', '2025-08-27 21:46:38', NULL, 'lookup_list_item_attributes', 158, 'CREATE', 'Created item attribute'),
(271, 1, 1, '2025-08-27 21:46:45', '2025-08-27 21:46:45', NULL, 'lookup_list_item_attributes', 159, 'CREATE', 'Created item attribute'),
(272, 1, 1, '2025-08-27 21:47:43', '2025-08-27 21:47:43', NULL, 'lookup_list_item_attributes', 160, 'CREATE', 'Created item attribute'),
(273, 1, 1, '2025-08-27 21:47:56', '2025-08-27 21:47:56', NULL, 'lookup_list_items', 230, 'UPDATE', 'Updated lookup list item'),
(274, 1, 1, '2025-08-27 21:48:03', '2025-08-27 21:48:03', NULL, 'lookup_list_item_attributes', 161, 'CREATE', 'Created item attribute'),
(275, 1, 1, '2025-08-27 21:48:11', '2025-08-27 21:48:11', NULL, 'lookup_list_item_attributes', 162, 'CREATE', 'Created item attribute'),
(276, 1, 1, '2025-08-27 21:48:16', '2025-08-27 21:48:16', NULL, 'lookup_list_item_attributes', 163, 'CREATE', 'Created item attribute'),
(277, 1, 1, '2025-08-27 21:48:26', '2025-08-27 21:48:26', NULL, 'lookup_list_items', 230, 'UPDATE', 'Updated lookup list item'),
(278, 1, 1, '2025-08-27 22:44:53', '2025-08-27 22:44:53', NULL, 'lookup_list_item_attributes', 164, 'CREATE', 'Created item attribute'),
(279, 1, 1, '2025-08-27 22:45:03', '2025-08-27 22:45:03', NULL, 'lookup_list_item_attributes', 165, 'CREATE', 'Created item attribute'),
(280, 1, 1, '2025-08-27 22:45:13', '2025-08-27 22:45:13', NULL, 'lookup_list_item_attributes', 166, 'CREATE', 'Created item attribute'),
(281, 1, 1, '2025-08-27 22:45:17', '2025-08-27 22:45:17', NULL, 'lookup_list_item_attributes', 167, 'CREATE', 'Created item attribute'),
(282, 1, 1, '2025-08-27 22:47:04', '2025-08-27 22:47:04', NULL, 'lookup_list_items', 285, 'DELETE', 'Deleted lookup list item'),
(283, 1, 1, '2025-08-27 22:47:20', '2025-08-27 22:47:20', NULL, 'lookup_list_item_attributes', 168, 'CREATE', 'Created item attribute'),
(284, 1, 1, '2025-08-27 22:47:25', '2025-08-27 22:47:25', NULL, 'lookup_list_item_attributes', 169, 'CREATE', 'Created item attribute'),
(285, 1, 1, '2025-08-27 22:47:32', '2025-08-27 22:47:32', NULL, 'lookup_list_item_attributes', 170, 'CREATE', 'Created item attribute'),
(286, 1, 1, '2025-08-27 22:47:52', '2025-08-27 22:47:52', NULL, 'lookup_list_item_attributes', 171, 'CREATE', 'Created item attribute'),
(287, 1, 1, '2025-08-27 22:47:55', '2025-08-27 22:47:55', NULL, 'lookup_list_item_attributes', 172, 'CREATE', 'Created item attribute'),
(288, 1, 1, '2025-08-27 22:47:58', '2025-08-27 22:47:58', NULL, 'lookup_list_item_attributes', 173, 'CREATE', 'Created item attribute'),
(289, 1, 1, '2025-08-27 22:48:01', '2025-08-27 22:48:01', NULL, 'lookup_list_item_attributes', 174, 'CREATE', 'Created item attribute'),
(290, 1, 1, '2025-08-27 22:48:23', '2025-08-27 22:48:23', NULL, 'lookup_list_item_attributes', 175, 'CREATE', 'Created item attribute'),
(291, 1, 1, '2025-08-27 22:48:27', '2025-08-27 22:48:27', NULL, 'lookup_list_item_attributes', 176, 'CREATE', 'Created item attribute'),
(292, 1, 1, '2025-08-27 22:48:36', '2025-08-27 22:48:36', NULL, 'lookup_list_item_attributes', 177, 'CREATE', 'Created item attribute');

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
(8, 1, 1, '2025-08-13 16:28:53', '2025-08-23 19:17:32', NULL, 'SYSTEM_PROPERTIES_CATEGORIES', 'Categories for system properties'),
(9, 1, 1, '2025-08-13 16:28:53', '2025-08-23 19:17:41', NULL, 'SYSTEM_PROPERTIES_TYPES', 'Data types for system properties'),
(10, 1, 1, '2025-08-14 00:00:00', '2025-08-23 20:26:00', NULL, 'PROJECT_STATUS', 'Status values for projects'),
(11, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'TASK_STATUS', 'Status values for tasks'),
(12, 1, 1, '2025-08-14 00:00:00', '2025-08-14 00:00:00', NULL, 'TASK_PRIORITY', 'Priority levels for tasks'),
(14, 1, 1, '2025-08-17 11:02:46', '2025-08-22 23:53:20', '', 'PROJECT_PRIORITY', ''),
(15, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'USER_GENDER', 'Gender options for users'),
(16, 1, 1, '2025-08-18 15:29:37', '2025-08-20 15:07:28', '', 'CONTRACTOR_COMPENSATION_TYPE', ''),
(17, 1, 1, '2025-08-18 15:29:50', '2025-08-20 14:37:41', '', 'CONTRACTOR_COMPENSATION_PAYMENT_METHOD', ''),
(18, 1, 1, '2025-08-18 15:29:59', '2025-08-18 15:29:59', '', 'CONTRACTOR_TYPE', ''),
(19, 1, 1, '2025-08-18 15:30:20', '2025-08-23 20:17:56', '', 'CONTRACTOR_FILE_TYPE', ''),
(20, 1, 1, '2025-08-18 15:32:11', '2025-08-20 20:48:24', '', 'CONTRACTOR_CONTACT_TYPE', ''),
(21, 1, 1, '2025-08-18 15:32:30', '2025-08-18 15:32:30', '', 'CONTRACTOR_STATUS', ''),
(22, 1, 1, '2025-08-18 00:00:00', '2025-08-18 00:00:00', NULL, 'USER_PROFILE_PIC_STATUS', 'Status values for user profile pictures'),
(23, 1, 1, '2025-08-20 00:22:10', '2025-08-21 02:31:25', '', 'IMAGE_FILE_TYPES', ''),
(24, 1, 1, '2025-08-20 20:50:24', '2025-08-21 15:33:50', '', 'CONTRACTOR_CONTACT_RESPONSE_TYPE', 'Response Type\'s from a person'),
(25, 1, 1, '2025-08-20 20:55:43', '2025-08-22 18:16:41', '', 'CONTRACTOR_ACQUAINTANCE_TYPE', 'How do we know this Contractor?'),
(26, 1, 1, '2025-08-20 21:07:06', '2025-08-20 21:14:03', '', 'PERSON_PHONE_TYPE', ''),
(27, 1, 1, '2025-08-20 21:07:13', '2025-08-20 21:13:19', '', 'PERSON_ADDRESS_TYPE', ''),
(28, 1, 1, '2025-08-20 21:07:53', '2025-08-20 21:12:32', '', 'PERSON_ADDRESS_STATUS', ''),
(29, 1, 1, '2025-08-20 21:07:59', '2025-08-20 21:10:50', '', 'PERSON_PHONE_STATUS', ''),
(30, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 'US_STATES', 'United States states and DC'),
(31, 1, 1, '2025-08-22 08:16:54', '2025-08-22 08:18:20', '', 'PROJECT_TYPE', 'Normal Project, SoW, etc.'),
(32, 1, 1, '2025-08-22 00:00:00', '2025-08-22 00:00:00', NULL, 'ORGANIZATION_PERSON_ROLES', 'Roles for persons assigned to organizations'),
(33, 1, 1, '2025-08-22 00:00:00', '2025-08-22 00:00:00', NULL, 'AGENCY_PERSON_ROLES', 'Roles for persons assigned to agencies'),
(34, 1, 1, '2025-08-22 00:00:00', '2025-08-22 00:00:00', NULL, 'DIVISION_PERSON_ROLES', 'Roles for persons assigned to divisions'),
(35, 1, 1, '2025-08-22 20:43:49', '2025-08-22 20:43:49', '', 'PROJECT_SUB_TYPE', ''),
(36, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', '', 'FEEDBACK_TYPE', 'Types of feedback'),
(37, 1, 1, '2025-08-23 11:07:04', '2025-08-23 11:10:01', '', 'CALENDAR_EVENT_TYPE', ''),
(38, 1, 1, '2025-08-23 11:07:08', '2025-08-23 11:09:03', '', 'CALENDAR_VISIBILITY', ''),
(39, 1, 1, '2025-08-23 15:58:35', '2025-08-27 21:45:35', '', 'MEETING_STATUS', 'Status values for meetings'),
(40, 1, 1, '2025-08-23 15:58:41', '2025-08-23 16:08:51', '', 'MEETING_TYPE', 'Types of meetings.'),
(41, 1, 1, '2025-08-23 15:58:44', '2025-08-23 16:08:11', '', 'MEETING_FILE_TYPE', 'Categories of meeting files'),
(42, 1, 1, '2025-08-27 00:00:00', '2025-08-25 00:35:20', '', 'PRODUCT_SERVICE_TYPE', 'Types of products or services'),
(43, 1, 1, '2025-08-27 00:00:00', '2025-08-25 01:29:19', 'test', 'PERSON_SKILL', 'Skills a person may have'),
(44, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:33', '', 'SKILL_LEVEL', 'Proficiency levels for skills'),
(45, 1, 1, '2025-08-24 18:57:56', '2025-08-24 18:57:56', NULL, 'MEETING_AGENDA_STATUS', 'Status values for meeting agenda items'),
(46, 1, 1, '2025-08-24 18:57:56', '2025-08-24 18:57:56', NULL, 'MEETING_QUESTION_STATUS', 'Status values for meeting questions'),
(47, 1, 1, '2025-08-24 19:03:24', '2025-08-24 19:04:16', '', 'PRODUCT_SERVICE_STATUS', ''),
(48, 1, 1, '2025-08-24 19:03:28', '2025-08-24 19:03:28', '', 'PRODUCT_SERVICE', ''),
(49, 1, 1, '2025-08-24 19:48:19', '2025-08-24 19:48:19', '', 'PRODUCT_SERVICE_CATEGORY', 'Categories for products and services'),
(51, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'SOW_STATUS', 'SoW statuses'),
(52, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'SOW_FILE_TYPE', 'Allowed SoW file types'),
(53, 1, 1, '2025-08-24 23:53:15', '2025-08-24 23:53:15', NULL, 'RELATIONSHIP_TYPE', 'SoW relationship types'),
(56, 1, 1, '2025-08-25 12:57:51', '2025-08-25 12:57:51', '', 'ADMIN_TASK_STATUS', ''),
(57, 1, 1, '2025-08-25 12:58:02', '2025-08-25 12:58:02', '', 'ADMIN_TASK_PRIORITY', ''),
(58, 1, 1, '2025-08-25 12:58:09', '2025-08-25 12:58:09', '', 'ADMIN_TASK_CATEGORY', ''),
(59, 1, 1, '2025-08-25 12:59:21', '2025-08-25 12:59:21', '', 'ADMIN_TASK_TYPE', ''),
(60, 1, 1, '2025-08-25 13:01:12', '2025-08-25 13:01:12', '', 'ADMIN_TASK_RECURRING_TYPE', ''),
(61, 1, 1, '2025-08-25 13:04:33', '2025-08-25 13:04:33', '', 'ADMIN_TASK_SUB_CATEGORY', ''),
(62, 1, 1, '2025-08-26 00:00:00', '2025-08-27 22:47:04', NULL, 'CORPORATE_FEATURE', 'Corporate module features'),
(63, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 'CONFERENCE_TYPE', 'Types of conferences'),
(64, 1, NULL, '2025-08-27 00:56:50', '2025-08-27 00:56:50', NULL, 'CONFERENCE_TOPIC', 'Topics for conferences'),
(66, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 'CORPORATE_FINANCE_SECTION', 'Sections for corporate finance'),
(67, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 'CORPORATE_STRATEGY_STATUS', 'Status values for corporate strategies'),
(68, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 'CORPORATE_STRATEGY_PRIORITY', 'Priority levels for corporate strategies'),
(69, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 'CORPORATE_STRATEGY_ROLE', 'Roles for strategy collaborators');

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
  `active_from` date DEFAULT (curdate() - interval 1 day),
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
(123, 1, 1, '2025-08-21 01:47:45', '2025-08-23 20:17:56', NULL, 19, '9.4 Acceptable Use Policy CONTINGENT WORKER - Lake County, IL', 'LAKE-AUP-1', 0, '2025-08-21', NULL),
(124, 1, 1, '2025-08-21 01:47:48', '2025-08-23 20:16:54', NULL, 19, 'CONSENT FOR BACKGROUND CHECK - Lake County, IL', 'LAKE-AUP-2', 0, '2025-08-21', NULL),
(125, 1, 1, '2025-08-21 01:47:52', '2025-08-23 20:17:42', NULL, 19, 'Electronic Communications - Acceptable Cell Phone Usage Policy - Lake County, IL', 'LAKE-AUP-3', 0, '2025-08-21', NULL),
(126, 1, 1, '2025-08-21 01:47:56', '2025-08-23 20:17:36', NULL, 19, 'Third Party Network Access Request Form - Lake County, IL', 'LAKE-AUP-4', 0, '2025-08-21', NULL),
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
(183, 1, 1, '2025-08-22 08:17:32', '2025-08-22 08:17:32', NULL, 31, 'Statement of Work', 'STATEMENTOFWORK', 0, '2025-08-22', NULL),
(184, 1, 1, '2025-08-22 00:00:00', '2025-08-22 00:00:00', NULL, 32, 'Member', 'MEMBER', 1, '2025-08-22', NULL),
(185, 1, 1, '2025-08-22 00:00:00', '2025-08-22 00:00:00', NULL, 33, 'Member', 'MEMBER', 1, '2025-08-22', NULL),
(186, 1, 1, '2025-08-22 00:00:00', '2025-08-22 00:00:00', NULL, 34, 'Member', 'MEMBER', 1, '2025-08-22', NULL),
(187, 1, 1, '2025-08-22 18:16:34', '2025-08-22 18:16:34', NULL, 25, 'Louisiana Baton Rouge Mission', 'MORMON', 0, '2025-08-22', NULL),
(188, 1, 1, '2025-08-22 23:51:09', '2025-08-22 23:51:09', NULL, 10, 'Drafting Contract', 'DRAFT', 0, '2025-08-22', NULL),
(189, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 36, 'Bug', 'BUG', 1, '2025-08-23', NULL),
(190, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 36, 'Feature Request', 'FEATURE_REQUEST', 2, '2025-08-23', NULL),
(191, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 36, 'Question', 'QUESTION', 3, '2025-08-23', NULL),
(192, 1, 1, '2025-08-23 00:00:00', '2025-08-23 00:00:00', NULL, 36, 'Other', 'OTHER', 4, '2025-08-23', NULL),
(193, 1, 1, '2025-08-23 11:07:49', '2025-08-23 11:07:49', NULL, 37, 'Internal Meeting', 'INTERNAL_MEETING', 0, '2025-08-23', NULL),
(194, 1, 1, '2025-08-23 11:07:56', '2025-08-23 11:07:56', NULL, 37, 'Client Meeting', 'CLIENT_MEETING', 0, '2025-08-23', NULL),
(195, 1, 1, '2025-08-23 11:08:03', '2025-08-23 11:08:03', NULL, 37, 'PTO', 'PTO', 0, '2025-08-23', NULL),
(196, 1, 1, '2025-08-23 11:08:08', '2025-08-23 11:08:08', NULL, 37, 'Busy', 'BUSY', 0, '2025-08-23', NULL),
(197, 1, 1, '2025-08-23 11:08:17', '2025-08-23 11:08:17', NULL, 37, 'General', 'GENERAL', 0, '2025-08-23', NULL),
(198, 1, 1, '2025-08-23 11:08:33', '2025-08-23 11:08:33', NULL, 38, 'Public', 'PUBLIC', 0, '2025-08-23', NULL),
(199, 1, 1, '2025-08-23 11:08:38', '2025-08-23 11:08:38', NULL, 38, 'Private', 'PRIVATE', 0, '2025-08-23', NULL),
(202, 1, 1, '2025-08-23 16:06:03', '2025-08-23 16:06:03', NULL, 39, 'Completed', 'COMPLETED', 0, '2025-08-23', NULL),
(204, 1, 1, '2025-08-23 16:06:27', '2025-08-27 21:43:19', NULL, 40, 'Atlis - Internal Meeting', 'ATLIS-INTERNAL', 0, '2025-08-23', NULL),
(205, 1, 1, '2025-08-23 16:06:41', '2025-08-23 16:06:41', NULL, 40, 'Client Meeting', 'CLIENT_MEETING', 0, '2025-08-23', NULL),
(206, 1, 1, '2025-08-23 16:06:49', '2025-08-23 16:06:49', NULL, 40, 'Kickoff', 'KICKOFF', 0, '2025-08-23', NULL),
(207, 1, 1, '2025-08-23 16:06:56', '2025-08-23 16:06:56', NULL, 40, 'Review', 'REVIEW', 0, '2025-08-23', NULL),
(208, 1, 1, '2025-08-23 16:07:10', '2025-08-23 16:07:10', NULL, 41, 'Minutes', 'MINUTES', 0, '2025-08-23', NULL),
(209, 1, 1, '2025-08-23 16:07:18', '2025-08-23 16:07:18', NULL, 41, 'Slide Deck', 'SLIDE_DECK', 0, '2025-08-23', NULL),
(210, 1, 1, '2025-08-23 16:07:26', '2025-08-23 16:07:26', NULL, 41, 'Recording', 'RECORDING', 0, '2025-08-23', NULL),
(211, 1, 1, '2025-08-23 19:17:29', '2025-08-23 19:17:29', NULL, 8, 'User', 'USER', 0, '2025-08-23', NULL),
(212, 1, 1, '2025-08-23 19:17:37', '2025-08-23 19:17:37', NULL, 9, 'User', 'USER', 0, '2025-08-23', NULL),
(213, 1, 1, '2025-08-23 20:25:52', '2025-08-23 20:25:52', NULL, 10, 'Indefinite - Ongoing', 'INDEFINITE', 0, '2025-08-23', NULL),
(214, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 42, 'Product', 'PRODUCT', 1, '2025-08-22', NULL),
(215, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 42, 'Service', 'SERVICE', 2, '2025-08-22', NULL),
(216, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 42, 'Subscription', 'SUBSCRIPTION', 3, '2025-08-22', NULL),
(217, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 43, 'PHP', 'PHP', 1, '2025-08-22', NULL),
(218, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 43, 'JavaScript', 'JAVASCRIPT', 2, '2025-08-22', NULL),
(219, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 43, 'SQL', 'SQL', 3, '2025-08-22', NULL),
(220, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 43, 'Project Management', 'PM', 4, '2025-08-22', NULL),
(221, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 43, 'Design', 'DESIGN', 5, '2025-08-22', NULL),
(222, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 44, 'Beginner', 'BEGINNER', 1, '2025-08-22', NULL),
(223, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 44, 'Intermediate', 'INTERMEDIATE', 2, '2025-08-22', NULL),
(224, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 44, 'Advanced', 'ADVANCED', 3, '2025-08-22', NULL),
(225, 1, 1, '2025-08-27 00:00:00', '2025-08-24 19:02:28', NULL, 44, 'Expert', 'EXPERT', 4, '2025-08-22', NULL),
(226, 1, 1, '2025-08-24 18:57:56', '2025-08-24 19:01:36', NULL, 45, 'Not Started', 'NOT_STARTED', 1, '2025-08-23', NULL),
(227, 1, 1, '2025-08-24 18:57:56', '2025-08-24 19:01:36', NULL, 45, 'In Progress', 'IN_PROGRESS', 2, '2025-08-23', NULL),
(228, 1, 1, '2025-08-24 18:57:56', '2025-08-24 19:01:36', NULL, 45, 'Completed', 'COMPLETED', 3, '2025-08-23', NULL),
(229, 1, 1, '2025-08-24 18:57:56', '2025-08-24 19:01:36', NULL, 46, 'Unanswered', 'UNANSWERED', 1, '2025-08-23', NULL),
(230, 1, 1, '2025-08-24 18:57:56', '2025-08-27 21:48:26', NULL, 46, 'Need More Info', 'MOREINFO', 2, '2025-08-26', NULL),
(231, 1, 1, '2025-08-24 18:57:56', '2025-08-24 19:01:36', NULL, 46, 'Answered', 'ANSWERED', 3, '2025-08-23', NULL),
(233, 1, 1, '2025-08-24 19:03:43', '2025-08-24 19:03:43', NULL, 47, 'Active', 'ACTIVE', 0, '2025-08-24', NULL),
(234, 1, 1, '2025-08-24 19:03:49', '2025-08-24 19:03:49', NULL, 47, 'Inactive', 'INACTIVE', 0, '2025-08-24', NULL),
(235, 1, 1, '2025-08-24 19:04:07', '2025-08-24 19:04:07', NULL, 47, 'Pending', 'PENDING', 0, '2025-08-24', NULL),
(236, 1, 1, '2025-08-27 00:00:00', '2025-08-25 00:35:49', NULL, 32, 'Manager', 'MANAGER', 2, '2025-08-24', NULL),
(237, 1, 1, '2025-08-27 00:00:00', '2025-08-25 00:35:46', NULL, 33, 'Manager', 'MANAGER', 2, '2025-08-24', NULL),
(238, 1, 1, '2025-08-27 00:00:00', '2025-08-25 00:35:43', NULL, 34, 'Manager', 'MANAGER', 2, '2025-08-24', NULL),
(242, 1, 1, '2025-08-25 00:35:20', '2025-08-25 00:35:20', NULL, 42, 'test', 'test', 0, '2025-08-25', NULL),
(243, 1, 1, '2025-08-25 00:51:21', '2025-08-25 00:51:21', NULL, 51, 'Draft', 'DRAFT', 1, '2025-08-24', NULL),
(244, 1, 1, '2025-08-25 00:51:21', '2025-08-25 00:51:21', NULL, 51, 'On Hold', 'ON_HOLD', 2, '2025-08-24', NULL),
(245, 1, 1, '2025-08-25 00:51:21', '2025-08-25 00:51:21', NULL, 51, 'In Progress', 'IN_PROGRESS', 3, '2025-08-24', NULL),
(246, 1, 1, '2025-08-25 00:51:21', '2025-08-25 00:51:21', NULL, 51, 'Cancelled', 'CANCELLED', 4, '2025-08-24', NULL),
(247, 1, 1, '2025-08-25 00:51:21', '2025-08-25 00:51:21', NULL, 51, 'Complete', 'COMPLETE', 5, '2025-08-24', NULL),
(248, 1, 1, '2025-08-25 00:51:22', '2025-08-25 00:51:22', NULL, 52, 'PDF', 'PDF', 1, '2025-08-24', NULL),
(249, 1, 1, '2025-08-25 00:51:22', '2025-08-25 00:51:22', NULL, 52, 'DOCX', 'DOCX', 2, '2025-08-24', NULL),
(250, 1, 1, '2025-08-25 00:51:22', '2025-08-25 00:51:22', NULL, 52, 'XLSX', 'XLSX', 3, '2025-08-24', NULL),
(251, 1, 1, '2025-08-25 00:51:22', '2025-08-25 00:51:22', NULL, 52, 'JPG', 'JPG', 4, '2025-08-24', NULL),
(252, 1, 1, '2025-08-25 00:51:22', '2025-08-25 00:51:22', NULL, 52, 'PNG', 'PNG', 5, '2025-08-24', NULL),
(253, 1, 1, '2025-08-25 00:51:22', '2025-08-25 00:51:22', NULL, 53, 'Owner', 'OWNER', 1, '2025-08-24', NULL),
(254, 1, 1, '2025-08-25 00:51:22', '2025-08-25 00:51:22', NULL, 53, 'Contributor', 'CONTRIBUTOR', 2, '2025-08-24', NULL),
(255, 1, 1, '2025-08-25 00:51:22', '2025-08-25 00:51:22', NULL, 53, 'Viewer', 'VIEWER', 3, '2025-08-24', NULL),
(256, 1, 1, '2025-08-25 01:39:32', '2025-08-25 01:39:32', NULL, 37, 'Meeting', 'MEETING', 1, '2025-08-25', NULL),
(257, 1, 1, '2025-08-25 01:39:32', '2025-08-25 01:39:32', NULL, 37, 'Task', 'TASK', 2, '2025-08-25', NULL),
(258, 1, 1, '2025-08-25 01:39:32', '2025-08-25 01:39:32', NULL, 37, 'Reminder', 'REMINDER', 3, '2025-08-25', NULL),
(259, 1, 1, '2025-08-25 01:39:32', '2025-08-25 01:39:32', NULL, 7, 'Icon / Class', 'ICON-CLASS', 3, '2025-08-25', NULL),
(262, 1, 1, '2025-08-25 01:54:03', '2025-08-25 01:54:03', NULL, 49, 'eSeries', 'ESERIES', 0, '2025-08-24', NULL),
(263, 1, 1, '2025-08-25 01:54:12', '2025-08-25 01:54:12', NULL, 49, 'Other', 'OTHER', 0, '2025-08-24', NULL),
(264, 1, 1, '2025-08-25 13:02:26', '2025-08-25 13:02:26', NULL, 59, 'Atlis', 'ATLIS', 0, '2025-08-24', NULL),
(265, 1, 1, '2025-08-25 13:02:34', '2025-08-25 13:02:34', NULL, 59, 'Personal', 'PERSONAL', 0, '2025-08-24', NULL),
(266, 1, 1, '2025-08-25 13:03:13', '2025-08-25 13:03:13', NULL, 58, 'Outreach / Prospecting', 'ATLIS-OUTREACH', 0, '2025-08-24', NULL),
(267, 1, 1, '2025-08-25 13:03:32', '2025-08-25 13:03:32', NULL, 58, 'Family', 'PERSONAL-FAMILY', 0, '2025-08-24', NULL),
(268, 1, 1, '2025-08-25 13:04:22', '2025-08-25 13:04:22', NULL, 58, 'Masonry', 'MASONRY', 0, '2025-08-24', NULL),
(269, 1, 1, '2025-08-25 13:05:22', '2025-08-25 13:05:22', NULL, 61, 'Masonic Business Meeting', 'MASONRY-BIZMEETING', 0, '2025-08-24', NULL),
(270, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 8, 'PROJECT_SETTINGS', 'PROJECT_SETTINGS', 3, '2025-08-24', NULL),
(271, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 9, 'INTEGER', 'INTEGER', 3, '2025-08-24', NULL),
(272, 1, 1, '2025-08-26 00:27:03', '2025-08-26 00:27:03', NULL, 57, 'Low', 'LOW', 0, '2025-08-25', NULL),
(273, 1, 1, '2025-08-26 00:28:08', '2025-08-26 00:28:08', NULL, 57, 'Medium', 'MEDIUM', 0, '2025-08-25', NULL),
(274, 1, 1, '2025-08-26 00:28:21', '2025-08-26 00:28:21', NULL, 57, 'Urgent !', 'URGEN', 0, '2025-08-25', NULL),
(275, 1, 1, '2025-08-26 00:29:34', '2025-08-26 00:29:34', NULL, 60, 'test', 'TEST', 0, '2025-08-25', NULL),
(276, 1, 1, '2025-08-26 00:30:41', '2025-08-26 00:30:41', NULL, 56, 'Pending', 'PENDING', 0, '2025-08-25', NULL),
(277, 1, 1, '2025-08-26 00:30:51', '2025-08-26 00:30:51', NULL, 56, 'In Progress', 'INPROGRESS', 0, '2025-08-25', NULL),
(278, 1, 1, '2025-08-26 00:30:56', '2025-08-26 00:31:05', NULL, 56, 'Done !', 'DONE', 0, '2025-08-25', NULL),
(279, 1, 1, '2025-08-26 00:37:43', '2025-08-26 00:37:43', NULL, 39, 'Scheduled', 'SCHEDULED', 0, '2025-08-25', NULL),
(280, 1, 1, '2025-08-26 00:37:59', '2025-08-26 00:37:59', NULL, 40, 'General', 'GENERAL', 0, '2025-08-25', NULL),
(281, 1, 1, '2025-08-26 22:29:20', '2025-08-26 22:29:20', NULL, 61, 'Dave', 'DAVE', 0, '0000-00-00', '0000-00-00'),
(282, 1, 1, '2025-08-26 22:29:20', '2025-08-26 22:29:20', NULL, 61, 'Emry', 'EMRY', 0, '0000-00-00', '0000-00-00'),
(283, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Business Strategy', 'BUSINESS_STRATEGY', 1, '2025-08-26', NULL),
(284, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Prospecting', 'PROSPECTING', 2, '2025-08-26', NULL),
(286, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Accounting', 'ACCOUNTING', 4, '2025-08-26', NULL),
(287, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Assets', 'ASSETS', 5, '2025-08-26', NULL),
(288, 1, 1, '2025-08-26 00:00:00', '2025-08-26 00:00:00', NULL, 62, 'Human Resources', 'HUMAN_RESOURCES', 6, '2025-08-26', NULL),
(289, 1, 1, '2025-08-27 00:58:54', '2025-08-27 00:58:54', NULL, 63, 'Journal Technologies ( JTI )', 'JTI', 0, '2025-08-26', NULL),
(290, 1, 1, '2025-08-27 00:59:03', '2025-08-27 00:59:03', NULL, 63, 'Court', 'COURT', 0, '2025-08-26', NULL),
(291, 1, 1, '2025-08-27 00:59:19', '2025-08-27 00:59:19', NULL, 64, 'Technical', 'TECHNICAL', 0, '2025-08-26', NULL),
(292, 1, 1, '2025-08-27 00:59:29', '2025-08-27 00:59:29', NULL, 64, 'Finance', 'FINANCE', 0, '2025-08-26', NULL),
(293, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 62, 'Finances', 'FINANCES', 0, '2025-08-26', NULL),
(294, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 62, 'Time Tracking', 'TIME_TRACKING', 1, '2025-08-26', NULL),
(295, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 66, 'Invoices', 'INVOICES', 0, '2025-08-26', NULL),
(296, 1, 1, '2025-08-27 02:18:52', '2025-08-27 02:18:52', NULL, 66, 'Statements of Work', 'STATEMENTS_OF_WORK', 1, '2025-08-26', NULL),
(297, 1, 1, '2025-08-27 19:44:13', '2025-08-27 21:44:03', NULL, 40, 'Core Meeting (from Meetings module)', 'CORE-MEETING-CALENDAR-EVENT', 0, '2025-08-26', NULL),
(298, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 67, 'Active', 'ACTIVE', 2, '2025-08-26', NULL),
(299, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 67, 'Archived', 'ARCHIVED', 3, '2025-08-26', NULL),
(300, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 68, 'Low', 'LOW', 1, '2025-08-26', NULL),
(301, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 68, 'Medium', 'MEDIUM', 2, '2025-08-26', NULL),
(302, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 68, 'High', 'HIGH', 3, '2025-08-26', NULL),
(303, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 68, 'Critical', 'CRITICAL', 4, '2025-08-26', NULL),
(304, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 69, 'Owner', 'OWNER', 1, '2025-08-26', NULL),
(305, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 69, 'Editor', 'EDITOR', 2, '2025-08-26', NULL),
(306, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 69, 'Viewer', 'VIEWER', 3, '2025-08-26', NULL),
(307, 1, 1, '2025-08-27 21:13:27', '2025-08-27 21:13:27', NULL, 67, 'Draft', 'DRAFT', 1, '2025-08-26', NULL);

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
(71, 1, 1, '2025-08-19 23:21:00', '2025-08-22 23:53:20', NULL, 87, 'COLOR-CLASS', 'rose'),
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
(122, 1, 1, '2025-08-22 08:18:20', '2025-08-22 08:18:20', NULL, 182, 'DEFAULT', 'true'),
(123, 1, 1, '2025-08-22 18:16:41', '2025-08-22 18:16:41', NULL, 187, 'COLOR-CLASS', 'warning'),
(124, 1, 1, '2025-08-22 23:51:21', '2025-08-22 23:51:21', NULL, 188, 'COLOR-CLASS', 'dark'),
(125, 1, 1, '2025-08-23 11:08:59', '2025-08-23 11:08:59', NULL, 199, 'COLOR-CLASS', 'danger'),
(126, 1, 1, '2025-08-23 11:09:03', '2025-08-23 11:09:03', NULL, 198, 'COLOR-CLASS', 'atlis'),
(127, 1, 1, '2025-08-23 11:09:18', '2025-08-23 11:09:18', NULL, 197, 'DEFAULT', 'true'),
(128, 1, 1, '2025-08-23 11:09:31', '2025-08-23 11:09:31', NULL, 196, 'COLOR-CLASS', 'danger'),
(129, 1, 1, '2025-08-23 11:09:35', '2025-08-23 11:09:54', NULL, 194, 'COLOR-CLASS', 'success'),
(130, 1, 1, '2025-08-23 11:09:41', '2025-08-23 11:09:41', NULL, 197, 'COLOR-CLASS', 'primary'),
(131, 1, 1, '2025-08-23 11:09:45', '2025-08-23 11:09:45', NULL, 193, 'COLOR-CLASS', 'atlis'),
(132, 1, 1, '2025-08-23 11:10:01', '2025-08-23 11:10:01', NULL, 195, 'COLOR-CLASS', 'sunset'),
(133, 1, 1, '2025-08-23 16:07:59', '2025-08-23 16:07:59', NULL, 208, 'COLOR-CLASS', 'atlis'),
(134, 1, 1, '2025-08-23 16:08:06', '2025-08-23 16:08:06', NULL, 210, 'COLOR-CLASS', 'sunset'),
(135, 1, 1, '2025-08-23 16:08:11', '2025-08-23 16:08:11', NULL, 209, 'COLOR-CLASS', 'grape'),
(136, 1, 1, '2025-08-23 16:08:23', '2025-08-23 16:08:23', NULL, 204, 'COLOR-CLASS', 'atlis'),
(137, 1, 1, '2025-08-23 16:08:27', '2025-08-23 16:08:27', NULL, 204, 'DEFAULT', 'true'),
(138, 1, 1, '2025-08-23 16:08:37', '2025-08-23 16:08:37', NULL, 206, 'COLOR-CLASS', 'sunset'),
(139, 1, 1, '2025-08-23 16:08:44', '2025-08-23 16:08:44', NULL, 207, 'COLOR-CLASS', 'purple'),
(140, 1, 1, '2025-08-23 16:08:51', '2025-08-23 16:08:51', NULL, 205, 'COLOR-CLASS', 'pink'),
(141, 1, 1, '2025-08-23 19:17:32', '2025-08-23 19:17:32', NULL, 211, 'COLOR-CLASS', 'atlis'),
(142, 1, 1, '2025-08-23 19:17:41', '2025-08-23 19:17:41', NULL, 212, 'COLOR-CLASS', 'atlis'),
(143, 1, 1, '2025-08-23 20:26:00', '2025-08-23 20:26:00', NULL, 213, 'COLOR-CLASS', 'pink'),
(144, 1, 1, '2025-08-24 19:03:53', '2025-08-24 19:03:53', NULL, 233, 'COLOR-CLASS', 'success'),
(145, 1, 1, '2025-08-24 19:03:57', '2025-08-24 19:03:57', NULL, 234, 'COLOR-CLASS', 'danger'),
(146, 1, 1, '2025-08-24 19:04:12', '2025-08-24 19:04:12', NULL, 235, 'COLOR-CLASS', 'warning'),
(147, 1, 1, '2025-08-24 19:04:16', '2025-08-24 19:04:16', NULL, 235, 'DEFAULT', 'true'),
(148, 1, 1, '2025-08-27 00:53:24', '2025-08-27 00:53:24', NULL, 202, 'COLOR-CLASS', 'success'),
(150, 1, 1, '2025-08-27 00:53:31', '2025-08-27 00:53:31', NULL, 279, 'COLOR-CLASS', 'atlis'),
(151, 1, 1, '2025-08-27 00:53:36', '2025-08-27 00:53:36', NULL, 279, 'DEFAULT', 'true'),
(152, 1, 1, '2025-08-27 00:59:38', '2025-08-27 00:59:38', NULL, 292, 'COLOR-CLASS', 'success'),
(153, 1, 1, '2025-08-27 00:59:46', '2025-08-27 00:59:46', NULL, 291, 'COLOR-CLASS', 'sunset'),
(154, 1, 1, '2025-08-27 00:59:50', '2025-08-27 00:59:50', NULL, 291, 'DEFAULT', 'true'),
(155, 1, 1, '2025-08-27 19:44:19', '2025-08-27 19:44:19', NULL, 297, 'COLOR-CLASS', 'danger'),
(156, 1, 1, '2025-08-27 21:46:26', '2025-08-27 21:46:26', NULL, 226, 'COLOR-CLASS', 'warning'),
(157, 1, 1, '2025-08-27 21:46:33', '2025-08-27 21:46:33', NULL, 227, 'COLOR-CLASS', 'primary'),
(158, 1, 1, '2025-08-27 21:46:38', '2025-08-27 21:46:38', NULL, 228, 'COLOR-CLASS', 'success'),
(159, 1, 1, '2025-08-27 21:46:45', '2025-08-27 21:46:45', NULL, 226, 'DEFAULT', 'true'),
(160, 1, 1, '2025-08-27 21:47:43', '2025-08-27 21:47:43', NULL, 229, 'COLOR-CLASS', 'warning'),
(161, 1, 1, '2025-08-27 21:48:03', '2025-08-27 21:48:03', NULL, 230, 'COLOR-CLASS', 'sunset'),
(162, 1, 1, '2025-08-27 21:48:11', '2025-08-27 21:48:11', NULL, 231, 'COLOR-CLASS', 'success'),
(163, 1, 1, '2025-08-27 21:48:16', '2025-08-27 21:48:16', NULL, 229, 'DEFAULT', 'true'),
(164, 1, 1, '2025-08-27 22:44:53', '2025-08-27 22:44:53', NULL, 293, 'COLOR-CLASS', 'ocean'),
(165, 1, 1, '2025-08-27 22:45:03', '2025-08-27 22:45:03', NULL, 283, 'COLOR-CLASS', 'atlis'),
(166, 1, 1, '2025-08-27 22:45:13', '2025-08-27 22:45:13', NULL, 294, 'COLOR-CLASS', 'grape'),
(167, 1, 1, '2025-08-27 22:45:17', '2025-08-27 22:45:17', NULL, 284, 'COLOR-CLASS', 'warning'),
(168, 1, 1, '2025-08-27 22:47:20', '2025-08-27 22:47:20', NULL, 286, 'COLOR-CLASS', 'citrus'),
(169, 1, 1, '2025-08-27 22:47:25', '2025-08-27 22:47:25', NULL, 287, 'COLOR-CLASS', 'red'),
(170, 1, 1, '2025-08-27 22:47:32', '2025-08-27 22:47:32', NULL, 288, 'COLOR-CLASS', 'forest'),
(171, 1, 1, '2025-08-27 22:47:52', '2025-08-27 22:47:52', NULL, 272, 'COLOR-CLASS', 'primary'),
(172, 1, 1, '2025-08-27 22:47:55', '2025-08-27 22:47:55', NULL, 273, 'COLOR-CLASS', 'warning'),
(173, 1, 1, '2025-08-27 22:47:58', '2025-08-27 22:47:58', NULL, 273, 'DEFAULT', 'true'),
(174, 1, 1, '2025-08-27 22:48:01', '2025-08-27 22:48:01', NULL, 274, 'COLOR-CLASS', 'danger'),
(175, 1, 1, '2025-08-27 22:48:23', '2025-08-27 22:48:23', NULL, 268, 'COLOR-CLASS', 'citrus'),
(176, 1, 1, '2025-08-27 22:48:27', '2025-08-27 22:48:27', NULL, 266, 'COLOR-CLASS', 'atlis'),
(177, 1, 1, '2025-08-27 22:48:36', '2025-08-27 22:48:36', NULL, 267, 'COLOR-CLASS', 'forest');

-- --------------------------------------------------------

--
-- Table structure for table `lookup_list_item_relations`
--

CREATE TABLE `lookup_list_item_relations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `related_item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lookup_list_item_relations`
--

INSERT INTO `lookup_list_item_relations` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `item_id`, `related_item_id`) VALUES
(1, 1, 1, '2025-08-23 16:19:03', '2025-08-23 16:19:03', NULL, 208, 194),
(2, 1, 1, '2025-08-23 16:19:03', '2025-08-23 16:19:03', NULL, 194, 208);

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
(1, 1, 1, '2025-08-06 16:27:31', '2025-08-25 01:06:00', NULL, 1, 'Atlis Technologies', 1, 3, 'Logo_Top_Atlis_Technologies_1300x1300_300dpi_white_text_dark_bg.png', '0040e65cb7c95b73129ea77e0b7d9175.png', 128317, 'image/png'),
(2, 1, 1, '2025-08-06 16:28:14', '2025-08-24 19:28:37', NULL, 2, '19th Circuit Court', NULL, 3, 'LakeCountyIL_Logo.png', '2440863a92437531028982668632197e.png', 375629, 'image/png'),
(3, 1, 1, '2025-08-21 02:14:26', '2025-08-21 02:14:26', NULL, 2, 'Office of the Public Defender', 30, 28, NULL, NULL, NULL, NULL),
(4, 1, 1, '2025-08-21 02:16:22', '2025-08-21 02:16:22', NULL, 2, 'State\'s Attorney Office', 31, 28, NULL, NULL, NULL, NULL),
(6, 1, 1, '2025-08-22 19:14:44', '2025-08-22 19:14:44', NULL, 4, 'Dave Wilkins', 1, 3, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_agency_assignments`
--

CREATE TABLE `module_agency_assignments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `agency_id` int(11) NOT NULL,
  `assigned_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_agency_persons`
--

CREATE TABLE `module_agency_persons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `agency_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `is_lead` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_agency_persons`
--

INSERT INTO `module_agency_persons` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `agency_id`, `person_id`, `role_id`, `is_lead`) VALUES
(1, 1, 1, '2025-08-22 19:15:28', '2025-08-22 19:15:28', NULL, 6, 1, 185, 1),
(2, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 3, 30, 237, 1),
(3, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 4, 31, 237, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_calendar`
--

CREATE TABLE `module_calendar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `is_private` tinyint(1) DEFAULT 0,
  `is_default` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_calendar`
--

INSERT INTO `module_calendar` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `is_private`, `is_default`) VALUES
(1, 1, NULL, '2025-08-23 15:44:36', '2025-08-27 20:19:26', NULL, 'Dave', 0, 1),
(2, 1, NULL, '2025-08-27 18:51:39', '2025-08-27 20:19:35', NULL, 'LA FAMILIA DE WILKINS', 1, 0),
(4, 2, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Sean', 0, 1),
(5, 4, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Tyler', 0, 1),
(6, 5, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'RJ', 0, 1),
(7, 6, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Kasper', 0, 1),
(8, 7, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Mileny', 0, 1),
(9, 8, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Kenny', 0, 1),
(10, 9, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Richard', 0, 1),
(11, 10, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Emma', 0, 1),
(12, 11, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Tom', 0, 1),
(13, 12, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Winnie', 0, 1),
(14, 13, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Zach', 0, 1),
(15, 14, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Nancy', 0, 1),
(16, 15, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Chris', 0, 1),
(17, 18, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Alisha', 0, 1),
(18, 19, NULL, '2025-08-27 20:19:19', '2025-08-27 20:19:19', NULL, 'Davey', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_calendar_events`
--

CREATE TABLE `module_calendar_events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `calendar_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `event_type_id` int(11) DEFAULT NULL,
  `link_module` varchar(50) DEFAULT NULL,
  `link_record_id` int(11) DEFAULT NULL,
  `visibility_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_calendar_external_accounts`
--

CREATE TABLE `module_calendar_external_accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `provider` enum('google','microsoft') NOT NULL,
  `access_token` text DEFAULT NULL,
  `refresh_token` text DEFAULT NULL,
  `token_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_calendar_person_attendees`
--

CREATE TABLE `module_calendar_person_attendees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `attendee_person_id` int(11) NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_conferences`
--

CREATE TABLE `module_conferences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `event_type_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `mode` enum('ONLINE','OFFLINE','BOTH') DEFAULT 'ONLINE',
  `venue` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `timezone` varchar(64) DEFAULT NULL,
  `registration_deadline` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `organizers` varchar(255) DEFAULT NULL,
  `sponsors` varchar(255) DEFAULT NULL,
  `is_private` tinyint(1) DEFAULT 0,
  `show_ticket_count` tinyint(1) DEFAULT 1,
  `going_count` int(11) DEFAULT 0,
  `interested_count` int(11) DEFAULT 0,
  `share_count` int(11) DEFAULT 0,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `banner_image_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_conferences`
--

INSERT INTO `module_conferences` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `event_type_id`, `topic_id`, `mode`, `venue`, `country_id`, `state_id`, `city`, `start_datetime`, `end_datetime`, `timezone`, `registration_deadline`, `description`, `organizers`, `sponsors`, `is_private`, `show_ticket_count`, `going_count`, `interested_count`, `share_count`, `latitude`, `longitude`, `banner_image_id`) VALUES
(1, 1, NULL, '2025-08-27 02:09:37', '2025-08-27 02:09:37', NULL, '2025 JTI User Conference', 289, 291, 'ONLINE', 'Downtown LA', NULL, NULL, NULL, '2025-11-13 09:00:00', '2025-11-14 18:00:00', NULL, NULL, 'Idk yet', 'JTI', 'JTI', 0, 1, 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_conference_attendees`
--

CREATE TABLE `module_conference_attendees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `conference_id` int(11) NOT NULL,
  `attendee_user_id` int(11) NOT NULL,
  `status` enum('GOING','INTERESTED') DEFAULT 'GOING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_conference_images`
--

CREATE TABLE `module_conference_images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `conference_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `is_banner` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_conference_tags`
--

CREATE TABLE `module_conference_tags` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `conference_id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_conference_tags`
--

INSERT INTO `module_conference_tags` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `conference_id`, `tag`) VALUES
(1, 1, NULL, '2025-08-27 02:09:37', '2025-08-27 02:09:37', NULL, 1, 'JTI'),
(2, 1, NULL, '2025-08-27 02:09:37', '2025-08-27 02:09:37', NULL, 1, 'eCourt'),
(3, 1, NULL, '2025-08-27 02:09:37', '2025-08-27 02:09:37', NULL, 1, 'eSeries');

-- --------------------------------------------------------

--
-- Table structure for table `module_conference_ticket_options`
--

CREATE TABLE `module_conference_ticket_options` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `conference_id` int(11) NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 1, '2025-08-19 23:23:43', '2025-08-23 02:29:52', NULL, 1, 79, 69, NULL, 'Owner', NULL, 187, '2024-10-01', NULL, '4357520708', '715 W 2600 S, Nibley, 172, 84321, USA'),
(2, 2, 1, '2025-08-19 23:23:51', '2025-08-20 14:39:03', NULL, 2, 79, 69, NULL, NULL, NULL, NULL, '2025-06-11', '2025-08-31', NULL, NULL),
(3, 4, 1, '2025-08-19 23:23:54', '2025-08-26 00:22:46', NULL, 5, 78, 69, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL),
(4, 8, 1, '2025-08-20 15:13:26', '2025-08-23 02:27:57', NULL, 23, 79, 69, '2025-06-11', 'BI Analyst / Report Writer', 'Former JTI Employee.\r\nThomas and Amanda\'s old neighbor.\r\nWorked with John Wilkins at New Dawn Technologies.', 102, '2025-06-21', NULL, '4357601327', 'kennydrenolds@gmail.com, USA'),
(5, 9, 1, '2025-08-20 15:14:43', '2025-08-23 02:28:02', NULL, 24, 79, 69, NULL, NULL, NULL, NULL, NULL, NULL, '4358902363', NULL),
(6, 10, 1, '2025-08-20 20:47:36', '2025-08-23 15:03:55', NULL, 27, 78, 69, NULL, NULL, NULL, NULL, NULL, NULL, '4436179726', NULL),
(7, 11, 1, '2025-08-22 18:07:25', '2025-08-22 18:08:56', NULL, 56, 78, 69, '2025-05-01', 'Systems Analyst / Configurator / Developer ', 'Dave\'s Brother', 100, '2025-08-22', NULL, '', NULL),
(8, 13, 1, '2025-08-23 10:57:10', '2025-08-23 10:57:42', NULL, 58, 78, 69, '2025-08-23', NULL, 'Zach is an ex-JTI employee. He worked on the eCourt Implementation team(s). Very skilled.', 102, NULL, NULL, '8017875849', NULL),
(9, 15, 1, '2025-08-23 17:45:11', '2025-08-23 17:48:09', NULL, 60, 78, 69, '2025-08-23', NULL, 'Ex-JTI Employee', 102, NULL, NULL, '', NULL),
(10, 18, 1, '2025-08-24 18:26:07', '2025-08-24 18:26:07', NULL, 63, 78, 69, NULL, NULL, NULL, NULL, NULL, NULL, '4352130627', NULL);

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
(4, 1, 1, '2025-08-21 01:58:19', '2025-08-21 01:58:19', NULL, 4, 75, '2025-06-21 14:00:00', 'SENT KENNY FIRST CONTRACT AND DETAILS ABOUT SoW #172', NULL, NULL, NULL, NULL),
(5, 1, 1, '2025-08-22 18:05:17', '2025-08-22 18:05:17', NULL, 3, 76, '2025-08-22 13:30:00', 'Asked Soup if he could hop on a meeting in 30 mins to be a \'fly on the wall\'. He agreed.\r\nI also told him I\'m working on a work agreement between himself and Atlis at $58/hr.\r\nHe said he\'s been interviewing at iFIT and may get a job offer, but he currently has time to work on Mondays and Wednesday but is flexible at other times/days.', 15, NULL, NULL, NULL),
(6, 1, 1, '2025-08-22 18:09:47', '2025-08-22 18:09:47', NULL, 7, 76, '2025-08-22 13:30:00', 'Call Thomas to ask if he could join our 2pm meeting and be a \'fly on the wall\' to observe. He said yes. Meeting went well.', 15, NULL, NULL, NULL),
(7, 1, 1, '2025-08-22 18:15:55', '2025-08-22 18:15:55', NULL, 3, 76, '2025-08-22 18:15:00', 'Soup is currently collecting Unemployment. So yeah. ⬇🪑', NULL, NULL, NULL, NULL),
(8, 1, 1, '2025-08-23 02:32:30', '2025-08-23 02:32:30', NULL, 7, 75, '2025-08-22 15:48:00', 'EMAIL SENT AFTER CREATING HIS @ATLIS EMAIL ADDRESS.\r\n\r\nThomas,\r\n\r\nPlease review, sign, and return the attached Access Use Policies for the 19th Circuit Court of Lake County, IL. These will give you permission to access their systems and view confidential data on a CJIS. (Criminal Justice Information System) Some of these documents may seem (well, they are) unnecessary as they won\'t be lending you a laptop or phone, but I guess it\'s all required. They will also perform a background check, with your consent.\r\n\r\nI recommend using the free program PDF24 https://www.pdf24.org/en/ for any and all edits you make to a PDF. (I don\'t have Adobe pro)\r\n\r\nPlease notice on the document titled \"Electronic Communications-Acceptable  Cell Phone-SmartPhone Usage  Policy -7-2016\" you are asked to sign and date two different pages:\r\nThe 2nd to last and 3rd to last pages. Do not sign the very last page — that is for the Chief Judge.\r\n\r\nLet me know if you have any questions or concerns.\r\n\r\nDon\'t let the Court-jargon scare you; it\'s taken me 8 years to learn the Judicial systems... they can be very complex and confusing.', NULL, NULL, NULL, NULL),
(9, 1, 1, '2025-08-23 10:58:36', '2025-08-23 10:58:36', NULL, 8, 76, '2025-08-23 10:57:00', 'Sean Cadina had a phone call with Zach that went great. Zach appears to be very excited and interested in joining Atlis. Zach mentioned he has many contacts (about 9) of agencies / potential customers.', NULL, NULL, NULL, NULL),
(10, 1, 1, '2025-08-23 10:59:38', '2025-08-23 10:59:38', NULL, 8, 99, '2025-08-23 10:59:00', 'Dave\'s Initial out reach to Zach via text message. Asking if he\'s got time for a 10 min call today or this weekend.', NULL, NULL, NULL, NULL),
(11, 1, 1, '2025-08-23 17:48:45', '2025-08-23 17:48:45', NULL, 9, 99, '2025-08-23 21:15:00', 'Text Doc this morning to ask if he can take a 5 minute phone call.  I want to ask him about BI.', NULL, 'Busy today. Free tomorrow.', NULL, NULL),
(12, 1, 1, '2025-08-24 18:51:18', '2025-08-24 18:51:18', NULL, 10, 75, '2025-08-24 18:51:00', 'Hi Alisha,\r\nI am in need to offload some work that I could do, but just don\'t have time. I believe your expertise could help if this is something you\'re interested in.\r\nI recently rebranded from ATLIS to Atlis Technologies, and I’d love your professional help pulling together a proper Brand Kit and setting up some lightweight social media presence.\r\nFor the Brand Kit, I’m looking for:\r\nColor Palette: Primary brand color (#00948E), secondary colors, neutrals, and accent colors (with HEX, RGB, and CMYK codes).\r\nTypography: Recommended fonts (headlines, body text, digital use, print use).\r\nLogo Variations: Full logo, icon-only, text-only, light/dark backgrounds, favicon.\r\nImage & Photography Style: Example guidelines (stock images vs custom, filters, tone).\r\nBrand Voice & Tone: A few sentences describing how Atlis Technologies should “sound” in writing.\r\nUsage Guidelines: Do’s and don’ts for logo, spacing, color ratios, etc.\r\n\r\nOn the Social Media side, the goal isn’t marketing but recognition, so just the basics:\r\nCreate SM Accounts for top Networks: Facebook, X, YouTube, etc. (you already have Instagram).\r\nProfile & Cover Images: Sized correctly for each platform, with consistent branding.\r\nOne Introductory Post Per Platform: Something light, maybe an IT joke or clever “We’re here” post.\r\nBio/About Sections: Few caveats here which we\'ll have to review together.\r\nHandle Consistency: Secure @AtlisTechnologies (or the closest match) across platforms. (let me know if @AtlisTechnologies is not available)\r\nEmail, Online, & Document Graphics: Branded header/footer images for email signatures, newsletters, proposals, contracts, agreements, etc.\r\n\r\nI\'m sure you can find other items as well. I trust your expertise and creative touch — I just want Atlis Technologies to look sharp and consistent across the interwebz. \r\nI can provide you with things that you need — let me know if there is anything else you would need:\r\nAccess to the Social Media email address: socialmedia@AtlisTechnologies.com\r\nFew branding items I do have\r\n    Main brand color: #00948E\r\nFont face (.ttf or .otf) for logo\r\nFew other things I can\'t think of right now.\r\nWhat is the best and easiest way to compensate?  Dollar$ per hour? Lump sum? (I hate time tracking...)\r\nLet me know your thoughts; I\'m open to hear your preferences.', NULL, NULL, NULL, NULL);

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
(7, 1, 1, '2025-08-21 11:38:34', '2025-08-21 11:38:47', NULL, 2, 127, 'Aug_21st_2025 - request to be paid 4 days early.PNG', '/admin/contractors/uploads/2/Aug_21st_2025_-_request_to_be_paid_4_days_early.PNG', '1', 'Sean requested to be paid 4 days early, so I sent $681.82 via Venmo today, Aug 21st, at 11:30am instead of the scheduled pay date of Aug 24th. No worries. He sent the request to me over DM\'s on Slack.'),
(8, 1, 1, '2025-08-22 18:14:37', '2025-08-22 18:14:37', NULL, 3, 123, '9.4 Acceptable Use Policy Signed Jessop.pdf', '/admin/contractors/uploads/3/9.4_Acceptable_Use_Policy_Signed_Jessop.pdf', '1', 'Tyler Jessop (Soup) signed this on July 31st, 2025.'),
(9, 1, 1, '2025-08-22 18:14:45', '2025-08-22 18:14:45', NULL, 3, 124, 'CONSENT FOR BACKGROUND CHECK Jessop.pdf', '/admin/contractors/uploads/3/CONSENT_FOR_BACKGROUND_CHECK_Jessop.pdf', '1', 'Tyler Jessop (Soup) signed this on July 31st, 2025.'),
(10, 1, 1, '2025-08-22 18:14:52', '2025-08-22 18:14:52', NULL, 3, 125, 'Electronic Communications-Acceptable  Cell Phone-SmartPhone Usage  Policy -7-2016 Signed Jessop.pdf', '/admin/contractors/uploads/3/Electronic_Communications-Acceptable__Cell_Phone-SmartPhone_Usage__Policy_-7-2016_Signed_Jessop.pdf', '1', 'Tyler Jessop (Soup) signed this on July 31st, 2025.'),
(11, 1, 1, '2025-08-22 18:14:58', '2025-08-22 18:14:58', NULL, 3, 126, 'Third Party Network Access Request Form Signed Jessop.pdf', '/admin/contractors/uploads/3/Third_Party_Network_Access_Request_Form_Signed_Jessop.pdf', '1', 'Tyler Jessop (Soup) signed this on July 31st, 2025.'),
(12, 1, 1, '2025-08-23 20:18:17', '2025-08-23 20:18:17', NULL, 7, 126, 'Third Party Network Access Request Form.pdf', '/admin/contractors/uploads/7/Third_Party_Network_Access_Request_Form.pdf', '1', 'Signed 8/23/25'),
(13, 1, 1, '2025-08-23 20:18:24', '2025-08-23 20:18:24', NULL, 7, 125, 'Electronic Communications-Acceptable  Cell Phone-SmartPhone Usage  Policy -7-2016.pdf', '/admin/contractors/uploads/7/Electronic_Communications-Acceptable__Cell_Phone-SmartPhone_Usage__Policy_-7-2016.pdf', '1', 'Signed 8/23/25'),
(14, 1, 1, '2025-08-23 20:18:32', '2025-08-23 20:18:32', NULL, 7, 124, 'CONSENT FOR BACKGROUND CHECK - Lake County, IL.pdf', '/admin/contractors/uploads/7/CONSENT_FOR_BACKGROUND_CHECK_-_Lake_County__IL.pdf', '1', 'Signed 8/23/25'),
(15, 1, 1, '2025-08-23 20:18:47', '2025-08-23 20:18:47', NULL, 7, 123, '9.4 Acceptable Use Policy CONTINGENT WORKERwith Signature Lines.pdf', '/admin/contractors/uploads/7/9.4_Acceptable_Use_Policy_CONTINGENT_WORKERwith_Signature_Lines.pdf', '1', 'Signed 8/23/25'),
(16, 1, 1, '2025-08-23 20:19:21', '2025-08-23 20:19:21', NULL, 7, 73, 'ATLIS TECHNOLOGIES WORK AGREEMENT - THOMAS WILKINS - ATLIS_SIGNED.pdf', '/admin/contractors/uploads/7/ATLIS_TECHNOLOGIES_WORK_AGREEMENT_-_THOMAS_WILKINS_-_ATLIS_SIGNED.pdf', '1', 'SENT FOR SIGNATURE - 8/23/25');

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

--
-- Dumping data for table `module_contractors_notes`
--

INSERT INTO `module_contractors_notes` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `contractor_id`, `note_text`) VALUES
(1, 1, 1, '2025-08-22 18:53:34', '2025-08-22 18:53:34', NULL, 7, 'Created an Atlis Technologies Office365 account for him:\r\nTom@AtlisTechnologies.com'),
(2, 1, 1, '2025-08-22 18:53:58', '2025-08-22 18:53:58', NULL, 3, 'Created an Atlis Technologies Office 365 account for him: Soup@AtlisTechnologies.com'),
(3, 1, 1, '2025-08-23 20:20:08', '2025-08-23 20:20:08', NULL, 7, 'Sent a signed work agreement in the contract said 5 hours per week at $60/hr.'),
(4, 1, 1, '2025-08-23 20:21:02', '2025-08-23 20:21:02', NULL, 3, 'Sent a signed work agreement and in the contract put in 5 hours per week at $58/hr and to invoice every ~2 weeks.'),
(5, 1, 1, '2025-08-23 20:24:10', '2025-08-23 20:24:10', NULL, 5, 'Richard has helped Atlis for I\'m guessing around 8 hours of creating templates for contracts. I need to compensate him somehow soon. I also need him, or a different technical contract writer, to be much more involved.'),
(6, 1, 1, '2025-08-23 20:24:27', '2025-08-23 20:24:27', NULL, 5, 'I NEED TO UPDATE RICHARD\'S WORK AGREEMENT WITH ATLIS.');

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
  `status` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_division`
--

INSERT INTO `module_division` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `agency_id`, `name`, `main_person`, `status`, `file_name`, `file_path`, `file_size`, `file_type`) VALUES
(1, 1, 1, '2025-08-06 16:27:41', '2025-08-25 01:06:12', NULL, 1, 'Atlis', 1, 5, 'main_logo.png', '79c33383fb29f1fa912221172d822412.png', 65851, 'image/png'),
(2, 1, 1, '2025-08-06 16:28:28', '2025-08-24 19:28:18', NULL, 2, 'Judicial Information Services & Technology', 57, 5, NULL, NULL, NULL, NULL),
(3, 1, 1, '2025-08-06 16:28:37', '2025-08-08 21:58:10', NULL, 2, 'Business Operations', NULL, 5, NULL, NULL, NULL, NULL),
(4, 1, 1, '2025-08-06 16:28:48', '2025-08-08 21:58:10', NULL, 2, 'Court Clerks', NULL, 5, NULL, NULL, NULL, NULL),
(5, 1, 1, '2025-08-21 02:22:59', '2025-08-21 15:48:10', NULL, 3, 'Public Defender', 30, 6, NULL, NULL, NULL, NULL),
(8, 1, 1, '2025-08-22 19:14:53', '2025-08-22 19:14:53', NULL, 6, 'Dave', 1, 5, NULL, NULL, NULL, NULL),
(9, 1, 1, '2025-08-23 01:38:10', '2025-08-23 01:38:10', NULL, 4, 'State\'s Attorney Office', 31, 27, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_division_persons`
--

CREATE TABLE `module_division_persons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `division_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `is_lead` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_division_persons`
--

INSERT INTO `module_division_persons` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `division_id`, `person_id`, `role_id`, `is_lead`) VALUES
(1, 1, 1, '2025-08-22 19:15:35', '2025-08-22 19:15:35', NULL, 8, 1, 186, 1),
(2, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 5, 30, 238, 1),
(3, 1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 9, 31, 238, 1),
(5, 1, 1, '2025-08-24 19:28:15', '2025-08-24 19:28:15', NULL, 2, 57, 186, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_feedback`
--

CREATE TABLE `module_feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_feedback`
--

INSERT INTO `module_feedback` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `title`, `description`, `type`) VALUES
(7, 1, 1, '2025-08-25 01:51:16', '2025-08-25 01:51:16', NULL, 'Project --> Task Assignment Removes', 'When checking or unchecking a Task on the Projects Details view, the assigned user(s) Profile Pictures are removed though they don\'t actually get removed in the database.', 189),
(8, 1, 1, '2025-08-25 02:01:38', '2025-08-25 02:01:38', NULL, 'MEETINGS Module - several bugs', '- Can\'t edit a Meeting\r\n- Agenda items not showing\r\n- Attendees not saving or showing\r\n- Attachments not saving.', 189),
(9, 1, 1, '2025-08-25 02:03:13', '2025-08-25 02:03:13', NULL, 'Edit Product/Service', '- On Edit Product/Service, Dropzone JS isn\'t working', 189);

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
-- Table structure for table `module_meetings`
--

CREATE TABLE `module_meetings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `recur_daily` tinyint(1) DEFAULT 0,
  `recur_weekly` tinyint(1) DEFAULT 0,
  `recur_monthly` tinyint(1) DEFAULT 0,
  `calendar_event_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_meetings`
--

INSERT INTO `module_meetings` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `title`, `description`, `start_time`, `end_time`, `recur_daily`, `recur_weekly`, `recur_monthly`, `calendar_event_id`, `status_id`, `type_id`) VALUES
(1, 1, 1, '2025-08-27 21:39:15', '2025-08-27 21:49:07', NULL, 'Atlis - Dave + Sean', '', '2025-08-26 14:00:00', NULL, 0, 0, 0, NULL, NULL, 204);

-- --------------------------------------------------------

--
-- Table structure for table `module_meeting_agenda`
--

CREATE TABLE `module_meeting_agenda` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `meeting_id` int(11) NOT NULL,
  `order_index` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `linked_task_id` int(11) DEFAULT NULL,
  `linked_project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_meeting_agenda`
--

INSERT INTO `module_meeting_agenda` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `meeting_id`, `order_index`, `title`, `status_id`, `linked_task_id`, `linked_project_id`) VALUES
(1, 1, 1, '2025-08-27 21:49:07', '2025-08-27 22:19:09', NULL, 1, 1, 'test 1', 226, NULL, NULL),
(2, 1, 1, '2025-08-27 21:49:07', '2025-08-27 22:19:09', NULL, 1, 2, 'test 2', 227, NULL, NULL),
(3, 1, 1, '2025-08-27 21:49:07', '2025-08-27 22:19:09', NULL, 1, 3, 'test 3', 226, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_meeting_attendees`
--

CREATE TABLE `module_meeting_attendees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `meeting_id` int(11) NOT NULL,
  `attendee_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_meeting_attendees`
--

INSERT INTO `module_meeting_attendees` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `meeting_id`, `attendee_user_id`) VALUES
(1, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 1, 1),
(2, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `module_meeting_files`
--

CREATE TABLE `module_meeting_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `meeting_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploader_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_meeting_questions`
--

CREATE TABLE `module_meeting_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `meeting_id` int(11) DEFAULT NULL,
  `agenda_id` int(11) DEFAULT NULL,
  `question_text` text NOT NULL,
  `answer_text` text DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_meeting_questions`
--

INSERT INTO `module_meeting_questions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `meeting_id`, `agenda_id`, `question_text`, `answer_text`, `status_id`) VALUES
(1, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 1, NULL, 'When should we schedule the restart?', '', NULL),
(2, 1, 1, '2025-08-27 21:49:07', '2025-08-27 21:49:07', NULL, 1, NULL, 'JOSEPH, WHERE DO YOU RECOMMEND WE START ?', '', NULL);

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
  `status` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_organization`
--

INSERT INTO `module_organization` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `main_person`, `status`, `file_name`, `file_path`, `file_size`, `file_type`) VALUES
(1, 1, 1, '2025-08-06 16:27:19', '2025-08-25 01:05:45', NULL, 'Atlis Technologies LLC', 1, 1, 'main_logo_AT_dark_text_white_bg.png', '2b38147e1806b4784eb93b035ffc6ed6.png', 82972, 'image/png'),
(2, 1, 1, '2025-08-06 16:27:55', '2025-08-24 19:27:16', NULL, 'Lake County, IL', NULL, 1, NULL, NULL, NULL, NULL),
(4, 1, 1, '2025-08-22 19:14:26', '2025-08-22 19:15:03', NULL, 'David Cottrell Wilkins', 1, 1, '10724_1188846233580_1001052977_30591197_3009316_n.jpg', 'f9da8c9bf924ef5b484df0f5404c1789.jpg', 54807, 'image/jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `module_organization_persons`
--

CREATE TABLE `module_organization_persons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `organization_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `is_lead` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_organization_persons`
--

INSERT INTO `module_organization_persons` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `organization_id`, `person_id`, `role_id`, `is_lead`) VALUES
(1, 1, 1, '2025-08-22 19:15:11', '2025-08-22 19:15:11', NULL, 4, 1, 184, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_products_services`
--

CREATE TABLE `module_products_services` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_products_services`
--

INSERT INTO `module_products_services` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `name`, `type_id`, `status_id`, `description`, `price`) VALUES
(6, 1, 1, '2025-08-24 18:22:30', '2025-08-24 19:50:47', 'test 2', 'Business Intelligence', 215, 235, 'test', 69.69),
(7, 1, 1, '2025-08-24 18:22:49', '2025-08-24 18:22:49', '', 'test', NULL, 0, 'test', NULL),
(8, 1, 1, '2025-08-24 18:23:00', '2025-08-24 18:23:00', '', 'test', NULL, 0, 'test', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_products_services_category`
--

CREATE TABLE `module_products_services_category` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `product_service_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_products_services_person`
--

CREATE TABLE `module_products_services_person` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `product_service_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `skill_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_products_services_person`
--

INSERT INTO `module_products_services_person` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `product_service_id`, `person_id`, `skill_id`) VALUES
(3, 1, 1, '2025-08-24 18:23:00', '2025-08-24 18:23:00', NULL, 8, 60, 0),
(4, 1, 1, '2025-08-24 18:23:00', '2025-08-24 18:23:00', NULL, 8, 1, 0),
(6, 1, 1, '2025-08-24 19:50:47', '2025-08-24 19:50:47', NULL, 6, 1, 217);

-- --------------------------------------------------------

--
-- Table structure for table `module_products_services_price_history`
--

CREATE TABLE `module_products_services_price_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `product_service_id` int(11) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `new_price` decimal(10,2) NOT NULL,
  `changed_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `is_private` tinyint(1) NOT NULL DEFAULT 0,
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

INSERT INTO `module_projects` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `agency_id`, `division_id`, `is_private`, `name`, `description`, `requirements`, `specifications`, `status`, `priority`, `type`, `start_date`, `complete_date`, `completed`) VALUES
(1, 1, 1, '2025-08-19 23:01:08', '2025-08-19 23:04:25', NULL, 2, 2, 0, 'Emailing Sealed Documents (E.S.D)', '', '', '', 29, 56, NULL, '2025-08-01', NULL, 0),
(2, 1, 1, '2025-08-19 23:02:03', '2025-08-19 23:24:13', NULL, 2, 3, 0, 'Bench View', '', '', '', 29, 58, NULL, '2025-08-01', NULL, 0),
(3, 1, 1, '2025-08-20 00:15:31', '2025-08-20 00:42:24', NULL, 2, 2, 0, 'Fee Waiver Icon in Case Header', '', '', '', 31, 57, NULL, '2025-04-26', NULL, 0),
(4, 1, 1, '2025-08-21 15:38:14', '2025-08-23 20:26:14', NULL, 1, 1, 1, 'ATLIS TECHNOLOGIES - CORE PROJECT', '', '', '', 213, NULL, NULL, '2025-08-21', NULL, 0),
(5, 1, 1, '2025-08-21 18:08:35', '2025-08-21 18:08:35', NULL, 2, 3, 0, 'Judge Mass Reassignment', 'Hi Gia & Davey,\r\n\r\nDo you have any specific requirements or specifications for the Judge Mass Reassignment project? I don’t want to make this any more complex than necessary—at a high level, it should be straightforward. For the sake of example, Judge A is the retiring judge and Judge B is the newly assigned judge.\r\n\r\n\r\nThanks,\r\nDave\r\n', '1) What gets reassigned\r\n-	Reassign all future events currently assigned to Judge A over to Judge B.\r\no	“All” assumes no filters (Case Type, Event Type, etc.).\r\no	“Future” assumes we are not modifying past events.\r\n-	Should any case-level or caseAssignment fields also be updated (for Judge A and/or Judge B)?\r\n\r\n\r\n2) Audit, validation, and proof checking\r\n-	Do you need audit artifacts (e.g., before/after counts, per-case change logs with timestamp/user, downloadable CSV)?\r\n-	Should we add guardrails (e.g., exclude sealed/closed cases, skip in-progress or same-day events)?\r\n\r\n\r\n3) Execution & UX\r\n-	Once Judge A → Judge B is selected, should the process run automatically in the background, or would you prefer a preview/confirm step with progress tracking?\r\n-	Would a summary be useful (e.g., via Search, Report, or Email notification)?', '', 29, NULL, NULL, '2025-08-21', NULL, 0),
(6, 1, 1, '2025-08-21 22:22:02', '2025-08-21 22:22:02', NULL, 1, 1, 0, 'McLean County, IL', '', '', '', 29, 56, NULL, '2025-08-21', NULL, 0),
(7, 1, 1, '2025-08-21 22:25:38', '2025-08-21 22:25:38', NULL, 1, 1, 0, 'JIT 2025 User Conference', '', '', '', 30, 87, NULL, '2025-11-13', NULL, 0),
(9, 1, 1, '2025-08-22 14:51:43', '2025-08-22 14:51:43', NULL, 2, 2, 0, 'Multiple Interpreter per Event', '', '', '', 29, 57, NULL, '0000-00-00', NULL, 0),
(10, 1, 1, '2025-08-22 18:00:14', '2025-08-23 01:48:19', NULL, 6, 8, 1, 'DAVE WILKINS', '', '', '', 29, 87, NULL, '2025-08-01', NULL, 0),
(11, 1, 1, '2025-08-22 18:10:32', '2025-08-22 18:10:32', NULL, 2, 2, 0, 'MEETINGS WITH JIS TEAM @ LAKE', '', '', '', 29, 87, 182, '2025-08-22', NULL, 0),
(12, 1, 1, '2025-08-22 18:12:14', '2025-08-23 01:47:59', NULL, 1, 1, 1, 'ATLIS - Onboard Tyler Jessop', 'SOUP\r\n	✔ LAKE AUPs\r\n	✔ FULL NAME & BIRTHDAY\r\n	ATLIS CONTRACT & DOCS', '', '', 29, 56, NULL, '0001-11-30', NULL, 0),
(13, 1, 1, '2025-08-22 18:19:20', '2025-08-22 18:19:20', NULL, 1, 1, 0, 'ATLISWARE - ADDITIONS', '', '', '', 29, 87, 182, '2025-08-01', NULL, 0),
(14, 1, 1, '2025-08-22 18:47:19', '2025-08-25 01:49:19', NULL, 1, 1, 1, 'ONBOARD Tom Wilkins', '', '', '', 31, 87, NULL, '2025-08-22', NULL, 0),
(15, 1, 1, '2025-08-22 18:56:22', '2025-08-25 01:51:37', NULL, 6, 8, 1, '2025 Kia Telluride SX-Prestige X-Line', '', '', '', 29, 87, NULL, '0001-11-30', NULL, 0),
(16, 1, 1, '2025-08-22 18:57:00', '2025-08-22 18:57:00', NULL, 1, 1, 0, 'RANDOM NOTES', '', '', '', 55, 57, 182, '0000-00-00', NULL, 0),
(17, 1, 1, '2025-08-22 18:57:34', '2025-08-22 18:57:34', NULL, 1, 1, 0, 'CJIS TESTS', '', '', '', 29, 56, 182, '2025-08-01', NULL, 0),
(18, 1, 1, '2025-08-22 23:50:12', '2025-08-24 15:44:08', NULL, 1, 1, 0, 'SoW #172 - Updates to AOIC Reports', '', '', '', 29, 56, 183, '2025-06-01', NULL, 0),
(19, 1, 1, '2025-08-22 23:51:43', '2025-08-22 23:51:43', NULL, 2, 2, 0, 'SoW #175 - eGAL Project', '', '', '', 188, 56, 183, '2025-08-22', NULL, 0),
(20, 1, 1, '2025-08-23 12:00:40', '2025-08-23 12:00:40', NULL, 6, 8, 0, 'DAVE - AROUND THE HOUSE', '', '', '', 29, 56, 182, '2025-08-23', NULL, 0),
(21, 1, 1, '2025-08-23 17:53:36', '2025-08-23 17:53:56', NULL, 6, 8, 1, 'DAVE - FILE CABINET', '', '', '', 29, 57, NULL, '2025-08-23', NULL, 0),
(22, 1, 1, '2025-08-23 20:25:05', '2025-08-23 20:25:05', NULL, 1, 1, 0, 'ATLIS TECHNOLOGIES - CORPORATE PROJECTS', '', '', '', 29, 87, 182, '2025-08-23', NULL, 0),
(23, 1, 1, '2025-08-24 11:32:06', '2025-08-24 11:32:06', NULL, 1, 1, 0, 'INITIAL CALL WITH ZACH JENKS', '', '', '', 55, 58, 182, '2025-08-24', NULL, 0),
(24, 1, 1, '2025-08-26 22:38:30', '2025-08-26 22:38:30', NULL, 2, 2, 0, '***NEWEST*** CURRENT PROJECTS !', 'HIGHEST PRIORITY OF CURRENT PROJECTS FOR LAKE COUNTY, IL 19TH CIRCUIT COURT\r\nINCLUDING 3 DIFFERENT DEPARTMENTS: JIS, BIZ OPS, AND COURT CLERKS', '', '', 29, 87, 182, '2025-08-26', NULL, 0),
(26, 1, 1, '2025-08-26 22:42:00', '2025-08-26 22:42:00', NULL, 1, 1, 0, 'test 1', '', '', '', 55, 58, 182, '0000-00-00', NULL, 0),
(27, 1, 1, '2025-08-26 22:46:48', '2025-08-26 22:46:48', NULL, 1, 1, 0, 'test 3', '', '', '', 55, 58, 182, '0000-00-00', NULL, 0),
(28, 1, 1, '2025-08-26 22:46:57', '2025-08-26 22:46:57', NULL, 1, 8, 0, 'sadfasdf', 'asdfsadf', '', '', 55, 58, 182, '0000-00-00', NULL, 0),
(29, 1, 1, '2025-08-27 21:52:16', '2025-08-27 21:52:16', NULL, NULL, NULL, 0, 'test 69', 'test 69', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_projects_answers`
--

CREATE TABLE `module_projects_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects_answers`
--

INSERT INTO `module_projects_answers` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `question_id`, `answer_text`) VALUES
(2, 1, 1, '2025-08-23 11:04:36', '2025-08-23 11:04:36', NULL, 2, 'White, dummy.'),
(3, 1, 1, '2025-08-23 11:04:46', '2025-08-23 11:04:46', NULL, 2, 'Yeah, it was obviously white.'),
(4, 1, 1, '2025-08-24 01:18:18', '2025-08-24 01:18:18', NULL, 3, 'Bob Saggit.'),
(6, 1, 1, '2025-08-24 02:09:11', '2025-08-24 02:09:11', NULL, 5, 'test 2');

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
(16, 1, 1, '2025-08-21 22:30:04', '2025-08-21 22:30:04', NULL, 7, 4),
(17, 1, 1, '2025-08-22 19:19:52', '2025-08-22 19:19:52', NULL, 15, 1),
(18, 1, 1, '2025-08-23 00:25:58', '2025-08-23 00:25:58', NULL, 10, 1),
(19, 1, 1, '2025-08-23 00:26:05', '2025-08-23 00:26:05', NULL, 12, 1),
(20, 1, 1, '2025-08-23 00:26:11', '2025-08-23 00:26:11', NULL, 17, 1),
(21, 1, 1, '2025-08-23 01:48:43', '2025-08-23 01:48:43', NULL, 16, 1),
(22, 1, 1, '2025-08-23 01:48:51', '2025-08-23 01:48:51', NULL, 14, 1),
(23, 1, 1, '2025-08-23 12:03:54', '2025-08-23 12:03:54', NULL, 20, 1),
(24, 1, 1, '2025-08-23 12:08:49', '2025-08-23 12:08:49', NULL, 13, 1),
(25, 1, 1, '2025-08-23 17:53:53', '2025-08-23 17:53:53', NULL, 21, 1),
(26, 1, 1, '2025-08-24 01:42:46', '2025-08-24 01:42:46', NULL, 22, 1),
(27, 1, 1, '2025-08-24 21:29:33', '2025-08-24 21:29:33', NULL, 11, 1);

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
  `folder_id` int(11) DEFAULT NULL,
  `note_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
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

INSERT INTO `module_projects_files` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`, `folder_id`, `note_id`, `question_id`, `description`, `file_type_id`, `status_id`, `sort_order`, `file_name`, `file_path`, `file_size`, `file_type`) VALUES
(1, 1, 1, '2025-08-20 00:40:59', '2025-08-25 22:53:06', NULL, 3, 2, NULL, NULL, NULL, NULL, NULL, 0, 'Capture43434.PNG', '/module/project/uploads/3/project_3_1755672059_Capture43434.PNG', 136873, 'image/png'),
(2, 1, 1, '2025-08-20 00:40:59', '2025-08-25 22:53:06', NULL, 3, 2, NULL, NULL, NULL, NULL, NULL, 0, 'DOCUMENT THIS WHAT I DID FOR LAKE FOR NEW ICON IN HEADER.txt', '/module/project/uploads/3/project_3_1755672059_DOCUMENT_THIS_WHAT_I_DID_FOR_LAKE_FOR_NEW_ICON_IN_HEADER.txt', 1910, 'text/plain'),
(3, 1, 1, '2025-08-20 00:40:59', '2025-08-25 22:53:06', NULL, 3, 2, NULL, NULL, NULL, NULL, NULL, 0, 'Feedback from CC and Leah Balzer.txt', '/module/project/uploads/3/project_3_1755672059_Feedback_from_CC_and_Leah_Balzer.txt', 886, 'text/plain'),
(4, 1, 1, '2025-08-20 00:40:59', '2025-08-25 22:53:06', NULL, 3, 2, NULL, NULL, NULL, NULL, NULL, 0, 'FeeWaiver Entity.PNG', '/module/project/uploads/3/project_3_1755672059_FeeWaiver_Entity.PNG', 291893, 'image/png'),
(5, 1, 1, '2025-08-20 00:40:59', '2025-08-25 22:53:06', NULL, 3, 2, NULL, NULL, NULL, NULL, NULL, 0, 'unnamed (2).png', '/module/project/uploads/3/project_3_1755672059_unnamed__2_.png', 10562, 'image/png'),
(6, 1, 1, '2025-08-23 00:24:52', '2025-08-25 22:53:06', NULL, 10, 3, 14, NULL, NULL, NULL, NULL, 0, 'FirstContactLetterV1DAVEWILKINS1755891275718.pdf', '/module/project/uploads/10/project_10_1755930292_0_FirstContactLetterV1DAVEWILKINS1755891275718.pdf', 106685, 'application/pdf'),
(7, 1, 1, '2025-08-24 09:55:07', '2025-08-25 22:53:06', NULL, 15, 4, NULL, NULL, NULL, NULL, NULL, 0, 'Screen Shot 2021-08-04 at 4.20.27 PM (1).png', '/module/project/uploads/15/project_15_1756050907_Screen_Shot_2021-08-04_at_4.20.27_PM__1_.png', 27996, 'image/png'),
(8, 1, 1, '2025-08-24 09:55:20', '2025-08-25 22:53:06', NULL, 15, 4, NULL, NULL, NULL, NULL, NULL, 0, '7-hydroxymitragynin_7-oh_an_assessment_of_the_scientific_data_and_toxicological_concerns_around_an_emerging_opioid_threat.pdf', '/module/project/uploads/15/project_15_1756050920_7-hydroxymitragynin_7-oh_an_assessment_of_the_scientific_data_and_toxicological_concerns_around_an_emerging_opioid_threat.pdf', 649344, 'application/pdf'),
(9, 1, 1, '2025-08-24 21:44:13', '2025-08-25 22:53:06', NULL, 18, 5, 17, NULL, NULL, NULL, NULL, 0, 'SoW #172 - RESTART ASSIGNMENTS.xlsx', '/module/project/uploads/18/project_18_1756093453_0_SoW__172_-_RESTART_ASSIGNMENTS.xlsx', 16465, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
(10, 1, 1, '2025-08-24 21:45:07', '2025-08-25 22:53:06', NULL, 18, 5, 18, NULL, NULL, NULL, NULL, 0, 'DataDictionary-LakeCountyCourt(n1)-2025-08-24.xls', '/module/project/uploads/18/project_18_1756093507_0_DataDictionary-LakeCountyCourt_n1_-2025-08-24.xls', 5015040, 'application/vnd.ms-excel'),
(11, 1, 1, '2025-08-24 21:45:29', '2025-08-25 22:53:06', NULL, 18, 5, 19, NULL, NULL, NULL, NULL, 0, 'lookuplists-CASE_STATUS-LakeCountyCourt(n1)-2025-08-24.xls', '/module/project/uploads/18/project_18_1756093529_0_lookuplists-CASE_STATUS-LakeCountyCourt_n1_-2025-08-24.xls', 17920, 'application/vnd.ms-excel'),
(12, 1, 1, '2025-08-24 21:45:29', '2025-08-25 22:53:06', NULL, 18, 5, 19, NULL, NULL, NULL, NULL, 0, 'lookuplists-CASE_STATUS-LakeCountyCourt(n1)-2025-08-24.xml', '/module/project/uploads/18/project_18_1756093529_1_lookuplists-CASE_STATUS-LakeCountyCourt_n1_-2025-08-24.xml', 56300, 'text/xml'),
(13, 1, 1, '2025-08-24 22:35:48', '2025-08-25 22:53:06', NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, 0, '_BENCH VIEW_.xlsx', '/module/project/uploads/2/project_2_1756096548__BENCH_VIEW_.xlsx', 20634, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
(14, 1, 1, '2025-08-24 22:35:51', '2025-08-25 22:53:06', NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, 0, 'Seal Type Badge in Doc Viewer', '/module/project/uploads/2/project_2_1756096551_Seal_Type_Badge_in_Doc_Viewer', 0, 'application/octet-stream'),
(15, 1, 1, '2025-08-26 13:36:41', '2025-08-26 13:36:41', NULL, 4, NULL, 21, NULL, NULL, NULL, NULL, 0, 'joke-missed.gif', '/module/project/uploads/project_4_1756237001_0_joke-missed.gif', 12184, 'image/gif');

-- --------------------------------------------------------

--
-- Table structure for table `module_projects_folders`
--

CREATE TABLE `module_projects_folders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects_folders`
--

INSERT INTO `module_projects_folders` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`, `parent_id`, `name`, `path`) VALUES
(1, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 2, NULL, 'root', '/module/project/uploads/2/'),
(2, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 3, NULL, 'root', '/module/project/uploads/3/'),
(3, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 10, NULL, 'root', '/module/project/uploads/10/'),
(4, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 15, NULL, 'root', '/module/project/uploads/15/'),
(5, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 18, NULL, 'root', '/module/project/uploads/18/');

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
(5, 1, 1, '2025-08-21 22:29:33', '2025-08-21 22:29:33', NULL, 7, 'Registration: https://info.journaltech.com/uc2025-registration\r\n\r\nEvent Summary & Notes:\r\nWelcome Reception: Nov 12, 2025, 7:00 - 9:00 PM\r\nConference Dates: Nov 13-14, 2025\r\nConference Location: 4th Floor, Hudson Loft, 1200 S Hope St, Los Angeles, CA 90015\r\nEarly-Bird Registration (through July 15, 2025): $495\r\nStandard Registration (starting July 16-November 12, 2025): $595\r\nContact events@journaltech.com for group discounts of 3+ attendees of your organization.'),
(6, 1, 1, '2025-08-22 14:52:00', '2025-08-22 14:52:00', NULL, 9, 'Metadata IS in Aux already. Cf_interpreter COLLECTION/ENTITY'),
(10, 1, 1, '2025-08-22 18:56:33', '2025-08-22 18:56:33', NULL, 15, 'CALL WITH SKYLER\r\nAUG 21st, 2025 @ 11am\r\n\r\n2 YEARS FROM KIA\r\n3 YEARS FROM AFCU\r\n5 YEAR TOTAL\r\n\r\nMAINTENANCE\r\n\r\n--> 9 FREE OIL CHANGES\r\n--> TIRE CHANGES\r\n\r\n--> WARRANTY / RECALL WORK MUST BE THROUGH KIA DEALERSHIP\r\n\r\n--> IF THERE IS A REMEDY, KIA WILL FIX THE RECALLS BEFORE I DRIVE IT OFF\r\n\r\n--> SKYLER SAYS IF PLANNING TO HOLD THE LOAN LONGER THAN 2 YEARS, FINANCE WITH AFCU.  OTHERWISE LESS THAN 2 YEARS, GO WITH KIA TO GET THE REBATE.\r\n\r\n\r\nEXTENDED WARRANTY (service contract)\r\n--> couple G\'s to bump up.\r\n--> electronic *could* be extended.\r\n--> SKYLER RECOMMENDS EXTENDING THE WARRANTIES \r\n--> GAP IS $1,000 - $1,200 AT THE KIA STEALERSHIP\r\n	--> \r\n\r\nFINANCE MANAGER:\r\n	- TRADEOFFS BETWEEN FINANCING WITH KIA & AFCU\r\n	- PULL MY CREDIT AGAIN...?\r\n	- HOW MUCH IS GAP ? \r\n		--> (price match AFCU ? )\r\n	- 90 DAYS OF NO PAYMENT ?\r\n		--> (match AFCU ? )\r\n	- extend few of the standard warranties just before they expire ?'),
(11, 1, 1, '2025-08-22 18:57:13', '2025-08-22 18:57:13', NULL, 16, 'GITHUB MERGE CONFLICT MARKERS:\r\n (<<<<<<<, =======, >>>>>>>)'),
(12, 1, 1, '2025-08-22 18:58:57', '2025-08-22 18:58:57', NULL, 11, 'E.S.D.\r\n	--> remaining tasks for both Atlis and Lake\r\n	--> timeline\r\n\r\n\r\nGAL\r\n	--> eDefender Admin Access\r\n		- I emailed Winnie\r\n\r\n\r\n\r\nJUDGE MASS REASSIGNMENT\r\n\r\n\r\n\r\nRESTART\r\n\r\n\r\nJTI USER CONFERENCE'),
(13, 1, 1, '2025-08-22 18:59:26', '2025-08-22 18:59:26', NULL, 1, '- EMAIL SUBJECT AND BODY TEMPLATE\r\n\r\n- ACTUAL GENERIC EMAIL ADDRESSES FOR eCOURT, ePROS, & eDEF\r\n\r\n\r\n- COLOR CODED SEAL TYPE IN DOCUMENTS MANAGER\r\n	--> EMAIL WINNIE (cc Leah, RJ, Kasper) WITH SCREENSHOT\r\n		--> WINNIE WILL SCHEDULE DEMO WITH JUDGE NOVAK & Court Clerks\r\n\r\n	--> JUDGE NOVAK MENTIONED NEW REGULATIONS\r\n\r\n\r\nRISKS\r\n	-> How Keith & Lonnie will receive this solution.\r\n	-> \"Turning off\" the eCourt Viewer in ePros & eDef.\r\n\r\n\r\n\r\nQUESTIONS\r\n	--> Who will \"turn off\" the Court Viewer in ePros & eDef ?\r\n		- I can do it, I just need admin access to ePros & eDef.\r\n\r\n	--> email Winnie: ask email Lonnie & Keith separately\r\n		- RJ says ask this after we demo to them.\r\n\r\n\r\n\r\n--------------------\r\nJUDGE MASS REASSIGNMENT\r\n	- ask Davey R. if he can hop on our 3pm CST meeting to discuss.\r\n--------------------\r\n\r\n\r\n\r\nhttps://www.ncsc.org/event/court-technology-conference-ctc\r\n--------------------\r\n\r\n\r\ngia + winnie are going to JTI User conf\r\n\r\n\r\nMcCLEAN COUNTY, IL (maybe 11th?)\r\n- Craig Nelson\r\n\r\n\r\n- not Don Everhart\r\n\r\nhttps://www.illinoiscourts.gov/courts-directory/34/McLean-County-Law-and-Justice-Center/court/'),
(14, 1, 1, '2025-08-23 00:24:52', '2025-08-23 00:25:29', NULL, 10, 'Damage information related to claim # 22930134 with ENTERPRISE\nInbox\n\nDamage Recovery Unit <DRU3@ehi.com>\nAttachments\nFri, Aug 22, 1:34 PM (10 hours ago)\nto me\n\nPlease review the important documentation attached that is related to damage claim #22930134\n\n\nIMPORTANT: This e-mail (including any attachments) is intended for the use of the individual or entity to which it is addressed and may contain information that is classified, private, or confidential. If the reader of this message is not the intended recipient, or the employee or agent responsible for delivering the message to the intended recipient, you are hereby notified that any dissemination, distribution, or copying of this communication is prohibited. If you have received this communication in error, please notify us immediately by replying to this e-mail and then deleting the email and attachments. Thank you.'),
(15, 1, 1, '2025-08-23 15:54:59', '2025-08-23 15:54:59', NULL, 7, 'For fiscal year 2025, the per diem rate for Los Angeles is $191 per night for lodging and $86 per day for Meals and Incidental Expenses (M&IE), totaling $277 per day. These rates are set by the General Services Administration (GSA) for official government travel and are higher than the standard rate due to Los Angeles\' high cost of living. \r\nBreakdown of the Los Angeles Per Diem Rate (FY 2025) \r\nLodging: $191\r\nMeals and Incidental Expenses (M&IE): $86\r\nTotal: $277\r\nKey Points\r\nGSA Rates:\r\nThese rates are for federal government employees traveling for official business. \r\nHigh-Cost Area:\r\nLos Angeles is considered a high-cost area, which results in a higher per diem allowance compared to the standard rate. \r\nEmployer\'s Accountable Plan:\r\nFor non-government employees, employer\'s accountable plans often use these GSA rates to reimburse employees for travel expenses. \r\nFirst and Last Day:\r\nOn your first and last day of travel, you may only be eligible for 75% of the M&IE rate.'),
(16, 1, 1, '2025-08-23 15:55:21', '2025-08-23 15:55:21', NULL, 7, 'https://www.gsa.gov/travel/plan-book/per-diem-rates'),
(17, 1, 1, '2025-08-24 21:44:13', '2025-08-24 21:44:13', NULL, 18, 'Met with Kenny tonight. 8/24/25 at 9pm. We reviewed our new tasks from the Addendum / new scope.  Biggest hurdle will be getting new metadata created and scheduling a Restart in PROD.'),
(18, 1, 1, '2025-08-24 21:45:07', '2025-08-24 21:45:07', NULL, 18, 'Data Dictionary - as of Aug 24th, 2025.'),
(19, 1, 1, '2025-08-24 21:45:29', '2025-08-24 21:45:29', NULL, 18, 'CASE_STATUS Lookup List export (xml and xls)'),
(20, 1, 1, '2025-08-25 01:49:09', '2025-08-25 01:49:09', NULL, 14, 'Done. It\'s official.'),
(21, 1, 1, '2025-08-26 13:36:41', '2025-08-26 13:36:41', NULL, 4, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `module_projects_pins`
--

CREATE TABLE `module_projects_pins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects_pins`
--

INSERT INTO `module_projects_pins` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`) VALUES
(1, 1, 1, '2025-08-23 01:39:13', '2025-08-23 01:39:13', NULL, 15),
(2, 1, 1, '2025-08-23 01:45:35', '2025-08-23 01:45:35', NULL, 12),
(3, 1, 1, '2025-08-23 01:48:03', '2025-08-23 01:48:03', NULL, 4),
(9, 1, 1, '2025-08-23 02:26:45', '2025-08-23 02:26:45', NULL, 2),
(11, 1, 1, '2025-08-24 00:24:23', '2025-08-24 00:24:23', NULL, 22),
(12, 1, 1, '2025-08-24 00:25:39', '2025-08-24 00:25:39', NULL, 20),
(15, 1, 1, '2025-08-24 01:37:42', '2025-08-24 01:37:42', NULL, 21),
(18, 1, 1, '2025-08-24 01:47:02', '2025-08-24 01:47:02', NULL, 11),
(19, 1, 1, '2025-08-24 01:47:07', '2025-08-24 01:47:07', NULL, 13),
(23, 1, 1, '2025-08-26 22:39:01', '2025-08-26 22:39:01', NULL, 24),
(24, 1, 1, '2025-08-26 22:41:37', '2025-08-26 22:41:37', NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `module_projects_questions`
--

CREATE TABLE `module_projects_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `question_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects_questions`
--

INSERT INTO `module_projects_questions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`, `question_text`) VALUES
(2, 1, 1, '2025-08-23 11:04:30', '2025-08-23 11:04:30', NULL, 4, 'What was was the color of George Washington\'s white horse?'),
(3, 1, 1, '2025-08-24 01:18:09', '2025-08-24 01:18:09', NULL, 10, 'Who is Dave Wilkins ?'),
(5, 1, 1, '2025-08-24 02:09:04', '2025-08-24 02:09:04', NULL, 2, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `module_strategy`
--

CREATE TABLE `module_strategy` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `corporate_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  `target_start` date DEFAULT NULL,
  `target_end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_strategy_collaborators`
--

CREATE TABLE `module_strategy_collaborators` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `strategy_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_strategy_files`
--

CREATE TABLE `module_strategy_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `strategy_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_strategy_key_results`
--

CREATE TABLE `module_strategy_key_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `objective_id` int(11) NOT NULL,
  `key_result` text NOT NULL,
  `target_value` varchar(255) DEFAULT NULL,
  `current_value` varchar(255) DEFAULT NULL,
  `kpi_unit` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `task_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_strategy_notes`
--

CREATE TABLE `module_strategy_notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `strategy_id` int(11) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_strategy_objectives`
--

CREATE TABLE `module_strategy_objectives` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `strategy_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `objective` text NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `progress_percent` int(11) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_strategy_tags`
--

CREATE TABLE `module_strategy_tags` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `strategy_id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL
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
  `is_private` tinyint(1) NOT NULL DEFAULT 0,
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

INSERT INTO `module_tasks` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `project_id`, `agency_id`, `division_id`, `is_private`, `name`, `description`, `requirements`, `specifications`, `status`, `previous_status`, `priority`, `start_date`, `due_date`, `complete_date`, `completed`, `completed_by`, `progress_percent`) VALUES
(1, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 0, 'Probation Officer Role and Permissions in eCourt Portal', NULL, NULL, NULL, '35', NULL, '38', NULL, '2025-03-17', NULL, 0, NULL, 0),
(2, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 0, 'GAL Role and Permissions in eCourt Portal', NULL, NULL, NULL, '35', NULL, '38', NULL, '2025-03-17', NULL, 0, NULL, 0),
(3, 1, 1, '2025-08-19 22:58:03', '2025-08-20 00:43:16', NULL, 3, 2, 2, 0, 'Fee Waiver Icon in Case Header', NULL, NULL, NULL, '34', 34, '38', NULL, '2025-03-17', '2025-08-20', 1, 1, 100),
(4, 1, 1, '2025-08-19 22:58:03', '2025-08-21 09:52:20', NULL, NULL, 2, 2, 0, 'New Judicial Assistant eCourt Role', NULL, NULL, NULL, '34', 34, '39', NULL, '2025-03-25', '2025-08-21', 1, 1, 100),
(6, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:59:41', NULL, NULL, 2, 2, 0, 'Zoom Link', NULL, NULL, NULL, '32', NULL, NULL, NULL, '2025-03-24', NULL, 0, NULL, 0),
(7, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 0, 'Write a SQL Query for Warrants?', NULL, NULL, NULL, '35', NULL, '37', NULL, '2025-03-26', NULL, 0, NULL, 0),
(8, 1, 1, '2025-08-19 22:58:03', '2025-08-21 09:52:19', NULL, NULL, 2, 2, 0, 'Document View / Stamp Tool', NULL, NULL, NULL, '34', 34, '38', NULL, '2025-03-27', '2025-08-21', 1, 1, 100),
(9, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 0, 'Judge Mass Reassignment', NULL, NULL, NULL, '32', NULL, '38', NULL, '2025-03-27', NULL, 0, NULL, 0),
(10, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 0, 'AOIC Update to Report E and I - Quarterly Statistic Reports', NULL, NULL, NULL, '3', NULL, '39', NULL, '2025-04-01', NULL, 0, NULL, 0),
(11, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 0, 'Report K Update', NULL, NULL, NULL, '3', NULL, '39', NULL, NULL, NULL, 0, NULL, 0),
(12, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 0, 'New search form request: search by assigned judge and current attorney law firm', NULL, NULL, NULL, '3', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(13, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 0, 'Block Restricted Documents from eProsecutor and eDefender', NULL, NULL, NULL, '3', NULL, '39', NULL, NULL, NULL, 0, NULL, 0),
(15, 1, 1, '2025-08-19 22:58:03', '2025-08-21 22:18:55', NULL, NULL, 2, 2, 0, 'COURT CLERK DocDef REVIEW', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(16, 1, 1, '2025-08-19 22:58:03', '2025-08-19 22:58:03', NULL, NULL, 2, 2, 0, 'Interpreter Needed - UPDATE EVENT & WF', NULL, NULL, NULL, '32', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(17, 1, 1, '2025-08-19 23:01:26', '2025-08-20 00:13:56', NULL, 1, 2, 2, 0, 'Initial Demo to Judge Novak - July 31st', NULL, NULL, NULL, '32', 32, '39', NULL, NULL, '2025-08-20', 1, 1, 100),
(18, 1, 1, '2025-08-19 23:02:12', '2025-08-21 15:31:46', NULL, 2, NULL, NULL, 0, 'Bench View Discussion', NULL, NULL, NULL, '32', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(19, 1, 1, '2025-08-20 00:13:16', '2025-08-20 00:13:16', NULL, 1, NULL, NULL, 0, 'Show [Seal Type] in Documents Viewer', NULL, NULL, NULL, '35', NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(20, 1, 1, '2025-08-20 00:21:07', '2025-08-20 00:42:11', NULL, 3, NULL, NULL, 0, 'Create the Widget', NULL, NULL, NULL, '34', 32, '38', NULL, NULL, '2025-08-20', 1, 1, 100),
(22, 1, 1, '2025-08-21 18:09:03', '2025-08-21 18:09:25', NULL, 5, NULL, NULL, 0, 'Email Davey & Gia about Specifications and Requirements', NULL, NULL, NULL, '32', NULL, '39', NULL, NULL, NULL, 0, NULL, 0),
(23, 1, 1, '2025-08-21 22:22:45', '2025-08-21 22:22:45', NULL, 6, NULL, NULL, 0, 'Kick off meeting with McLean County, IL', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(24, 1, 1, '2025-08-21 22:24:14', '2025-08-21 22:24:14', NULL, 6, NULL, NULL, 0, 'Reach out to RJ to get the proper Person/Contact to initiate', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(25, 1, 1, '2025-08-21 22:24:39', '2025-08-21 22:24:39', NULL, 6, NULL, NULL, 0, 'Compile list of completed Projects & Tasks to demo', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(26, 1, 1, '2025-08-21 22:26:08', '2025-08-21 22:26:08', NULL, 7, NULL, NULL, 0, 'Prepare Winnie to pitch Atlis\' support and post go-live services.', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(27, 1, 1, '2025-08-21 22:26:23', '2025-08-21 22:26:23', NULL, 7, NULL, NULL, 0, 'Compile list of completed Projects & Tasks', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(28, 1, 1, '2025-08-21 22:26:43', '2025-08-21 22:26:43', NULL, 7, NULL, NULL, 0, 'Business Cards / Way to introduce ourselves and Atlis', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(29, 1, 1, '2025-08-22 18:00:29', '2025-08-22 18:00:29', NULL, 10, NULL, NULL, 0, 'TELLURIDE - get insurance', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(30, 1, 1, '2025-08-22 18:00:44', '2025-08-22 18:00:44', NULL, 10, NULL, NULL, 0, 'TELLURIDE - send AFCU proof of insurance', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(31, 1, 1, '2025-08-22 18:00:55', '2025-08-22 18:00:55', NULL, 10, NULL, NULL, 0, 'TELLURIDE - purchase all weather floor mats', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(32, 1, 1, '2025-08-22 18:01:01', '2025-08-22 18:01:01', NULL, 10, NULL, NULL, 0, 'TELLURIDE - get windows tinted', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(33, 1, 1, '2025-08-22 18:06:00', '2025-08-22 18:06:00', NULL, 4, NULL, NULL, 0, 'Reach out to Docstader about Business Intelligence', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(34, 1, 1, '2025-08-22 18:06:14', '2025-08-22 18:06:14', NULL, 4, NULL, NULL, 0, 'Email Emma Baylor details about doing Business Intelligence', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(35, 1, 1, '2025-08-22 18:12:21', '2025-08-22 18:13:05', NULL, 12, NULL, NULL, 0, 'Send him LAKE AUPs', NULL, NULL, NULL, '34', 35, '38', NULL, NULL, '2025-08-22', 1, 1, 100),
(36, 1, 1, '2025-08-22 18:12:30', '2025-08-22 18:12:30', NULL, 12, NULL, NULL, 0, 'FULL NAME & BIRTHDAY for Background Check', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(37, 1, 1, '2025-08-22 18:12:47', '2025-08-22 18:12:47', NULL, 12, NULL, NULL, 0, 'Send for signature - Atlis Documents', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(38, 1, 1, '2025-08-22 18:13:01', '2025-08-24 02:54:55', NULL, 12, NULL, NULL, 0, 'Create Work Agreement between him and Atlis Technologies', NULL, NULL, NULL, '32', NULL, '39', '2025-08-17', '2025-08-30', NULL, 0, NULL, 0),
(39, 1, 1, '2025-08-22 18:19:29', '2025-08-23 01:50:27', NULL, 13, NULL, NULL, 0, 'New CSS Color classes system-wide', NULL, NULL, NULL, '34', 35, '38', NULL, NULL, '2025-08-23', 1, 1, 100),
(40, 1, 1, '2025-08-22 18:52:14', '2025-08-25 01:51:26', NULL, 14, NULL, NULL, 0, 'Send him LAKE AUPs', NULL, NULL, NULL, '34', 35, '38', NULL, NULL, '2025-08-25', 1, 1, 100),
(41, 1, 1, '2025-08-22 18:52:23', '2025-08-25 01:48:50', NULL, 14, NULL, NULL, 0, 'FULL NAME & Birthday for Background Check', NULL, NULL, NULL, '34', 34, '38', NULL, NULL, '2025-08-25', 1, 1, 100),
(42, 1, 1, '2025-08-22 18:52:30', '2025-08-25 01:48:53', NULL, 14, NULL, NULL, 0, 'Send for signature - Atlis Documents', NULL, NULL, NULL, '34', 35, '38', NULL, NULL, '2025-08-25', 1, 1, 100),
(43, 1, 1, '2025-08-22 18:52:35', '2025-08-25 01:48:55', NULL, 14, NULL, NULL, 0, 'Create Work Agreement between him and Atlis Technologies', NULL, NULL, NULL, '34', 35, '38', NULL, NULL, '2025-08-25', 1, 1, 100),
(44, 1, 1, '2025-08-22 18:54:32', '2025-08-22 18:54:32', NULL, 11, NULL, NULL, 0, 'August 22nd, 2025 at 2pm - Me, Sean, Tom, Soup, RJ, and Kasper', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(45, 1, 1, '2025-08-22 18:57:58', '2025-08-22 18:57:58', NULL, 4, NULL, NULL, 0, 'Background Checks !', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(46, 1, 1, '2025-08-22 18:58:23', '2025-08-24 20:41:20', NULL, 10, NULL, NULL, 0, 'BUY KRATOM - OR GET THE F OFF IT', NULL, NULL, NULL, '34', 32, '39', NULL, NULL, '2025-08-24', 1, 1, 100),
(47, 1, 1, '2025-08-22 20:44:36', '2025-08-22 20:44:36', NULL, 13, NULL, NULL, 0, 'Relationships between Lookup Lists and LU Items (upload eCourt schema)', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(48, 1, 1, '2025-08-22 20:45:04', '2025-08-22 20:45:04', NULL, 13, NULL, NULL, 0, 'Why does eCourt schema use Lookup List CODE as FK value in child tables instead of id PK?', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(49, 1, 1, '2025-08-22 20:47:03', '2025-08-22 20:47:15', NULL, 10, NULL, NULL, 0, 'Dentist Cleaning?', NULL, NULL, NULL, '35', NULL, '39', NULL, NULL, NULL, 0, NULL, 0),
(50, 1, 1, '2025-08-22 20:47:09', '2025-08-22 20:47:14', NULL, 10, NULL, NULL, 0, 'Dentist fill cavities?', NULL, NULL, NULL, '35', NULL, '40', NULL, NULL, NULL, 0, NULL, 0),
(51, 1, 1, '2025-08-22 20:47:56', '2025-08-23 01:50:53', NULL, 13, NULL, NULL, 0, 'Dynamic / User selected sorting on... everything (projects + tasks)', NULL, NULL, NULL, '34', 0, '38', NULL, NULL, '2025-08-23', 1, 1, 100),
(52, 1, 1, '2025-08-22 20:50:21', '2025-08-22 20:50:21', NULL, 4, NULL, NULL, 0, 'Email Winnie about JTI User Conference (register with .gov email?)', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(53, 1, 1, '2025-08-22 21:10:57', '2025-08-22 21:10:57', NULL, 10, NULL, NULL, 0, 'TELLURIDE - VACUUM UP KARJAR\'S MESS', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(54, 1, 1, '2025-08-22 21:20:28', '2025-08-23 01:50:51', NULL, 13, NULL, NULL, 0, 'Dynamically check Note INSERTS (or set a type) for things like https Links to actually link.', NULL, NULL, NULL, '34', 0, '38', NULL, NULL, '2025-08-23', 1, 1, 100),
(55, 1, 1, '2025-08-22 21:34:22', '2025-08-22 21:34:22', NULL, 7, NULL, NULL, 0, 'SIGN UP FOR HILTON BUSINESS', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(56, 1, 1, '2025-08-22 21:35:14', '2025-08-22 21:35:14', NULL, 10, NULL, NULL, 0, 'SIGN UP FOR HILTON BUSINESS', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(57, 1, 1, '2025-08-22 21:36:15', '2025-08-22 21:36:15', NULL, 4, NULL, NULL, 0, 'CASE MANAGEMENT CONVENTIONS !', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(58, 1, 1, '2025-08-22 21:36:37', '2025-08-22 21:36:37', NULL, 6, NULL, NULL, 0, 'https://www.illinoiscourts.gov/courts-directory/34/McLean-County-Law-and-Justice-Center/court/', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(59, 1, 1, '2025-08-22 23:39:22', '2025-08-22 23:39:22', NULL, 10, NULL, NULL, 0, 'CALL Zynex Medical Inc - BILLING MY INSURANCE AF !', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(60, 1, 1, '2025-08-22 23:45:34', '2025-08-23 01:50:41', NULL, 13, NULL, NULL, 0, 'All Projects to be Private (for person use)', NULL, NULL, NULL, '34', 35, '38', NULL, NULL, '2025-08-23', 1, 1, 100),
(61, 1, 1, '2025-08-22 23:46:06', '2025-08-23 01:50:46', NULL, 13, NULL, NULL, 0, 'Allow Users to individually PIN Projects on the List view so they\'re always at the top', NULL, NULL, NULL, '34', 35, '38', NULL, NULL, '2025-08-23', 1, 1, 100),
(62, 1, 1, '2025-08-22 23:46:19', '2025-08-22 23:46:19', NULL, 13, NULL, NULL, 0, 'Allow Users to individually PIN Tasks on the List view so they\'re always at the top', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(63, 1, 1, '2025-08-23 00:24:34', '2025-08-23 00:24:34', NULL, 10, NULL, NULL, 0, 'ENTERPRISE BROKEN WINDSHIELD', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(64, 1, 1, '2025-08-23 00:26:34', '2025-08-23 00:26:34', NULL, 13, NULL, NULL, 0, 'ALL TO QUICK ASSIGN FROM PROJECT & TASKS LIST VIEW', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(65, 1, 1, '2025-08-23 03:00:50', '2025-08-23 03:00:50', NULL, 13, NULL, NULL, 0, 'System Property which shows a banner if the system is in Dev Mode', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(66, 1, 1, '2025-08-23 03:01:24', '2025-08-23 03:01:24', NULL, 13, NULL, NULL, 0, 'Actually use the Logo SP', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(67, 1, 1, '2025-08-23 03:01:52', '2025-08-23 03:01:52', NULL, 13, NULL, NULL, 0, 'Finance / Invoice module - copy invoices from Atlisware', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(68, 1, 1, '2025-08-23 12:00:50', '2025-08-23 12:00:50', NULL, 20, NULL, NULL, 0, 'VACUUM OUT THE TELLURIDE', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(69, 1, 1, '2025-08-23 12:01:00', '2025-08-23 12:01:00', NULL, 20, NULL, NULL, 0, 'INSTALL THE BACK SLIDING DOOR CURTAIN', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(70, 1, 1, '2025-08-23 12:01:15', '2025-08-23 12:01:15', NULL, 20, NULL, NULL, 0, 'HANG LONG MIRROR IN OUR BEDROOM ON WALL', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(71, 1, 1, '2025-08-23 15:46:16', '2025-08-23 15:46:16', NULL, 10, NULL, NULL, 0, 'RIZATRIPTAN - request minty disintegrating', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(72, 1, 1, '2025-08-23 17:53:50', '2025-08-23 17:53:50', NULL, 21, NULL, NULL, 0, 'FILE FOR KRISTINE & REAL ESTATE', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(73, 1, 1, '2025-08-23 20:55:32', '2025-08-23 21:56:27', NULL, 10, NULL, NULL, 0, 'FIX THE DOOR KNOB ON EMRYS CLOSET', NULL, NULL, NULL, '34', 35, '38', NULL, NULL, '2025-08-23', 1, 1, 100),
(74, 1, 1, '2025-08-23 20:55:40', '2025-08-23 20:55:40', NULL, 10, NULL, NULL, 0, 'FIX EMRY\'S BEDROOM DRESSER', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(75, 1, 1, '2025-08-23 20:55:50', '2025-08-23 20:55:50', NULL, 10, NULL, NULL, 0, 'INSTALL LONG MIRROR IN OUR ROOM', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(76, 1, 1, '2025-08-24 01:50:12', '2025-08-24 01:50:12', NULL, 13, NULL, NULL, 0, 'MAKE ALL NON-BUTTON/BADGE TEXT IN THE TOP NAV BE WHITE IN COLOR', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(77, 1, 1, '2025-08-24 01:50:45', '2025-08-24 01:50:45', NULL, 13, NULL, NULL, 0, 'TASKS: ALLOW USER TO SORT HOW THEY WANT.', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(78, 1, 1, '2025-08-24 02:05:43', '2025-08-24 02:05:43', NULL, 13, NULL, NULL, 0, 'FINANCE: Add Invoices, Time Tracking, & SoW\'s to system.', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(79, 1, 1, '2025-08-24 10:06:10', '2025-08-24 10:07:20', NULL, 22, NULL, NULL, 0, 'BUSINESS INSURANCE !', NULL, NULL, NULL, '32', NULL, '40', NULL, NULL, NULL, 0, NULL, 0),
(80, 1, 1, '2025-08-24 11:31:57', '2025-08-24 11:31:57', NULL, 13, NULL, NULL, 0, 'PROJECTS: ADD SETTING FOR DEFAULT ORG, AGC, & DIV', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(81, 1, 1, '2025-08-24 11:32:23', '2025-08-24 11:32:23', NULL, 23, NULL, NULL, 0, 'Lake County, IL - AUPs', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(82, 1, 1, '2025-08-24 11:32:34', '2025-08-24 11:32:34', NULL, 23, NULL, NULL, 0, 'Atlis Work Agreement Contract', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(83, 1, 1, '2025-08-24 11:32:40', '2025-08-24 11:32:40', NULL, 23, NULL, NULL, 0, 'Atlis Required Docs', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(84, 1, 1, '2025-08-24 11:32:50', '2025-08-24 11:32:50', NULL, 23, NULL, NULL, 0, 'Create Office365 Account', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(85, 1, 1, '2025-08-24 11:33:20', '2025-08-24 11:33:39', NULL, 4, NULL, NULL, 0, 'DEFINE ATLIS INTERNAL POLICIES AND WORK PROCESSES', NULL, NULL, NULL, '32', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(86, 1, 1, '2025-08-24 16:57:23', '2025-08-24 16:57:23', NULL, 10, NULL, NULL, 0, 'TENS - NexWave', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0),
(87, 1, 1, '2025-08-24 17:31:27', '2025-08-25 02:04:09', NULL, 4, NULL, NULL, 0, 'Create Team/Group emails so don\'t have to CC individually', NULL, NULL, NULL, '34', 32, '38', NULL, NULL, '2025-08-25', 1, 1, 100),
(88, 1, 1, '2025-08-24 21:46:06', '2025-08-24 21:46:32', NULL, 13, NULL, NULL, 0, 'ATLIS HELPERS - SQL scripts, Guides, etc.', NULL, NULL, NULL, '32', NULL, '39', NULL, NULL, NULL, 0, NULL, 0),
(89, 1, 1, '2025-08-24 23:40:28', '2025-08-24 23:40:33', NULL, 13, NULL, NULL, 0, 'HOSTING... JUST RENT SERVERS', NULL, NULL, NULL, '32', NULL, '40', NULL, NULL, NULL, 0, NULL, 0),
(90, 1, 1, '2025-08-25 02:03:46', '2025-08-25 02:03:46', NULL, 4, NULL, NULL, 0, 'BUSINESS INSURANCE !', NULL, NULL, NULL, '35', NULL, '38', NULL, NULL, NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_tasks_answers`
--

CREATE TABLE `module_tasks_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_tasks_answers`
--

INSERT INTO `module_tasks_answers` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `question_id`, `answer_text`) VALUES
(1, 1, 1, '2025-08-24 01:34:50', '2025-08-24 01:34:50', NULL, 1, 'Whatever color you pick from Bootstrap.');

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
  `question_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_tasks_files`
--

INSERT INTO `module_tasks_files` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `task_id`, `note_id`, `question_id`, `file_name`, `file_path`, `file_size`, `file_type`) VALUES
(5, 1, 1, '2025-08-22 21:34:51', '2025-08-22 21:34:51', NULL, 55, 29, NULL, 'canopy-somasanfran-landscape-jpg-3.avif', '/module/task/uploads/task_55_1755920091_canopy-somasanfran-landscape-jpg-3.avif', 72347, 'image/avif'),
(6, 1, 1, '2025-08-24 21:46:24', '2025-08-24 21:46:24', NULL, 88, 44, NULL, 'ENTIRE DATABASE ROWS (1).sql', '/module/task/uploads/task_88_1756093584_ENTIRE_DATABASE_ROWS__1_.sql', 540, 'application/octet-stream'),
(7, 1, 1, '2025-08-24 21:47:13', '2025-08-24 21:47:13', NULL, 17, 45, NULL, '_DEMO TO JUDGE NOVAK.xlsx', '/module/task/uploads/task_17_1756093633__DEMO_TO_JUDGE_NOVAK.xlsx', 38114, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

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
(12, 1, 1, '2025-08-21 18:09:15', '2025-08-21 18:09:15', NULL, 22, 'Hi Gia & Davey,\r\n\r\nDo you have any specific requirements or specifications for the Judge Mass Reassignment project? I don’t want to make this any more complex than necessary—at a high level, it should be straightforward. For the sake of example, Judge A is the retiring judge and Judge B is the newly assigned judge.\r\n\r\n1) What gets reassigned\r\n-	Reassign all future events currently assigned to Judge A over to Judge B.\r\no	“All” assumes no filters (Case Type, Event Type, etc.).\r\no	“Future” assumes we are not modifying past events.\r\n-	Should any case-level or caseAssignment fields also be updated (for Judge A and/or Judge B)?\r\n\r\n\r\n2) Audit, validation, and proof checking\r\n-	Do you need audit artifacts (e.g., before/after counts, per-case change logs with timestamp/user, downloadable CSV)?\r\n-	Should we add guardrails (e.g., exclude sealed/closed cases, skip in-progress or same-day events)?\r\n\r\n\r\n3) Execution & UX\r\n-	Once Judge A → Judge B is selected, should the process run automatically in the background, or would you prefer a preview/confirm step with progress tracking?\r\n-	Would a summary be useful (e.g., via Search, Report, or Email notification)?\r\n\r\n\r\nThanks,\r\nDave'),
(15, 1, 1, '2025-08-22 18:20:07', '2025-08-22 18:20:07', NULL, 35, 'He signed each AUP on July 31st, 2025.\r\nAttached to Contractor module.'),
(16, 1, 1, '2025-08-22 18:52:58', '2025-08-22 18:52:58', NULL, 43, 'I texted him asking what resume-boosting Role he wants on the work agreement.'),
(17, 1, 1, '2025-08-22 18:54:39', '2025-08-22 18:54:39', NULL, 44, '- EMAIL SUBJECT AND BODY TEMPLATE\r\n\r\n- ACTUAL GENERIC EMAIL ADDRESSES FOR eCOURT, ePROS, & eDEF\r\n\r\n\r\n- COLOR CODED SEAL TYPE IN DOCUMENTS MANAGER\r\n--> EMAIL WINNIE (cc Leah, RJ, Kasper) WITH SCREENSHOT\r\n--> WINNIE WILL SCHEDULE DEMO WITH JUDGE NOVAK & Court Clerks\r\n\r\n--> JUDGE NOVAK MENTIONED NEW REGULATIONS\r\n\r\n\r\nRISKS\r\n-> How Keith & Lonnie will receive this solution.\r\n-> \"Turning off\" the eCourt Viewer in ePros & eDef.\r\n\r\n\r\n\r\nQUESTIONS\r\n--> Who will \"turn off\" the Court Viewer in ePros & eDef ?\r\n- I can do it, I just need admin access to ePros & eDef.\r\n\r\n--> email Winnie: ask email Lonnie & Keith separately\r\n- RJ says ask this after we demo to them.\r\n\r\n\r\n\r\n--------------------\r\nJUDGE MASS REASSIGNMENT\r\n- ask Davey R. if he can hop on our 3pm CST meeting to discuss.\r\n--------------------\r\n\r\n\r\n\r\nhttps://www.ncsc.org/event/court-technology-conference-ctc\r\n--------------------\r\n\r\n\r\ngia + winnie are going to JTI User conf\r\n\r\n\r\nMcCLEAN COUNTY, IL (maybe 11th?)\r\n- Craig Nelson\r\n\r\n\r\n- not Don Everhart\r\n\r\nhttps://www.illinoiscourts.gov/courts-directory/34/McLean-County-Law-and-Justice-Center/court/'),
(18, 1, 1, '2025-08-22 18:54:47', '2025-08-22 18:54:47', NULL, 44, 'ONE RESTART, TO RULE THEM ALL\r\n- verify with the Clerks that they\'re good to wait ~2 weeks for Restart\r\n\r\n- Kapser will request the restart with JTI.\r\n\r\n- Judge Mass Reassignment may need new metadata\r\n\r\n- Multiple Interpreters per Event\r\n--> need metadata in PROD\r\n--> one small new config: show exotic langauge in WQ.\r\n--> When I complete in AUX, email Leah/CC & JIS for UAT.\r\n\r\n\r\nASK LEAH & TARA IF THEY\'RE GOOD WAITING ON THE REPORTS SoW\r\nTO COMBINE THE RESTART IN PRODUCTION !'),
(19, 1, 1, '2025-08-22 18:54:55', '2025-08-22 18:54:55', NULL, 44, 'E.S.D.\r\n--> remaining tasks for both Atlis and Lake\r\n--> timeline\r\n\r\n\r\nGAL\r\n--> eDefender Admin Access\r\n- I emailed Winnie\r\n\r\n\r\n\r\nJUDGE MASS REASSIGNMENT\r\n\r\n\r\n\r\nRESTART\r\n\r\n\r\nJTI USER CONFERENCE'),
(20, 1, 1, '2025-08-22 18:58:03', '2025-08-22 18:58:03', NULL, 45, 'Josh Barnett'),
(21, 1, 1, '2025-08-22 18:59:07', '2025-08-22 18:59:07', NULL, 44, 'AGENDA:\r\n\r\nE.S.D.\r\n	--> remaining tasks for both Atlis and Lake\r\n	--> timeline\r\n\r\n\r\nGAL\r\n	--> eDefender Admin Access\r\n		- I emailed Winnie\r\n\r\n\r\n\r\nJUDGE MASS REASSIGNMENT\r\n\r\n\r\n\r\nRESTART\r\n\r\n\r\nJTI USER CONFERENCE'),
(22, 1, 1, '2025-08-22 21:19:52', '2025-08-22 21:19:52', NULL, 46, 'https://www.amazon.com/Kratom-Things-Need-Know-About/dp/1724047809/\r\n\r\nhttps://www.amazon.com/Kratom-Medicine-Natural-Anxiety-Fatigue/dp/0578866463/\r\n\r\nhttps://www.amazon.com/My-Kratom-Hell-Users-Quitting/dp/1691182109'),
(24, 1, 1, '2025-08-22 21:20:42', '2025-08-22 21:20:42', NULL, 46, '1) Kratom: 101 Things You Need to Know About Kratom — Frank Coles (2018; ISBN-10: 1724047809)\r\n\r\nLibrary copy (Utah): Salt Lake City Public Library has it listed—good candidate for a local borrow or interlibrary loan. \r\ncatalog.slcpl.org\r\n\r\nPreview / metadata: Google Books page (limited preview). \r\nGoogle Books\r\n\r\nAudiobook (paid, sometimes with free trial): Audible listing. \r\nAudible.com\r\n\r\nRetail reference: Amazon product page (print). \r\nAmazon'),
(25, 1, 1, '2025-08-22 21:20:52', '2025-08-22 21:20:52', NULL, 46, '2) Kratom Is Medicine: Natural Relief for Anxiety, Pain, Fatigue, and More — Michele Ross (2021; ISBN-10: 0578866463)\r\n\r\nRead online (with free trial): Everand/Scribd eBook. \r\nEverand\r\n\r\nAuthor site (book info & buy links; occasionally authors share extras or discounts here): \r\nDr. Michele Ross\r\n\r\nPreview: Google Books entry (limited preview). \r\nGoogle Books\r\n\r\nRetail refs: Barnes & Noble listing; AbeBooks (used). \r\nBarnes & Noble\r\nAbeBooks'),
(26, 1, 1, '2025-08-22 21:20:57', '2025-08-22 21:20:57', NULL, 46, '3) My Kratom Hell: A User’s Guide to Quitting Kratom — Safari Girl (2019; ISBN-10: 1691182109)\r\n\r\nAuthor’s site (background & posts): quittingkratom.wordpress.com. \r\nquittingkratom.wordpress.com\r\n\r\nPreview / metadata: Google Books (limited). \r\nGoogle Books'),
(27, 1, 1, '2025-08-22 21:21:02', '2025-08-22 21:21:02', NULL, 46, 'Solid, free kratom resources (open access)\r\n\r\nIf your goal is research (mechanisms, risks, clinical view), these are high-quality and free:\r\n\r\nFDA’s current kratom page (policy & safety, updated July 29, 2025). \r\nU.S. Food and Drug Administration\r\n\r\nWHO ECDD pre-review report on kratom (pdf). \r\nWorld Health Organization\r\n\r\nPeer-reviewed open-access overviews (PMC/JAMA): pharmacology & clinical implications; assessment & treatment; EMA of use/effects. \r\nPMC\r\n+1\r\nJAMA Network\r\n\r\nConcise clinical guide (Michigan OPEN educational PDF). \r\nmichigan-open.org'),
(28, 1, 1, '2025-08-22 21:34:24', '2025-08-22 21:34:24', NULL, 55, 'https://www.hilton.com/en/p/hilton-for-business/'),
(29, 1, 1, '2025-08-22 21:34:51', '2025-08-22 21:34:51', NULL, 55, 'Earn up to 15,000 Bonus Points\r\nMan checking in at reception with luggage\r\nBook exclusive discounted Hilton for Business rates and earn 5,000 Bonus Points per stay, up to 3 stays, through Aug 27, 2025.'),
(30, 1, 1, '2025-08-22 21:35:18', '2025-08-22 21:35:18', NULL, 56, 'https://www.hilton.com/en/p/hilton-for-business/'),
(31, 1, 1, '2025-08-22 21:35:21', '2025-08-22 21:35:21', NULL, 56, 'Earn up to 15,000 Bonus Points\r\nMan checking in at reception with luggage\r\nBook exclusive discounted Hilton for Business rates and earn 5,000 Bonus Points per stay, up to 3 stays, through Aug 27, 2025.'),
(32, 1, 1, '2025-08-22 21:35:43', '2025-08-22 21:35:43', NULL, 56, 'JTI 2025 USER CONFERENCE:\r\nNOVEMBER 12, 13, & 14th, 2025'),
(33, 1, 1, '2025-08-22 21:36:19', '2025-08-22 21:36:19', NULL, 57, 'https://www.ncsc.org/event/court-technology-conference-ctc'),
(34, 1, 1, '2025-08-22 21:36:25', '2025-08-22 21:36:25', NULL, 57, 'https://www.ccpio.org/'),
(35, 1, 1, '2025-08-22 21:36:39', '2025-08-22 21:36:39', NULL, 58, 'https://www.illinoiscourts.gov/courts-directory/34/McLean-County-Law-and-Justice-Center/court/'),
(36, 1, 1, '2025-08-22 21:36:42', '2025-08-22 21:36:42', NULL, 58, 'https://www.mcleancountyil.gov/81/Circuit-Court'),
(37, 1, 1, '2025-08-22 21:36:59', '2025-08-22 21:36:59', NULL, 58, 'McLean County Circuit Court - 2025 Judicial Assignments\r\nhttps://www.mcleancountyil.gov/DocumentCenter/View/28840/2025-Judicial-Assignments'),
(38, 1, 1, '2025-08-23 02:31:34', '2025-08-23 02:31:34', NULL, 40, 'Email sent with Lake\'s AUPs on 8/22/2025 at 3:48pm'),
(39, 1, 1, '2025-08-23 21:57:02', '2025-08-23 21:57:02', NULL, 73, 'Fixed tonight. Eamon helped me. Emry saw and got jealous as she was reading with Ashlin. She cried and said she wants to help me.'),
(40, 1, 1, '2025-08-24 02:16:21', '2025-08-24 02:16:21', NULL, 46, 'I purchased some SUPER SPECOSIA'),
(41, 1, 1, '2025-08-24 02:55:46', '2025-08-24 02:55:46', NULL, 46, 'I purchased from: https://kures.co/\r\nKratom72!@'),
(42, 1, 1, '2025-08-24 11:33:34', '2025-08-24 11:33:34', NULL, 85, '- ONLY FEW PEOPLE HAVE ACCESS TO PROD ENVS'),
(43, 1, 1, '2025-08-24 17:31:39', '2025-08-24 17:31:39', NULL, 87, 'Created Atlis@Atlistechnologies.com'),
(44, 1, 1, '2025-08-24 21:46:24', '2025-08-24 21:46:24', NULL, 88, 'DATABASE ROW COUNTS'),
(45, 1, 1, '2025-08-24 21:47:13', '2025-08-24 21:47:13', NULL, 17, 'NOTES / AGENDA FOR DEMO TO JUDGE NOVAK MEETING.'),
(46, 1, 1, '2025-08-24 23:41:22', '2025-08-24 23:41:22', NULL, 89, 'JUST RENT DEDICATED SERVERS...... \r\nI REALLY DON\'T WANT ALL OF THE TROUBLE OF NETWORKING IN MY HOUSE......');

-- --------------------------------------------------------

--
-- Table structure for table `module_tasks_questions`
--

CREATE TABLE `module_tasks_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `question_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_tasks_questions`
--

INSERT INTO `module_tasks_questions` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `task_id`, `question_text`) VALUES
(1, 1, 1, '2025-08-24 01:34:36', '2025-08-24 01:34:36', NULL, 19, 'What color per seal type ?'),
(2, 1, 1, '2025-08-24 02:05:55', '2025-08-24 02:05:55', NULL, 78, 'Should this be a PUBLIC or ADMIN module ?'),
(3, 1, 1, '2025-08-24 02:07:05', '2025-08-24 02:07:05', NULL, 78, 'What layer/level or the Organizational hierarchy should the financial components be tracked at? Organization --> Agency --> Division. 🤔');

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
(4, 1, 1, '2025-08-21 15:31:49', '2025-08-21 15:31:49', NULL, 18, 2),
(6, 1, 1, '2025-08-23 02:30:45', '2025-08-23 02:30:45', NULL, 40, 1),
(7, 1, 1, '2025-08-23 12:03:58', '2025-08-23 12:03:58', NULL, 68, 1),
(8, 1, 1, '2025-08-23 12:08:29', '2025-08-23 12:08:29', NULL, 69, 1),
(9, 1, 1, '2025-08-23 12:08:32', '2025-08-23 12:08:32', NULL, 70, 1),
(10, 1, 1, '2025-08-23 12:08:58', '2025-08-23 12:08:58', NULL, 61, 1),
(11, 1, 1, '2025-08-23 12:09:06', '2025-08-23 12:09:06', NULL, 60, 1),
(12, 1, 1, '2025-08-23 12:09:08', '2025-08-23 12:09:08', NULL, 54, 1),
(13, 1, 1, '2025-08-23 12:09:10', '2025-08-23 12:09:10', NULL, 51, 1),
(14, 1, 1, '2025-08-23 12:09:13', '2025-08-23 12:09:13', NULL, 39, 1),
(15, 1, 1, '2025-08-23 12:09:26', '2025-08-23 12:09:26', NULL, 47, 1),
(16, 1, 1, '2025-08-23 12:09:28', '2025-08-23 12:09:28', NULL, 48, 1),
(17, 1, 1, '2025-08-23 12:09:30', '2025-08-23 12:09:30', NULL, 62, 1),
(18, 1, 1, '2025-08-24 00:30:08', '2025-08-24 00:30:08', NULL, 59, 1),
(19, 1, 1, '2025-08-24 00:30:11', '2025-08-24 00:30:11', NULL, 46, 1),
(20, 1, 1, '2025-08-24 00:30:15', '2025-08-24 00:30:15', NULL, 57, 1),
(21, 1, 1, '2025-08-24 00:31:28', '2025-08-24 00:31:28', NULL, 66, 1),
(22, 1, 1, '2025-08-24 00:31:39', '2025-08-24 00:31:39', NULL, 72, 1),
(23, 1, 1, '2025-08-24 00:31:42', '2025-08-24 00:31:42', NULL, 74, 1),
(24, 1, 1, '2025-08-24 01:50:52', '2025-08-24 01:50:52', NULL, 76, 1),
(25, 1, 1, '2025-08-24 01:50:52', '2025-08-24 01:50:52', NULL, 77, 1),
(26, 1, 1, '2025-08-24 01:50:54', '2025-08-24 01:50:54', NULL, 64, 1),
(27, 1, 1, '2025-08-24 01:50:55', '2025-08-24 01:50:55', NULL, 65, 1),
(28, 1, 1, '2025-08-24 01:50:56', '2025-08-24 01:50:56', NULL, 67, 1),
(29, 1, 1, '2025-08-24 01:51:10', '2025-08-24 01:51:10', NULL, 28, 1),
(30, 1, 1, '2025-08-24 01:51:12', '2025-08-24 01:51:12', NULL, 27, 1),
(31, 1, 1, '2025-08-24 02:05:44', '2025-08-24 02:05:44', NULL, 78, 1),
(32, 1, 1, '2025-08-24 02:54:17', '2025-08-24 02:54:17', NULL, 44, 1),
(33, 1, 1, '2025-08-24 02:54:17', '2025-08-24 02:54:17', NULL, 45, 1),
(34, 1, 1, '2025-08-24 02:54:24', '2025-08-24 02:54:24', NULL, 15, 1),
(35, 1, 1, '2025-08-24 02:54:26', '2025-08-24 02:54:26', NULL, 43, 1),
(36, 1, 1, '2025-08-24 02:54:27', '2025-08-24 02:54:27', NULL, 38, 1),
(37, 1, 1, '2025-08-24 02:54:27', '2025-08-24 02:54:27', NULL, 25, 1),
(38, 1, 1, '2025-08-24 10:06:43', '2025-08-24 10:06:43', NULL, 41, 1),
(39, 1, 1, '2025-08-24 10:06:44', '2025-08-24 10:06:44', NULL, 36, 1),
(40, 1, 1, '2025-08-24 10:06:52', '2025-08-24 10:06:52', NULL, 79, 1),
(41, 1, 1, '2025-08-24 11:31:58', '2025-08-24 11:31:58', NULL, 80, 1),
(42, 1, 1, '2025-08-24 11:33:43', '2025-08-24 11:33:43', NULL, 33, 1),
(43, 1, 1, '2025-08-24 11:33:44', '2025-08-24 11:33:44', NULL, 34, 1),
(44, 1, 1, '2025-08-24 11:33:45', '2025-08-24 11:33:45', NULL, 52, 1),
(45, 1, 1, '2025-08-24 11:33:53', '2025-08-24 11:33:53', NULL, 85, 1),
(46, 1, 1, '2025-08-24 17:31:29', '2025-08-24 17:31:29', NULL, 87, 1),
(47, 1, 1, '2025-08-24 21:46:08', '2025-08-24 21:46:08', NULL, 88, 1),
(48, 1, 1, '2025-08-24 23:40:30', '2025-08-24 23:40:30', NULL, 89, 1),
(49, 1, 1, '2025-08-25 01:48:56', '2025-08-25 01:48:56', NULL, 42, 1),
(50, 1, 1, '2025-08-25 02:03:50', '2025-08-25 02:03:50', NULL, 90, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_users_defaults`
--

CREATE TABLE `module_users_defaults` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `list_name` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_users_defaults`
--

INSERT INTO `module_users_defaults` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `list_name`, `item_id`) VALUES
(1, 1, 1, '2025-08-23 19:23:51', '2025-08-24 11:30:44', NULL, 'PROJECT_STATUS', 55),
(2, 1, 1, '2025-08-23 19:23:51', '2025-08-24 11:30:44', NULL, 'PROJECT_PRIORITY', 58),
(3, 1, 1, '2025-08-23 19:23:51', '2025-08-24 11:30:44', NULL, 'PROJECT_TYPE', 182),
(7, 1, 1, '2025-08-24 11:30:44', '2025-08-24 11:30:44', NULL, 'TASK_STATUS', 35),
(8, 1, 1, '2025-08-24 11:30:44', '2025-08-24 11:30:44', NULL, 'TASK_PRIORITY', 38),
(14, 1, 1, '2025-08-27 18:51:09', '2025-08-27 18:51:09', NULL, 'CALENDAR_DEFAULT', 1);

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
(1, 1, 'Dave', 'Wilkins', NULL, 59, NULL, NULL, NULL, '1992-02-20', 1, '2025-08-08 21:52:52', '2025-08-23 01:38:34', NULL),
(2, 2, 'Sean', 'Cadina', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-15 00:11:11', '2025-08-19 23:23:09', NULL),
(5, 4, 'Tyler', 'Jessop', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-17 22:17:49', '2025-08-19 23:23:32', NULL),
(12, 5, 'RJ', 'Calara', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-19 23:21:53', '2025-08-19 23:21:53', NULL),
(13, 6, 'Kasper', 'Krynski', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-19 23:22:44', '2025-08-19 23:22:44', NULL),
(14, 7, 'Mileny', 'Valdez', NULL, 60, NULL, NULL, NULL, NULL, 1, '2025-08-19 23:27:09', '2025-08-19 23:27:09', NULL),
(23, 8, 'Kenny', 'Reynolds', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-20 14:44:46', '2025-08-20 14:44:46', NULL),
(24, 9, 'Richard', 'Sprague', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-20 15:14:36', '2025-08-20 15:14:36', NULL),
(27, 10, 'Emma', 'Baylor', NULL, 60, NULL, NULL, NULL, NULL, 1, '2025-08-20 20:47:24', '2025-08-20 20:47:24', NULL),
(30, NULL, 'Keith', 'Grant', 'KGrant@lakecountyil.gov', 59, 2, 3, 5, NULL, 1, '2025-08-20 21:03:51', '2025-08-23 01:37:50', NULL),
(31, NULL, 'Lonnie', 'Renda', 'LRenda@LakeCountyIL.gov', 59, 2, 4, NULL, NULL, 1, '2025-08-21 02:15:50', '2025-08-21 02:17:20', NULL),
(56, 11, 'Tom', 'Wilkins', NULL, 59, NULL, NULL, NULL, '1988-04-16', 1, '2025-08-22 18:07:18', '2025-08-22 18:07:18', NULL),
(57, 12, 'Winnie', 'Webber', NULL, 60, NULL, NULL, NULL, NULL, 1, '2025-08-22 19:16:00', '2025-08-22 19:16:00', NULL),
(58, 13, 'Zach', 'Jenks', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-23 10:55:54', '2025-08-23 10:55:54', NULL),
(59, 14, 'Nancy', 'Crandall', NULL, 60, NULL, NULL, NULL, NULL, 1, '2025-08-23 15:00:41', '2025-08-23 15:00:41', NULL),
(60, 15, 'Chris', 'Docstader', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-23 17:44:36', '2025-08-23 17:44:36', NULL),
(63, 18, 'Alisha', 'Wilkins', NULL, 60, NULL, NULL, NULL, NULL, 1, '2025-08-24 18:25:55', '2025-08-24 18:25:55', NULL),
(64, 19, 'Davey', 'Rivers', NULL, 59, NULL, NULL, NULL, NULL, 1, '2025-08-27 18:32:05', '2025-08-27 18:32:05', NULL);

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
  `country` varchar(100) DEFAULT 'USA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person_addresses`
--

INSERT INTO `person_addresses` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `person_id`, `type_id`, `status_id`, `start_date`, `end_date`, `address_line1`, `address_line2`, `city`, `state_id`, `postal_code`, `country`) VALUES
(1, 1, 1, '2025-08-08 21:52:52', '2025-08-23 01:38:50', NULL, 1, 111, 108, '2022-07-01', NULL, '3124 S 340 W', '', 'Nibley', 172, '84321', 'USA'),
(2, 1, 1, '2025-08-20 14:44:46', '2025-08-25 02:20:36', NULL, 23, 111, 108, '2025-08-20', NULL, 'kennydrenolds@gmail.com', '', '', NULL, '', 'USA'),
(4, 1, 1, '2025-08-23 02:29:47', '2025-08-23 02:29:52', NULL, 1, 112, 109, NULL, NULL, '715 W 2600 S', '', 'Nibley', 172, '84321', 'USA');

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
(5, NULL, 1, '2025-08-21 02:15:50', '2025-08-21 02:15:50', NULL, 31, 115, 105, NULL, NULL, '(224) 236-7938'),
(6, 1, 1, '2025-08-23 02:29:21', '2025-08-23 02:29:21', NULL, 1, 114, 106, '1992-02-20', '2011-05-13', '4357520708'),
(7, 1, 1, '2025-08-23 10:57:03', '2025-08-23 10:57:03', NULL, 58, 113, 105, '2025-08-23', NULL, '8017875849'),
(8, 1, 1, '2025-08-23 15:01:24', '2025-08-23 15:01:24', NULL, 59, 113, 105, '2025-08-23', NULL, '6514921467'),
(9, 1, 1, '2025-08-24 18:25:55', '2025-08-24 18:25:55', NULL, 63, 113, 105, '2025-08-24', NULL, '4352130627');

-- --------------------------------------------------------

--
-- Table structure for table `person_skills`
--

CREATE TABLE `person_skills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `memo` text DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person_skills`
--

INSERT INTO `person_skills` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `person_id`, `skill_id`, `level_id`) VALUES
(1, NULL, NULL, '2025-08-24 19:06:44', '2025-08-24 19:06:44', NULL, 1, 217, 1);

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
(1, 1, 1, '2025-08-13 16:28:53', '2025-08-13 16:28:53', NULL, 30, 'logo', '/assets/logo.png', 32, 'Default site logo'),
(2, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'DEFAULT_ORGANIZATION_STATUS', '1', 32, 'Default status for new organizations'),
(3, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'DEFAULT_AGENCY_STATUS', '3', 32, 'Default status for new agencies'),
(4, 1, 1, '2025-08-21 00:00:00', '2025-08-21 00:00:00', NULL, 30, 'DEFAULT_DIVISION_STATUS', '5', 32, 'Default status for new divisions'),
(5, 1, 1, '2025-08-23 00:00:00', '2025-08-23 19:21:48', '', 211, 'USER_DEFAULT_PASSWORD', 'Atlis01!', 212, 'Default password for new users'),
(6, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 270, 'PROJECT_FILE_MAX_UPLOAD_MB', '10', 271, 'Max upload size (MB) for project files'),
(7, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 270, 'PROJECT_FILE_MAX_FOLDERS', '10', 271, 'Maximum folders per project'),
(8, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 270, 'PROJECT_FILE_MAX_FOLDER_DEPTH', '3', 271, 'Maximum folder depth per project'),
(9, 1, 1, '2025-08-27 21:40:39', '2025-08-27 21:40:39', '', 51, 'ADMIN_MEETING_DEFAULT_END_DATE', '1 hour', 53, NULL);

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
(1, 1, 1, '2025-08-13 16:28:53', '2025-08-13 16:28:53', NULL, 1, 1, '/assets/logo.png', 'Initial version'),
(2, 1, NULL, '2025-08-23 19:17:59', '2025-08-23 19:17:59', NULL, 5, 1, 'ChangeMe123!', NULL),
(3, 1, NULL, '2025-08-23 19:21:48', '2025-08-23 19:21:48', NULL, 5, 2, 'Atlis01!', NULL),
(4, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 6, 1, '10', 'Initial version'),
(5, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 7, 1, '10', 'Initial version'),
(6, 1, 1, '2025-08-25 22:53:06', '2025-08-25 22:53:06', NULL, 8, 1, '3', 'Initial version'),
(7, 1, NULL, '2025-08-27 21:40:39', '2025-08-27 21:40:39', NULL, 9, 1, '1 hour', NULL);

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
  `last_login` datetime DEFAULT NULL,
  `JTIformer` tinyint(1) DEFAULT 0,
  `JTIcurrent` tinyint(1) DEFAULT 0,
  `JTI_start_date` date DEFAULT NULL,
  `JTI_end_date` date DEFAULT NULL,
  `JTI_Team` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_updated`, `date_created`, `date_updated`, `memo`, `email`, `password`, `email_verified`, `current_profile_pic_id`, `type`, `status`, `last_login`, `JTIformer`, `JTIcurrent`, `JTI_start_date`, `JTI_end_date`, `JTI_Team`) VALUES
(1, 1, 1, '2025-08-06 16:08:42', '2025-08-25 18:21:53', NULL, 'Dave@AtlisTechnologies.com', '$2y$10$DTIuXMqLvNh1N.Go53lZKeSh5.KoCRa3kjlfJ0yboVhbnvcTRmcn6', 1, 4, 'ADMIN', 1, '2025-08-25 18:21:53', 0, 0, NULL, NULL, NULL),
(2, 1, 1, '2025-08-15 00:11:11', '2025-08-21 15:31:21', NULL, 'Sean@AtlisTechnologies.com', '$2y$10$Bk4sqfPb4G49fa9HepMbBOfOjz/wEtvFJBSHIz9HFMO0nzOFeeJ3u', 0, 2, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(4, 1, 1, '2025-08-17 22:17:49', '2025-08-27 21:20:47', NULL, 'soup@atlistechnologies.com', '$2y$10$UWkUcrDvpwvGtkvTEht.0ORPydm5pxzWmafKMCVXvDgTYqZMTxlka', 0, NULL, 'USER', 1, '2025-08-27 21:20:47', 0, 0, NULL, NULL, ''),
(5, 1, 1, '2025-08-19 23:21:53', '2025-08-19 23:21:53', NULL, 'rcalara@lakecountyil.gov', '$2y$10$6ZS/zYF7mW3VZkEsiLyOBeiiJHfBrSLPEQveZpnfL5CeZV148k8vG', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(6, 1, 1, '2025-08-19 23:22:44', '2025-08-19 23:22:44', NULL, 'kkrynski@lakecountyil.gov', '$2y$10$gQEtHURn4ktYNyKR4f/1qeusz29IqCYGVO1/n7TE9xSqO81kqxNYi', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(7, 1, 1, '2025-08-19 23:27:09', '2025-08-19 23:27:09', NULL, 'milenyvaldez@AtlisTechnologies.com', '$2y$10$K3F6dYfzQbVGSoIXjWrOmucNiQwj9e/KOPK81f9NvE6YNu/V.pE6q', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(8, 1, 1, '2025-08-20 14:44:46', '2025-08-25 02:20:36', NULL, 'kenny@AtlisTechnologies.com', '$2y$10$MBdcSf/iWlQTDH5Zo9Od/ewd28dkz7Din.B4vAyxFW63MvemxCmVu', 0, NULL, 'USER', 1, '2025-08-25 02:20:01', 0, 0, NULL, NULL, ''),
(9, 1, 1, '2025-08-20 15:14:36', '2025-08-20 15:14:36', NULL, 'richardsprague3@gmail.com', '$2y$10$0oZA5Mfmqe5JMXzUDmaJyeCe4k1YF4jmRXGEtxPpW253QYyIXf/CK', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(10, 1, 1, '2025-08-20 20:47:24', '2025-08-20 20:47:24', NULL, 'emmabaylor@gmail.com', '$2y$10$4B6tCgezPP5mDagAeMGT.uf/1cRo1AtfaxVALRbBWlzpvQNDIv7bi', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(11, 1, 1, '2025-08-22 18:07:18', '2025-08-22 18:07:18', NULL, 'tom@atlistechnologies.com', '$2y$10$wtXJUR0GBfw/tmBeD5/qUeGbGEK/Bu35K0epng.Cd/YobvJlnWxEC', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(12, 1, 1, '2025-08-22 19:16:00', '2025-08-22 19:16:00', NULL, 'wwebber@lakecountyil.gov', '$2y$10$EBZvZWr/dB7bdh73ZPp1XuOODbDhH4mjTc9B4kWXR3m0kqV1SxfPy', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(13, 1, 1, '2025-08-23 10:55:54', '2025-08-23 10:55:54', NULL, 'zach@atlistechnologies.com', '$2y$10$aGr1GvSel95YbuW09OaLm.cgutOJVXV49insI7u0vNKreV1FZwY2a', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(14, 1, 1, '2025-08-23 15:00:41', '2025-08-23 15:00:41', NULL, 'idk@idk.com', '$2y$10$s4jIZBkvR1IDuxQ9rMJnlOwA2/SYDuCpNX2AzTtJdQluSLliAdq1u', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(15, 1, 1, '2025-08-23 17:44:36', '2025-08-23 17:44:36', NULL, 'chris@doc.com', '$2y$10$4jkkJwdy6.9jUVTWIEMopeoKaztrDeqFhR5LmwIjhLz7e6c5wSNvm', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, NULL),
(18, 1, 1, '2025-08-24 18:25:55', '2025-08-24 18:25:55', NULL, 'alishajean06@gmail.com', '$2y$10$J4Fd3CT8kB9o1tt7maSRfO7emvQ3OfAwv.vk9P4.Fw7IYn7QMYroO', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, ''),
(19, 1, 1, '2025-08-27 18:32:05', '2025-08-27 18:32:05', NULL, 'drivers@lakecountyil.gov', '$2y$10$CiY8maK.kK2bzidVSQ0tz.fSYW1N0CDZlUxOJFzOSdKW81e7vvA/a', 0, NULL, 'USER', 1, NULL, 0, 0, NULL, NULL, '');

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
(21, 4, 4, '2025-08-27 21:20:47', '2025-08-27 21:20:51', NULL, '756585', '2025-08-27 21:30:47', 1);

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
-- Indexes for table `admin_corporate`
--
ALTER TABLE `admin_corporate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_corporate_user_id` (`user_id`),
  ADD KEY `fk_module_corporate_user_updated` (`user_updated`);

--
-- Indexes for table `admin_corporate_files`
--
ALTER TABLE `admin_corporate_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_corporate_files_user_id` (`user_id`),
  ADD KEY `fk_module_corporate_files_user_updated` (`user_updated`),
  ADD KEY `fk_module_corporate_files_corporate_id` (`corporate_id`),
  ADD KEY `fk_module_corporate_files_note_id` (`note_id`);

--
-- Indexes for table `admin_corporate_notes`
--
ALTER TABLE `admin_corporate_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_corporate_notes_user_id` (`user_id`),
  ADD KEY `fk_module_corporate_notes_user_updated` (`user_updated`),
  ADD KEY `fk_module_corporate_notes_corporate_id` (`corporate_id`);

--
-- Indexes for table `admin_finances_invoices`
--
ALTER TABLE `admin_finances_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_finances_invoices_user_id` (`user_id`),
  ADD KEY `fk_admin_finances_invoices_user_updated` (`user_updated`),
  ADD KEY `fk_admin_finances_invoices_corporate_id` (`corporate_id`),
  ADD KEY `fk_admin_finances_invoices_status_id` (`status_id`);

--
-- Indexes for table `admin_finances_invoice_items`
--
ALTER TABLE `admin_finances_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_finances_invoice_items_user_id` (`user_id`),
  ADD KEY `fk_admin_finances_invoice_items_user_updated` (`user_updated`),
  ADD KEY `fk_admin_finances_invoice_items_invoice_id` (`invoice_id`),
  ADD KEY `fk_admin_finances_invoice_items_time_entry_id` (`time_entry_id`);

--
-- Indexes for table `admin_finances_invoice_sow`
--
ALTER TABLE `admin_finances_invoice_sow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_finances_invoice_sow_user_id` (`user_id`),
  ADD KEY `fk_admin_finances_invoice_sow_user_updated` (`user_updated`),
  ADD KEY `fk_admin_finances_invoice_sow_invoice_id` (`invoice_id`),
  ADD KEY `fk_admin_finances_invoice_sow_statement_id` (`statement_id`);

--
-- Indexes for table `admin_finances_statements_of_work`
--
ALTER TABLE `admin_finances_statements_of_work`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_finances_sow_user_id` (`user_id`),
  ADD KEY `fk_admin_finances_sow_user_updated` (`user_updated`),
  ADD KEY `fk_admin_finances_sow_corporate_id` (`corporate_id`),
  ADD KEY `fk_admin_finances_sow_status_id` (`status_id`);

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
-- Indexes for table `admin_task`
--
ALTER TABLE `admin_task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_task_user_id` (`user_id`),
  ADD KEY `fk_admin_task_user_updated` (`user_updated`),
  ADD KEY `fk_admin_task_type_id` (`type_id`),
  ADD KEY `fk_admin_task_category_id` (`category_id`),
  ADD KEY `fk_admin_task_sub_category_id` (`sub_category_id`),
  ADD KEY `fk_admin_task_status_id` (`status_id`),
  ADD KEY `fk_admin_task_priority_id` (`priority_id`);

--
-- Indexes for table `admin_task_assignments`
--
ALTER TABLE `admin_task_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_task_assignments_user_id` (`user_id`),
  ADD KEY `fk_admin_task_assignments_user_updated` (`user_updated`),
  ADD KEY `fk_admin_task_assignments_task_id` (`task_id`),
  ADD KEY `fk_admin_task_assignments_assigned_user_id` (`assigned_user_id`);

--
-- Indexes for table `admin_task_comments`
--
ALTER TABLE `admin_task_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_task_comments_user_id` (`user_id`),
  ADD KEY `fk_admin_task_comments_user_updated` (`user_updated`),
  ADD KEY `fk_admin_task_comments_task_id` (`task_id`);

--
-- Indexes for table `admin_task_files`
--
ALTER TABLE `admin_task_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_task_files_user_id` (`user_id`),
  ADD KEY `fk_admin_task_files_user_updated` (`user_updated`),
  ADD KEY `fk_admin_task_files_task_id` (`task_id`);

--
-- Indexes for table `admin_task_relations`
--
ALTER TABLE `admin_task_relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_task_relations_user_id` (`user_id`),
  ADD KEY `fk_admin_task_relations_user_updated` (`user_updated`),
  ADD KEY `fk_admin_task_relations_task_id` (`task_id`);

--
-- Indexes for table `admin_time_tracking_entries`
--
ALTER TABLE `admin_time_tracking_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_time_tracking_entries_user_id` (`user_id`),
  ADD KEY `fk_admin_time_tracking_entries_user_updated` (`user_updated`),
  ADD KEY `fk_admin_time_tracking_entries_corporate_id` (`corporate_id`),
  ADD KEY `fk_admin_time_tracking_entries_person_id` (`person_id`),
  ADD KEY `fk_admin_time_tracking_entries_invoice_id` (`invoice_id`);

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
  ADD KEY `idx_module_lookup_list_items_label` (`label`),
  ADD KEY `idx_lookup_list_items_active` (`list_id`,`active_from`,`active_to`);

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
-- Indexes for table `lookup_list_item_relations`
--
ALTER TABLE `lookup_list_item_relations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_lookup_list_item_relations_pair` (`item_id`,`related_item_id`),
  ADD KEY `fk_lookup_list_item_relations_item_id` (`item_id`),
  ADD KEY `fk_lookup_list_item_relations_related_item_id` (`related_item_id`),
  ADD KEY `fk_lookup_list_item_relations_user_id` (`user_id`),
  ADD KEY `fk_lookup_list_item_relations_user_updated` (`user_updated`);

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
-- Indexes for table `module_agency_assignments`
--
ALTER TABLE `module_agency_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_agency_assignments_user_id` (`user_id`),
  ADD KEY `fk_module_agency_assignments_user_updated` (`user_updated`),
  ADD KEY `fk_module_agency_assignments_agency_id` (`agency_id`),
  ADD KEY `fk_module_agency_assignments_assigned_user_id` (`assigned_user_id`);

--
-- Indexes for table `module_agency_persons`
--
ALTER TABLE `module_agency_persons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_agency_persons_user_id` (`user_id`),
  ADD KEY `fk_module_agency_persons_user_updated` (`user_updated`),
  ADD KEY `fk_module_agency_persons_agency_id` (`agency_id`),
  ADD KEY `fk_module_agency_persons_person_id` (`person_id`),
  ADD KEY `fk_module_agency_persons_role_id` (`role_id`);

--
-- Indexes for table `module_calendar`
--
ALTER TABLE `module_calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_calendar_events`
--
ALTER TABLE `module_calendar_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_calendar_events_calendar_id` (`calendar_id`),
  ADD KEY `fk_module_calendar_events_event_type_id` (`event_type_id`),
  ADD KEY `fk_module_calendar_events_link_record_id` (`link_record_id`),
  ADD KEY `fk_module_calendar_events_user_id` (`user_id`),
  ADD KEY `fk_module_calendar_events_user_updated` (`user_updated`),
  ADD KEY `fk_module_calendar_events_visibility_id` (`visibility_id`),
  ADD KEY `idx_calendar_events_start_time` (`start_time`);

--
-- Indexes for table `module_calendar_external_accounts`
--
ALTER TABLE `module_calendar_external_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_calendar_external_accounts_user_id` (`user_id`),
  ADD KEY `fk_module_calendar_external_accounts_user_updated` (`user_updated`),
  ADD KEY `idx_module_calendar_external_accounts_provider` (`provider`);

--
-- Indexes for table `module_calendar_person_attendees`
--
ALTER TABLE `module_calendar_person_attendees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_event_person` (`event_id`,`attendee_person_id`),
  ADD KEY `fk_module_calendar_event_attendees_user_id` (`user_id`),
  ADD KEY `fk_module_calendar_event_attendees_user_updated` (`user_updated`),
  ADD KEY `fk_module_calendar_event_attendees_event_id` (`event_id`),
  ADD KEY `fk_module_calendar_person_attendees_attendee_person_id` (`attendee_person_id`);

--
-- Indexes for table `module_conferences`
--
ALTER TABLE `module_conferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_conferences_user_id` (`user_id`),
  ADD KEY `fk_module_conferences_user_updated` (`user_updated`);

--
-- Indexes for table `module_conference_attendees`
--
ALTER TABLE `module_conference_attendees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_conference_attendees_user_id` (`user_id`),
  ADD KEY `fk_module_conference_attendees_user_updated` (`user_updated`),
  ADD KEY `fk_module_conference_attendees_conference_id` (`conference_id`),
  ADD KEY `fk_module_conference_attendees_attendee_user_id` (`attendee_user_id`);

--
-- Indexes for table `module_conference_images`
--
ALTER TABLE `module_conference_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_conference_images_user_id` (`user_id`),
  ADD KEY `fk_module_conference_images_user_updated` (`user_updated`),
  ADD KEY `fk_module_conference_images_conference_id` (`conference_id`);

--
-- Indexes for table `module_conference_tags`
--
ALTER TABLE `module_conference_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_conference_tags_user_id` (`user_id`),
  ADD KEY `fk_module_conference_tags_user_updated` (`user_updated`),
  ADD KEY `fk_module_conference_tags_conference_id` (`conference_id`);

--
-- Indexes for table `module_conference_ticket_options`
--
ALTER TABLE `module_conference_ticket_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_conference_ticket_options_user_id` (`user_id`),
  ADD KEY `fk_module_conference_ticket_options_user_updated` (`user_updated`),
  ADD KEY `fk_module_conference_ticket_options_conference_id` (`conference_id`);

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
-- Indexes for table `module_division_persons`
--
ALTER TABLE `module_division_persons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_division_persons_user_id` (`user_id`),
  ADD KEY `fk_module_division_persons_user_updated` (`user_updated`),
  ADD KEY `fk_module_division_persons_division_id` (`division_id`),
  ADD KEY `fk_module_division_persons_person_id` (`person_id`),
  ADD KEY `fk_module_division_persons_role_id` (`role_id`);

--
-- Indexes for table `module_feedback`
--
ALTER TABLE `module_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_feedback_user_id` (`user_id`),
  ADD KEY `fk_module_feedback_user_updated` (`user_updated`),
  ADD KEY `fk_module_feedback_type_id` (`type`);

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
-- Indexes for table `module_meetings`
--
ALTER TABLE `module_meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_meetings_user_id` (`user_id`),
  ADD KEY `fk_module_meetings_user_updated` (`user_updated`),
  ADD KEY `fk_module_meetings_calendar_event_id` (`calendar_event_id`),
  ADD KEY `fk_module_meetings_status_id` (`status_id`),
  ADD KEY `fk_module_meetings_type_id` (`type_id`);

--
-- Indexes for table `module_meeting_agenda`
--
ALTER TABLE `module_meeting_agenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_meeting_agenda_user_id` (`user_id`),
  ADD KEY `fk_module_meeting_agenda_user_updated` (`user_updated`),
  ADD KEY `fk_module_meeting_agenda_meeting_id` (`meeting_id`),
  ADD KEY `fk_module_meeting_agenda_status_id` (`status_id`),
  ADD KEY `fk_module_meeting_agenda_linked_task_id` (`linked_task_id`),
  ADD KEY `fk_module_meeting_agenda_linked_project_id` (`linked_project_id`);

--
-- Indexes for table `module_meeting_attendees`
--
ALTER TABLE `module_meeting_attendees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_meeting_attendees_user_id` (`user_id`),
  ADD KEY `fk_module_meeting_attendees_user_updated` (`user_updated`),
  ADD KEY `fk_module_meeting_attendees_meeting_id` (`meeting_id`),
  ADD KEY `fk_module_meeting_attendees_attendee_user_id` (`attendee_user_id`);

--
-- Indexes for table `module_meeting_files`
--
ALTER TABLE `module_meeting_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_meeting_files_user_id` (`user_id`),
  ADD KEY `fk_module_meeting_files_user_updated` (`user_updated`),
  ADD KEY `fk_module_meeting_files_meeting_id` (`meeting_id`),
  ADD KEY `fk_module_meeting_files_uploader_id` (`uploader_id`);

--
-- Indexes for table `module_meeting_questions`
--
ALTER TABLE `module_meeting_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_meeting_questions_user_id` (`user_id`),
  ADD KEY `fk_module_meeting_questions_agenda_id` (`agenda_id`),
  ADD KEY `fk_module_meeting_questions_meeting_id` (`meeting_id`),
  ADD KEY `fk_module_meeting_questions_status_id` (`status_id`),
  ADD KEY `fk_module_meeting_questions_user_updated` (`user_updated`);

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
-- Indexes for table `module_organization_persons`
--
ALTER TABLE `module_organization_persons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_organization_persons_user_id` (`user_id`),
  ADD KEY `fk_module_organization_persons_user_updated` (`user_updated`),
  ADD KEY `fk_module_organization_persons_organization_id` (`organization_id`),
  ADD KEY `fk_module_organization_persons_person_id` (`person_id`),
  ADD KEY `fk_module_organization_persons_role_id` (`role_id`);

--
-- Indexes for table `module_products_services`
--
ALTER TABLE `module_products_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_products_services_user_id` (`user_id`),
  ADD KEY `fk_module_products_services_user_updated` (`user_updated`),
  ADD KEY `fk_module_products_services_status_id` (`status_id`);

--
-- Indexes for table `module_products_services_category`
--
ALTER TABLE `module_products_services_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_updated` (`user_updated`),
  ADD KEY `product_service_id` (`product_service_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `module_products_services_person`
--
ALTER TABLE `module_products_services_person`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_products_services_person_user_id` (`user_id`),
  ADD KEY `fk_module_products_services_person_user_updated` (`user_updated`),
  ADD KEY `fk_module_products_services_person_product_service_id` (`product_service_id`),
  ADD KEY `fk_module_products_services_person_person_id` (`person_id`),
  ADD KEY `fk_module_products_services_person_skill_id` (`skill_id`);

--
-- Indexes for table `module_products_services_price_history`
--
ALTER TABLE `module_products_services_price_history`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `module_projects_answers`
--
ALTER TABLE `module_projects_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_projects_answers_user_id` (`user_id`),
  ADD KEY `fk_module_projects_answers_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_answers_question_id` (`question_id`);

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
  ADD KEY `fk_module_projects_files_question_id` (`question_id`),
  ADD KEY `fk_module_projects_files_file_type_id` (`file_type_id`),
  ADD KEY `fk_module_projects_files_status_id` (`status_id`),
  ADD KEY `fk_module_projects_files_folder_id` (`folder_id`);

--
-- Indexes for table `module_projects_folders`
--
ALTER TABLE `module_projects_folders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_project_path` (`project_id`,`path`),
  ADD KEY `fk_module_projects_folders_user_id` (`user_id`),
  ADD KEY `fk_module_projects_folders_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_folders_project_id` (`project_id`),
  ADD KEY `fk_module_projects_folders_parent_id` (`parent_id`);

--
-- Indexes for table `module_projects_notes`
--
ALTER TABLE `module_projects_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_projects_notes_user_id` (`user_id`),
  ADD KEY `fk_module_projects_notes_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_notes_project_id` (`project_id`);

--
-- Indexes for table `module_projects_pins`
--
ALTER TABLE `module_projects_pins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_projects_questions`
--
ALTER TABLE `module_projects_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_projects_questions_user_id` (`user_id`),
  ADD KEY `fk_module_projects_questions_user_updated` (`user_updated`),
  ADD KEY `fk_module_projects_questions_project_id` (`project_id`);

--
-- Indexes for table `module_strategy`
--
ALTER TABLE `module_strategy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_updated` (`user_updated`),
  ADD KEY `corporate_id` (`corporate_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `priority_id` (`priority_id`);

--
-- Indexes for table `module_strategy_collaborators`
--
ALTER TABLE `module_strategy_collaborators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_updated` (`user_updated`),
  ADD KEY `strategy_id` (`strategy_id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `module_strategy_files`
--
ALTER TABLE `module_strategy_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_updated` (`user_updated`),
  ADD KEY `strategy_id` (`strategy_id`);

--
-- Indexes for table `module_strategy_key_results`
--
ALTER TABLE `module_strategy_key_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_updated` (`user_updated`),
  ADD KEY `objective_id` (`objective_id`),
  ADD KEY `fk_mskr_task` (`task_id`),
  ADD KEY `fk_mskr_project` (`project_id`);

--
-- Indexes for table `module_strategy_notes`
--
ALTER TABLE `module_strategy_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_updated` (`user_updated`),
  ADD KEY `strategy_id` (`strategy_id`);

--
-- Indexes for table `module_strategy_objectives`
--
ALTER TABLE `module_strategy_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_updated` (`user_updated`),
  ADD KEY `strategy_id` (`strategy_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `module_strategy_tags`
--
ALTER TABLE `module_strategy_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_updated` (`user_updated`),
  ADD KEY `strategy_id` (`strategy_id`);

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
-- Indexes for table `module_tasks_answers`
--
ALTER TABLE `module_tasks_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_tasks_answers_user_id` (`user_id`),
  ADD KEY `fk_module_tasks_answers_user_updated` (`user_updated`),
  ADD KEY `fk_module_tasks_answers_question_id` (`question_id`);

--
-- Indexes for table `module_tasks_files`
--
ALTER TABLE `module_tasks_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_tasks_files_user_id` (`user_id`),
  ADD KEY `fk_module_tasks_files_user_updated` (`user_updated`),
  ADD KEY `fk_module_tasks_files_task_id` (`task_id`),
  ADD KEY `fk_module_tasks_files_note_id` (`note_id`),
  ADD KEY `fk_module_tasks_files_question_id` (`question_id`);

--
-- Indexes for table `module_tasks_notes`
--
ALTER TABLE `module_tasks_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_tasks_notes_user_id` (`user_id`),
  ADD KEY `fk_module_tasks_notes_user_updated` (`user_updated`),
  ADD KEY `fk_module_tasks_notes_task_id` (`task_id`);

--
-- Indexes for table `module_tasks_questions`
--
ALTER TABLE `module_tasks_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_tasks_questions_user_id` (`user_id`),
  ADD KEY `fk_module_tasks_questions_user_updated` (`user_updated`),
  ADD KEY `fk_module_tasks_questions_task_id` (`task_id`);

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
-- Indexes for table `module_users_defaults`
--
ALTER TABLE `module_users_defaults`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_module_users_defaults_user_list` (`user_id`,`list_name`),
  ADD KEY `fk_module_users_defaults_user_id` (`user_id`),
  ADD KEY `fk_module_users_defaults_user_updated` (`user_updated`),
  ADD KEY `fk_module_users_defaults_item_id` (`item_id`);

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
-- Indexes for table `person_skills`
--
ALTER TABLE `person_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_person_skills_user_id` (`user_id`),
  ADD KEY `fk_person_skills_user_updated` (`user_updated`),
  ADD KEY `fk_person_skills_person_id` (`person_id`),
  ADD KEY `fk_person_skills_skill_id` (`skill_id`),
  ADD KEY `fk_person_skills_level_id` (`level_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=336;

--
-- AUTO_INCREMENT for table `admin_corporate`
--
ALTER TABLE `admin_corporate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_corporate_files`
--
ALTER TABLE `admin_corporate_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_corporate_notes`
--
ALTER TABLE `admin_corporate_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_finances_invoices`
--
ALTER TABLE `admin_finances_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_finances_invoice_items`
--
ALTER TABLE `admin_finances_invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_finances_invoice_sow`
--
ALTER TABLE `admin_finances_invoice_sow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_finances_statements_of_work`
--
ALTER TABLE `admin_finances_statements_of_work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_navigation_links`
--
ALTER TABLE `admin_navigation_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `admin_permission_groups`
--
ALTER TABLE `admin_permission_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `admin_permission_group_permissions`
--
ALTER TABLE `admin_permission_group_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `admin_role_permission_groups`
--
ALTER TABLE `admin_role_permission_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `admin_task`
--
ALTER TABLE `admin_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_task_assignments`
--
ALTER TABLE `admin_task_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin_task_comments`
--
ALTER TABLE `admin_task_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_task_files`
--
ALTER TABLE `admin_task_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_task_relations`
--
ALTER TABLE `admin_task_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_time_tracking_entries`
--
ALTER TABLE `admin_time_tracking_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;

--
-- AUTO_INCREMENT for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `lookup_list_item_relations`
--
ALTER TABLE `lookup_list_item_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_agency`
--
ALTER TABLE `module_agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module_agency_assignments`
--
ALTER TABLE `module_agency_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_agency_persons`
--
ALTER TABLE `module_agency_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `module_calendar`
--
ALTER TABLE `module_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `module_calendar_events`
--
ALTER TABLE `module_calendar_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_calendar_external_accounts`
--
ALTER TABLE `module_calendar_external_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_calendar_person_attendees`
--
ALTER TABLE `module_calendar_person_attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_conferences`
--
ALTER TABLE `module_conferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module_conference_attendees`
--
ALTER TABLE `module_conference_attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_conference_images`
--
ALTER TABLE `module_conference_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_conference_tags`
--
ALTER TABLE `module_conference_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `module_conference_ticket_options`
--
ALTER TABLE `module_conference_ticket_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_contractors`
--
ALTER TABLE `module_contractors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `module_contractors_compensation`
--
ALTER TABLE `module_contractors_compensation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `module_contractors_contacts`
--
ALTER TABLE `module_contractors_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `module_contractors_notes`
--
ALTER TABLE `module_contractors_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module_contractors_status_history`
--
ALTER TABLE `module_contractors_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_division`
--
ALTER TABLE `module_division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `module_division_persons`
--
ALTER TABLE `module_division_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `module_feedback`
--
ALTER TABLE `module_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- AUTO_INCREMENT for table `module_meetings`
--
ALTER TABLE `module_meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module_meeting_agenda`
--
ALTER TABLE `module_meeting_agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `module_meeting_attendees`
--
ALTER TABLE `module_meeting_attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_meeting_files`
--
ALTER TABLE `module_meeting_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module_meeting_questions`
--
ALTER TABLE `module_meeting_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_organization`
--
ALTER TABLE `module_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `module_organization_persons`
--
ALTER TABLE `module_organization_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_products_services`
--
ALTER TABLE `module_products_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `module_products_services_category`
--
ALTER TABLE `module_products_services_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_products_services_person`
--
ALTER TABLE `module_products_services_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module_products_services_price_history`
--
ALTER TABLE `module_products_services_price_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_projects`
--
ALTER TABLE `module_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `module_projects_answers`
--
ALTER TABLE `module_projects_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module_projects_assignments`
--
ALTER TABLE `module_projects_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `module_projects_files`
--
ALTER TABLE `module_projects_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `module_projects_folders`
--
ALTER TABLE `module_projects_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `module_projects_notes`
--
ALTER TABLE `module_projects_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `module_projects_pins`
--
ALTER TABLE `module_projects_pins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `module_projects_questions`
--
ALTER TABLE `module_projects_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `module_strategy`
--
ALTER TABLE `module_strategy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_strategy_collaborators`
--
ALTER TABLE `module_strategy_collaborators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_strategy_files`
--
ALTER TABLE `module_strategy_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_strategy_key_results`
--
ALTER TABLE `module_strategy_key_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_strategy_notes`
--
ALTER TABLE `module_strategy_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_strategy_objectives`
--
ALTER TABLE `module_strategy_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_strategy_tags`
--
ALTER TABLE `module_strategy_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_tasks`
--
ALTER TABLE `module_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `module_tasks_answers`
--
ALTER TABLE `module_tasks_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module_tasks_files`
--
ALTER TABLE `module_tasks_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `module_tasks_notes`
--
ALTER TABLE `module_tasks_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `module_tasks_questions`
--
ALTER TABLE `module_tasks_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `module_task_assignments`
--
ALTER TABLE `module_task_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `module_users_defaults`
--
ALTER TABLE `module_users_defaults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `person_addresses`
--
ALTER TABLE `person_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `person_phones`
--
ALTER TABLE `person_phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `person_skills`
--
ALTER TABLE `person_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_properties`
--
ALTER TABLE `system_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `system_properties_versions`
--
ALTER TABLE `system_properties_versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users_2fa`
--
ALTER TABLE `users_2fa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users_profile_pics`
--
ALTER TABLE `users_profile_pics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_corporate`
--
ALTER TABLE `admin_corporate`
  ADD CONSTRAINT `fk_module_corporate_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_corporate_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_corporate_files`
--
ALTER TABLE `admin_corporate_files`
  ADD CONSTRAINT `fk_module_corporate_files_corporate_id` FOREIGN KEY (`corporate_id`) REFERENCES `admin_corporate` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_corporate_files_note_id` FOREIGN KEY (`note_id`) REFERENCES `admin_corporate_notes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_corporate_files_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_corporate_files_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_corporate_notes`
--
ALTER TABLE `admin_corporate_notes`
  ADD CONSTRAINT `fk_module_corporate_notes_corporate_id` FOREIGN KEY (`corporate_id`) REFERENCES `admin_corporate` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_corporate_notes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_corporate_notes_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_finances_invoices`
--
ALTER TABLE `admin_finances_invoices`
  ADD CONSTRAINT `fk_admin_finances_invoices_corporate_id` FOREIGN KEY (`corporate_id`) REFERENCES `admin_corporate` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_finances_invoices_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_finances_invoices_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_finances_invoices_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_finances_invoice_items`
--
ALTER TABLE `admin_finances_invoice_items`
  ADD CONSTRAINT `fk_admin_finances_invoice_items_invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `admin_finances_invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_finances_invoice_items_time_entry_id` FOREIGN KEY (`time_entry_id`) REFERENCES `admin_time_tracking_entries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_finances_invoice_items_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_finances_invoice_items_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_finances_invoice_sow`
--
ALTER TABLE `admin_finances_invoice_sow`
  ADD CONSTRAINT `fk_admin_finances_invoice_sow_invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `admin_finances_invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_finances_invoice_sow_statement_id` FOREIGN KEY (`statement_id`) REFERENCES `admin_finances_statements_of_work` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_finances_invoice_sow_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_finances_invoice_sow_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_finances_statements_of_work`
--
ALTER TABLE `admin_finances_statements_of_work`
  ADD CONSTRAINT `fk_admin_finances_sow_corporate_id` FOREIGN KEY (`corporate_id`) REFERENCES `admin_corporate` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_finances_sow_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_finances_sow_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_finances_sow_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `admin_task`
--
ALTER TABLE `admin_task`
  ADD CONSTRAINT `fk_admin_task_category_id` FOREIGN KEY (`category_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_task_priority_id` FOREIGN KEY (`priority_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_task_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_task_sub_category_id` FOREIGN KEY (`sub_category_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_task_type_id` FOREIGN KEY (`type_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_task_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_task_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_task_assignments`
--
ALTER TABLE `admin_task_assignments`
  ADD CONSTRAINT `fk_admin_task_assignments_assigned_user_id` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_task_assignments_task_id` FOREIGN KEY (`task_id`) REFERENCES `admin_task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_task_assignments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_task_assignments_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_task_comments`
--
ALTER TABLE `admin_task_comments`
  ADD CONSTRAINT `fk_admin_task_comments_task_id` FOREIGN KEY (`task_id`) REFERENCES `admin_task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_task_comments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_task_comments_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_task_files`
--
ALTER TABLE `admin_task_files`
  ADD CONSTRAINT `fk_admin_task_files_task_id` FOREIGN KEY (`task_id`) REFERENCES `admin_task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_task_files_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_task_files_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_task_relations`
--
ALTER TABLE `admin_task_relations`
  ADD CONSTRAINT `fk_admin_task_relations_task_id` FOREIGN KEY (`task_id`) REFERENCES `admin_task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_task_relations_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_task_relations_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_time_tracking_entries`
--
ALTER TABLE `admin_time_tracking_entries`
  ADD CONSTRAINT `fk_admin_time_tracking_entries_corporate_id` FOREIGN KEY (`corporate_id`) REFERENCES `admin_corporate` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_time_tracking_entries_invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `admin_finances_invoices` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_time_tracking_entries_person_id` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_time_tracking_entries_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_admin_time_tracking_entries_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `lookup_list_item_relations`
--
ALTER TABLE `lookup_list_item_relations`
  ADD CONSTRAINT `fk_lookup_list_item_relations_item_id` FOREIGN KEY (`item_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_lookup_list_item_relations_related_item_id` FOREIGN KEY (`related_item_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_lookup_list_item_relations_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_lookup_list_item_relations_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_agency`
--
ALTER TABLE `module_agency`
  ADD CONSTRAINT `fk_module_agency_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_agency_organization_id` FOREIGN KEY (`organization_id`) REFERENCES `module_organization` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_agency_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_agency_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_agency_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_agency_assignments`
--
ALTER TABLE `module_agency_assignments`
  ADD CONSTRAINT `fk_module_agency_assignments_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`),
  ADD CONSTRAINT `fk_module_agency_assignments_assigned_user_id` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_agency_assignments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_agency_assignments_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_agency_persons`
--
ALTER TABLE `module_agency_persons`
  ADD CONSTRAINT `fk_module_agency_persons_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_agency_persons_person_id` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_agency_persons_role_id` FOREIGN KEY (`role_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_agency_persons_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_agency_persons_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_calendar_events`
--
ALTER TABLE `module_calendar_events`
  ADD CONSTRAINT `fk_module_calendar_events_calendar_id` FOREIGN KEY (`calendar_id`) REFERENCES `module_calendar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_calendar_events_event_type_id` FOREIGN KEY (`event_type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_calendar_events_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_calendar_events_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_calendar_events_visibility_id` FOREIGN KEY (`visibility_id`) REFERENCES `lookup_list_items` (`id`);

--
-- Constraints for table `module_calendar_external_accounts`
--
ALTER TABLE `module_calendar_external_accounts`
  ADD CONSTRAINT `fk_module_calendar_external_accounts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_calendar_external_accounts_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_calendar_person_attendees`
--
ALTER TABLE `module_calendar_person_attendees`
  ADD CONSTRAINT `fk_module_calendar_event_attendees_event_id` FOREIGN KEY (`event_id`) REFERENCES `module_calendar_events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_calendar_event_attendees_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_calendar_event_attendees_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_calendar_person_attendees_attendee_person_id` FOREIGN KEY (`attendee_person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_conferences`
--
ALTER TABLE `module_conferences`
  ADD CONSTRAINT `fk_module_conferences_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_conferences_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `module_conference_attendees`
--
ALTER TABLE `module_conference_attendees`
  ADD CONSTRAINT `fk_module_conference_attendees_attendee_user_id` FOREIGN KEY (`attendee_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_conference_attendees_conference_id` FOREIGN KEY (`conference_id`) REFERENCES `module_conferences` (`id`),
  ADD CONSTRAINT `fk_module_conference_attendees_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_conference_attendees_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `module_conference_images`
--
ALTER TABLE `module_conference_images`
  ADD CONSTRAINT `fk_module_conference_images_conference_id` FOREIGN KEY (`conference_id`) REFERENCES `module_conferences` (`id`),
  ADD CONSTRAINT `fk_module_conference_images_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_conference_images_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `module_conference_tags`
--
ALTER TABLE `module_conference_tags`
  ADD CONSTRAINT `fk_module_conference_tags_conference_id` FOREIGN KEY (`conference_id`) REFERENCES `module_conferences` (`id`),
  ADD CONSTRAINT `fk_module_conference_tags_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_conference_tags_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `module_conference_ticket_options`
--
ALTER TABLE `module_conference_ticket_options`
  ADD CONSTRAINT `fk_module_conference_ticket_options_conference_id` FOREIGN KEY (`conference_id`) REFERENCES `module_conferences` (`id`),
  ADD CONSTRAINT `fk_module_conference_ticket_options_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_conference_ticket_options_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

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
-- Constraints for table `module_division_persons`
--
ALTER TABLE `module_division_persons`
  ADD CONSTRAINT `fk_module_division_persons_division_id` FOREIGN KEY (`division_id`) REFERENCES `module_division` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_division_persons_person_id` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_division_persons_role_id` FOREIGN KEY (`role_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_division_persons_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_division_persons_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_feedback`
--
ALTER TABLE `module_feedback`
  ADD CONSTRAINT `fk_module_feedback_type_id` FOREIGN KEY (`type`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_feedback_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_feedback_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `module_meetings`
--
ALTER TABLE `module_meetings`
  ADD CONSTRAINT `fk_module_meetings_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_meetings_type_id` FOREIGN KEY (`type_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_meetings_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_meetings_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_meeting_agenda`
--
ALTER TABLE `module_meeting_agenda`
  ADD CONSTRAINT `fk_module_meeting_agenda_meeting_id` FOREIGN KEY (`meeting_id`) REFERENCES `module_meetings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_meeting_agenda_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_meeting_questions`
--
ALTER TABLE `module_meeting_questions`
  ADD CONSTRAINT `fk_module_meeting_questions_agenda_id` FOREIGN KEY (`agenda_id`) REFERENCES `module_meeting_agenda` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_meeting_questions_meeting_id` FOREIGN KEY (`meeting_id`) REFERENCES `module_meetings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_meeting_questions_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_meeting_questions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_meeting_questions_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_organization`
--
ALTER TABLE `module_organization`
  ADD CONSTRAINT `fk_module_organization_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_organization_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_organization_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_organization_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_organization_persons`
--
ALTER TABLE `module_organization_persons`
  ADD CONSTRAINT `fk_module_organization_persons_organization_id` FOREIGN KEY (`organization_id`) REFERENCES `module_organization` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_organization_persons_person_id` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_organization_persons_role_id` FOREIGN KEY (`role_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_organization_persons_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_organization_persons_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_products_services_category`
--
ALTER TABLE `module_products_services_category`
  ADD CONSTRAINT `module_products_services_category_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `module_products_services_category_ibfk_2` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `module_products_services_category_ibfk_3` FOREIGN KEY (`product_service_id`) REFERENCES `module_products_services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `module_products_services_category_ibfk_4` FOREIGN KEY (`category_id`) REFERENCES `lookup_list_items` (`id`);

--
-- Constraints for table `module_products_services_person`
--
ALTER TABLE `module_products_services_person`
  ADD CONSTRAINT `fk_module_products_services_person_person_id` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_products_services_person_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_products_services_person_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `module_projects_answers`
--
ALTER TABLE `module_projects_answers`
  ADD CONSTRAINT `fk_module_projects_answers_question_id` FOREIGN KEY (`question_id`) REFERENCES `module_projects_questions` (`id`);

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
  ADD CONSTRAINT `fk_module_projects_files_folder_id` FOREIGN KEY (`folder_id`) REFERENCES `module_projects_folders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_projects_files_note_id` FOREIGN KEY (`note_id`) REFERENCES `module_projects_notes` (`id`),
  ADD CONSTRAINT `fk_module_projects_files_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`),
  ADD CONSTRAINT `fk_module_projects_files_question_id` FOREIGN KEY (`question_id`) REFERENCES `module_projects_questions` (`id`),
  ADD CONSTRAINT `fk_module_projects_files_status_id` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`);

--
-- Constraints for table `module_projects_folders`
--
ALTER TABLE `module_projects_folders`
  ADD CONSTRAINT `fk_module_projects_folders_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `module_projects_folders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_projects_folders_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_projects_folders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_module_projects_folders_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `module_projects_notes`
--
ALTER TABLE `module_projects_notes`
  ADD CONSTRAINT `fk_module_projects_notes_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`);

--
-- Constraints for table `module_projects_questions`
--
ALTER TABLE `module_projects_questions`
  ADD CONSTRAINT `fk_module_projects_questions_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`);

--
-- Constraints for table `module_strategy`
--
ALTER TABLE `module_strategy`
  ADD CONSTRAINT `module_strategy_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_ibfk_2` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_ibfk_3` FOREIGN KEY (`corporate_id`) REFERENCES `admin_corporate` (`id`),
  ADD CONSTRAINT `module_strategy_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `module_strategy_ibfk_5` FOREIGN KEY (`priority_id`) REFERENCES `lookup_list_items` (`id`);

--
-- Constraints for table `module_strategy_collaborators`
--
ALTER TABLE `module_strategy_collaborators`
  ADD CONSTRAINT `module_strategy_collaborators_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_collaborators_ibfk_2` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_collaborators_ibfk_3` FOREIGN KEY (`strategy_id`) REFERENCES `module_strategy` (`id`),
  ADD CONSTRAINT `module_strategy_collaborators_ibfk_4` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `module_strategy_collaborators_ibfk_5` FOREIGN KEY (`role_id`) REFERENCES `lookup_list_items` (`id`);

--
-- Constraints for table `module_strategy_files`
--
ALTER TABLE `module_strategy_files`
  ADD CONSTRAINT `module_strategy_files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_files_ibfk_2` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_files_ibfk_3` FOREIGN KEY (`strategy_id`) REFERENCES `module_strategy` (`id`);

--
-- Constraints for table `module_strategy_key_results`
--
ALTER TABLE `module_strategy_key_results`
  ADD CONSTRAINT `fk_mskr_project` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mskr_task` FOREIGN KEY (`task_id`) REFERENCES `module_tasks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `module_strategy_key_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_key_results_ibfk_2` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_key_results_ibfk_3` FOREIGN KEY (`objective_id`) REFERENCES `module_strategy_objectives` (`id`);

--
-- Constraints for table `module_strategy_notes`
--
ALTER TABLE `module_strategy_notes`
  ADD CONSTRAINT `module_strategy_notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_notes_ibfk_2` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_notes_ibfk_3` FOREIGN KEY (`strategy_id`) REFERENCES `module_strategy` (`id`);

--
-- Constraints for table `module_strategy_objectives`
--
ALTER TABLE `module_strategy_objectives`
  ADD CONSTRAINT `module_strategy_objectives_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_objectives_ibfk_2` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_objectives_ibfk_3` FOREIGN KEY (`strategy_id`) REFERENCES `module_strategy` (`id`),
  ADD CONSTRAINT `module_strategy_objectives_ibfk_4` FOREIGN KEY (`parent_id`) REFERENCES `module_strategy_objectives` (`id`),
  ADD CONSTRAINT `module_strategy_objectives_ibfk_5` FOREIGN KEY (`owner_id`) REFERENCES `person` (`id`);

--
-- Constraints for table `module_strategy_tags`
--
ALTER TABLE `module_strategy_tags`
  ADD CONSTRAINT `module_strategy_tags_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_tags_ibfk_2` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `module_strategy_tags_ibfk_3` FOREIGN KEY (`strategy_id`) REFERENCES `module_strategy` (`id`);

--
-- Constraints for table `module_tasks`
--
ALTER TABLE `module_tasks`
  ADD CONSTRAINT `fk_module_tasks_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`),
  ADD CONSTRAINT `fk_module_tasks_division_id` FOREIGN KEY (`division_id`) REFERENCES `module_division` (`id`),
  ADD CONSTRAINT `fk_module_tasks_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`);

--
-- Constraints for table `module_tasks_answers`
--
ALTER TABLE `module_tasks_answers`
  ADD CONSTRAINT `fk_module_tasks_answers_question_id` FOREIGN KEY (`question_id`) REFERENCES `module_tasks_questions` (`id`);

--
-- Constraints for table `module_tasks_files`
--
ALTER TABLE `module_tasks_files`
  ADD CONSTRAINT `fk_module_tasks_files_note_id` FOREIGN KEY (`note_id`) REFERENCES `module_tasks_notes` (`id`),
  ADD CONSTRAINT `fk_module_tasks_files_question_id` FOREIGN KEY (`question_id`) REFERENCES `module_tasks_questions` (`id`),
  ADD CONSTRAINT `fk_module_tasks_files_task_id` FOREIGN KEY (`task_id`) REFERENCES `module_tasks` (`id`);

--
-- Constraints for table `module_tasks_notes`
--
ALTER TABLE `module_tasks_notes`
  ADD CONSTRAINT `fk_module_tasks_notes_task_id` FOREIGN KEY (`task_id`) REFERENCES `module_tasks` (`id`);

--
-- Constraints for table `module_tasks_questions`
--
ALTER TABLE `module_tasks_questions`
  ADD CONSTRAINT `fk_module_tasks_questions_task_id` FOREIGN KEY (`task_id`) REFERENCES `module_tasks` (`id`);

--
-- Constraints for table `module_task_assignments`
--
ALTER TABLE `module_task_assignments`
  ADD CONSTRAINT `fk_module_task_assignments_assigned_user_id` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_task_assignments_task_id` FOREIGN KEY (`task_id`) REFERENCES `module_tasks` (`id`);

--
-- Constraints for table `module_users_defaults`
--
ALTER TABLE `module_users_defaults`
  ADD CONSTRAINT `fk_module_users_defaults_item_id` FOREIGN KEY (`item_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_module_users_defaults_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_module_users_defaults_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `person_skills`
--
ALTER TABLE `person_skills`
  ADD CONSTRAINT `fk_person_skills_level_id` FOREIGN KEY (`level_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_person_skills_person_id` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_person_skills_skill_id` FOREIGN KEY (`skill_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_person_skills_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_person_skills_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
