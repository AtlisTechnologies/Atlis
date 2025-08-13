ALTER TABLE `lookup_list_items`
  ADD COLUMN `active_from` DATE DEFAULT CURDATE() AFTER `value`,
  ADD COLUMN `active_to` DATE DEFAULT NULL AFTER `active_from`;
