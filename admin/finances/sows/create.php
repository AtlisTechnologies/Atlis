<?php
require '../../admin_header.php';
require_permission('sow','create');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$allowedItems = get_lookup_items($pdo,'SOW_FILE_TYPE');
$accept = implode(',', array_map(fn($i)=>'.'.strtolower($i['code']), $allowedItems));
?>
<h2 class="mb-4">Create Statement of Work</h2>
<form action="functions/create.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?= h($token) ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="title" class="form-control" placeholder="SoW Name">
  </div>
  <div class="mb-3">
    <label class="form-label">Upload File</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="10485760"><!-- 10MB -->
    <input type="file" name="file" class="form-control" accept="<?= h($accept) ?>">
  </div>
  <button class="btn btn-primary">Save</button>
</form>
<?php require '../../admin_footer.php'; ?>
