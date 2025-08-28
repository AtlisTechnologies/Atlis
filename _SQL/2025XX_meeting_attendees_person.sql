ALTER TABLE module_meeting_attendees
  CHANGE COLUMN attendee_user_id attendee_person_id INT(11) NOT NULL,
  ADD COLUMN attendee_user_id INT(11) NULL AFTER attendee_person_id,
  DROP INDEX fk_module_meeting_attendees_attendee_user_id,
  ADD CONSTRAINT fk_meeting_attendees_person
    FOREIGN KEY (attendee_person_id) REFERENCES person(id) ON DELETE CASCADE,
  ADD CONSTRAINT fk_meeting_attendees_user
    FOREIGN KEY (attendee_user_id) REFERENCES users(id) ON DELETE SET NULL,
  ADD UNIQUE KEY uk_meeting_person (meeting_id, attendee_person_id);
