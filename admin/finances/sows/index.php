<?php
require '../../admin_header.php';
require_permission('sow','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  require_permission('sow','delete');
  $id = (int)$_POST['delete_id'];
  $pdo->prepare('DELETE FROM module_sows WHERE id = :id')->execute([':id'=>$id]);
  admin_audit_log($pdo,$this_user_id,'module_sows',$id,'DELETE',null,null,'Deleted SoW');
  $message = 'Statement of Work deleted.';
}

$sql = 'SELECT s.id,s.title,s.summary,s.status_id,o.name AS org_name,a.name AS agency_name,d.name AS division_name,p.name AS project_name
        FROM module_sows s
        LEFT JOIN module_organization o ON s.organization_id = o.id
        LEFT JOIN module_agency a ON s.agency_id = a.id
        LEFT JOIN module_division d ON s.division_id = d.id
        LEFT JOIN module_projects p ON s.project_id = p.id
        ORDER BY s.date_created DESC';
$stmt = $pdo->query($sql);
$sows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Statements of Work</h2>
<?php if($message){ echo '<div class="alert alert-success">'.h($message).'</div>'; } ?>
<a class="btn btn-sm btn-primary mb-3" href="edit.php">Create New SoW</a>
<table class="table table-bordered">
  <thead><tr><th>ID</th><th>Title</th><th>Organization</th><th>Agency</th><th>Division</th><th>Project</th><th></th></tr></thead>
  <tbody>
    <?php foreach($sows as $s): ?>
      <tr>
        <td><?= h($s['id']) ?></td>
        <td><a href="edit.php?id=<?= h($s['id']) ?>"><?= h($s['title']) ?></a></td>
        <td><?= h($s['org_name']) ?></td>
        <td><?= h($s['agency_name']) ?></td>
        <td><?= h($s['division_name']) ?></td>
        <td><?= h($s['project_name']) ?></td>
        <td>
          <form method="post" class="d-inline" onsubmit="return confirm('Delete this SoW?');">
            <input type="hidden" name="csrf_token" value="<?= h($token) ?>">
            <input type="hidden" name="delete_id" value="<?= h($s['id']) ?>">
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require '../../admin_footer.php'; ?>
