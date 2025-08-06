<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require '../../../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  $sql = 'SELECT id, email, password, type FROM users WHERE email = :email';
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $update = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = :id');
    $update->bindParam(':id', $user['id'], PDO::PARAM_INT);
    $update->execute();

    $_SESSION['user_logged_in'] = true;
    $_SESSION['this_user_email'] = $user['email'];
    $_SESSION['type'] = $user['type'];

    header('Location: ' . getURLDir());
    exit;
  }
}

header('Location: ../index.php?action=login&error=1');
exit;
?>
