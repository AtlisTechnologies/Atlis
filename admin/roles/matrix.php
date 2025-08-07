<?php
require '../admin_header.php';

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

// Current assignments for audit and display
$currentAssignments = $pdo->query('SELECT role_id, permission_id FROM admin_role_permissions')->fetchAll(PDO::FETCH_ASSOC);
$currentMap = [];
foreach ($currentAssignments as $a) {
  $currentMap[$a['role_id']][] = $a['permission_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $rolePerms = $_POST['perm'] ?? [];
  $roles = $pdo->query('SELECT id FROM admin_roles')->fetchAll(PDO::FETCH_COLUMN);
  foreach ($roles as $roleId) {
    $old = json_encode($currentMap[$roleId] ?? []);
    $stmt = $pdo->prepare('DELETE FROM admin_role_permissions WHERE role_id = :role_id');
    $stmt->execute([':role_id' => $roleId]);
    $newPerms = [];
    if (!empty($rolePerms[$roleId]) && is_array($rolePerms[$roleId])) {
      foreach ($rolePerms[$roleId] as $pid) {
        $stmt2 = $pdo->prepare('INSERT INTO admin_role_permissions (role_id, permission_id, user_id, user_updated) VALUES (:rid, :pid, :uid, :uid)');
        $stmt2->execute([':rid' => $roleId, ':pid' => $pid, ':uid' => $this_user_id]);
        $newPerms[] = (int)$pid;
      }
    }
    admin_audit_log($pdo, $this_user_id, 'admin_role_permissions', $roleId, 'SYNC', $old, json_encode($newPerms), 'Updated role permissions');
  }
  $message = 'Permissions updated.';
  // refresh current map for display
  $currentAssignments = $pdo->query('SELECT role_id, permission_id FROM admin_role_permissions')->fetchAll(PDO::FETCH_ASSOC);
  $currentMap = [];
  foreach ($currentAssignments as $a) {
    $currentMap[$a['role_id']][] = $a['permission_id'];
  }
}

$roles = $pdo->query('SELECT id, name FROM admin_roles ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$permissions = $pdo->query('SELECT id, module, action FROM admin_permissions ORDER BY module, action')->fetchAll(PDO::FETCH_ASSOC);
$assignedMap = [];
foreach ($currentMap as $rid => $pids) {
  foreach ($pids as $pid) {
    $assignedMap[$rid][$pid] = true;
  }
}
?>
<h2 class="mb-4">Role Permissions</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>Permission</th>
          <?php foreach($roles as $r): ?>
            <th><?= htmlspecialchars($r['name']); ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach($permissions as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['module'].' - '.$p['action']); ?></td>
            <?php foreach($roles as $r): ?>
              <td class="text-center">
                <input type="checkbox" name="perm[<?= $r['id']; ?>][]" value="<?= $p['id']; ?>" <?= isset($assignedMap[$r['id']][$p['id']]) ? 'checked' : ''; ?>>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <button class="btn btn-warning" type="submit">Save</button>
</form>
<?php require '../admin_footer.php'; ?>
