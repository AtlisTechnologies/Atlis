<?php
require '../../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

if ($editing) {
  require_permission('minder_task','update');
  $stmt = $pdo->prepare('SELECT * FROM admin_task WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $task = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$task) {
    echo '<div class="alert alert-danger">Task not found.</div>';
    exit;
  }
} else {
  require_permission('minder_task','create');
  $task = [
    'name' => '',
    'description' => '',
    'type_id' => null,
    'category_id' => null,
    'sub_category_id' => null,
    'status_id' => null,
    'priority_id' => null,
    'start_date' => null,
    'due_date' => null,
    'memo' => null
  ];
}

$types = get_lookup_items($pdo, 'ADMIN_TASK_TYPE');
$categories = get_lookup_items($pdo, 'ADMIN_TASK_CATEGORY');
$subcategories = get_lookup_items($pdo, 'ADMIN_TASK_SUB_CATEGORY');
$statuses = get_lookup_items($pdo, 'ADMIN_TASK_STATUS');
$priorities = get_lookup_items($pdo, 'ADMIN_TASK_PRIORITY');

$userStmt = $pdo->query('SELECT id, email FROM users ORDER BY email');
$users = $userStmt->fetchAll(PDO::FETCH_ASSOC);

$assignedUserIds = [];
if ($editing) {
  $assStmt = $pdo->prepare('SELECT assigned_user_id FROM admin_task_assignments WHERE task_id = :id');
  $assStmt->execute([':id' => $id]);
  $assignedUserIds = $assStmt->fetchAll(PDO::FETCH_COLUMN);
}

$token = generate_csrf_token();

?>
<h2 class="mb-4"><?= $editing ? 'Edit Task' : 'Add Task'; ?></h2>
<?= flash_message($_SESSION['message'] ?? '', 'success'); ?>
<?= flash_message($_SESSION['error_message'] ?? '', 'danger'); ?>
<?php unset($_SESSION['message'], $_SESSION['error_message']); ?>
<form method="post" action="functions/<?= $editing ? 'update' : 'create'; ?>.php">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <?php if ($editing): ?>
  <input type="hidden" name="id" value="<?= $id; ?>">
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= e($task['name']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3"><?= e($task['description']); ?></textarea>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Type</label>
      <select name="type_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($types as $i): ?>
        <option value="<?= $i['id']; ?>" <?= $task['type_id'] == $i['id'] ? 'selected' : ''; ?>><?= e($i['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($categories as $i): ?>
        <option value="<?= $i['id']; ?>" <?= $task['category_id'] == $i['id'] ? 'selected' : ''; ?>><?= e($i['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Sub Category</label>
      <select name="sub_category_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($subcategories as $i): ?>
        <option value="<?= $i['id']; ?>" <?= $task['sub_category_id'] == $i['id'] ? 'selected' : ''; ?>><?= e($i['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Status</label>
      <select name="status_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($statuses as $i): ?>
        <option value="<?= $i['id']; ?>" <?= $task['status_id'] == $i['id'] ? 'selected' : ''; ?>><?= e($i['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Priority</label>
      <select name="priority_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($priorities as $i): ?>
        <option value="<?= $i['id']; ?>" <?= $task['priority_id'] == $i['id'] ? 'selected' : ''; ?>><?= e($i['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Start Date</label>
      <input type="date" name="start_date" class="form-control" value="<?= e($task['start_date']); ?>">
    </div>
    <div class="col">
      <label class="form-label">Due Date</label>
      <input type="date" name="due_date" class="form-control" value="<?= e($task['due_date']); ?>">
    </div>
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
    <textarea name="memo" class="form-control" rows="2"><?= e($task['memo']); ?></textarea>
  </div>
  <div class="mb-3">
    <button class="btn btn-sm btn-primary" type="submit">Save</button>
      <?php if ($editing): ?>
      <?php if (user_has_permission('minder_task','delete')): ?>
      <a href="functions/delete.php?id=<?= $id; ?>&csrf_token=<?= $token; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this task?');">Delete</a>
      <?php endif; ?>
      <?php endif; ?>
  </div>
</form>
<?php require '../../admin_footer.php'; ?>
