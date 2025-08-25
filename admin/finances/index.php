<?php
require '../admin_header.php';
require_permission('finances','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>
<h2 class="mb-4">Finance Dashboard</h2>
<ul>
  <li><a href="sows/index.php">Statements of Work</a></li>
</ul>
<?php require '../admin_footer.php'; ?>
