<?php
require '../admin_header.php';
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
$tags = $editing ? get_asset_tags($pdo,$id) : [];
?>
<h2 class="mb-4"><?= $editing ? 'Edit' : 'Add'; ?> Asset</h2>
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
  </div>
  <?php if ($editing && $asset['asset_tag']): ?>
  <div class="mb-3">
    <label class="form-label">QR Code</label><br>
    <img src="functions/label.php?id=<?= $id; ?>" alt="QR">
  </div>
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Memo</label>
    <textarea name="memo" class="form-control" rows="3"><?= e($asset['memo'] ?? ''); ?></textarea>
  </div>
  <button class="btn btn-primary" type="submit">Save</button>
</form>

<?php if($editing): ?>
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

<link rel="stylesheet" href="../vendors/dropzone/dropzone.css">
<link rel="stylesheet" href="../vendors/choices/choices.min.css">
<link rel="stylesheet" href="../vendors/flatpickr/flatpickr.min.css">
<script src="../vendors/dropzone/dropzone-min.js"></script>
<script src="../vendors/choices/choices.min.js"></script>
<script src="../vendors/flatpickr/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.1.5/signature_pad.umd.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-flatpickr]').forEach(el => flatpickr(el, {}));
    document.querySelectorAll('[data-choices]').forEach(el => new Choices(el));
    Dropzone.autoDiscover = false;
    new Dropzone('#asset-dropzone', { url: 'functions/upload_file.php', params: { csrf_token: '<?= $token; ?>', asset_id: '<?= $id; ?>' } });
  });
</script>
<?php require '../admin_footer.php'; ?>
