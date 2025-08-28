-- Migration: Rename calendar event attendees to person attendees and update schema

RENAME TABLE module_calendar_event_attendees TO module_calendar_person_attendees;

ALTER TABLE module_calendar_person_attendees
  CHANGE COLUMN attendee_user_id attendee_person_id INT(11) NOT NULL,
  ADD COLUMN attended TINYINT(1) NOT NULL DEFAULT 0 AFTER attendee_person_id;

ALTER TABLE module_calendar_person_attendees
  DROP FOREIGN KEY fk_module_calendar_event_attendees_attendee_user_id,
  DROP INDEX fk_module_calendar_event_attendees_attendee_user_id,
  ADD CONSTRAINT fk_module_calendar_person_attendees_attendee_person_id FOREIGN KEY (attendee_person_id) REFERENCES person(id) ON DELETE CASCADE;

ALTER TABLE module_calendar_person_attendees
  DROP INDEX uk_module_calendar_event_attendees_event_attendee,
  ADD UNIQUE KEY uk_event_person (event_id, attendee_person_id);
