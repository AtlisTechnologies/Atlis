<?php
require '../admin_header.php';
require_permission('contractors', 'read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  require_permission('contractors', 'delete');
  $delId = (int)$_POST['delete_id'];
  $stmt = $pdo->prepare('DELETE FROM module_contractors WHERE id = :id');
  $stmt->execute([':id' => $delId]);
  admin_audit_log($pdo, $this_user_id, 'module_contractors', $delId, 'DELETE', null, null, 'Deleted contractor');
  $message = 'Contractor deleted.';
}

$stmt = $pdo->query('SELECT id, first_name, last_name FROM module_contractors ORDER BY last_name, first_name');
$contractors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Contractors</h2>
<?php if($message){ echo '<div class="alert alert-success">'.h($message).'</div>'; } ?>
<a href="contractor.php" class="btn btn-sm btn-success mb-3">Add Contractor</a>
<div id="contractors" data-list='{"valueNames":["name"],"page":20,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="row g-3 list">
    <?php foreach($contractors as $c): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column justify-content-between">
            <div>
              <h5 class="name mb-1"><?= h(trim(($c['first_name'] ?? '').' '.($c['last_name'] ?? ''))); ?></h5>
            </div>
            <div>
              <a class="btn btn-sm btn-warning" href="contractor.php?id=<?= $c['id']; ?>">Edit</a>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_id" value="<?= $c['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this contractor?');">Delete</button>
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
