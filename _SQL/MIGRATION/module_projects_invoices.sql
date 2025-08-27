-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2025 at 09:36 AM
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
-- Database: `atlisware`
--

-- --------------------------------------------------------

--
-- Table structure for table `module_projects_invoices`
--

CREATE TABLE `module_projects_invoices` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(999) DEFAULT NULL,
  `amount` varchar(999) DEFAULT NULL,
  `hours` varchar(999) DEFAULT NULL,
  `rate` varchar(999) DEFAULT NULL,
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_updated_by` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `status` varchar(999) DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `date_paid` datetime DEFAULT NULL,
  `attachment` varchar(999) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_projects_invoices`
--

INSERT INTO `module_projects_invoices` (`id`, `project_id`, `name`, `amount`, `hours`, `rate`, `last_updated`, `last_updated_by`, `date_created`, `created_by`, `status`, `date_sent`, `date_paid`, `attachment`, `notes`) VALUES
(1, 1, 'Lake County Invoice #1 - Last two weeks of October 2024', '2062.5', '13.75', '150', '0000-00-00 00:00:00', 1, '2024-11-12 15:36:34', 1, 'PAID', '2024-10-30 15:35:37', '2024-11-14 11:25:00', NULL, '13.75 Hours worked in first two weeks of November 2024'),
(6, 1, 'Lake County Invoice #2 -  First two weeks of November 2024', '2662.5', '17.75', '150', '0000-00-00 00:00:00', NULL, '2024-11-13 20:20:28', 1, 'PAID', '2024-11-15 16:14:00', '2024-12-06 15:24:00', NULL, '17.75 Hours worked in last two weeks of November 2024'),
(9, 1, 'Lake County Invoice #3 - Last two weeks of November 2024', '2887.5', '19.25', '150', '0000-00-00 00:00:00', NULL, '2024-11-20 15:28:45', 1, 'PAID', '2024-12-02 17:24:00', '2024-12-19 15:04:00', NULL, 'This project continued to grow as RJ and I dove into the database.\r\nThe initial excel file LC provided me, that I created a data map from, was only half of what really needed to be exported from the database. There were MANY non-Case entities that were not on the data map. Because of this, I switched from doing a PHP script on Nov 19th, 2024, to creating Searches/Reports in eDefender for all Case related Entities and exporting the results to excel.\r\nOn Nov 21st, we created 24 different Reports and exported them all to excel. After our meeting, I worked in SSMS and began exporting the remaining non-Case tables via \"Export Data\" and manually executing SQL and copy/pasting results to Excel.'),
(10, 1, 'Lake County Invoice #4 - First two weeks of December 2024', '2490', '16.6', '150', '0000-00-00 00:00:00', NULL, '2024-12-02 16:40:16', 1, 'PAID', '2024-12-20 18:49:00', '2025-01-10 12:55:00', NULL, '4th invoice to Lake County.\r\nATLIS Invoice #140.'),
(14, 1, 'Lake County Invoice #5 - Last two weeks of December 2024', '375', '2.5', '150', '0000-00-00 00:00:00', NULL, '2024-12-20 15:49:02', 1, 'PAID', '2025-01-02 18:25:00', '2025-01-16 15:24:00', NULL, ''),
(15, 1, 'Lake County Invoice #6 - First two weeks of January 2025', '2437.5', '16.25', '150', '0000-00-00 00:00:00', NULL, '2025-01-02 18:26:08', 1, 'PAID', '2025-01-16 16:23:00', '2025-02-06 18:56:00', NULL, 'JANUARY 2025 INVOICE #6\r\nInvoice #143'),
(16, 10, 'First half of January 2025', '423', '47', '9', '0000-00-00 00:00:00', NULL, '2025-01-06 08:18:13', 1, 'PAID', '2025-01-16 15:03:00', '2025-01-16 15:03:00', NULL, '$423 for rate\r\n$20 for formula that Ashlin bought\r\n\r\nPaige paid via AFCU transfer on 1/16/25 at 3:00pm'),
(17, 11, '1st TEMPLATE', '0', '0', '0', '2025-01-15 11:10:03', NULL, '2025-01-15 11:10:03', 1, 'INPROGRESS', '2025-01-15 11:09:00', '2025-01-15 11:10:00', NULL, 'Need a contract...'),
(18, 1, 'Lake County Invoice #7 - Last two weeks of January 2025', '3499.5', '23.33', '150', '0000-00-00 00:00:00', NULL, '2025-01-16 15:27:08', 1, 'PAID', '2025-01-31 18:02:00', '2025-02-13 20:27:00', NULL, ''),
(19, 10, 'Last half of January 2025', '486', '54', '9', '0000-00-00 00:00:00', NULL, '2025-01-21 07:50:47', 1, 'PAID', '2025-01-31 18:10:00', '2025-01-31 19:47:00', NULL, 'Last half of January 2025'),
(21, 10, 'First half of February 2025', '288', '32', '9', '0000-00-00 00:00:00', NULL, '2025-02-02 19:49:16', 1, 'PAID', '2025-02-14 14:00:00', '2025-02-16 18:38:00', NULL, 'We will be gone Feb 3rd - Feb 6th at Disneyland.'),
(22, 1, 'Lake County Invoice #8 - First two weeks of February 2025', '2925', '19.5', '150', '0000-00-00 00:00:00', NULL, '2025-02-02 19:55:13', 1, 'PAID', '2025-02-18 04:48:00', '2025-03-06 16:46:00', NULL, 'Recreated this one on 2/2/25'),
(23, 1, 'Lake County Invoice #9 - Last two weeks of February 2025', '6000', '40', '150', '0000-00-00 00:00:00', NULL, '2025-02-16 00:07:11', 1, 'PAID', '2025-02-28 22:46:00', '2025-03-21 13:39:00', NULL, 'First invoice working almost 20 hours per week !'),
(24, 10, 'Last half of February 2025', '517.5', '57.5', '9', '0000-00-00 00:00:00', NULL, '2025-02-24 18:37:48', 1, 'PAID', '2025-03-03 16:12:00', '2025-03-03 21:44:00', NULL, ''),
(25, 1, 'Lake County Invoice #10 - First two weeks of March 2025', '5850', '39', '150', '0000-00-00 00:00:00', NULL, '2025-03-03 21:52:16', 1, 'PAID', '2025-03-17 00:41:00', '2025-04-18 17:41:00', NULL, 'First Week: March 3rd - 7th\r\nSecond Week:  March 10th - 14th'),
(26, 10, 'First half of March 2025', '427.5', '47.5', '9', '0000-00-00 00:00:00', NULL, '2025-03-03 16:12:55', 1, 'INPROGRESS', '0000-00-00 00:00:00', NULL, NULL, ''),
(27, 1, 'Lake County eCourt Invoice #11 - Last two weeks of March 2025', '5475', '36.5', '150', '0000-00-00 00:00:00', NULL, '2025-03-17 00:36:26', 1, 'PAID', '2025-03-29 13:44:00', '2025-04-25 15:15:00', NULL, ''),
(28, 1, 'Lake County eCourt Invoice #12 - First two weeks of April 2025', '6000', '40', '150', '0000-00-00 00:00:00', NULL, '2025-03-29 12:43:59', 1, 'PAID', '2025-04-14 12:32:00', '2025-05-02 16:07:00', NULL, 'March 31st to April 11th, 2025'),
(29, 1, 'Lake County eCourt Invoice #13 - April 14th to April 25th', '5700', '38', '150', '0000-00-00 00:00:00', NULL, '2025-04-15 22:10:54', 1, 'PAID', '2025-04-26 20:55:00', '2025-05-09 14:47:00', NULL, ''),
(30, 1, 'Lake County eCourt Invoice #14 - April 28th to May 9th', '6000', '40', '150', '0000-00-00 00:00:00', NULL, '2025-04-26 19:17:49', 1, 'PAID', '2025-05-09 16:13:00', '2025-05-23 18:55:00', NULL, 'April 28th - May 9th'),
(31, 1, 'Lake County eCourt Invoice #15 - May 12th to May 23rd', '6000', '40', '150', '0000-00-00 00:00:00', NULL, '2025-05-09 15:21:49', 1, 'PAID', '2025-05-27 15:29:00', '2025-06-20 16:38:00', NULL, ''),
(32, 1, 'Lake County eCourt Invoice #16 - May 26th to June 6th', '5625', '37.5', '150', '0000-00-00 00:00:00', NULL, '2025-05-27 17:18:25', 1, 'PAID', '2025-06-09 12:30:00', '2025-07-03 15:27:00', NULL, 'May 26th was Memorial Day - Did not work.'),
(33, 1, 'Lake County eCourt Invoice #158 - June 9th to June 20th', '6000', '40', '150', '0000-00-00 00:00:00', NULL, '2025-06-09 12:27:17', 1, 'PAID', '2025-06-20 18:56:00', '2025-08-26 04:14:00', NULL, 'Invoice #158'),
(34, 1, 'Lake County eCourt Invoice #159 - June 23rd to July 4th', '5400', '36', '150', '0000-00-00 00:00:00', NULL, '2025-06-20 17:27:12', 1, 'PAID', '2025-07-15 18:34:00', '2025-08-08 11:13:00', NULL, 'Invoice #159 - Will include a holiday.  NEW INVOICE STYLE.'),
(35, 1, 'Lake County eCourt Invoice #160 - July 7th to July 18th', '5400', '36', '150', '0000-00-00 00:00:00', NULL, '2025-07-11 16:40:59', 1, 'PAID', '2025-07-23 18:27:00', '2025-08-15 15:16:00', NULL, 'Invoice #160'),
(36, 1, 'Lake County eCourt Invoice #162 - July 21st to Aug 1', '5400', '36', '150', '0000-00-00 00:00:00', NULL, '2025-07-23 22:12:03', 1, 'SENT', '2025-08-03 14:25:00', NULL, NULL, 'Invoice #162'),
(37, 1, 'Lake County eCourt Invoice #163 - Aug 4th to Aug 15th', '5700', '38', '150', '0000-00-00 00:00:00', NULL, '2025-08-03 14:25:32', 1, 'SENT', '2025-08-21 00:24:00', NULL, NULL, ''),
(38, 1, 'Lake County eCourt Invoice #164 - Aug 18th to Aug 29th', '4200', '28', '150', '0000-00-00 00:00:00', NULL, '2025-08-18 16:33:33', 1, 'INPROGRESS', '0000-00-00 00:00:00', NULL, NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `module_projects_invoices`
--
ALTER TABLE `module_projects_invoices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `module_projects_invoices`
--
ALTER TABLE `module_projects_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
