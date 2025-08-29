<?php
require_once '../../../includes/php_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: '';
  $password = trim($_POST['password'] ?? '');
  $ip = $_SERVER['REMOTE_ADDR'];
  $now = time();
  $maxAttempts = 5;
  $lockout = 300; // seconds

  if (!isset($_SESSION['login_attempts_user'])) {
    $_SESSION['login_attempts_user'] = [];
  }
  if (!isset($_SESSION['login_attempts_ip'])) {
    $_SESSION['login_attempts_ip'] = [];
  }

  $userKey = $email;
  $userAttempts = $_SESSION['login_attempts_user'][$userKey] ?? ['count' => 0, 'last' => 0];
  $ipAttempts = $_SESSION['login_attempts_ip'][$ip] ?? ['count' => 0, 'last' => 0];
  if (($userAttempts['count'] >= $maxAttempts && $now - $userAttempts['last'] < $lockout) ||
      ($ipAttempts['count'] >= $maxAttempts && $now - $ipAttempts['last'] < $lockout)) {
    header('Location: ../index.php?action=login&error=rate');
    exit;
  }

  if ($email === '') {
    header('Location: ../index.php?action=login&error=1');
    exit;
  }

  $sql = 'SELECT id, email, password, type FROM users WHERE email = :email';
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    $userKey = 'user_' . $user['id'];
    $userAttempts = $_SESSION['login_attempts_user'][$userKey] ?? ['count' => 0, 'last' => 0];
    if ($userAttempts['count'] >= $maxAttempts && $now - $userAttempts['last'] < $lockout) {
      header('Location: ../index.php?action=login&error=rate');
      exit;
    }
  }

  if ($user && password_verify($password, $user['password'])) {
    $update = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = :id');
    $update->bindParam(':id', $user['id'], PDO::PARAM_INT);
    $update->execute();

    $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $hash = password_hash($code, PASSWORD_DEFAULT);
    $expires = date('Y-m-d H:i:s', time() + 600);
    $insert = $pdo->prepare('INSERT INTO users_2fa (user_id, user_updated, code, expires_at) VALUES (:user_id, :user_id, :code, :expires)');
    $insert->execute([
      ':user_id' => $user['id'],
      ':code' => $hash,
      ':expires' => $expires,
    ]);

    $pdo->prepare('DELETE FROM users_2fa WHERE used = 1 OR expires_at < NOW()')->execute();

    @mail($user['email'], 'Your verification code', 'Your verification code is ' . $code);

    $_SESSION['2fa_user_id'] = $user['id'];
    $_SESSION['2fa_user_email'] = $user['email'];

    unset($_SESSION['login_attempts_user'][$userKey], $_SESSION['login_attempts_ip'][$ip]);

    header('Location: ../index.php?action=2fa');
    exit;
  } else {
    $userKey = $user ? 'user_' . $user['id'] : $email;
    $_SESSION['login_attempts_user'][$userKey]['count'] = ($userAttempts['count'] ?? 0) + 1;
    $_SESSION['login_attempts_user'][$userKey]['last'] = $now;
    $_SESSION['login_attempts_ip'][$ip]['count'] = ($ipAttempts['count'] ?? 0) + 1;
    $_SESSION['login_attempts_ip'][$ip]['last'] = $now;
  }
}

header('Location: ../index.php?action=login&error=1');
exit;
?>
