ALTER TABLE module_calendar_events
  ADD COLUMN timezone_id INT(11) NULL;

ALTER TABLE module_calendar_events
  ADD CONSTRAINT fk_module_calendar_events_timezone_id
    FOREIGN KEY (timezone_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL;

