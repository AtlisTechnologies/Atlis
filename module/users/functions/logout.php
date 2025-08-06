<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
$_SESSION = [];
session_unset();
session_destroy();
header('Location: ../index.php?action=login');
exit;
?>
