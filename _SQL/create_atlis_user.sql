-- Create application-specific MySQL user for Atlisware
CREATE USER 'atlis_app'@'localhost' IDENTIFIED BY 'change_this_password';

-- Grant minimal privileges required for application operations
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER, CREATE TEMPORARY TABLES
ON atlis.* TO 'atlis_app'@'localhost';

FLUSH PRIVILEGES;
