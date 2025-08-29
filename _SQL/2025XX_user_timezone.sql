-- Add TIMEZONE lookup list and user timezone support

INSERT INTO lookup_lists (user_id, user_updated, name, description)
VALUES (1, 1, 'TIMEZONE', 'User timezone options');

SET @timezone_list_id = (SELECT id FROM lookup_lists WHERE name = 'TIMEZONE');

INSERT INTO lookup_list_items (user_id, user_updated, list_id, label, code, sort_order) VALUES
  (1, 1, @timezone_list_id, 'America/Denver', 'America/Denver', 1),
  (1, 1, @timezone_list_id, 'America/Chicago', 'America/Chicago', 2),
  (1, 1, @timezone_list_id, 'America/New_York', 'America/New_York', 3),
  (1, 1, @timezone_list_id, 'America/Los_Angeles', 'America/Los_Angeles', 4),
  (1, 1, @timezone_list_id, 'America/Phoenix', 'America/Phoenix', 5),
  (1, 1, @timezone_list_id, 'America/Anchorage', 'America/Anchorage', 6),
  (1, 1, @timezone_list_id, 'America/Honolulu', 'America/Honolulu', 7);

ALTER TABLE users ADD COLUMN timezone_id INT(11) NULL;
ALTER TABLE users ADD CONSTRAINT fk_users_timezone_id FOREIGN KEY (timezone_id) REFERENCES lookup_list_items(id) ON DELETE SET NULL;
