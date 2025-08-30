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
  $pStmt = $pdo->prepare("SELECT rp.person_id, CONCAT(p.first_name,' ',p.last_name) AS name FROM admin_minder_reminders_persons rp JOIN person p ON rp.person_id = p.id WHERE rp.reminder_id = :id");
  $pStmt->execute([':id'=>$id]);
  $linkedPersonsData = $pStmt->fetchAll(PDO::FETCH_ASSOC);
  $linkedPersons = array_column($linkedPersonsData, 'person_id');
  $cStmt = $pdo->prepare("SELECT rc.contractor_id, CONCAT(p.first_name,' ',p.last_name) AS name FROM admin_minder_reminders_contractors rc JOIN module_contractors mc ON rc.contractor_id = mc.id LEFT JOIN person p ON mc.person_id = p.id WHERE rc.reminder_id = :id");
  $cStmt->execute([':id'=>$id]);
  $linkedContractorsData = $cStmt->fetchAll(PDO::FETCH_ASSOC);
  $linkedContractors = array_column($linkedContractorsData, 'contractor_id');
  $fStmt = $pdo->prepare('SELECT id, file_name, file_path FROM admin_minder_reminders_files WHERE reminder_id = :id');
  $fStmt->execute([':id'=>$id]);
  $files = $fStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  require_permission('minder_reminder','create');
  $reminder = [
    'title' => '',
    'description' => '',
    'remind_at' => null,
    'type_id' => null,
    'status_id' => null
  ];
  $linkedPersonsData = $linkedPersons = [];
  $linkedContractorsData = $linkedContractors = [];
  $files = [];
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
      <select name="person_ids[]" id="personSelect" class="form-select" multiple>
        <?php foreach ($persons as $p): ?>
        <option value="<?= (int)$p['id']; ?>" <?= in_array($p['id'], $linkedPersons) ? 'selected' : ''; ?>><?= e($p['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <?php if ($editing): ?>
    <table class="table" id="personLinks">
      <thead><tr><th>Name</th><th>Action</th></tr></thead>
      <tbody>
        <?php foreach ($linkedPersonsData as $lp): ?>
        <tr data-id="<?= (int)$lp['person_id']; ?>">
          <td><?= e($lp['name']); ?></td>
          <td><button type="button" class="btn btn-sm btn-danger remove-person" data-id="<?= (int)$lp['person_id']; ?>">Delete</button></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
    <div class="mb-3">
      <label class="form-label">Contractors</label>
      <select name="contractor_ids[]" id="contractorSelect" class="form-select" multiple>
        <?php foreach ($contractors as $c): ?>
        <option value="<?= (int)$c['id']; ?>" <?= in_array($c['id'], $linkedContractors) ? 'selected' : ''; ?>><?= e($c['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <?php if ($editing): ?>
    <table class="table" id="contractorLinks">
      <thead><tr><th>Name</th><th>Action</th></tr></thead>
      <tbody>
        <?php foreach ($linkedContractorsData as $lc): ?>
        <tr data-id="<?= (int)$lc['contractor_id']; ?>">
          <td><?= e($lc['name']); ?></td>
          <td><button type="button" class="btn btn-sm btn-danger remove-contractor" data-id="<?= (int)$lc['contractor_id']; ?>">Delete</button></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  <button type="submit" class="btn btn-primary">Save</button>
</form>

<?php if ($editing): ?>
  <hr class="my-4">
  <h3 class="mb-3">Attachments</h3>
  <form method="post" enctype="multipart/form-data" id="fileUploadForm" action="functions/upload_file.php">
    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
    <input type="hidden" name="reminder_id" value="<?= $id; ?>">
    <div class="mb-3">
      <input type="file" name="file" class="form-control" required>
    </div>
    <button class="btn btn-secondary" type="submit">Upload File</button>
  </form>
  <table class="table mt-3" id="filesTable">
    <thead><tr><th>File</th><th>Action</th></tr></thead>
    <tbody>
      <?php foreach ($files as $f): ?>
      <tr data-id="<?= (int)$f['id']; ?>">
        <td><a href="/<?= e($f['file_path']); ?>" target="_blank"><?= e($f['file_name']); ?></a></td>
        <td><button type="button" class="btn btn-sm btn-danger remove-file" data-id="<?= (int)$f['id']; ?>">Delete</button></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
  <?php require __DIR__ . '/../../admin_footer.php'; ?>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const csrf = '<?= $token; ?>';
    const reminderId = <?= $id; ?>;
    function post(url, data){return fetch(url,{method:'POST',body:data}).then(r=>r.json());}

    const mainForm = document.querySelector('form[action^="functions/"]');
    if(mainForm){
      mainForm.addEventListener('submit', e => {
        e.preventDefault();
        const fd = new FormData(mainForm);
        post(mainForm.getAttribute('action'), fd).then(res => {
          if(res.success){
            if(res.id){ window.location = 'reminder.php?id='+res.id; }
          }
        });
      });
    }

    document.querySelectorAll('.remove-person').forEach(btn => {
      btn.addEventListener('click', () => {
        const pid = btn.dataset.id;
        const fd = new FormData();
        fd.append('csrf_token', csrf);
        fd.append('reminder_id', reminderId);
        fd.append('person_id', pid);
        post('functions/unlink_person.php', fd).then(res => {
          if(res.success){
            document.querySelector(`#personLinks tr[data-id="${pid}"]`).remove();
            const opt = document.querySelector(`#personSelect option[value="${pid}"]`);
            if(opt) opt.selected = false;
          }
        });
      });
    });

    document.querySelectorAll('.remove-contractor').forEach(btn => {
      btn.addEventListener('click', () => {
        const cid = btn.dataset.id;
        const fd = new FormData();
        fd.append('csrf_token', csrf);
        fd.append('reminder_id', reminderId);
        fd.append('contractor_id', cid);
        post('functions/unlink_contractor.php', fd).then(res => {
          if(res.success){
            document.querySelector(`#contractorLinks tr[data-id="${cid}"]`).remove();
            const opt = document.querySelector(`#contractorSelect option[value="${cid}"]`);
            if(opt) opt.selected = false;
          }
        });
      });
    });

    document.querySelectorAll('.remove-file').forEach(btn => {
      btn.addEventListener('click', () => {
        const fid = btn.dataset.id;
        const fd = new FormData();
        fd.append('csrf_token', csrf);
        fd.append('id', fid);
        post('functions/delete_file.php', fd).then(res => {
          if(res.success){
            document.querySelector(`#filesTable tr[data-id="${fid}"]`).remove();
          }
        });
      });
    });

    const fileForm = document.getElementById('fileUploadForm');
    if(fileForm){
      fileForm.addEventListener('submit', e => {
        e.preventDefault();
        const fd = new FormData(fileForm);
        post('functions/upload_file.php', fd).then(res => {
          if(res.success){
            const tbody = document.querySelector('#filesTable tbody');
            const tr = document.createElement('tr');
            tr.dataset.id = res.file_id;
            tr.innerHTML = `<td><a href="/${res.path}" target="_blank">${res.name}</a></td><td><button type="button" class="btn btn-sm btn-danger remove-file" data-id="${res.file_id}">Delete</button></td>`;
            tbody.appendChild(tr);
            fileForm.reset();
          }
        });
      });
    }
  });
  </script>
