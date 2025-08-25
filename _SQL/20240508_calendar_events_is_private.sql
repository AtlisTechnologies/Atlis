-- Replace visibility_id with is_private in module_calendar_events
ALTER TABLE `module_calendar_events`
  ADD COLUMN `is_private` tinyint(1) NOT NULL DEFAULT 0 AFTER `link_record_id`;

UPDATE `module_calendar_events` m
SET m.is_private = CASE
  WHEN m.visibility_id IS NOT NULL AND EXISTS (
    SELECT 1 FROM lookup_list_items l
    WHERE l.id = m.visibility_id AND l.list_id = 38 AND l.code = 'PRIVATE'
  ) THEN 1 ELSE 0 END;

ALTER TABLE `module_calendar_events`
  DROP FOREIGN KEY `fk_module_calendar_events_visibility_id`,
  DROP KEY `fk_module_calendar_events_visibility_id`,
  DROP COLUMN `visibility_id`;
