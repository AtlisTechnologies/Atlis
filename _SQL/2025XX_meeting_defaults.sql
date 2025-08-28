-- Default lookup list items for the Meetings module

-- MEETING_STATUS default value
SET @meeting_status_list_id := (SELECT id FROM lookup_lists WHERE name = 'MEETING_STATUS');
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order, active_from)
VALUES (1, 1, @meeting_status_list_id, 'Scheduled', 'SCHEDULED', 1, CURDATE());
SET @meeting_status_item_id := LAST_INSERT_ID();
INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
VALUES
  (1, 1, @meeting_status_item_id, 'DEFAULT', 'true'),
  (1, 1, @meeting_status_item_id, 'COLOR-CLASS', 'primary');

-- MEETING_TYPE default value
SET @meeting_type_list_id := (SELECT id FROM lookup_lists WHERE name = 'MEETING_TYPE');
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order, active_from)
VALUES (1, 1, @meeting_type_list_id, 'General', 'GENERAL', 1, CURDATE());
SET @meeting_type_item_id := LAST_INSERT_ID();
INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
VALUES
  (1, 1, @meeting_type_item_id, 'DEFAULT', 'true'),
  (1, 1, @meeting_type_item_id, 'COLOR-CLASS', 'primary');

-- MEETING_AGENDA_STATUS default value
SET @agenda_status_list_id := (SELECT id FROM lookup_lists WHERE name = 'MEETING_AGENDA_STATUS');
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order, active_from)
VALUES (1, 1, @agenda_status_list_id, 'Pending', 'PENDING', 1, CURDATE());
SET @agenda_status_item_id := LAST_INSERT_ID();
INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
VALUES
  (1, 1, @agenda_status_item_id, 'DEFAULT', 'true'),
  (1, 1, @agenda_status_item_id, 'COLOR-CLASS', 'warning');

