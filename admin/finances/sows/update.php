<?php
require '../../admin_header.php';
require_permission('sow','update');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$id = (int)($_GET['id'] ?? 0);
?>
<h2 class="mb-4">Update Statement of Work</h2>
<form action="functions/update.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?= h($token) ?>">
  <input type="hidden" name="id" value="<?= h($id) ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="title" class="form-control" placeholder="SoW Name">
  </div>
  <div class="mb-3">
    <label class="form-label">Upload File</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="10485760"><!-- 10MB -->
    <input type="file" name="file" class="form-control" accept=".pdf,.docx,.xlsx,.jpg,.png">
  </div>
  <button class="btn btn-primary">Update</button>
</form>
<?php require '../../admin_footer.php'; ?>
