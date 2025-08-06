<?php
require '../admin_header.php';

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $delId = (int)$_POST['delete_id'];
  $stmt = $pdo->prepare('DELETE FROM lookup_lists WHERE id = :id');
  $stmt->execute([':id' => $delId]);
  audit_log($pdo, $this_user_id, 'lookup_lists', $delId, 'DELETE', 'Deleted lookup list');
  $message = 'Lookup list deleted.';
}

$stmt = $pdo->query('SELECT id, name, description FROM lookup_lists ORDER BY name');
$lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Lookup Lists</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<a href="edit.php" class="btn btn-sm btn-primary mb-3">Add Lookup List</a>
<div id="lookup-lists" data-list='{"valueNames":["id","name","description"],"page":10,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm mb-0">
      <thead>
        <tr>
          <th class="sort" data-sort="id">ID</th>
          <th class="sort" data-sort="name">Name</th>
          <th class="sort" data-sort="description">Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="list">
        <?php foreach($lists as $l): ?>
          <tr>
            <td class="id"><?= htmlspecialchars($l['id']); ?></td>
            <td class="name"><?= htmlspecialchars($l['name']); ?></td>
            <td class="description"><?= htmlspecialchars($l['description']); ?></td>
            <td>
              <a class="btn btn-sm btn-secondary" href="edit.php?id=<?= $l['id']; ?>">Edit</a>
              <a class="btn btn-sm btn-info" href="items.php?list_id=<?= $l['id']; ?>">Items</a>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_id" value="<?= $l['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this list?');">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-between align-items-center mt-3">
    <p class="mb-0" data-list-info></p>
    <ul class="pagination mb-0"></ul>
  </div>
</div>
<?php require '../admin_footer.php'; ?>
