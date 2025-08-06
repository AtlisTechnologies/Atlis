<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once '../../../includes/config.php';

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

    $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $expires = date('Y-m-d H:i:s', time() + 600);
    $insert = $pdo->prepare('INSERT INTO users_2fa (user_id, user_updated, code, expires_at) VALUES (:user_id, :user_id, :code, :expires)');
    $insert->execute([
      ':user_id' => $user['id'],
      ':code' => $code,
      ':expires' => $expires,
    ]);

    @mail($user['email'], 'Your verification code', 'Your verification code is ' . $code);

    $_SESSION['2fa_user_id'] = $user['id'];
    $_SESSION['2fa_user_email'] = $user['email'];

    header('Location: ../index.php?action=2fa');
    exit;
  }
}

header('Location: ../index.php?action=login&error=1');
exit;
?>
