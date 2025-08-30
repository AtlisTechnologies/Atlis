<?php
require_once __DIR__ . '/../../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

if ($editing) {
    require_permission('minder_note', 'update');
    $stmt = $pdo->prepare('SELECT * FROM admin_minder_notes WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $note = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$note) {
        echo '<div class="alert alert-danger">Note not found.</div>';
        require_once __DIR__ . '/../../admin_footer.php';
        exit;
    }
} else {
    require_permission('minder_note', 'create');
    $note = [
        'title' => '',
        'body' => '',
        'category_id' => null,
        'status_id' => null
    ];
}

$categories = get_lookup_items($pdo, 'ADMIN_MINDER_NOTE_CATEGORY');
$statuses   = get_lookup_items($pdo, 'ADMIN_MINDER_NOTE_STATUS');

$personStmt = $pdo->query('SELECT id, CONCAT(first_name, " ", last_name) AS name FROM person ORDER BY first_name, last_name');
$persons = $personStmt->fetchAll(PDO::FETCH_ASSOC);

$contractorStmt = $pdo->query('SELECT mc.id, CONCAT(p.first_name, " ", p.last_name) AS name FROM module_contractors mc JOIN person p ON mc.person_id = p.id ORDER BY p.first_name, p.last_name');
$contractors = $contractorStmt->fetchAll(PDO::FETCH_ASSOC);

$token = generate_csrf_token();
?>
<h2 class="mb-4"><?= $editing ? 'Edit Note' : 'Add Note'; ?></h2>
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
    <input type="text" name="title" class="form-control" value="<?= e($note['title']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Body</label>
    <textarea name="body" class="form-control" rows="4" required><?= e($note['body']); ?></textarea>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id']; ?>" <?= $note['category_id'] == $cat['id'] ? 'selected' : ''; ?>><?= e($cat['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Status</label>
      <select name="status_id" class="form-select">
        <option value="">--</option>
        <?php foreach ($statuses as $st): ?>
          <option value="<?= $st['id']; ?>" <?= $note['status_id'] == $st['id'] ? 'selected' : ''; ?>><?= e($st['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="mb-3">
    <button class="btn btn-sm btn-primary" type="submit">Save</button>
    <?php if ($editing && user_has_permission('minder_note','delete')): ?>
      <a href="functions/delete.php?id=<?= $id; ?>&csrf_token=<?= $token; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this note?');">Delete</a>
    <?php endif; ?>
  </div>
</form>
<?php if ($editing): ?>
<hr>
<form method="post" action="functions/upload.php" enctype="multipart/form-data" class="mb-4">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="note_id" value="<?= $id; ?>">
  <div class="mb-3">
    <label class="form-label">Attachment</label>
    <input type="file" name="file" class="form-control" required>
  </div>
  <button class="btn btn-secondary btn-sm" type="submit">Upload</button>
</form>
<form method="post" action="functions/link_person.php" class="mb-3">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="note_id" value="<?= $id; ?>">
  <div class="mb-3">
    <label class="form-label">Link Person</label>
    <select name="person_id" class="form-select">
      <option value="">-- Person --</option>
      <?php foreach ($persons as $p): ?>
        <option value="<?= $p['id']; ?>"><?= e($p['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button class="btn btn-secondary btn-sm" type="submit">Link</button>
</form>
<form method="post" action="functions/link_contractor.php" class="mb-3">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="note_id" value="<?= $id; ?>">
  <div class="mb-3">
    <label class="form-label">Link Contractor</label>
    <select name="contractor_id" class="form-select">
      <option value="">-- Contractor --</option>
      <?php foreach ($contractors as $c): ?>
        <option value="<?= $c['id']; ?>"><?= e($c['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button class="btn btn-secondary btn-sm" type="submit">Link</button>
</form>
<?php endif; ?>
<?php require_once __DIR__ . '/../../admin_footer.php'; ?>
