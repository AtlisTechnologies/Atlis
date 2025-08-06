<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

// Ensure database and helper functions are available
require_once '../../../includes/config.php';

// Capture current user ID via session email before destroying session
$userId = null;
if (!empty($_SESSION['this_user_email'])) {
  $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
  $stmt->bindParam(':email', $_SESSION['this_user_email'], PDO::PARAM_STR);
  $stmt->execute();
  $userId = $stmt->fetchColumn();
}

// Log the logout action if the user was identified
if ($userId) {
  audit_log($pdo, $userId, 'users', $userId, 'LOGOUT', 'User logged out');
}

// Clear session and destroy
$_SESSION = [];
session_unset();
session_destroy();
session_regenerate_id(true);

?>
