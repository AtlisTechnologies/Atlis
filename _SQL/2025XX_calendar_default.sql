ALTER TABLE module_calendar ADD COLUMN is_default TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE module_calendar ADD UNIQUE KEY uk_calendar_user_default (user_id, is_default);
