<?php
require '../admin_header.php';
require_permission('person','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  require_permission('person','delete');
  $delId = (int)$_POST['delete_id'];
  $stmt = $pdo->prepare('DELETE FROM person WHERE id = :id');
  $stmt->execute([':id' => $delId]);
  admin_audit_log($pdo, $this_user_id, 'person', $delId, 'DELETE', null, null, 'Deleted person');
  $message = 'Person deleted.';
}

$stmt = $pdo->query('SELECT p.id, p.first_name, p.last_name, u.email FROM person p LEFT JOIN users u ON p.user_id = u.id ORDER BY p.last_name, p.first_name');
$persons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Persons</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<a href="edit.php" class="btn btn-sm btn-phoenix-success mb-3">Add Person</a>
<div id="persons" data-list='{"valueNames":["name","user"],"page":12,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="row g-3 list">
    <?php foreach($persons as $p): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column justify-content-between">
            <div>
              <h5 class="name mb-1"><?= htmlspecialchars(trim(($p['first_name'] ?? '').' '.($p['last_name'] ?? ''))); ?></h5>
              <?php if($p['email']): ?>
                <p class="user text-muted small mb-2"><?= htmlspecialchars($p['email']); ?></p>
              <?php endif; ?>
            </div>
            <div>
              <a class="btn btn-sm btn-phoenix-warning" href="edit.php?id=<?= $p['id']; ?>">Edit</a>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_id" value="<?= $p['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-sm btn-phoenix-danger" onclick="return confirm('Delete this person?');">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="d-flex justify-content-between align-items-center mt-3">
    <p class="mb-0" data-list-info></p>
    <ul class="pagination mb-0"></ul>
  </div>
</div>
<?php require '../admin_footer.php'; ?>
