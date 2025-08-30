<?php
require '../admin_header.php';
require_permission('assets','read');

$token = generate_csrf_token();

$filters = [
  'status_id' => isset($_GET['status_id']) ? (int)$_GET['status_id'] : null,
  'type_id' => isset($_GET['type_id']) ? (int)$_GET['type_id'] : null,
  'assigned' => isset($_GET['assigned']) ? (int)$_GET['assigned'] : null,
  'tag' => trim($_GET['tag'] ?? '')
];

$sql = "SELECT a.id, a.asset_tag, a.model, a.serial, a.warranty_expiration,
               st.label AS status_label, ty.label AS type_label,
               CONCAT(u.first_name,' ',u.last_name) AS assignee,
               (SELECT MAX(date_created) FROM module_asset_events e WHERE e.asset_id=a.id) AS last_event
        FROM module_assets a
        LEFT JOIN lookup_list_items st ON a.status_id=st.id
        LEFT JOIN lookup_list_items ty ON a.type_id=ty.id
        LEFT JOIN contractors u ON a.assignee_id=u.id
        WHERE 1=1";
$params = [];
if ($filters['status_id']) { $sql .= ' AND a.status_id=:status'; $params[':status']=$filters['status_id']; }
if ($filters['type_id']) { $sql .= ' AND a.type_id=:type'; $params[':type']=$filters['type_id']; }
if ($filters['assigned']!==null) {
  if ($filters['assigned']) { $sql .= ' AND a.assignee_id IS NOT NULL'; }
  else { $sql .= ' AND a.assignee_id IS NULL'; }
}
if ($filters['tag']!=='') { $sql .= ' AND a.asset_tag LIKE :tag'; $params[':tag']='%'.$filters['tag'].'%'; }
$sql .= ' ORDER BY a.date_created DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);

$statuses = get_lookup_items($pdo,'ASSET_STATUS');
$types = get_lookup_items($pdo,'ASSET_TYPE');
?>
<h2 class="mb-4">Assets</h2>
<?= flash_message($_SESSION['message'] ?? '', 'success'); ?>
<?= flash_message($_SESSION['error_message'] ?? '', 'danger'); ?>
<?php unset($_SESSION['message'], $_SESSION['error_message']); ?>
<div class="mb-3 d-flex gap-2">
  <?php if (user_has_permission('assets','create')): ?>
  <a class="btn btn-sm btn-success" href="asset.php">Add Asset</a>
  <?php endif; ?>
</div>
<form class="row g-2 mb-3" method="get">
  <div class="col-auto">
    <select class="form-select form-select-sm" name="status_id">
      <option value="">Status</option>
      <?php foreach($statuses as $s): ?>
      <option value="<?= $s['id']; ?>" <?= $filters['status_id']==$s['id']?'selected':''; ?>><?= e($s['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-auto">
    <select class="form-select form-select-sm" name="type_id">
      <option value="">Type</option>
      <?php foreach($types as $t): ?>
      <option value="<?= $t['id']; ?>" <?= $filters['type_id']==$t['id']?'selected':''; ?>><?= e($t['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-auto">
    <select class="form-select form-select-sm" name="assigned">
      <option value="">Assignment</option>
      <option value="1" <?= $filters['assigned']===1?'selected':''; ?>>Assigned</option>
      <option value="0" <?= $filters['assigned']===0?'selected':''; ?>>Unassigned</option>
    </select>
  </div>
  <div class="col-auto">
    <input class="form-control form-control-sm" name="tag" placeholder="Tag" value="<?= e($filters['tag']); ?>">
  </div>
  <div class="col-auto">
    <button class="btn btn-sm btn-primary" type="submit">Filter</button>
  </div>
</form>
<div class="table-responsive">
  <table class="table table-striped table-sm mb-0">
    <thead>
      <tr>
        <th>Tag</th>
        <th>Type</th>
        <th>Model</th>
        <th>Serial</th>
        <th>Status</th>
        <th>Assignee</th>
        <th>Warranty Days Left</th>
        <th>Last Event</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($assets as $a): ?>
      <tr>
        <td><?= e($a['asset_tag']); ?></td>
        <td><?= e($a['type_label']); ?></td>
        <td><?= e($a['model']); ?></td>
        <td><?= e($a['serial']); ?></td>
        <td><?= e($a['status_label']); ?></td>
        <td><?= e($a['assignee']); ?></td>
        <td><?php if($a['warranty_expiration']){ $days=(new DateTime())->diff(new DateTime($a['warranty_expiration']))->format('%r%a'); echo e($days);} ?></td>
        <td><?= e($a['last_event']); ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="asset.php?id=<?= $a['id']; ?>">View</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require '../admin_footer.php'; ?>
