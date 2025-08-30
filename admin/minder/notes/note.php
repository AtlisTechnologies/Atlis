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

if ($editing) {
    $fileStmt = $pdo->prepare('SELECT id, file_name, file_path FROM admin_minder_notes_files WHERE note_id = :id');
    $fileStmt->execute([':id' => $id]);
    $files = $fileStmt->fetchAll(PDO::FETCH_ASSOC);

    $lpStmt = $pdo->prepare('SELECT np.id, CONCAT(p.first_name, " ", p.last_name) AS name FROM admin_minder_notes_persons np JOIN person p ON np.person_id = p.id WHERE np.note_id = :id ORDER BY p.first_name, p.last_name');
    $lpStmt->execute([':id' => $id]);
    $linkedPersons = $lpStmt->fetchAll(PDO::FETCH_ASSOC);

    $lcStmt = $pdo->prepare('SELECT nc.id, CONCAT(p.first_name, " ", p.last_name) AS name FROM admin_minder_notes_contractors nc JOIN module_contractors mc ON nc.contractor_id = mc.id JOIN person p ON mc.person_id = p.id WHERE nc.note_id = :id ORDER BY p.first_name, p.last_name');
    $lcStmt->execute([':id' => $id]);
    $linkedContractors = $lcStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $files = $linkedPersons = $linkedContractors = [];
}

$token = generate_csrf_token();
?>
<h2 class="mb-4"><?= $editing ? 'Edit Note' : 'Add Note'; ?></h2>
<?= flash_message($_SESSION['message'] ?? '', 'success'); ?>
<?= flash_message($_SESSION['error_message'] ?? '', 'danger'); ?>
<?php unset($_SESSION['message'], $_SESSION['error_message']); ?>
<form id="noteForm" method="post" action="functions/<?= $editing ? 'update' : 'create'; ?>.php">
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
    <div id="bodyEditor" class="form-control" style="height:200px;"></div>
    <input type="hidden" name="body" id="bodyInput">
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
  <div class="mb-3">
    <h5>Attachments</h5>
    <ul class="list-unstyled">
      <?php foreach ($files as $f): ?>
      <li class="mb-1"><a href="../../../<?= e($f['file_path']); ?>" target="_blank"><?= e($f['file_name']); ?></a>
        <a href="functions/delete_file.php?note_id=<?= $id; ?>&id=<?= $f['id']; ?>&csrf_token=<?= $token; ?>" class="btn btn-sm btn-danger ms-2" onclick="return confirm('Delete this file?');">Delete</a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="mb-3">
    <h5>Linked Persons</h5>
    <ul class="list-unstyled">
      <?php foreach ($linkedPersons as $lp): ?>
      <li class="mb-1"><?= e($lp['name']); ?>
        <a href="functions/unlink_person.php?note_id=<?= $id; ?>&id=<?= $lp['id']; ?>&csrf_token=<?= $token; ?>" class="btn btn-sm btn-danger ms-2" onclick="return confirm('Remove this person?');">Delete</a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="mb-3">
    <h5>Linked Contractors</h5>
    <ul class="list-unstyled">
      <?php foreach ($linkedContractors as $lc): ?>
      <li class="mb-1"><?= e($lc['name']); ?>
        <a href="functions/unlink_contractor.php?note_id=<?= $id; ?>&id=<?= $lc['id']; ?>&csrf_token=<?= $token; ?>" class="btn btn-sm btn-danger ms-2" onclick="return confirm('Remove this contractor?');">Delete</a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
 <?php endif; ?>
<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.7/quill.snow.css">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#bodyEditor', { theme: 'snow' });
    quill.root.innerHTML = <?= json_encode($note['body']); ?>;
    document.getElementById('noteForm').addEventListener('submit', function() {
      document.getElementById('bodyInput').value = quill.root.innerHTML;
    });
  });
</script>
<?php require_once __DIR__ . '/../../admin_footer.php'; ?>
