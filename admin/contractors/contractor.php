<?php
require '../admin_header.php';
require_permission('contractors', 'read');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$contractor = null;
$availableUsers = [];
$currentPhone = $currentAddress = null;

if ($id) {
  $stmt = $pdo->prepare('SELECT mc.*, p.first_name, p.last_name FROM module_contractors mc JOIN person p ON mc.person_id = p.id WHERE mc.id = :id');
  $stmt->execute([':id' => $id]);
  $contractor = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$contractor) {
    $id = 0;
  }
  if ($contractor) {
    $stmt = $pdo->prepare('SELECT phone_number FROM person_phones WHERE person_id = :pid ORDER BY date_updated DESC, id DESC LIMIT 1');
    $stmt->execute([':pid' => $contractor['person_id']]);
    $currentPhone = $stmt->fetchColumn();
    $stmt = $pdo->prepare('SELECT address_line1, address_line2, city, state_id, postal_code, country FROM person_addresses WHERE person_id = :pid ORDER BY date_updated DESC, id DESC LIMIT 1');
    $stmt->execute([':pid' => $contractor['person_id']]);
    if($addr = $stmt->fetch(PDO::FETCH_ASSOC)){
      $parts = array_filter([
        $addr['address_line1'] ?? null,
        $addr['address_line2'] ?? null,
        $addr['city'] ?? null,
        $addr['state_id'] ?? null,
        $addr['postal_code'] ?? null,
        $addr['country'] ?? null
      ]);
      $currentAddress = implode(', ', $parts);
    }
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
$acqTypes = get_lookup_items($pdo, 'CONTRACTOR_ACQUAINTANCE_TYPE');
$responseTypes = get_lookup_items($pdo, 'CONTRACTOR_CONTACT_RESPONSE_TYPE');
$stmt = $pdo->query('SELECT u.id, CONCAT(p.first_name, " ", p.last_name) AS full_name FROM users u JOIN person p ON u.id = p.user_id ORDER BY p.first_name, p.last_name');
$allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
$existingFiles = [];
if ($id) {
  $stmt = $pdo->prepare('SELECT id, file_name FROM module_contractors_files WHERE contractor_id = :id ORDER BY date_created DESC');
  $stmt->execute([':id' => $id]);
  $existingFiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$organizations = $pdo->query('SELECT id, name FROM module_organization ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$agencies      = $pdo->query('SELECT id, name, organization_id FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$divisions     = $pdo->query('SELECT id, name, agency_id FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);

$selectedOrgIds      = [];
$selectedAgencyIds   = [];
$selectedDivisionIds = [];
if ($id) {
  $stmt = $pdo->prepare('SELECT organization_id FROM module_contractors_organizations WHERE contractor_id = :id');
  $stmt->execute([':id' => $id]);
  $selectedOrgIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

  $stmt = $pdo->prepare('SELECT agency_id FROM module_contractors_agencies WHERE contractor_id = :id');
  $stmt->execute([':id' => $id]);
  $selectedAgencyIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

  $stmt = $pdo->prepare('SELECT division_id FROM module_contractors_divisions WHERE contractor_id = :id');
  $stmt->execute([':id' => $id]);
  $selectedDivisionIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

$messages = [
  'note-added'      => 'Note added',
  'note-updated'    => 'Note updated',
  'note-deleted'    => 'Note deleted',
  'contact-added'   => 'Contact added',
  'contact-updated' => 'Contact updated',
  'contact-deleted' => 'Contact deleted',
  'response-saved'  => 'Response saved',
  'response-deleted'=> 'Response deleted',
  'comp-saved'      => 'Compensation saved',
  'comp-deleted'    => 'Compensation deleted',
  'file-uploaded'   => 'File uploaded',
  'file-updated'    => 'File updated',
  'file-deleted'    => 'File deleted'
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
$defaultResponseTypeId = null;
foreach ($responseTypes as $rt) {
  if (!empty($rt['is_default'])) {
    $defaultResponseTypeId = $rt['id'];
    break;
  }
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

function format_display_date($dt) {
  if (empty($dt)) {
    return '';
  }
  $ts  = strtotime($dt);
  $out = date('M jS, Y', $ts);
  if (date('His', $ts) !== '000000') {
    $out .= ' ' . date('g:ia', $ts);
  }
  return $out;
}
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
      <?php if($id): ?>
      <div class="alert alert-secondary small mb-3">
        <strong>Phone:</strong> <?= h($currentPhone ?? 'N/A'); ?><br>
        <strong>Address:</strong> <?= h($currentAddress ?? 'N/A'); ?>
      </div>
      <?php endif; ?>
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
        <label class="form-label">Initial Contact Date</label>
        <input type="date" name="initial_contact_date" class="form-control" value="<?= h($contractor['initial_contact_date'] ?? ''); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Title/Role</label>
        <input type="text" name="title_role" class="form-control" value="<?= h($contractor['title_role'] ?? ''); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Acquaintance</label>
        <textarea name="acquaintance" class="form-control"><?= h($contractor['acquaintance'] ?? ''); ?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Acquaintance Type</label>
        <select name="acquaintance_type_id" class="form-select">
          <option value="">Select Type</option>
          <?php foreach($acqTypes as $a):
            $selected = ($contractor['acquaintance_type_id'] ?? '') == $a['id'] ? 'selected' : '';
          ?>
          <option value="<?= h($a['id']); ?>" <?= $selected; ?>><?= h($a['label']); ?></option>
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
      <?php endif; ?>
      <div class="mb-3">
        <label class="form-label">Organizations</label>
        <?php foreach($organizations as $org): ?>
        <div class="form-check">
          <input class="form-check-input org-filter" type="checkbox" name="organizations[]" value="<?= h($org['id']); ?>" id="org<?= h($org['id']); ?>" <?= in_array($org['id'], $selectedOrgIds) ? 'checked' : ''; ?>>
          <label class="form-check-label" for="org<?= h($org['id']); ?>"><?= h($org['name']); ?></label>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Agencies</label>
        <div id="agency-options">
          <?php foreach($agencies as $agency): ?>
          <div class="form-check" data-org="<?= h($agency['organization_id']); ?>">
            <input class="form-check-input agency-filter" type="checkbox" name="agencies[]" value="<?= h($agency['id']); ?>" id="agency<?= h($agency['id']); ?>" <?= in_array($agency['id'], $selectedAgencyIds) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="agency<?= h($agency['id']); ?>"><?= h($agency['name']); ?></label>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Divisions</label>
        <div id="division-options">
          <?php foreach($divisions as $division): ?>
          <div class="form-check" data-agency="<?= h($division['agency_id']); ?>">
            <input class="form-check-input division-filter" type="checkbox" name="divisions[]" value="<?= h($division['id']); ?>" id="division<?= h($division['id']); ?>" <?= in_array($division['id'], $selectedDivisionIds) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="division<?= h($division['id']); ?>"><?= h($division['name']); ?></label>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
    </form>
    <script>
    (function(){
      function filterAgencies(){
        const orgs = Array.from(document.querySelectorAll('.org-filter:checked')).map(cb => cb.value);
        document.querySelectorAll('#agency-options .form-check').forEach(el => {
          const match = orgs.includes(el.dataset.org);
          el.style.display = match ? '' : 'none';
          if(!match){ el.querySelector('input').checked = false; }
        });
        filterDivisions();
      }
      function filterDivisions(){
        const ags = Array.from(document.querySelectorAll('.agency-filter:checked')).map(cb => cb.value);
        document.querySelectorAll('#division-options .form-check').forEach(el => {
          const match = ags.includes(el.dataset.agency);
          el.style.display = match ? '' : 'none';
          if(!match){ el.querySelector('input').checked = false; }
        });
      }
      document.querySelectorAll('.org-filter').forEach(cb => cb.addEventListener('change', filterAgencies));
      document.querySelectorAll('.agency-filter').forEach(cb => cb.addEventListener('change', filterDivisions));
      filterAgencies();
    })();
    </script>
  </div>
  <div class="tab-pane fade" id="notes" role="tabpanel">
    <?php if($id): ?>
      <?php
        $stmt = $pdo->prepare('SELECT * FROM module_contractors_notes WHERE contractor_id = :id ORDER BY date_created DESC');
        $stmt->execute([':id'=>$id]);
        $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <button class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addNoteModal"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></button>
      <table class="table table-sm table-striped align-middle">
        <thead>
          <tr>
            <th>Actions</th><th>ID</th><th>User ID</th><th>User Updated</th><th>Created</th><th>Updated</th><th>Memo</th><th>Contractor ID</th><th>Note Text</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($notes as $n): ?>
            <tr>
              <td>
                <button type="button" class="btn btn-warning btn-sm edit-note-btn" data-id="<?= h($n['id']); ?>" data-text="<?= h($n['note_text']); ?>"><span class="fa-solid fa-pen"></span><span class="visually-hidden">Edit</span></button>
                <form method="post" action="functions/delete_note.php" class="d-inline" onsubmit="return confirm('Delete note?');">
                  <input type="hidden" name="id" value="<?= h($n['id']); ?>">
                  <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                  <button class="btn btn-danger btn-sm"><span class="fa-solid fa-trash"></span><span class="visually-hidden">Delete</span></button>
                </form>
              </td>
              <td><?= h($n['id']); ?></td>
              <td><?= h($n['user_id']); ?></td>
              <td><?= h($n['user_updated']); ?></td>
              <td><?= h(format_display_date($n['date_created'])); ?></td>
              <td><?= h(format_display_date($n['date_updated'])); ?></td>
              <td><?= h($n['memo']); ?></td>
              <td><?= h($n['contractor_id']); ?></td>
              <td><?= h($n['note_text']); ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if(!$notes): ?><tr><td colspan="9" class="text-muted text-center">No notes found.</td></tr><?php endif; ?>
        </tbody>
      </table>
      <div class="modal fade" id="addNoteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post" action="functions/add_note.php">
              <div class="modal-header">
                <h5 class="modal-title">Add Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <textarea name="note_text" class="form-control" required></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="editNoteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post" action="functions/update_note.php">
              <div class="modal-header">
                <h5 class="modal-title">Edit Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id" id="edit_note_id">
                <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <textarea name="note_text" id="edit_note_text" class="form-control" required></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <script>
      document.querySelectorAll('.edit-note-btn').forEach(btn => {
        btn.addEventListener('click', function(){
          document.getElementById('edit_note_id').value = this.dataset.id;
          document.getElementById('edit_note_text').value = this.dataset.text || '';
          var modal = new bootstrap.Modal(document.getElementById('editNoteModal'));
          modal.show();
        });
      });
      </script>
    <?php else: ?>
      <p class="text-muted">Save contractor to add notes.</p>
    <?php endif; ?>
  </div>
  <div class="tab-pane fade" id="contacts" role="tabpanel">
    <?php if($id): ?>
      <?php
        $stmt = $pdo->prepare('SELECT mcc.*, l.label AS contact_type, COALESCE(la.attr_value, "secondary") AS contact_color FROM module_contractors_contacts mcc LEFT JOIN lookup_list_items l ON mcc.contact_type_id = l.id LEFT JOIN lookup_list_item_attributes la ON l.id = la.item_id AND la.attr_code = "COLOR-CLASS" WHERE mcc.contractor_id = :id ORDER BY mcc.date_created DESC');
        $stmt->execute([':id'=>$id]);
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <button class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addContactModal"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></button>
      <table class="table table-sm table-striped align-middle">
        <thead>
          <tr>
            <th>Actions</th><th>ID</th><th>User ID</th><th>User Updated</th><th>Created</th><th>Updated</th><th>Memo</th><th>Contractor ID</th><th>Type</th><th>Date</th><th>Summary</th><th>Duration</th><th>Result</th><th>Related Module</th><th>Related ID</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($contacts as $c): ?>
          <?php
            $stmtR = $pdo->prepare('SELECT r.*, l.label AS response_type, COALESCE(la.attr_value, "secondary") AS response_color, CONCAT(p.first_name, " ", p.last_name) AS assigned_name FROM module_contractors_contact_responses r LEFT JOIN lookup_list_items l ON r.response_type_id = l.id LEFT JOIN lookup_list_item_attributes la ON l.id = la.item_id AND la.attr_code = "COLOR-CLASS" LEFT JOIN users u ON r.assigned_user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE r.contact_id = :cid ORDER BY r.date_created DESC');
            $stmtR->execute([':cid'=>$c['id']]);
            $responses = $stmtR->fetchAll(PDO::FETCH_ASSOC);
          ?>
          <tr>
            <td>
              <button type="button" class="btn btn-info btn-sm add-response-btn" data-contact="<?= h($c['id']); ?>"><span class="fa-solid fa-reply"></span><span class="visually-hidden">Add Response</span></button>
              <button type="button" class="btn btn-warning btn-sm edit-contact-btn"
                data-id="<?= h($c['id']); ?>"
                data-type="<?= h($c['contact_type_id']); ?>"
                data-date="<?= h($c['contact_date']); ?>"
                data-duration="<?= h($c['contact_duration']); ?>"
                data-result="<?= h($c['contact_result']); ?>"
                data-module="<?= h($c['related_module']); ?>"
                data-rid="<?= h($c['related_id']); ?>"
                data-summary="<?= h($c['summary']); ?>"><span class="fa-solid fa-pen"></span><span class="visually-hidden">Edit</span></button>
              <form method="post" action="functions/delete_contact.php" class="d-inline" onsubmit="return confirm('Delete contact?');">
                <input type="hidden" name="id" value="<?= h($c['id']); ?>">
                <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-danger btn-sm"><span class="fa-solid fa-trash"></span><span class="visually-hidden">Delete</span></button>
              </form>
            </td>
            <td><?= h($c['id']); ?></td>
            <td><?= h($c['user_id']); ?></td>
            <td><?= h($c['user_updated']); ?></td>
            <td><?= h(format_display_date($c['date_created'])); ?></td>
            <td><?= h(format_display_date($c['date_updated'])); ?></td>
            <td><?= h($c['memo']); ?></td>
            <td><?= h($c['contractor_id']); ?></td>
            <td><?php if($c['contact_type']): ?><span class="badge badge-phoenix-<?= h($c['contact_color']); ?>"><?= h($c['contact_type']); ?></span><?php endif; ?></td>
            <td><?= h(format_display_date($c['contact_date'])); ?></td>
            <td><?= h($c['summary']); ?></td>
            <td><?= h($c['contact_duration']); ?></td>
            <td><?= h($c['contact_result']); ?></td>
            <td><?= h($c['related_module']); ?></td>
            <td><?= h($c['related_id']); ?></td>
          </tr>
          <tr class="table-light">
            <td colspan="15">
              <table class="table table-sm mb-0">
                <thead>
                  <tr>
                    <th>Actions</th><th>Type</th><th>Urgent</th><th>Deadline</th><th>Response</th><th>Assigned To</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($responses as $r): ?>
                  <tr>
                    <td>
                      <button type="button" class="btn btn-warning btn-sm edit-response-btn"
                        data-id="<?= h($r['id']); ?>"
                        data-contact="<?= h($c['id']); ?>"
                        data-type="<?= h($r['response_type_id']); ?>"
                        data-urgent="<?= h($r['is_urgent']); ?>"
                        data-deadline="<?= h($r['deadline']); ?>"
                        data-text="<?= h($r['response_text']); ?>"
                        data-assigned="<?= h($r['assigned_user_id']); ?>"
                        data-completed="<?= h($r['completed_date']); ?>">
                        <span class="fa-solid fa-pen"></span><span class="visually-hidden">Edit</span>
                      </button>
                      <form method="post" action="functions/delete_contact_response.php" class="d-inline" onsubmit="return confirm('Delete response?');">
                        <input type="hidden" name="id" value="<?= h($r['id']); ?>">
                        <input type="hidden" name="contact_id" value="<?= h($c['id']); ?>">
                        <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                        <button class="btn btn-danger btn-sm"><span class="fa-solid fa-trash"></span><span class="visually-hidden">Delete</span></button>
                      </form>
                    </td>
                    <td><?php if($r['response_type']): ?><span class="badge badge-phoenix-<?= h($r['response_color']); ?>"><?= h($r['response_type']); ?></span><?php endif; ?></td>
                    <td><?= $r['is_urgent'] ? '<span class="fa-solid fa-circle-exclamation text-danger"></span>' : ''; ?></td>
                    <td><?= h(format_display_date($r['deadline'])); ?></td>
                    <td><?= h($r['response_text']); ?></td>
                    <td><?= h($r['assigned_name']); ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php if(!$responses): ?><tr><td colspan="6" class="text-muted text-center">No responses.</td></tr><?php endif; ?>
                </tbody>
              </table>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if(!$contacts): ?><tr><td colspan="15" class="text-muted text-center">No contacts found.</td></tr><?php endif; ?>
        </tbody>
      </table>
      <div class="modal fade" id="addContactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="post" action="functions/add_contact.php">
              <div class="modal-header">
                <h5 class="modal-title">Add Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <div class="row g-2">
                  <div class="col-md-4">
                    <select name="contact_type_id" class="form-select" required>
                      <option value="">Type</option>
                      <?php foreach($contactTypes as $ct): ?>
                        <option value="<?= h($ct['id']); ?>"><?= h($ct['label']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <input type="datetime-local" name="contact_date" class="form-control">
                  </div>
                  <div class="col-md-4">
                    <input type="number" name="contact_duration" class="form-control" placeholder="Duration (min)">
                  </div>
                  <div class="col-md-4 mt-2">
                    <input type="text" name="contact_result" class="form-control" placeholder="Result">
                  </div>
                  <div class="col-md-4 mt-2">
                    <input type="text" name="related_module" class="form-control" placeholder="Related Module">
                  </div>
                  <div class="col-md-4 mt-2">
                    <input type="number" name="related_id" class="form-control" placeholder="Related ID">
                  </div>
                  <div class="col-12 mt-2">
                    <textarea name="summary" class="form-control" placeholder="Summary" required></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="editContactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="post" action="functions/update_contact.php">
              <div class="modal-header">
                <h5 class="modal-title">Edit Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id" id="edit_contact_id">
                <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <div class="row g-2">
                  <div class="col-md-4">
                    <select name="contact_type_id" id="edit_contact_type" class="form-select" required>
                      <option value="">Type</option>
                      <?php foreach($contactTypes as $ct): ?>
                        <option value="<?= h($ct['id']); ?>"><?= h($ct['label']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <input type="datetime-local" name="contact_date" id="edit_contact_date" class="form-control">
                  </div>
                  <div class="col-md-4">
                    <input type="number" name="contact_duration" id="edit_contact_duration" class="form-control" placeholder="Duration (min)">
                  </div>
                  <div class="col-md-4 mt-2">
                    <input type="text" name="contact_result" id="edit_contact_result" class="form-control" placeholder="Result">
                  </div>
                  <div class="col-md-4 mt-2">
                    <input type="text" name="related_module" id="edit_related_module" class="form-control" placeholder="Related Module">
                  </div>
                  <div class="col-md-4 mt-2">
                    <input type="number" name="related_id" id="edit_related_id" class="form-control" placeholder="Related ID">
                  </div>
                  <div class="col-12 mt-2">
                    <textarea name="summary" id="edit_contact_summary" class="form-control" placeholder="Summary" required></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="addResponseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post" action="functions/add_contact_response.php">
              <div class="modal-header">
                <h5 class="modal-title">Add Response</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="contact_id" id="add_response_contact_id">
                <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <div class="mb-2">
                  <select name="response_type_id" class="form-select" required>
                    <option value="">Type</option>
                    <?php foreach($responseTypes as $rt): ?>
                      <option value="<?= h($rt['id']); ?>" <?= $rt['id']==$defaultResponseTypeId ? 'selected' : ''; ?>><?= h($rt['label']); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="is_urgent" id="add_response_urgent" value="1">
                  <label class="form-check-label" for="add_response_urgent">Urgent</label>
                </div>
                <div class="mb-2"><input type="datetime-local" name="deadline" class="form-control" placeholder="Deadline"></div>
                <div class="mb-2"><textarea name="response_text" class="form-control" placeholder="Response" required></textarea></div>
                <div class="mb-2">
                  <select name="assigned_user_id" class="form-select">
                    <option value="">Assign to</option>
                    <?php foreach($allUsers as $u): ?>
                      <option value="<?= h($u['id']); ?>"><?= h($u['full_name']); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="editResponseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post" action="functions/update_contact_response.php">
              <div class="modal-header">
                <h5 class="modal-title">Edit Response</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id" id="edit_response_id">
                <input type="hidden" name="contact_id" id="edit_response_contact_id">
                <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <div class="mb-2">
                  <select name="response_type_id" id="edit_response_type" class="form-select" required>
                    <option value="">Type</option>
                    <?php foreach($responseTypes as $rt): ?>
                      <option value="<?= h($rt['id']); ?>"><?= h($rt['label']); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="is_urgent" id="edit_response_urgent" value="1">
                  <label class="form-check-label" for="edit_response_urgent">Urgent</label>
                </div>
                <div class="mb-2"><input type="datetime-local" name="deadline" id="edit_response_deadline" class="form-control" placeholder="Deadline"></div>
                <div class="mb-2"><textarea name="response_text" id="edit_response_text" class="form-control" placeholder="Response" required></textarea></div>
                <div class="mb-2">
                  <select name="assigned_user_id" id="edit_assigned_user" class="form-select">
                    <option value="">Assign to</option>
                    <?php foreach($allUsers as $u): ?>
                      <option value="<?= h($u['id']); ?>"><?= h($u['full_name']); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="mb-2"><input type="datetime-local" name="completed_date" id="edit_completed_date" class="form-control" placeholder="Completed"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <script>
      document.querySelectorAll('.edit-contact-btn').forEach(btn => {
        btn.addEventListener('click', function(){
          document.getElementById('edit_contact_id').value = this.dataset.id;
          document.getElementById('edit_contact_type').value = this.dataset.type || '';
          document.getElementById('edit_contact_date').value = this.dataset.date ? this.dataset.date.replace(' ', 'T') : '';
          document.getElementById('edit_contact_duration').value = this.dataset.duration || '';
          document.getElementById('edit_contact_result').value = this.dataset.result || '';
          document.getElementById('edit_related_module').value = this.dataset.module || '';
          document.getElementById('edit_related_id').value = this.dataset.rid || '';
          document.getElementById('edit_contact_summary').value = this.dataset.summary || '';
          var modal = new bootstrap.Modal(document.getElementById('editContactModal'));
          modal.show();
        });
      });
      document.querySelectorAll('.add-response-btn').forEach(btn => {
        btn.addEventListener('click', function(){
          document.getElementById('add_response_contact_id').value = this.dataset.contact;
          var modal = new bootstrap.Modal(document.getElementById('addResponseModal'));
          modal.show();
        });
      });
      document.querySelectorAll('.edit-response-btn').forEach(btn => {
        btn.addEventListener('click', function(){
          document.getElementById('edit_response_id').value = this.dataset.id;
          document.getElementById('edit_response_contact_id').value = this.dataset.contact;
          document.getElementById('edit_response_type').value = this.dataset.type || '';
          document.getElementById('edit_response_urgent').checked = this.dataset.urgent == '1';
          document.getElementById('edit_response_deadline').value = this.dataset.deadline ? this.dataset.deadline.replace(' ', 'T') : '';
          document.getElementById('edit_response_text').value = this.dataset.text || '';
          document.getElementById('edit_assigned_user').value = this.dataset.assigned || '';
          document.getElementById('edit_completed_date').value = this.dataset.completed ? this.dataset.completed.replace(' ', 'T') : '';
          var modal = new bootstrap.Modal(document.getElementById('editResponseModal'));
          modal.show();
        });
      });
      </script>
    <?php else: ?>
      <p class="text-muted">Save contractor to add contacts.</p>
    <?php endif; ?>
  </div>
  <div class="tab-pane fade" id="compensation" role="tabpanel">
    <?php if($id): ?>
      <?php
        $stmt = $pdo->prepare('SELECT mcc.*, t.label AS type_label, COALESCE(ta.attr_value, "secondary") AS type_color, pm.label AS payment_method_label, COALESCE(pma.attr_value, "secondary") AS payment_color, CONCAT(p.first_name, " ", p.last_name) AS created_by_name, f.file_path, f.file_name FROM module_contractors_compensation mcc LEFT JOIN lookup_list_items t ON mcc.compensation_type_id = t.id LEFT JOIN lookup_list_item_attributes ta ON t.id = ta.item_id AND ta.attr_code = "COLOR-CLASS" LEFT JOIN lookup_list_items pm ON mcc.payment_method_id = pm.id LEFT JOIN lookup_list_item_attributes pma ON pm.id = pma.item_id AND pma.attr_code = "COLOR-CLASS" LEFT JOIN module_contractors_files f ON mcc.file_id = f.id LEFT JOIN users u ON mcc.user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE mcc.contractor_id = :id ORDER BY mcc.date_created DESC');
        $stmt->execute([':id'=>$id]);
        $comps = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <button class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addCompModal"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></button>
      <div class="modal fade" id="addCompModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="post" action="functions/add_compensation.php" enctype="multipart/form-data">
              <div class="modal-header">
                <h5 class="modal-title">Add Compensation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
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
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <table class="table table-sm table-striped align-middle">
        <thead>
          <tr>
            <th>Actions</th><th>ID</th><th>User ID</th><th>User Updated</th><th>Created</th><th>Updated</th><th>Memo</th><th>Contractor ID</th><th>Title</th><th>Pay Date</th><th>Invoice #</th><th>File ID</th><th>File</th><th>Type</th><th>Payment Method</th><th>Amount</th><th>Effective Start</th><th>Effective End</th><th>Notes</th>
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
                  data-file-id="<?= h($cp['file_id']); ?>"><span class="fa-solid fa-pen"></span><span class="visually-hidden">Edit</span></button>
                <form method="post" action="functions/delete_compensation.php" class="d-inline" onsubmit="return confirm('Delete compensation?');">
                  <input type="hidden" name="id" value="<?= h($cp['id']); ?>">
                  <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                  <button class="btn btn-danger btn-sm"><span class="fa-solid fa-trash"></span><span class="visually-hidden">Delete</span></button>
                </form>
              </td>
              <td><?= h($cp['id']); ?></td>
              <td><?= h($cp['user_id']); ?></td>
              <td><?= h($cp['user_updated']); ?></td>
              <td><?= h(format_display_date($cp['date_created'])); ?></td>
              <td><?= h(format_display_date($cp['date_updated'])); ?></td>
              <td><?= h($cp['memo']); ?></td>
              <td><?= h($cp['contractor_id']); ?></td>
              <td><?= h($cp['title']); ?></td>
              <td><?= h(format_display_date($cp['pay_date'])); ?></td>
              <td><?= h($cp['invoice_number']); ?></td>
              <td><?= h($cp['file_id']); ?></td>
              <td>
                <?php if($cp['file_path']): ?>
                  <a class="btn btn-outline-secondary btn-sm" href="<?= h($cp['file_path']); ?>" download>Download</a>
                <?php else: ?>
                  —
                <?php endif; ?>
              </td>
              <td><?php if($cp['type_label']): ?><span class="badge badge-phoenix-<?= h($cp['type_color']); ?>"><?= h($cp['type_label']); ?></span><?php endif; ?></td>
              <td><?php if($cp['payment_method_label']): ?><span class="badge badge-phoenix-<?= h($cp['payment_color']); ?>"><?= h($cp['payment_method_label']); ?></span><?php endif; ?></td>
              <td><?= h($cp['amount']); ?></td>
              <td><?= h(format_display_date($cp['effective_start'])); ?></td>
              <td><?= h(format_display_date($cp['effective_end'])); ?></td>
              <td><?= h($cp['notes']); ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if(!$comps): ?>
            <tr><td colspan="19" class="text-center text-muted">No compensation found.</td></tr>
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
                <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
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
        $stmt = $pdo->prepare('SELECT mcf.*, l.label AS file_type, COALESCE(la.attr_value, "secondary") AS file_color FROM module_contractors_files mcf LEFT JOIN lookup_list_items l ON mcf.file_type_id = l.id LEFT JOIN lookup_list_item_attributes la ON l.id = la.item_id AND la.attr_code = "COLOR-CLASS" WHERE mcf.contractor_id = :id ORDER BY mcf.date_created DESC');
        $stmt->execute([':id'=>$id]);
        $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <button class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addFileModal"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></button>
      <table class="table table-sm table-striped align-middle">
        <thead>
          <tr>
            <th>Actions</th><th>ID</th><th>User ID</th><th>User Updated</th><th>Created</th><th>Updated</th><th>Memo</th><th>Contractor ID</th><th>Type</th><th>File Name</th><th>File Path</th><th>Version</th><th>Description</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($files as $f): ?>
            <tr>
              <td>
                <a class="btn btn-outline-secondary btn-sm" href="<?= h($f['file_path']); ?>" download>Download</a>
                <button type="button" class="btn btn-warning btn-sm edit-file-btn" data-id="<?= h($f['id']); ?>" data-type="<?= h($f['file_type_id']); ?>" data-desc="<?= h($f['description']); ?>"><span class="fa-solid fa-pen"></span><span class="visually-hidden">Edit</span></button>
                <form method="post" action="functions/delete_file.php" class="d-inline" onsubmit="return confirm('Delete file?');">
                  <input type="hidden" name="id" value="<?= h($f['id']); ?>">
                  <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                  <button class="btn btn-danger btn-sm"><span class="fa-solid fa-trash"></span><span class="visually-hidden">Delete</span></button>
                </form>
              </td>
              <td><?= h($f['id']); ?></td>
              <td><?= h($f['user_id']); ?></td>
              <td><?= h($f['user_updated']); ?></td>
              <td><?= h(format_display_date($f['date_created'])); ?></td>
              <td><?= h(format_display_date($f['date_updated'])); ?></td>
              <td><?= h($f['memo']); ?></td>
              <td><?= h($f['contractor_id']); ?></td>
              <td><?php if($f['file_type']): ?><span class="badge badge-phoenix-<?= h($f['file_color']); ?>"><?= h($f['file_type']); ?></span><?php endif; ?></td>
              <td><?= h($f['file_name']); ?></td>
              <td><?= h($f['file_path']); ?></td>
              <td><?= h($f['version']); ?></td>
              <td><?= h($f['description']); ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if(!$files): ?><tr><td colspan="13" class="text-muted text-center">No files found.</td></tr><?php endif; ?>
        </tbody>
      </table>
      <div class="modal fade" id="addFileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post" action="functions/upload_file.php" enctype="multipart/form-data">
              <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
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
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="editFileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post" action="functions/update_file.php" enctype="multipart/form-data">
              <div class="modal-header">
                <h5 class="modal-title">Edit File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id" id="edit_file_id">
                <input type="hidden" name="contractor_id" value="<?= $id; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <select name="file_type_id" id="edit_file_type" class="form-select mb-2" required>
                  <option value="">File Type</option>
                  <?php foreach($fileTypes as $ft): ?>
                    <option value="<?= h($ft['id']); ?>"><?= h($ft['label']); ?></option>
                  <?php endforeach; ?>
                </select>
                <input type="text" name="description" id="edit_file_desc" class="form-control mb-2" placeholder="Description">
                <input type="file" name="file" class="form-control mb-2">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-atlis" type="submit"><span class="fa-solid fa-floppy-disk"></span><span class="visually-hidden">Save</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <script>
      document.querySelectorAll('.edit-file-btn').forEach(btn => {
        btn.addEventListener('click', function(){
          document.getElementById('edit_file_id').value = this.dataset.id;
          document.getElementById('edit_file_type').value = this.dataset.type || '';
          document.getElementById('edit_file_desc').value = this.dataset.desc || '';
          var modal = new bootstrap.Modal(document.getElementById('editFileModal'));
          modal.show();
        });
      });
      </script>
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
