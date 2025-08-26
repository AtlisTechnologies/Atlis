ALTER TABLE module_meetings
  ADD COLUMN status_id INT NULL,
  ADD COLUMN type_id INT NULL;

ALTER TABLE module_meetings
  ADD CONSTRAINT fk_module_meetings_status_id FOREIGN KEY (status_id) REFERENCES lookup_list_items(id),
  ADD CONSTRAINT fk_module_meetings_type_id FOREIGN KEY (type_id) REFERENCES lookup_list_items(id);

-- Seed default lookup items if they do not exist
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'Scheduled','scheduled',1
FROM lookup_lists l
WHERE l.name='MEETING_STATUS'
  AND NOT EXISTS (SELECT 1 FROM lookup_list_items WHERE list_id=l.id);

INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order)
SELECT 1,1,l.id,'General','general',1
FROM lookup_lists l
WHERE l.name='MEETING_TYPE'
  AND NOT EXISTS (SELECT 1 FROM lookup_list_items WHERE list_id=l.id);
