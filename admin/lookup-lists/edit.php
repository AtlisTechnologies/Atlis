<?php
require '../admin_header.php';

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$name = $description = $memo = '';
$message = $error = '';
$btnClass = $id ? 'btn-phoenix-warning' : 'btn-phoenix-success';

if ($id) {
  $stmt = $pdo->prepare('SELECT * FROM lookup_lists WHERE id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $name = $row['name'];
    $description = $row['description'];
    $memo = $row['memo'];
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $name = trim($_POST['name'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $memo = trim($_POST['memo'] ?? '');
  if ($name === '') {
    $error = 'Name is required.';
  }
  if (!$error) {
    if ($id) {
      $stmt = $pdo->prepare('UPDATE lookup_lists SET name=:name, description=:description, memo=:memo, user_updated=:uid WHERE id=:id');
      $stmt->execute([':name'=>$name, ':description'=>$description, ':memo'=>$memo, ':uid'=>$this_user_id, ':id'=>$id]);
      audit_log($pdo, $this_user_id, 'lookup_lists', $id, 'UPDATE', 'Updated lookup list');
      $message = 'Lookup list updated.';
    } else {
      $stmt = $pdo->prepare('INSERT INTO lookup_lists (user_id, user_updated, name, description, memo) VALUES (:uid, :uid, :name, :description, :memo)');
      $stmt->execute([':uid'=>$this_user_id, ':name'=>$name, ':description'=>$description, ':memo'=>$memo]);
      $id = $pdo->lastInsertId();
      audit_log($pdo, $this_user_id, 'lookup_lists', $id, 'CREATE', 'Created lookup list');
      $message = 'Lookup list created.';
    }
  }
}
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Lookup List</h2>
<?php if($error){ echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>'; } ?>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" name="description"><?= htmlspecialchars($description); ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Memo</label>
    <textarea class="form-control" name="memo"><?= htmlspecialchars($memo); ?></textarea>
  </div>
  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-phoenix-secondary">Back</a>
</form>
<?php require '../admin_footer.php'; ?>
