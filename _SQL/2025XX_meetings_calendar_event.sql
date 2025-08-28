ALTER TABLE module_meetings ADD COLUMN calendar_event_id INT(11) NULL AFTER recur_monthly;
ALTER TABLE module_meetings ADD CONSTRAINT fk_meetings_calendar_event FOREIGN KEY (calendar_event_id) REFERENCES module_calendar_events(id) ON DELETE SET NULL;
