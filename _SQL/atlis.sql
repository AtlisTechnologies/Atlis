-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2025 at 03:30 AM
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
  `status` int(11) DEFAULT NULL
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
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_table_name` (`table_name`),
  ADD KEY `idx_record_id` (`record_id`),
  ADD KEY `fk_audit_log_user_id` (`user_id`),
  ADD KEY `fk_audit_log_user_updated` (`user_updated`);

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
-- Indexes for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_lookup_lists_name` (`name`),
  ADD KEY `fk_lookup_lists_user_id` (`user_id`),
  ADD KEY `fk_lookup_lists_user_updated` (`user_updated`);

--
-- Indexes for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lookup_list_items_list_id` (`list_id`),
  ADD KEY `fk_lookup_list_items_user_id` (`user_id`),
  ADD KEY `fk_lookup_list_items_user_updated` (`user_updated`),
  ADD KEY `idx_lookup_list_items_label` (`label`);

--
-- Indexes for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lookup_item_attributes_item_id` (`item_id`),
  ADD KEY `fk_lookup_item_attributes_user_id` (`user_id`),
  ADD KEY `fk_lookup_item_attributes_user_updated` (`user_updated`),
  ADD KEY `idx_lookup_item_attributes_key` (`attr_key`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_organization`
--
ALTER TABLE `module_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_agency`
--
ALTER TABLE `module_agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_division`
--
ALTER TABLE `module_division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `fk_audit_log_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_audit_log_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

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
-- Constraints for table `lookup_lists`
--
ALTER TABLE `lookup_lists`
  ADD CONSTRAINT `fk_lookup_lists_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_lookup_lists_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `lookup_list_items`
--
ALTER TABLE `lookup_list_items`
  ADD CONSTRAINT `fk_lookup_list_items_list_id` FOREIGN KEY (`list_id`) REFERENCES `lookup_lists` (`id`),
  ADD CONSTRAINT `fk_lookup_list_items_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_lookup_list_items_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `lookup_list_item_attributes`
--
ALTER TABLE `lookup_list_item_attributes`
  ADD CONSTRAINT `fk_lookup_item_attributes_item_id` FOREIGN KEY (`item_id`) REFERENCES `lookup_list_items` (`id`),
  ADD CONSTRAINT `fk_lookup_item_attributes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_lookup_item_attributes_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`);

--
-- Constraints for table `module_organization`
--
ALTER TABLE `module_organization`
  ADD CONSTRAINT `fk_module_organization_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_organization_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_organization_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_module_organization_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`);

--
-- Constraints for table `module_agency`
--
ALTER TABLE `module_agency`
  ADD CONSTRAINT `fk_module_agency_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_agency_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_agency_organization_id` FOREIGN KEY (`organization_id`) REFERENCES `module_organization` (`id`),
  ADD CONSTRAINT `fk_module_agency_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_module_agency_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`);

--
-- Constraints for table `module_division`
--
ALTER TABLE `module_division`
  ADD CONSTRAINT `fk_module_division_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_division_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_module_division_agency_id` FOREIGN KEY (`agency_id`) REFERENCES `module_agency` (`id`),
  ADD CONSTRAINT `fk_module_division_main_person` FOREIGN KEY (`main_person`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_module_division_status` FOREIGN KEY (`status`) REFERENCES `lookup_list_items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
