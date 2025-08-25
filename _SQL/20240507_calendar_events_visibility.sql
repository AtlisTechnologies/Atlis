-- Add visibility_id to module_calendar_events and migrate data
ALTER TABLE `module_calendar_events`
  ADD COLUMN `visibility_id` int(11) DEFAULT NULL AFTER `link_record_id`;

UPDATE `module_calendar_events` m
SET m.visibility_id = CASE
  WHEN m.is_private = 1 THEN (SELECT id FROM lookup_list_items WHERE list_id=38 AND code='PRIVATE')
  ELSE (SELECT id FROM lookup_list_items WHERE list_id=38 AND code='PUBLIC')
END;

ALTER TABLE `module_calendar_events`
  DROP COLUMN `is_private`,
  ADD KEY `fk_module_calendar_events_visibility_id` (`visibility_id`),
  ADD CONSTRAINT `fk_module_calendar_events_visibility_id` FOREIGN KEY (`visibility_id`) REFERENCES `lookup_list_items` (`id`);
