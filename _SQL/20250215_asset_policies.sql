CREATE TABLE `module_asset_policies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text DEFAULT NULL,
  `version` varchar(50) NOT NULL,
  `effective_date` date NOT NULL,
  `content` text NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `module_asset_assignments`
  ADD COLUMN `policy_id` int(11) DEFAULT NULL,
  ADD COLUMN `agreement_file` varchar(255) DEFAULT NULL;
