-- Assign status_id to all existing profile pictures
UPDATE users_profile_pics upp
LEFT JOIN users u ON u.current_profile_pic_id = upp.id
SET upp.status_id = CASE WHEN u.id IS NOT NULL THEN 82 ELSE 83 END;

-- Ensure status_id is NOT NULL
ALTER TABLE users_profile_pics
  DROP FOREIGN KEY fk_users_profile_pics_status_id,
  MODIFY status_id INT(11) NOT NULL,
  ADD CONSTRAINT fk_users_profile_pics_status_id FOREIGN KEY (status_id)
    REFERENCES lookup_list_items(id) ON DELETE RESTRICT;
