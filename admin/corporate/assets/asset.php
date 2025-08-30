<?php
require '../../admin_header.php';
require_permission('assets','read');

function get_asset_tags(PDO $pdo, int $asset_id): array {
  $stmt = $pdo->prepare('SELECT tag FROM module_asset_tags WHERE asset_id=:id');
  $stmt->execute([':id'=>$asset_id]);
  return array_column($stmt->fetchAll(PDO::FETCH_ASSOC),'tag');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;
$token = generate_csrf_token();

$asset = null;
if ($editing) {
  $stmt = $pdo->prepare('SELECT * FROM module_assets WHERE id=:id');
  $stmt->execute([':id'=>$id]);
  $asset = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$asset) {
    $_SESSION['error_message'] = 'Asset not found';
    header('Location: index.php');
    exit;
  }
}

$types = get_lookup_items($pdo,'ASSET_TYPE');
$statuses = get_lookup_items($pdo,'ASSET_STATUS');
$conditions = get_lookup_items($pdo,'ASSET_CONDITION');
$contractors = $pdo->query("SELECT mc.id, CONCAT(p.first_name,' ',p.last_name) AS name FROM module_contractors mc LEFT JOIN person p ON mc.person_id=p.id ORDER BY p.last_name,p.first_name")->fetchAll(PDO::FETCH_ASSOC);
$tags = $editing ? get_asset_tags($pdo,$id) : [];

$policy_stmt = $pdo->query("SELECT id,version FROM module_asset_policies WHERE active=1 AND effective_date<=CURDATE() ORDER BY effective_date DESC LIMIT 1");
$active_policy = $policy_stmt->fetch(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4"><?= $editing ? 'Edit' : 'Add'; ?> Asset</h2>
<?php if($active_policy): ?>
<div class="mb-2">
  <strong>Current Policy:</strong> <?= e($active_policy['version']); ?>
  <?php if(user_has_permission('asset_policies','update')): ?>
  <a class="ms-2" href="policy.php">Manage Policies</a>
  <?php endif; ?>
</div>
<?php endif; ?>
<?= flash_message($_SESSION['message'] ?? '', 'success'); ?>
<?= flash_message($_SESSION['error_message'] ?? '', 'danger'); ?>
<?php unset($_SESSION['message'], $_SESSION['error_message']); ?>
<form method="post" action="functions/<?= $editing?'update':'create'; ?>.php" enctype="multipart/form-data" id="assetForm">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <?php if ($editing): ?><input type="hidden" name="id" value="<?= $id; ?>"><?php endif; ?>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Type</label>
      <select name="type_id" class="form-select" data-choices data-options='{"removeItemButton":true}'>
        <option value="">--</option>
        <?php foreach($types as $t): ?>
        <option value="<?= $t['id']; ?>" <?= $asset && $asset['type_id']==$t['id']?'selected':''; ?>><?= e($t['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Status</label>
      <select name="status_id" class="form-select" data-choices>
        <option value="">--</option>
        <?php foreach($statuses as $s): ?>
        <option value="<?= $s['id']; ?>" <?= $asset && $asset['status_id']==$s['id']?'selected':''; ?>><?= e($s['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" value="<?= e($asset['name'] ?? ''); ?>">
    </div>
    <div class="col">
      <label class="form-label">Vendor</label>
      <input type="text" name="vendor" class="form-control" value="<?= e($asset['vendor'] ?? ''); ?>">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Model</label>
      <input type="text" name="model" class="form-control" value="<?= e($asset['model'] ?? ''); ?>">
    </div>
    <div class="col">
      <label class="form-label">Serial</label>
      <input type="text" name="serial" class="form-control" value="<?= e($asset['serial'] ?? ''); ?>">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Purchase Date</label>
      <input type="text" name="purchase_date" class="form-control" data-flatpickr value="<?= e($asset['purchase_date'] ?? ''); ?>">
    </div>
    <div class="col">
      <label class="form-label">Warranty Expiration</label>
      <input type="text" name="warranty_expiration" class="form-control" data-flatpickr value="<?= e($asset['warranty_expiration'] ?? ''); ?>">
    </div>
    <div class="col">
      <label class="form-label">Purchase Price</label>
      <input type="number" step="0.01" name="purchase_price" class="form-control" value="<?= e($asset['purchase_price'] ?? ''); ?>">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Condition</label>
      <select name="condition_id" class="form-select" data-choices>
        <option value="">--</option>
        <?php foreach($conditions as $c): ?>
        <option value="<?= $c['id']; ?>" <?= $asset && $asset['condition_id']==$c['id']?'selected':''; ?>><?= e($c['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Location</label>
      <input type="text" name="location" class="form-control" value="<?= e($asset['location'] ?? ''); ?>">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <div class="form-check mt-4">
        <input class="form-check-input" type="checkbox" name="is_encrypted" value="1" <?= $asset && $asset['is_encrypted'] ? 'checked' : ''; ?>>
        <label class="form-check-label">Encrypted</label>
      </div>
    </div>
    <div class="col">
      <div class="form-check mt-4">
        <input class="form-check-input" type="checkbox" name="is_mdm_enrolled" value="1" <?= $asset && $asset['is_mdm_enrolled'] ? 'checked' : ''; ?>>
        <label class="form-check-label">MDM Enrolled</label>
      </div>
    </div>
    <div class="col">
      <label class="form-label">Last Patch Date</label>
      <input type="text" name="last_patch_date" class="form-control" data-flatpickr value="<?= e($asset['last_patch_date'] ?? ''); ?>">
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Compliance Flags</label><br>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="compliance[]" value="gdpr" <?php if($asset && str_contains($asset['compliance_flags'],'gdpr')) echo 'checked'; ?>>
      <label class="form-check-label">GDPR</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="compliance[]" value="hipaa" <?php if($asset && str_contains($asset['compliance_flags'],'hipaa')) echo 'checked'; ?>>
      <label class="form-check-label">HIPAA</label>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Tags</label>
    <select name="tags[]" class="form-select" data-choices data-options='{"removeItemButton":true}' multiple>
      <?php foreach($tags as $tag): ?>
      <option value="<?= e($tag); ?>" selected><?= e($tag); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Attachments</label>
    <div class="dropzone" id="asset-dropzone"></div>
    <ul id="asset-files" class="list-unstyled mt-2"></ul>
  </div>
  <?php if ($editing && $asset['asset_tag']): ?>
  <div class="mb-3">
    <label class="form-label">QR Code</label><br>
    <iframe src="functions/label.php?id=<?= $id; ?>" style="border:0;width:200px;height:100px"></iframe>
  </div>
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Memo</label>
    <textarea name="memo" class="form-control" rows="3"><?= e($asset['memo'] ?? ''); ?></textarea>
  </div>
  <button class="btn btn-primary" type="submit">Save</button>
  <?php if($editing): ?>
  <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#assignModal">Assign</button>
  <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#returnModal">Return</button>
  <?php endif; ?>
</form>

<?php if($editing): ?>
<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="functions/assign.php">
      <input type="hidden" name="csrf_token" value="<?= $token; ?>">
      <input type="hidden" name="asset_id" value="<?= $id; ?>">
      <div class="modal-header">
        <h5 class="modal-title">Assign Asset</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Contractor</label>
          <select name="contractor_id" class="form-select" required>
            <option value="">--</option>
            <?php foreach($contractors as $c): ?>
            <option value="<?= $c['id']; ?>"><?= e($c['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Due Date</label>
          <input type="text" name="due_date" class="form-control" data-flatpickr>
        </div>
        <div class="mb-3">
          <label class="form-label">Condition Out</label>
          <select name="condition_out_id" class="form-select">
            <option value="">--</option>
            <?php foreach($conditions as $c): ?>
            <option value="<?= $c['id']; ?>"><?= e($c['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div id="policySection" class="mb-3 d-none">
          <input type="hidden" name="policy_id" id="policyId">
          <div class="border p-2 mb-2" id="policyText" style="max-height:200px;overflow:auto"></div>
          <label class="form-label">Signature</label>
          <canvas id="policyCanvas" class="border w-100" height="200"></canvas>
          <input type="hidden" name="signature_data" id="signatureData">
          <button type="button" class="btn btn-sm btn-secondary mt-2" id="clearSig">Clear</button>
        </div>
        <div class="mb-3">
          <label class="form-label">Notes</label>
          <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Assign</button>
      </div>
    </form>
  </div>
</div>

<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="functions/return.php">
      <input type="hidden" name="csrf_token" value="<?= $token; ?>">
      <input type="hidden" name="asset_id" value="<?= $id; ?>">
      <div class="modal-header">
        <h5 class="modal-title">Return Asset</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Condition In</label>
          <select name="condition_in_id" class="form-select">
            <option value="">--</option>
            <?php foreach($conditions as $c): ?>
            <option value="<?= $c['id']; ?>"><?= e($c['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Notes</label>
          <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Return</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<?php if($editing): ?>
<?php
$assign_stmt = $pdo->prepare('SELECT aa.*, ap.version, CONCAT(p.first_name," ",p.last_name) AS contractor FROM module_asset_assignments aa LEFT JOIN module_asset_policies ap ON aa.policy_id=ap.id LEFT JOIN module_contractors mc ON aa.contractor_id=mc.id LEFT JOIN person p ON mc.person_id=p.id WHERE aa.asset_id=:id ORDER BY aa.assigned_date DESC');
$assign_stmt->execute([':id'=>$id]);
$assignments = $assign_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php if($assignments): ?>
<h3>Assignment History</h3>
<div class="table-responsive mb-4">
  <table class="table table-sm">
    <thead><tr><th>Contractor</th><th>Assigned</th><th>Returned</th><th>Policy</th><th>Agreement</th></tr></thead>
    <tbody>
      <?php foreach($assignments as $a): ?>
      <tr>
        <td><?= e($a['contractor']); ?></td>
        <td><?= e($a['assigned_date']); ?></td>
        <td><?= e($a['returned_date']); ?></td>
        <td><?= e($a['version']); ?></td>
        <td><?php if($a['agreement_file']): ?><a href="<?= e($a['agreement_file']); ?>" target="_blank">View Agreement</a><?php endif; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>
<hr>
<h3>History</h3>
<?php
$events = $pdo->prepare('SELECT * FROM module_asset_events WHERE asset_id=:id ORDER BY date_created DESC');
$events->execute([':id'=>$id]);
foreach ($events->fetchAll(PDO::FETCH_ASSOC) as $ev) {
  echo '<div class="border rounded p-2 mb-2"><strong>'.e($ev['event_type']).'</strong> '.e($ev['memo']).' <span class="text-muted small">'.e($ev['date_created'])."</span></div>";
}
?>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.1.5/signature_pad.umd.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-flatpickr]').forEach(el => flatpickr(el, {}));
    document.querySelectorAll('[data-choices]').forEach(el => new Choices(el));
    Dropzone.autoDiscover = false;
    const loadFiles = () => {
      fetch('functions/list_files.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ asset_id: '<?= $id; ?>', csrf_token: '<?= $token; ?>' })
      }).then(r => r.json()).then(files => {
        const list = document.getElementById('asset-files');
        if (!list) return;
        list.innerHTML = '';
        files.forEach(f => {
          const li = document.createElement('li');
          const link = document.createElement('a');
          link.href = '../../assets/uploads/<?= $id; ?>/' + encodeURIComponent(f.file_path);
          link.textContent = f.file_path;
          li.appendChild(link);
          li.append(' ');
          const btn = document.createElement('button');
          btn.className = 'btn btn-sm btn-danger';
          btn.textContent = 'Delete';
          btn.addEventListener('click', () => {
            fetch('functions/delete_file.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: new URLSearchParams({ id: f.id, csrf_token: '<?= $token; ?>' })
            }).then(() => loadFiles());
          });
          li.appendChild(btn);
          list.appendChild(li);
        });
      });
    };
    loadFiles();
    new Dropzone('#asset-dropzone', { url: 'functions/upload_file.php', params: { csrf_token: '<?= $token; ?>', asset_id: '<?= $id; ?>' }, success: loadFiles });

    const contractorSelect = document.querySelector('select[name="contractor_id"]');
    const policySection = document.getElementById('policySection');
    const policyText = document.getElementById('policyText');
    const policyIdInput = document.getElementById('policyId');
    const sigCanvas = document.getElementById('policyCanvas');
    const signatureData = document.getElementById('signatureData');
    const clearBtn = document.getElementById('clearSig');
    let sigPad;

    const checkPolicy = cid => {
      if(!cid){ policySection.classList.add('d-none'); policyIdInput.value=''; return; }
      fetch('functions/assign.php?contractor_id='+cid)
        .then(r=>r.json()).then(data => {
          if(data.policy && data.needs){
            policySection.classList.remove('d-none');
            policyText.innerHTML = data.policy.content;
            policyIdInput.value = data.policy.id;
            sigPad = new SignaturePad(sigCanvas);
            clearBtn.onclick = () => sigPad.clear();
          } else {
            policySection.classList.add('d-none');
            policyIdInput.value='';
            if(sigPad){sigPad.clear();}
          }
        });
    };

    contractorSelect && contractorSelect.addEventListener('change', e => checkPolicy(e.target.value));
    document.querySelector('#assignModal form').addEventListener('submit', e => {
      if(!policySection.classList.contains('d-none')){
        if(sigPad && sigPad.isEmpty()){ e.preventDefault(); alert('Signature required'); return; }
        signatureData.value = sigPad.toDataURL();
      }
    });
  });
</script>
<?php require '../../admin_footer.php'; ?>
