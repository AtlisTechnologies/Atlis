<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once '../../../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $code = $_POST['code'] ?? '';
  $userId = $_SESSION['2fa_user_id'] ?? null;
  if ($userId) {
    $stmt = $pdo->prepare('SELECT id FROM users_2fa WHERE user_id = :user_id AND code = :code AND used = 0 AND expires_at > NOW() ORDER BY id DESC LIMIT 1');
    $stmt->execute([':user_id' => $userId, ':code' => $code]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $pdo->prepare('UPDATE users_2fa SET used = 1 WHERE id = :id')->execute([':id' => $row['id']]);
      $stmt = $pdo->prepare('SELECT email, type FROM users WHERE id = :id');
      $stmt->execute([':id' => $userId]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      $_SESSION['user_logged_in'] = true;
      $_SESSION['this_user_email'] = $user['email'];
      $_SESSION['type'] = $user['type'];
      audit_log($pdo, $userId, 'users', $userId, 'LOGIN', 'User logged in');
      session_regenerate_id(true);
      unset($_SESSION['2fa_user_id'], $_SESSION['2fa_user_email']);
      header('Location: ' . getURLDir());
      exit;
    }
  }
}

header('Location: ../index.php?action=2fa&error=1');
exit;
?>
