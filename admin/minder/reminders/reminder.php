<?php
require_once __DIR__ . '/../../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

if ($editing) {
  require_permission('minder_reminder','update');
  $stmt = $pdo->prepare('SELECT * FROM admin_minder_reminders WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $reminder = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$reminder) {
    echo '<div class="alert alert-danger">Reminder not found.</div>';
    require __DIR__ . '/../../admin_footer.php';
    exit;
  }
  $pStmt = $pdo->prepare('SELECT person_id FROM admin_minder_reminders_person WHERE reminder_id = :id');
  $pStmt->execute([':id'=>$id]);
  $linkedPersons = $pStmt->fetchAll(PDO::FETCH_COLUMN);
  $cStmt = $pdo->prepare('SELECT contractor_id FROM admin_minder_reminders_contractor WHERE reminder_id = :id');
  $cStmt->execute([':id'=>$id]);
  $linkedContractors = $cStmt->fetchAll(PDO::FETCH_COLUMN);
} else {
  require_permission('minder_reminder','create');
  $reminder = [
    'title' => '',
    'description' => '',
    'remind_at' => null,
    'type_id' => null,
    'status_id' => null
  ];
  $linkedPersons = [];
  $linkedContractors = [];
}

$types = get_lookup_items($pdo, 'ADMIN_MINDER_REMINDER_TYPE');
$statuses = get_lookup_items($pdo, 'ADMIN_MINDER_REMINDER_STATUS');
$persons = $pdo->query("SELECT id, CONCAT(first_name,' ',last_name) AS name FROM person ORDER BY last_name, first_name")->fetchAll(PDO::FETCH_ASSOC);
$contractors = $pdo->query("SELECT mc.id, CONCAT(p.first_name,' ',p.last_name) AS name FROM module_contractors mc LEFT JOIN person p ON mc.person_id = p.id ORDER BY p.last_name, p.first_name")->fetchAll(PDO::FETCH_ASSOC);

$token = generate_csrf_token();
?>
<h2 class="mb-4"><?= $editing ? 'Edit Reminder' : 'Add Reminder'; ?></h2>
<?= flash_message($_SESSION['message'] ?? '', 'success'); ?>
<?= flash_message($_SESSION['error_message'] ?? '', 'danger'); ?>
<?php unset($_SESSION['message'], $_SESSION['error_message']); ?>
<form method="post" action="functions/<?= $editing ? 'update' : 'create'; ?>.php">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <?php if ($editing): ?>
  <input type="hidden" name="id" value="<?= $id; ?>">
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="<?= e($reminder['title']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3"><?= e($reminder['description']); ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Remind At</label>
    <input type="datetime-local" name="remind_at" class="form-control" value="<?= !empty($reminder['remind_at']) ? e(date('Y-m-d\\TH:i', strtotime($reminder['remind_at']))) : ''; ?>">
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Type</label>
      <select name="type_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($types as $t): ?>
        <option value="<?= (int)$t['id']; ?>" <?= $reminder['type_id'] == $t['id'] ? 'selected' : ''; ?>><?= e($t['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Status</label>
      <select name="status_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($statuses as $s): ?>
        <option value="<?= (int)$s['id']; ?>" <?= $reminder['status_id'] == $s['id'] ? 'selected' : ''; ?>><?= e($s['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Persons</label>
    <select name="person_ids[]" class="form-select" multiple>
      <?php foreach ($persons as $p): ?>
      <option value="<?= (int)$p['id']; ?>" <?= in_array($p['id'], $linkedPersons) ? 'selected' : ''; ?>><?= e($p['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Contractors</label>
    <select name="contractor_ids[]" class="form-select" multiple>
      <?php foreach ($contractors as $c): ?>
      <option value="<?= (int)$c['id']; ?>" <?= in_array($c['id'], $linkedContractors) ? 'selected' : ''; ?>><?= e($c['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
</form>

<?php if ($editing): ?>
<hr class="my-4">
<h3 class="mb-3">Attachments</h3>
<form method="post" enctype="multipart/form-data" action="functions/upload_file.php">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="reminder_id" value="<?= $id; ?>">
  <div class="mb-3">
    <input type="file" name="file" class="form-control" required>
  </div>
  <button class="btn btn-secondary" type="submit">Upload File</button>
</form>
<?php endif; ?>
<?php require __DIR__ . '/../../admin_footer.php'; ?>
