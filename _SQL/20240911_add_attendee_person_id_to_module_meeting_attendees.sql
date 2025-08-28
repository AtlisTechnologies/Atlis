ALTER TABLE module_meeting_attendees
  ADD COLUMN attendee_person_id INT(11) DEFAULT NULL AFTER meeting_id;

ALTER TABLE module_meeting_attendees
  ADD KEY fk_module_meeting_attendees_attendee_person_id (attendee_person_id),
  ADD CONSTRAINT fk_module_meeting_attendees_attendee_person_id FOREIGN KEY (attendee_person_id) REFERENCES person(id) ON DELETE CASCADE;

UPDATE module_meeting_attendees mma
  LEFT JOIN person p ON p.user_id = mma.attendee_user_id
  SET mma.attendee_person_id = p.id
  WHERE mma.attendee_user_id IS NOT NULL;
