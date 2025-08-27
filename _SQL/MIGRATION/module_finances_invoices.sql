CREATE TABLE `module_finances_invoices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `module_finances_invoices`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `module_finances_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
