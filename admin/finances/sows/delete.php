<?php
require '../../admin_header.php';
require_permission('sow','delete');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$id = (int)($_GET['id'] ?? 0);
?>
<h2 class="mb-4">Delete Statement of Work</h2>
<form action="functions/delete.php" method="post" onsubmit="return confirm('Are you sure?');">
  <input type="hidden" name="csrf_token" value="<?= h($token) ?>">
  <input type="hidden" name="id" value="<?= h($id) ?>">
  <p>Confirm deletion of SoW ID <?= h($id) ?>.</p>
  <button class="btn btn-danger">Delete</button>
</form>
<?php require '../../admin_footer.php'; ?>
