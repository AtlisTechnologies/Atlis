-- Insert calendar event types
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order, active_from)
VALUES
  (1,1,37,'Meeting','MEETING',1,CURDATE()),
  (1,1,37,'Task','TASK',2,CURDATE()),
  (1,1,37,'Reminder','REMINDER',3,CURDATE());

-- Ensure icon attribute type exists
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order, active_from)
VALUES (1,1,7,'Icon / Class','ICON-CLASS',3,CURDATE());

-- Insert calendar visibility options
INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order, active_from)
VALUES
  (1,1,38,'Public','PUBLIC',1,CURDATE()),
  (1,1,38,'Private','PRIVATE',2,CURDATE());

-- Attributes for calendar event types
INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
SELECT 1,1,id,'COLOR-CLASS','primary' FROM lookup_list_items WHERE list_id=37 AND code='MEETING';
INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
SELECT 1,1,id,'ICON-CLASS','fas fa-users' FROM lookup_list_items WHERE list_id=37 AND code='MEETING';

INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
SELECT 1,1,id,'COLOR-CLASS','warning' FROM lookup_list_items WHERE list_id=37 AND code='TASK';
INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
SELECT 1,1,id,'ICON-CLASS','fas fa-check' FROM lookup_list_items WHERE list_id=37 AND code='TASK';

INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
SELECT 1,1,id,'COLOR-CLASS','info' FROM lookup_list_items WHERE list_id=37 AND code='REMINDER';
INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
SELECT 1,1,id,'ICON-CLASS','fas fa-bell' FROM lookup_list_items WHERE list_id=37 AND code='REMINDER';

-- Attributes for calendar visibility options
INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
SELECT 1,1,id,'COLOR-CLASS','success' FROM lookup_list_items WHERE list_id=38 AND code='PUBLIC';
INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
SELECT 1,1,id,'ICON-CLASS','fas fa-globe' FROM lookup_list_items WHERE list_id=38 AND code='PUBLIC';

INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
SELECT 1,1,id,'COLOR-CLASS','danger' FROM lookup_list_items WHERE list_id=38 AND code='PRIVATE';
INSERT INTO lookup_list_item_attributes (user_id, user_updated, item_id, attr_code, attr_value)
SELECT 1,1,id,'ICON-CLASS','fas fa-lock' FROM lookup_list_items WHERE list_id=38 AND code='PRIVATE';
