<?php
require_once __DIR__ . '/../../admin_header.php';
require_permission('minder_note','read');

$token = generate_csrf_token();

$sql = "SELECT n.id, n.title, n.body, n.category_id, n.date_created, cat.label AS category_label
        FROM admin_minder_note n
        LEFT JOIN lookup_list_items cat ON n.category_id = cat.id
        ORDER BY n.date_created DESC";
$notes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$fileStmt = $pdo->prepare('SELECT id, file_name, file_path FROM admin_minder_note_file WHERE note_id = :id');
foreach ($notes as &$n) {
  $fileStmt->execute([':id' => $n['id']]);
  $n['attachments'] = $fileStmt->fetchAll(PDO::FETCH_ASSOC);
}
unset($n);

$categories = get_lookup_items($pdo, 'ADMIN_NOTE_CATEGORY');
?>
<h2 class="mb-4">Notes</h2>
<?= flash_message($_SESSION['message'] ?? '', 'success'); ?>
<?= flash_message($_SESSION['error_message'] ?? '', 'danger'); ?>
<?php unset($_SESSION['message'], $_SESSION['error_message']); ?>
<?php if (user_has_permission('minder_note','create')): ?>
<button class="btn btn-sm btn-primary mb-3" id="addNoteBtn">Add Note</button>
<?php endif; ?>
<div class="timeline">
<?php foreach ($notes as $note): ?>
  <div class="timeline-item mb-4">
    <div class="timeline-date text-secondary small"><?= e(date('Y-m-d H:i', strtotime($note['date_created']))); ?></div>
    <h5 class="mb-1"><?= e($note['title']); ?></h5>
    <?php if ($note['category_label']): ?><span class="badge bg-info mb-2"><?= e($note['category_label']); ?></span><?php endif; ?>
    <p><?= nl2br(e($note['body'])); ?></p>
    <?php if (!empty($note['attachments'])): ?>
    <div class="mb-2">
      <?php foreach ($note['attachments'] as $f): ?>
        <a href="<?= e($f['file_path']); ?>" target="_blank"><?= e($f['file_name']); ?></a><br>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div>
      <?php if (user_has_permission('minder_note','update')): ?>
        <a class="btn btn-sm btn-warning" href="note.php?id=<?= $note['id']; ?>">Edit</a>
      <?php endif; ?>
      <?php if (user_has_permission('minder_note','delete')): ?>
        <form method="post" action="functions/delete.php" class="d-inline" onsubmit="return confirm('Delete this note?');">
          <input type="hidden" name="id" value="<?= $note['id']; ?>">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php if (user_has_permission('minder_note','create')): ?>
<div class="modal fade" id="noteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="noteForm">
      <div class="modal-header">
        <h5 class="modal-title">Add Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="noteAlert"></div>
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Body</label>
          <textarea name="body" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-select">
            <option value="">--</option>
            <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id']; ?>"><?= e($c['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Attachments</label>
          <input type="file" name="attachments[]" class="form-control" multiple>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>
<script>
<?php if (user_has_permission('minder_note','create')): ?>
const noteModal = new bootstrap.Modal(document.getElementById('noteModal'));
const noteForm = document.getElementById('noteForm');
const noteAlert = document.getElementById('noteAlert');
document.getElementById('addNoteBtn').addEventListener('click', () => {
  noteAlert.innerHTML = '';
  noteForm.reset();
  noteModal.show();
});
noteForm.addEventListener('submit', e => {
  e.preventDefault();
  const formData = new FormData(noteForm);
  fetch('functions/create.php', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        window.location.reload();
      } else {
        noteAlert.innerHTML = `<div class="alert alert-danger">${data.error || 'Error'}</div>`;
      }
    })
    .catch(() => noteAlert.innerHTML = '<div class="alert alert-danger">Server error</div>');
});
<?php endif; ?>
</script>
<?php require '../../admin_footer.php'; ?>
