-- Lookup lists for meeting module
INSERT INTO lookup_lists (user_id, user_updated, name, description) VALUES
(1,1,'MEETING_AGENDA_STATUS','Status values for meeting agenda items'),
(1,1,'MEETING_QUESTION_STATUS','Status values for meeting questions');

-- Agenda status items
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order) VALUES
(1,1,(SELECT id FROM lookup_lists WHERE name='MEETING_AGENDA_STATUS'),'Not Started','NOT_STARTED',1),
(1,1,(SELECT id FROM lookup_lists WHERE name='MEETING_AGENDA_STATUS'),'In Progress','IN_PROGRESS',2),
(1,1,(SELECT id FROM lookup_lists WHERE name='MEETING_AGENDA_STATUS'),'Completed','COMPLETED',3);

-- Question status items
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order) VALUES
(1,1,(SELECT id FROM lookup_lists WHERE name='MEETING_QUESTION_STATUS'),'Unanswered','UNANSWERED',1),
(1,1,(SELECT id FROM lookup_lists WHERE name='MEETING_QUESTION_STATUS'),'In Progress','IN_PROGRESS',2),
(1,1,(SELECT id FROM lookup_lists WHERE name='MEETING_QUESTION_STATUS'),'Answered','ANSWERED',3);
