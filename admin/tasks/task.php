<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

if ($editing) {
  require_permission('admin_task','update');
  $stmt = $pdo->prepare('SELECT * FROM admin_task WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $task = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$task) {
    echo '<div class="alert alert-danger">Task not found.</div>';
    require '../admin_footer.php';
    exit;
  }
} else {
  require_permission('admin_task','create');
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

$assignedIds = [];
if ($editing) {
  $assStmt = $pdo->prepare('SELECT user_id FROM admin_task_assignments WHERE task_id = :id');
  $assStmt->execute([':id' => $id]);
  $assignedIds = $assStmt->fetchAll(PDO::FETCH_COLUMN);
}

$comments = [];
if ($editing) {
  $cstmt = $pdo->prepare('SELECT c.id, c.comment, u.email, c.date_created FROM admin_task_comments c JOIN users u ON c.user_id = u.id WHERE c.task_id = :id ORDER BY c.date_created');
  $cstmt->execute([':id' => $id]);
  $comments = $cstmt->fetchAll(PDO::FETCH_ASSOC);
}

$files = [];
if ($editing) {
  $fstmt = $pdo->prepare('SELECT id, file_name, file_path FROM admin_task_files WHERE task_id = :id ORDER BY date_created');
  $fstmt->execute([':id' => $id]);
  $files = $fstmt->fetchAll(PDO::FETCH_ASSOC);
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>
<h2 class="mb-4"><?= $editing ? 'Edit Task' : 'Add Task'; ?></h2>
<form method="post" action="functions/<?= $editing ? 'update' : 'create'; ?>.php">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <?php if ($editing): ?>
  <input type="hidden" name="id" value="<?= $id; ?>">
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($task['name']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($task['description']); ?></textarea>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Type</label>
      <select name="type_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($types as $i): ?>
        <option value="<?= $i['id']; ?>" <?= $task['type_id'] == $i['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($i['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($categories as $i): ?>
        <option value="<?= $i['id']; ?>" <?= $task['category_id'] == $i['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($i['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Sub Category</label>
      <select name="sub_category_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($subcategories as $i): ?>
        <option value="<?= $i['id']; ?>" <?= $task['sub_category_id'] == $i['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($i['label']); ?></option>
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
        <option value="<?= $i['id']; ?>" <?= $task['status_id'] == $i['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($i['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Priority</label>
      <select name="priority_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($priorities as $i): ?>
        <option value="<?= $i['id']; ?>" <?= $task['priority_id'] == $i['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($i['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Start Date</label>
      <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($task['start_date']); ?>">
    </div>
    <div class="col">
      <label class="form-label">Due Date</label>
      <input type="date" name="due_date" class="form-control" value="<?= htmlspecialchars($task['due_date']); ?>">
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Assign Users</label>
    <select name="assignments[]" class="form-select" multiple>
      <?php foreach ($users as $u): ?>
      <option value="<?= $u['id']; ?>" <?= in_array($u['id'], $assignedIds) ? 'selected' : ''; ?>><?= htmlspecialchars($u['email']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Memo</label>
    <textarea name="memo" class="form-control" rows="2"><?= htmlspecialchars($task['memo']); ?></textarea>
  </div>
  <div class="mb-3">
    <button class="btn btn-sm btn-primary" type="submit">Save</button>
    <?php if ($editing && user_has_permission('admin_task','delete')): ?>
    <a href="functions/delete.php?id=<?= $id; ?>&csrf_token=<?= $token; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this task?');">Delete</a>
    <?php endif; ?>
  </div>
</form>

<?php if ($editing): ?>
<hr>
<h5>Files</h5>
<ul class="list-unstyled">
  <?php foreach ($files as $f): ?>
  <li>
    <a href="../tasks/uploads/<?= htmlspecialchars(basename($f['file_path'])); ?>" target="_blank"><?= htmlspecialchars($f['file_name']); ?></a>
    <?php if (user_has_permission('admin_task_file','delete')): ?>
    <form method="post" action="functions/delete_file.php" class="d-inline">
      <input type="hidden" name="csrf_token" value="<?= $token; ?>">
      <input type="hidden" name="id" value="<?= $f['id']; ?>">
      <button class="btn btn-sm btn-link text-danger">Delete</button>
    </form>
    <?php endif; ?>
  </li>
  <?php endforeach; ?>
</ul>
<?php if (user_has_permission('admin_task_file','create')): ?>
<form method="post" action="functions/upload_file.php" enctype="multipart/form-data" class="mb-3">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="task_id" value="<?= $id; ?>">
  <input type="file" name="file" required>
  <button class="btn btn-sm btn-secondary">Upload</button>
</form>
<?php endif; ?>
<hr>
<h5>Comments</h5>
<ul class="list-unstyled">
  <?php foreach ($comments as $c): ?>
  <li class="mb-2">
    <strong><?= htmlspecialchars($c['email']); ?>:</strong>
    <?= nl2br(htmlspecialchars($c['comment'])); ?>
    <?php if (user_has_permission('admin_task_comment','delete')): ?>
    <form method="post" action="functions/delete_comment.php" class="d-inline">
      <input type="hidden" name="csrf_token" value="<?= $token; ?>">
      <input type="hidden" name="id" value="<?= $c['id']; ?>">
      <button class="btn btn-sm btn-link text-danger">Delete</button>
    </form>
    <?php endif; ?>
  </li>
  <?php endforeach; ?>
</ul>
<?php if (user_has_permission('admin_task_comment','create')): ?>
<form method="post" action="functions/add_comment.php" class="mb-3">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="task_id" value="<?= $id; ?>">
  <textarea name="comment" class="form-control" rows="2" required></textarea>
  <button class="btn btn-sm btn-secondary mt-2">Add Comment</button>
</form>
<?php endif; ?>
<hr>
<h5>Related Records</h5>
<div id="relations">
  <div class="row g-2 align-items-center mb-2">
    <div class="col"><input type="text" name="relation_module[]" class="form-control" placeholder="Module"></div>
    <div class="col"><input type="text" name="relation_record_id[]" class="form-control" placeholder="Record ID"></div>
  </div>
</div>
<?php endif; ?>
<?php require '../admin_footer.php'; ?>
