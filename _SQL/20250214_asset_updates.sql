ALTER TABLE `module_assets`
  ADD COLUMN `name` varchar(100) DEFAULT NULL,
  ADD COLUMN `vendor` varchar(100) DEFAULT NULL,
  ADD COLUMN `purchase_price` decimal(10,2) DEFAULT NULL,
  ADD COLUMN `condition_id` int(11) DEFAULT NULL,
  ADD COLUMN `location` varchar(255) DEFAULT NULL;

ALTER TABLE `module_asset_assignments`
  ADD COLUMN `due_date` date DEFAULT NULL,
  ADD COLUMN `condition_out_id` int(11) DEFAULT NULL,
  ADD COLUMN `condition_in_id` int(11) DEFAULT NULL,
  ADD COLUMN `notes` text DEFAULT NULL,
  ADD COLUMN `policy_version` varchar(50) DEFAULT NULL;
