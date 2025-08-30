<?php
require_once __DIR__ . '/../../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

if ($editing) {
  require_permission('minder_note','update');
  $stmt = $pdo->prepare('SELECT * FROM admin_minder_note WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $note = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$note) {
    echo '<div class="alert alert-danger">Note not found.</div>';
    require '../../admin_footer.php';
    exit;
  }
  $fileStmt = $pdo->prepare('SELECT id, file_name, file_path FROM admin_minder_note_file WHERE note_id = :id');
  $fileStmt->execute([':id' => $id]);
  $files = $fileStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  require_permission('minder_note','create');
  $note = ['title' => '', 'body' => '', 'category_id' => null];
  $files = [];
}

$categories = get_lookup_items($pdo, 'ADMIN_NOTE_CATEGORY');
$token = generate_csrf_token();
?>
<h2 class="mb-4"><?= $editing ? 'Edit Note' : 'Add Note'; ?></h2>
<div id="noteAlert"></div>
<form id="noteForm" enctype="multipart/form-data">
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
  <div class="mb-3">
    <label class="form-label">Category</label>
    <select name="category_id" class="form-select">
      <option value="">--</option>
      <?php foreach ($categories as $c): ?>
      <option value="<?= $c['id']; ?>" <?= $note['category_id'] == $c['id'] ? 'selected' : ''; ?>><?= e($c['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Attachments</label>
    <input type="file" name="attachments[]" class="form-control" multiple>
    <?php if ($editing && $files): ?>
    <ul class="mt-2">
      <?php foreach ($files as $f): ?>
      <li><a href="<?= e($f['file_path']); ?>" target="_blank"><?= e($f['file_name']); ?></a></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>
  <button class="btn btn-primary" type="submit">Save</button>
</form>
<script>
const noteForm = document.getElementById('noteForm');
const noteAlert = document.getElementById('noteAlert');
noteForm.addEventListener('submit', e => {
  e.preventDefault();
  const formData = new FormData(noteForm);
  fetch('functions/<?= $editing ? 'update' : 'create'; ?>.php', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        window.location.href = 'index.php';
      } else {
        noteAlert.innerHTML = `<div class="alert alert-danger">${data.error || 'Error'}</div>`;
      }
    })
    .catch(() => noteAlert.innerHTML = '<div class="alert alert-danger">Server error</div>');
});
</script>
<?php require '../../admin_footer.php'; ?>
