<?php
require '../admin_header.php';
require_permission('roles','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

// Current assignments for audit and display
$currentAssignments = $pdo->query('SELECT role_id, permission_group_id FROM admin_role_permission_groups')->fetchAll(PDO::FETCH_ASSOC);
$currentMap = [];
foreach ($currentAssignments as $a) {
  $currentMap[$a['role_id']][] = $a['permission_group_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  require_permission('roles','update');
  // sanitize submitted group assignments
  $rolePerms = [];
  foreach(($_POST['grp'] ?? []) as $rid => $gids){
    if(is_array($gids)){
      $rolePerms[(int)$rid] = array_unique(array_map('intval',$gids));
    }
  }
  $roles = $pdo->query('SELECT id FROM admin_roles')->fetchAll(PDO::FETCH_COLUMN);
  foreach ($roles as $roleId) {
    $old = json_encode($currentMap[$roleId] ?? []);
    $stmt = $pdo->prepare('DELETE FROM admin_role_permission_groups WHERE role_id = :role_id');
    $stmt->execute([':role_id' => $roleId]);
    $newPerms = [];
    if (!empty($rolePerms[$roleId]) && is_array($rolePerms[$roleId])) {
      foreach ($rolePerms[$roleId] as $gid) {
        $stmt2 = $pdo->prepare('INSERT INTO admin_role_permission_groups (role_id, permission_group_id, user_id, user_updated) VALUES (:rid, :gid, :uid, :uid)');
        $stmt2->execute([':rid' => $roleId, ':gid' => $gid, ':uid' => $this_user_id]);
        $newPerms[] = (int)$gid;
      }
    }
    admin_audit_log($pdo, $this_user_id, 'admin_role_permission_groups', $roleId, 'SYNC', $old, json_encode($newPerms), 'Updated role group assignments');
  }
  $message = 'Permission groups updated.';
  // refresh current map for display
  $currentAssignments = $pdo->query('SELECT role_id, permission_group_id FROM admin_role_permission_groups')->fetchAll(PDO::FETCH_ASSOC);
  $currentMap = [];
  foreach ($currentAssignments as $a) {
    $currentMap[$a['role_id']][] = $a['permission_group_id'];
  }
}

$roles = $pdo->query('SELECT id, name FROM admin_roles ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$groups = $pdo->query('SELECT id, name FROM admin_permission_groups ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$assignedMap = [];
foreach ($currentMap as $rid => $pids) {
  foreach ($pids as $pid) {
    $assignedMap[$rid][$pid] = true;
  }
}
?>
  <h2 class="mb-4">Role Permission Groups</h2>
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
        <?php foreach($groups as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['name']); ?></td>
            <?php foreach($roles as $r): ?>
              <td class="text-center">
                <input type="checkbox" name="grp[<?= $r['id']; ?>][]" value="<?= $p['id']; ?>" <?= isset($assignedMap[$r['id']][$p['id']]) ? 'checked' : ''; ?>>
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
