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
$contactTypes = get_lookup_items($pdo, 'CONTRACTOR_CONTACT_TYPE');
$paymentMethods = get_lookup_items($pdo, 'CONTRACTOR_COMPENSATION_PAYMENT_METHOD');
$fileTypes = get_lookup_items($pdo, 'CONTRACTOR_FILE_TYPE');
$existingFiles = [];
if ($id) {
  $stmt = $pdo->prepare('SELECT id, file_name FROM module_contractors_files WHERE contractor_id = :id ORDER BY date_created DESC');
  $stmt->execute([':id' => $id]);
  $existingFiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$messages = [
  'note-added'    => 'Note added',
  'contact-added' => 'Contact added',
  'comp-saved'    => 'Compensation saved',
  'file-uploaded' => 'File uploaded'
];

$defaultCompTypeId = null;
foreach ($payTypes as $p) {
  if (!empty($p['is_default'])) {
    $defaultCompTypeId = $p['id'];
    break;
  }
}
$defaultPaymentMethodId = null;
foreach ($paymentMethods as $pm) {
  if (!empty($pm['is_default'])) {
    $defaultPaymentMethodId = $pm['id'];
    break;
  }
}

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
        $stmt = $pdo->prepare('SELECT mcc.*, l.label AS contact_type FROM module_contractors_contacts mcc LEFT JOIN lookup_list_items l ON mcc.contact_type_id = l.id WHERE mcc.contractor_id = :id ORDER BY mcc.date_created DESC');
        $stmt->execute([':id'=>$id]);
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <form method="post" action="functions/add_contact.php" class="mb-3">
        <input type="hidden" name="contractor_id" value="<?= $id; ?>">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <div class="row g-2">
          <div class="col-md-3">
            <select name="contact_type_id" class="form-select form-select-sm" required>
              <option value="">Type</option>
              <?php foreach($contactTypes as $ct): ?>
                <option value="<?= h($ct['id']); ?>"><?= h($ct['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <input type="datetime-local" name="contact_date" class="form-control form-control-sm">
          </div>
          <div class="col-md-3">
            <input type="number" name="contact_duration" class="form-control form-control-sm" placeholder="Duration (min)">
          </div>
          <div class="col-md-3">
            <input type="text" name="contact_result" class="form-control form-control-sm" placeholder="Result">
          </div>
          <div class="col-md-3 mt-2">
            <input type="text" name="related_module" class="form-control form-control-sm" placeholder="Related Module">
          </div>
          <div class="col-md-3 mt-2">
            <input type="number" name="related_id" class="form-control form-control-sm" placeholder="Related ID">
          </div>
          <div class="col-md-12 mt-2">
            <textarea name="summary" class="form-control form-control-sm" placeholder="Summary" required></textarea>
          </div>
          <div class="col-md-12 mt-2">
            <button class="btn btn-primary btn-sm">Add Contact</button>
          </div>
        </div>
      </form>
      <ul class="list-group">
        <?php foreach($contacts as $c): ?>
          <li class="list-group-item small">
            <strong><?= h($c['contact_date']); ?></strong> - <?= h($c['contact_type']); ?>
            <?php if($c['summary']): ?>: <?= h($c['summary']); ?><?php endif; ?>
            <?php if($c['contact_duration']): ?> (<?= h($c['contact_duration']); ?> min)<?php endif; ?>
            <?php if($c['contact_result']): ?> - <?= h($c['contact_result']); ?><?php endif; ?>
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
        $stmt = $pdo->prepare('SELECT mcc.*, t.label AS type_label, pm.label AS payment_method_label, CONCAT(p.first_name, " ", p.last_name) AS created_by_name, f.file_path, f.file_name FROM module_contractors_compensation mcc LEFT JOIN lookup_list_items t ON mcc.compensation_type_id = t.id LEFT JOIN lookup_list_items pm ON mcc.payment_method_id = pm.id LEFT JOIN module_contractors_files f ON mcc.file_id = f.id LEFT JOIN users u ON mcc.user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE mcc.contractor_id = :id ORDER BY mcc.date_created DESC');
        $stmt->execute([':id'=>$id]);
        $comps = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <form method="post" action="functions/add_compensation.php" class="mb-3" enctype="multipart/form-data">
        <input type="hidden" name="contractor_id" value="<?= $id; ?>">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <div class="row g-2">
          <div class="col-md-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Pay Date</label>
            <input type="date" name="pay_date" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Invoice #</label>
            <input type="text" name="invoice_number" class="form-control form-control-sm">
          </div>
          <div class="col-md-3">
            <label class="form-label">Existing File</label>
            <select name="existing_file_id" class="form-select form-select-sm">
              <option value="">Select File</option>
              <?php foreach($existingFiles as $ef): ?>
                <option value="<?= h($ef['id']); ?>"><?= h($ef['file_name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <select name="compensation_type_id" class="form-select form-select-sm" required>
              <option value="">Type</option>
              <?php foreach($payTypes as $idx => $p):
                $selected = $defaultCompTypeId !== null ? ($p['id'] == $defaultCompTypeId) : ($idx === 0);
              ?>
              <option value="<?= h($p['id']); ?>" <?= $selected ? 'selected' : ''; ?>><?= h($p['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <select name="payment_method_id" class="form-select form-select-sm" required>
              <option value="">Payment Method</option>
              <?php foreach($paymentMethods as $idx => $pm):
                $selected = $defaultPaymentMethodId !== null ? ($pm['id'] == $defaultPaymentMethodId) : ($idx === 0);
              ?>
              <option value="<?= h($pm['id']); ?>" <?= $selected ? 'selected' : ''; ?>><?= h($pm['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <label for="comp_amount" class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" id="comp_amount" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-3">
            <label for="effective_start" class="form-label">Effective Start</label>
            <input type="date" name="effective_start" id="effective_start" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-3 mt-2">
            <label for="effective_end" class="form-label">Effective End</label>
            <input type="date" name="effective_end" id="effective_end" class="form-control form-control-sm">
          </div>
          <div class="col-md-3 mt-2">
            <label class="form-label">Attachment</label>
            <input type="file" name="attachment" class="form-control form-control-sm">
          </div>
          <div class="col-md-6 mt-2">
            <label for="comp_notes" class="form-label">Notes</label>
            <textarea name="notes" id="comp_notes" class="form-control form-control-sm"></textarea>
          </div>
          <div class="col-md-12 mt-2">
            <button class="btn btn-primary btn-sm">Add Compensation</button>
          </div>
        </div>
      </form>
      <table class="table table-sm table-striped align-middle">
        <thead>
          <tr>
            <th>Actions</th>
            <th>Title</th>
            <th>Pay Date</th>
            <th>Invoice #</th>
            <th>File</th>
            <th>Type</th>
            <th>Payment Method</th>
            <th>Amount</th>
            <th>Effective Start</th>
            <th>Effective End</th>
            <th>Notes</th>
            <th>Created (date/user)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($comps as $cp): ?>
            <tr>
              <td>
                <button type="button"
                  class="btn btn-warning btn-sm edit-comp-btn"
                  data-id="<?= h($cp['id']); ?>"
                  data-title="<?= h($cp['title']); ?>"
                  data-pay-date="<?= h($cp['pay_date']); ?>"
                  data-invoice-number="<?= h($cp['invoice_number']); ?>"
                  data-compensation-type-id="<?= h($cp['compensation_type_id']); ?>"
                  data-payment-method-id="<?= h($cp['payment_method_id']); ?>"
                  data-amount="<?= h($cp['amount']); ?>"
                  data-effective-start="<?= h($cp['effective_start']); ?>"
                  data-effective-end="<?= h($cp['effective_end']); ?>"
                  data-notes="<?= h($cp['notes']); ?>"
                  data-file-id="<?= h($cp['file_id']); ?>">
                  Edit
                </button>
              </td>
              <td><?= h($cp['title']); ?></td>
              <td><?= h($cp['pay_date']); ?></td>
              <td><?= h($cp['invoice_number'] ?: '—'); ?></td>
              <td>
                <?php if($cp['file_path']): ?>
                  <a class="btn btn-outline-secondary btn-sm" href="<?= h($cp['file_path']); ?>" download>Download</a>
                <?php else: ?>
                  —
                <?php endif; ?>
              </td>
              <td><?= h($cp['type_label'] ?: '—'); ?></td>
              <td><?= h($cp['payment_method_label'] ?: '—'); ?></td>
              <td><?= h($cp['amount'] ?: '—'); ?></td>
              <td><?= h($cp['effective_start'] ?: '—'); ?></td>
              <td><?= h($cp['effective_end'] ?: '—'); ?></td>
              <td><?= h($cp['notes'] ?: '—'); ?></td>
              <td><?= h($cp['date_created'] ?: '—'); ?><br><span class="text-muted small"><?= h($cp['created_by_name'] ?: '—'); ?></span></td>
            </tr>
          <?php endforeach; ?>
          <?php if(!$comps): ?>
            <tr><td colspan="12" class="text-center text-muted">No compensation found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      <div class="modal fade" id="editCompModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="post" action="functions/update_compensation.php" enctype="multipart/form-data">
              <div class="modal-header">
                <h5 class="modal-title">Edit Compensation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id" id="edit_comp_id">
                <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <div class="row g-2">
                  <div class="col-md-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" id="edit_comp_title" class="form-control form-control-sm" required>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Pay Date</label>
                    <input type="date" name="pay_date" id="edit_comp_pay_date" class="form-control form-control-sm" required>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Invoice #</label>
                    <input type="text" name="invoice_number" id="edit_comp_invoice_number" class="form-control form-control-sm">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Existing File</label>
                    <select name="existing_file_id" id="edit_existing_file_id" class="form-select form-select-sm">
                      <option value="">Select File</option>
                      <?php foreach($existingFiles as $ef): ?>
                        <option value="<?= h($ef['id']); ?>"><?= h($ef['file_name']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <select name="compensation_type_id" id="edit_compensation_type_id" class="form-select form-select-sm" required>
                      <option value="">Type</option>
                      <?php foreach($payTypes as $p): ?>
                        <option value="<?= h($p['id']); ?>"><?= h($p['label']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <select name="payment_method_id" id="edit_payment_method_id" class="form-select form-select-sm" required>
                      <option value="">Payment Method</option>
                      <?php foreach($paymentMethods as $pm): ?>
                        <option value="<?= h($pm['id']); ?>"><?= h($pm['label']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label for="edit_comp_amount" class="form-label">Amount</label>
                    <input type="number" step="0.01" name="amount" id="edit_comp_amount" class="form-control form-control-sm" required>
                  </div>
                  <div class="col-md-3">
                    <label for="edit_effective_start" class="form-label">Effective Start</label>
                    <input type="date" name="effective_start" id="edit_effective_start" class="form-control form-control-sm" required>
                  </div>
                  <div class="col-md-3 mt-2">
                    <label for="edit_effective_end" class="form-label">Effective End</label>
                    <input type="date" name="effective_end" id="edit_effective_end" class="form-control form-control-sm">
                  </div>
                  <div class="col-md-3 mt-2">
                    <label class="form-label">Attachment</label>
                    <input type="file" name="attachment" class="form-control form-control-sm">
                  </div>
                  <div class="col-md-6 mt-2">
                    <label for="edit_comp_notes" class="form-label">Notes</label>
                    <textarea name="notes" id="edit_comp_notes" class="form-control form-control-sm"></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Update Compensation</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <script>
      document.querySelectorAll('.edit-comp-btn').forEach(btn => {
        btn.addEventListener('click', function(){
          document.getElementById('edit_comp_id').value = this.dataset.id;
          document.getElementById('edit_comp_title').value = this.dataset.title || '';
          document.getElementById('edit_comp_pay_date').value = this.dataset.payDate || '';
          document.getElementById('edit_comp_invoice_number').value = this.dataset.invoiceNumber || '';
          document.getElementById('edit_compensation_type_id').value = this.dataset.compensationTypeId || '';
          document.getElementById('edit_payment_method_id').value = this.dataset.paymentMethodId || '';
          document.getElementById('edit_comp_amount').value = this.dataset.amount || '';
          document.getElementById('edit_effective_start').value = this.dataset.effectiveStart || '';
          document.getElementById('edit_effective_end').value = this.dataset.effectiveEnd || '';
          document.getElementById('edit_comp_notes').value = this.dataset.notes || '';
          document.getElementById('edit_existing_file_id').value = this.dataset.fileId || '';
          var modal = new bootstrap.Modal(document.getElementById('editCompModal'));
          modal.show();
        });
      });
      </script>
    <?php else: ?>
      <p class="text-muted">Save contractor to add compensation.</p>
    <?php endif; ?>
  </div>
  <div class="tab-pane fade" id="files" role="tabpanel">
    <?php if($id): ?>
      <?php
        $stmt = $pdo->prepare('SELECT mcf.*, l.label AS file_type FROM module_contractors_files mcf LEFT JOIN lookup_list_items l ON mcf.file_type_id = l.id WHERE mcf.contractor_id = :id ORDER BY mcf.date_created DESC');
        $stmt->execute([':id'=>$id]);
        $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <form method="post" action="functions/upload_file.php" enctype="multipart/form-data" class="mb-3">
        <input type="hidden" name="contractor_id" value="<?= $id; ?>">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <select name="file_type_id" class="form-select mb-2" required>
          <option value="">File Type</option>
          <?php foreach($fileTypes as $ft): ?>
            <option value="<?= h($ft['id']); ?>"><?= h($ft['label']); ?></option>
          <?php endforeach; ?>
        </select>
        <input type="text" name="description" class="form-control mb-2" placeholder="Description">
        <input type="file" name="file" class="form-control mb-2" required>
        <button class="btn btn-primary btn-sm">Upload File</button>
      </form>
      <table class="table table-sm">
        <thead><tr><th>File</th><th>Type</th><th>Version</th><th>Description</th><th></th></tr></thead>
        <tbody>
          <?php foreach($files as $f): ?>
            <tr>
              <td><?= h($f['file_name']); ?></td>
              <td><?= h($f['file_type']); ?></td>
              <td>v<?= h($f['version']); ?></td>
              <td><?= h($f['description']); ?></td>
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
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
  <div id="action-toast" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
<script>
const messages = <?= json_encode($messages); ?>;
document.addEventListener('DOMContentLoaded', () => {
  const hash = window.location.hash;
  if (hash) {
    const tabTrigger = document.querySelector(`[data-bs-target="${hash}"]`);
    tabTrigger && new bootstrap.Tab(tabTrigger).show();
  }
  const msg = new URLSearchParams(window.location.search).get('msg');
  const toastEl = document.getElementById('action-toast');
  if (msg && toastEl) {
    toastEl.querySelector('.toast-body').textContent = messages[msg] || 'Saved successfully';
    new bootstrap.Toast(toastEl).show();
  }
});
</script>
<?php require '../admin_footer.php'; ?>
