<?php
require_once '../../../includes/php_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $code = $_POST['code'] ?? '';
  $userId = $_SESSION['2fa_user_id'] ?? null;
  $ip = $_SERVER['REMOTE_ADDR'];
  $now = time();
  $maxAttempts = 5;
  $lockout = 300; // seconds

  if (!isset($_SESSION['verify_attempts_user'])) {
    $_SESSION['verify_attempts_user'] = [];
  }
  if (!isset($_SESSION['verify_attempts_ip'])) {
    $_SESSION['verify_attempts_ip'] = [];
  }

  $userAttempts = $_SESSION['verify_attempts_user'][$userId] ?? ['count' => 0, 'last' => 0];
  $ipAttempts = $_SESSION['verify_attempts_ip'][$ip] ?? ['count' => 0, 'last' => 0];
  if (($userAttempts['count'] >= $maxAttempts && $now - $userAttempts['last'] < $lockout) ||
      ($ipAttempts['count'] >= $maxAttempts && $now - $ipAttempts['last'] < $lockout)) {
    header('Location: ../index.php?action=2fa&error=rate');
    exit;
  }

  if ($userId) {
    $stmt = $pdo->prepare('SELECT id, code FROM users_2fa WHERE user_id = :user_id AND used = 0 AND expires_at > NOW() ORDER BY id DESC LIMIT 1');
    $stmt->execute([':user_id' => $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && password_verify($code, $row['code'])) {
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
      unset($_SESSION['verify_attempts_user'][$userId], $_SESSION['verify_attempts_ip'][$ip]);
      header('Location: ' . getURLDir());
      exit;
    } else {
      $_SESSION['verify_attempts_user'][$userId]['count'] = ($userAttempts['count'] ?? 0) + 1;
      $_SESSION['verify_attempts_user'][$userId]['last'] = $now;
      $_SESSION['verify_attempts_ip'][$ip]['count'] = ($ipAttempts['count'] ?? 0) + 1;
      $_SESSION['verify_attempts_ip'][$ip]['last'] = $now;
    }
  }
}

header('Location: ../index.php?action=2fa&error=1');
exit;
?>
