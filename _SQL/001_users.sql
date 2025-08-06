-- Creates the users table with standard audit fields
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) DEFAULT NULL,
    user_updated INT(11) DEFAULT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    memo TEXT DEFAULT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    CONSTRAINT fk_users_user_id FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_users_user_updated FOREIGN KEY (user_updated) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
