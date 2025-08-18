<?php
require '../admin_header.php';
require_permission('roles','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  require_permission('roles','delete');
  $delId = (int)$_POST['delete_id'];
  // remove any permission group assignments
  $oldGroupsStmt = $pdo->prepare('SELECT permission_group_id FROM admin_role_permission_groups WHERE role_id = :id');
  $oldGroupsStmt->execute([':id' => $delId]);
  $oldGroups = $oldGroupsStmt->fetchAll(PDO::FETCH_COLUMN);
  $pdo->prepare('DELETE FROM admin_role_permission_groups WHERE role_id = :id')->execute([':id' => $delId]);
  admin_audit_log($pdo, $this_user_id, 'admin_role_permission_groups', $delId, 'DELETE', json_encode($oldGroups), json_encode([]), 'Removed role group assignments');

  $stmt = $pdo->prepare('DELETE FROM admin_roles WHERE id = :id');
  $stmt->execute([':id' => $delId]);
  admin_audit_log($pdo, $this_user_id, 'admin_roles', $delId, 'DELETE', null, null, 'Deleted role');
  $message = 'Role deleted.';
}

$stmt = $pdo->query('SELECT r.id, r.name, r.description, GROUP_CONCAT(pg.name ORDER BY pg.name SEPARATOR ", ") AS groups'
                  . ' FROM admin_roles r'
                  . ' LEFT JOIN admin_role_permission_groups rpg ON r.id = rpg.role_id'
                  . ' LEFT JOIN admin_permission_groups pg ON rpg.permission_group_id = pg.id'
                  . ' GROUP BY r.id, r.name, r.description'
                  . ' ORDER BY r.name');
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Roles</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<div class="mb-3">
  <a href="edit.php" class="btn btn-sm btn-success">Add Role</a>
  <a href="permissions.php" class="btn btn-sm btn-info">Permissions</a>
  <a href="matrix.php" class="btn btn-sm btn-secondary">Role Permissions</a>
</div>
<div id="roles" data-list='{"valueNames":["id","name","description","groups"],"page":25,"pagination":true}'>
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
          <th class="sort" data-sort="groups">Permission Groups</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="list">
        <?php foreach($roles as $r): ?>
          <tr>
            <td class="id"><?= htmlspecialchars($r['id']); ?></td>
            <td class="name"><?= htmlspecialchars($r['name']); ?></td>
            <td class="description"><?= htmlspecialchars($r['description']); ?></td>
            <td class="groups"><?= htmlspecialchars($r['groups'] ?: '-'); ?></td>
            <td>
              <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $r['id']; ?>">Edit</a>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_id" value="<?= $r['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this role?');">Delete</button>
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
