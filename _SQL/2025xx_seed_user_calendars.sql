INSERT INTO module_calendar (user_id, name, is_private, is_default)
SELECT u.id, p.first_name, 0, 1
FROM users u
LEFT JOIN module_calendar c ON c.user_id = u.id
LEFT JOIN person p ON p.user_id = u.id
WHERE c.id IS NULL;
