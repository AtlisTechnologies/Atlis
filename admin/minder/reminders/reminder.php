<?php
require_once __DIR__ . '/../../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

if ($editing) {
  require_permission('minder_reminder','update');
  $stmt = $pdo->prepare('SELECT * FROM minder_reminder WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $reminder = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$reminder) {
    echo '<div class="alert alert-danger">Reminder not found.</div>';
    require_once __DIR__ . '/../../admin_footer.php';
    exit;
  }
} else {
  require_permission('minder_reminder','create');
  $reminder = [
    'title' => '',
    'description' => '',
    'remind_at' => '',
    'repeat_type' => '',
    'memo' => null
  ];
}

$userStmt = $pdo->query('SELECT id, email FROM users ORDER BY email');
$users = $userStmt->fetchAll(PDO::FETCH_ASSOC);

$assignedUserIds = [];
if ($editing) {
  $assStmt = $pdo->prepare('SELECT assigned_user_id FROM minder_reminder_assignments WHERE reminder_id = :id');
  $assStmt->execute([':id' => $id]);
  $assignedUserIds = $assStmt->fetchAll(PDO::FETCH_COLUMN);
}

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
    <input type="datetime-local" name="remind_at" class="form-control" value="<?= $reminder['remind_at'] ? e(date('Y-m-d\TH:i', strtotime($reminder['remind_at']))) : ''; ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Repeat</label>
    <select name="repeat_type" class="form-select">
      <option value="">None</option>
      <option value="daily" <?= $reminder['repeat_type']=='daily'?'selected':''; ?>>Daily</option>
      <option value="weekly" <?= $reminder['repeat_type']=='weekly'?'selected':''; ?>>Weekly</option>
      <option value="monthly" <?= $reminder['repeat_type']=='monthly'?'selected':''; ?>>Monthly</option>
      <option value="yearly" <?= $reminder['repeat_type']=='yearly'?'selected':''; ?>>Yearly</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Assign Users</label>
    <select name="assignments[]" class="form-select" multiple>
      <?php foreach ($users as $u): ?>
      <option value="<?= $u['id']; ?>" <?= in_array($u['id'], $assignedUserIds) ? 'selected' : ''; ?>><?= e($u['email']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Memo</label>
    <textarea name="memo" class="form-control" rows="2"><?= e($reminder['memo']); ?></textarea>
  </div>
  <div class="mb-3">
    <button class="btn btn-sm btn-primary" type="submit">Save</button>
    <?php if ($editing && user_has_permission('minder_reminder','delete')): ?>
    <a href="functions/delete.php?id=<?= $id; ?>&csrf_token=<?= $token; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this reminder?');">Delete</a>
    <?php endif; ?>
  </div>
</form>
<?php require_once __DIR__ . '/../../admin_footer.php'; ?>
