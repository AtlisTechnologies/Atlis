<?php
require '../admin_header.php';
require_permission('contractors', 'read');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$contractor = null;
$availableUsers = [];

if ($id) {
  $stmt = $pdo->prepare('SELECT mc.*, p.first_name, p.last_name FROM module_contractors mc JOIN person p ON mc.person_id = p.id WHERE mc.id = :id');
  $stmt->execute([':id' => $id]);
  $contractor = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$contractor) {
    $id = 0;
  }
} else {
  $stmt = $pdo->query('SELECT u.id, CONCAT(p.first_name, " ", p.last_name) AS full_name FROM users u JOIN person p ON u.id = p.user_id WHERE u.id NOT IN (SELECT user_id FROM module_contractors) ORDER BY p.first_name, p.last_name');
  $availableUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$statuses = get_lookup_items($pdo, 'CONTRACTOR_STATUS');
$payTypes = get_lookup_items($pdo, 'CONTRACTOR_COMPENSATION_TYPE');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Contractor</h2>
<ul class="nav nav-tabs mb-3" id="contractorTabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">Notes</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab">Contacts</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="comp-tab" data-bs-toggle="tab" data-bs-target="#compensation" type="button" role="tab">Compensation</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">Files</button>
  </li>
</ul>
<div class="tab-content" id="contractorTabsContent">
  <div class="tab-pane fade show active" id="profile" role="tabpanel">
    <form method="post" action="functions/<?= $id ? 'update.php' : 'create.php'; ?>">
      <input type="hidden" name="csrf_token" value="<?= $token; ?>">
      <?php if($id): ?><input type="hidden" name="id" value="<?= $id; ?>"><?php endif; ?>
      <?php if(!$id): ?>
      <div class="mb-3">
        <label class="form-label">User</label>
        <select name="user_id" class="form-select" required>
          <option value="">Select User</option>
          <?php foreach($availableUsers as $u): ?>
            <option value="<?= h($u['id']); ?>"><?= h($u['full_name']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php else: ?>
      <div class="mb-3">
        <label class="form-label">User</label>
        <input type="text" class="form-control" value="<?= h($contractor['first_name'] . ' ' . $contractor['last_name']); ?>" disabled>
      </div>
      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status_id" class="form-select">
          <?php foreach($statuses as $s):
            $selected = ($contractor['status_id'] ?? '') == $s['id'] ? 'selected' : '';
          ?>
          <option value="<?= h($s['id']); ?>" <?= $selected; ?>><?= h($s['label']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Pay Type</label>
        <select name="pay_type_id" class="form-select">
          <?php foreach($payTypes as $p):
            $selected = ($contractor['pay_type_id'] ?? '') == $p['id'] ? 'selected' : '';
          ?>
          <option value="<?= h($p['id']); ?>" <?= $selected; ?>><?= h($p['label']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" class="form-control" value="<?= h($contractor['start_date'] ?? ''); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">End Date</label>
        <input type="date" name="end_date" class="form-control" value="<?= h($contractor['end_date'] ?? ''); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Current Rate</label>
        <input type="number" step="0.01" name="current_rate" class="form-control" value="<?= h($contractor['current_rate'] ?? ''); ?>">
      </div>
      <?php endif; ?>
      <button class="btn <?= $id ? 'btn-warning' : 'btn-success'; ?>" type="submit">Save</button>
    </form>
  </div>
  <div class="tab-pane fade" id="notes" role="tabpanel">
    <?php if($id): ?>
      <?php
        $stmt = $pdo->prepare('SELECT * FROM module_contractors_notes WHERE contractor_id = :id ORDER BY date_created DESC');
        $stmt->execute([':id'=>$id]);
        $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <form method="post" action="functions/add_note.php" class="mb-3">
        <input type="hidden" name="contractor_id" value="<?= $id; ?>">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <textarea name="note_text" class="form-control mb-2" required></textarea>
        <button class="btn btn-primary btn-sm">Add Note</button>
      </form>
      <ul class="list-group">
        <?php foreach($notes as $n): ?>
          <li class="list-group-item small"><strong><?= h($n['date_created']); ?>:</strong> <?= h($n['note_text']); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="text-muted">Save contractor to add notes.</p>
    <?php endif; ?>
  </div>
  <div class="tab-pane fade" id="contacts" role="tabpanel">
    <?php if($id): ?>
      <?php
        $stmt = $pdo->prepare('SELECT * FROM module_contractors_contacts WHERE contractor_id = :id ORDER BY date_created DESC');
        $stmt->execute([':id'=>$id]);
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <form method="post" action="functions/add_contact.php" class="mb-3">
        <input type="hidden" name="contractor_id" value="<?= $id; ?>">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <div class="row g-2">
          <div class="col-md-3">
            <input type="text" name="name" class="form-control form-control-sm" placeholder="Name" required>
          </div>
          <div class="col-md-3">
            <input type="text" name="phone" class="form-control form-control-sm" placeholder="Phone">
          </div>
          <div class="col-md-3">
            <input type="email" name="email" class="form-control form-control-sm" placeholder="Email">
          </div>
          <div class="col-md-3">
            <input type="text" name="related_module" class="form-control form-control-sm" placeholder="Related Module">
          </div>
          <div class="col-md-3 mt-2">
            <input type="number" name="related_id" class="form-control form-control-sm" placeholder="Related ID">
          </div>
          <div class="col-md-12 mt-2">
            <button class="btn btn-primary btn-sm">Add Contact</button>
          </div>
        </div>
      </form>
      <ul class="list-group">
        <?php foreach($contacts as $c): ?>
          <li class="list-group-item small">
            <?= h($c['name']); ?><?php if($c['email']): ?> - <?= h($c['email']); ?><?php endif; ?><?php if($c['phone']): ?> - <?= h($c['phone']); ?><?php endif; ?>
            <?php if($c['related_module'] && $c['related_id']): ?>
              <span class="text-muted">(<?= h($c['related_module']); ?> #<?= h($c['related_id']); ?>)</span>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="text-muted">Save contractor to add contacts.</p>
    <?php endif; ?>
  </div>
  <div class="tab-pane fade" id="compensation" role="tabpanel">
    <?php if($id): ?>
      <?php
        $stmt = $pdo->prepare('SELECT * FROM module_contractors_compensation WHERE contractor_id = :id ORDER BY date_created DESC');
        $stmt->execute([':id'=>$id]);
        $comps = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <form method="post" action="functions/add_compensation.php" class="mb-3">
        <input type="hidden" name="contractor_id" value="<?= $id; ?>">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <div class="row g-2">
          <div class="col-md-3">
            <input type="number" step="0.01" name="amount" class="form-control form-control-sm" placeholder="Amount" required>
          </div>
          <div class="col-md-3">
            <input type="text" name="type" class="form-control form-control-sm" placeholder="Type" required>
          </div>
          <div class="col-md-3">
            <input type="date" name="start_date" class="form-control form-control-sm">
          </div>
          <div class="col-md-3">
            <input type="date" name="end_date" class="form-control form-control-sm">
          </div>
          <div class="col-md-12 mt-2">
            <button class="btn btn-primary btn-sm">Add Compensation</button>
          </div>
        </div>
      </form>
      <ul class="list-group">
        <?php foreach($comps as $cp): ?>
          <li class="list-group-item small">
            <?= h($cp['type']); ?>: <?= h($cp['amount']); ?>
            <?php if($cp['start_date']): ?> (<?= h($cp['start_date']); ?><?php if($cp['end_date']): ?> - <?= h($cp['end_date']); ?><?php endif; ?>)<?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="text-muted">Save contractor to add compensation.</p>
    <?php endif; ?>
  </div>
  <div class="tab-pane fade" id="files" role="tabpanel">
    <?php if($id): ?>
      <?php
        $stmt = $pdo->prepare('SELECT * FROM module_contractors_files WHERE contractor_id = :id ORDER BY date_created DESC');
        $stmt->execute([':id'=>$id]);
        $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <form method="post" action="functions/upload_file.php" enctype="multipart/form-data" class="mb-3">
        <input type="hidden" name="contractor_id" value="<?= $id; ?>">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <input type="file" name="file" class="form-control mb-2" required>
        <button class="btn btn-primary btn-sm">Upload File</button>
      </form>
      <table class="table table-sm">
        <thead><tr><th>File</th><th>Version</th><th></th></tr></thead>
        <tbody>
          <?php foreach($files as $f): ?>
            <tr>
              <td><?= h($f['file_name']); ?></td>
              <td>v<?= h($f['version']); ?></td>
              <td><a class="btn btn-outline-secondary btn-sm" href="<?= h($f['file_path']); ?>" download>Download</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-muted">Save contractor to manage files.</p>
    <?php endif; ?>
  </div>
</div>
<?php require '../admin_footer.php'; ?>
