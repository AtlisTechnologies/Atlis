<?php
// load functions
require 'functions.php';

// Admin user IDs that should have permissions enforced
// Add IDs here to restrict specific admin accounts
$restricted_admin_ids = [];

// Load environment variables from optional .env file
$envFile = __DIR__ . '/../.env';
$env = [];
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
}

// DB Credentials
define('DB_HOST', $env['DB_HOST'] ?? getenv('DB_HOST') ?? 'localhost');
define('DB_USER', $env['DB_USER'] ?? getenv('DB_USER') ?? '');
define('DB_NAME', $env['DB_NAME'] ?? getenv('DB_NAME') ?? 'atlis');
define('DB_PASSWORD', $env['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? '');
define('DB_PORT', $env['DB_PORT'] ?? getenv('DB_PORT') ?? '3306');

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


?>
