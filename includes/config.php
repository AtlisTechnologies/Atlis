<?php
// load functions
require 'functions.php';

// Admin user IDs that should have permissions enforced
// Add IDs here to restrict specific admin accounts
$restricted_admin_ids = [];

// DB Credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_NAME', 'atlis');
define('DB_PASSWORD', '');
define('DB_PORT', '3306');

// Contractors module upload configuration
define('CONTRACTOR_UPLOAD_DIR', __DIR__ . '/../admin/contractors/uploads/');
define('CONTRACTOR_MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB limit

$dsn = "mysql:dbname=".DB_NAME.";host=".DB_HOST.";port=".DB_PORT.";charset=utf8mb4";
$pdo = "";
try{
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}catch (PDOException $e) {
        error_log($e->getMessage());
        echo "Connection failed: " . $e->getMessage();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
