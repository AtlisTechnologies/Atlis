<?php
require '../admin_header.php';
require_permission('person','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  require_permission('person','delete');
  $delId = (int)$_POST['delete_id'];
  $stmt = $pdo->prepare('DELETE FROM person WHERE id = :id');
  $stmt->execute([':id' => $delId]);
  admin_audit_log($pdo, $this_user_id, 'person', $delId, 'DELETE', null, null, 'Deleted person');
  $message = 'Person deleted.';
}

$addrStatusItems = get_lookup_items($pdo, 'PERSON_ADDRESS_STATUS');
$phoneStatusItems = get_lookup_items($pdo, 'PERSON_PHONE_STATUS');
$defaultAddrStatus = null; foreach ($addrStatusItems as $a) { if (!empty($a['is_default'])) { $defaultAddrStatus = $a['id']; break; } }
$defaultPhoneStatus = null; foreach ($phoneStatusItems as $a) { if (!empty($a['is_default'])) { $defaultPhoneStatus = $a['id']; break; } }
$stmt = $pdo->prepare('SELECT p.id, p.first_name, p.last_name, p.email,
                               o.name AS org_name, a.name AS agency_name, d.name AS division_name,
                               pp.phone_number, pa.address_line1, pa.city, s.code AS state_code, pa.postal_code
                        FROM person p
                        LEFT JOIN module_organization o ON p.organization_id = o.id
                        LEFT JOIN module_agency a ON p.agency_id = a.id
                        LEFT JOIN module_division d ON p.division_id = d.id
                        LEFT JOIN person_phones pp ON p.id = pp.person_id AND pp.status_id = :ph_status
                        LEFT JOIN person_addresses pa ON p.id = pa.person_id AND pa.status_id = :addr_status
                        LEFT JOIN lookup_list_items s ON pa.state_id = s.id
                        WHERE p.user_id IS NULL
                        ORDER BY p.last_name, p.first_name');
$stmt->execute([':ph_status'=>$defaultPhoneStatus, ':addr_status'=>$defaultAddrStatus]);
$persons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Persons</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<a href="edit.php" class="btn btn-sm btn-success mb-3">Add Person</a>
<div id="persons" data-list='{"valueNames":["name","email"],"page":20,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="row g-3 list">
    <?php foreach($persons as $p): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column justify-content-between">
            <div>
              <h5 class="name mb-1"><?= htmlspecialchars(trim(($p['first_name'] ?? '').' '.($p['last_name'] ?? ''))); ?></h5>
              <?php if($p['email']): ?>
                <p class="email text-muted small mb-1"><?= htmlspecialchars($p['email']); ?></p>
              <?php endif; ?>
              <?php if($p['org_name'] || $p['agency_name'] || $p['division_name']): ?>
                <p class="text-muted small mb-1">
                  <?= htmlspecialchars($p['org_name'] ?? ''); ?>
                  <?php if($p['agency_name']): ?>/ <?= htmlspecialchars($p['agency_name']); ?><?php endif; ?>
                  <?php if($p['division_name']): ?>/ <?= htmlspecialchars($p['division_name']); ?><?php endif; ?>
                </p>
              <?php endif; ?>
              <?php if($p['phone_number']): ?>
                <p class="text-muted small mb-1">📞 <?= htmlspecialchars($p['phone_number']); ?></p>
              <?php endif; ?>
              <?php if($p['address_line1']): ?>
                <p class="text-muted small mb-2">🏠 <?= htmlspecialchars($p['address_line1']); ?><?= $p['city'] ? ', '.htmlspecialchars($p['city']) : ''; ?><?= $p['state_code'] ? ' '.htmlspecialchars($p['state_code']) : ''; ?><?= $p['postal_code'] ? ' '.htmlspecialchars($p['postal_code']) : ''; ?></p>
              <?php endif; ?>
            </div>
            <div>
              <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $p['id']; ?>">Edit</a>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_id" value="<?= $p['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this person?');">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="d-flex justify-content-between align-items-center mt-3">
    <p class="mb-0" data-list-info></p>
    <ul class="pagination mb-0"></ul>
  </div>
</div>
<?php require '../admin_footer.php'; ?>
