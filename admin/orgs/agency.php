<?php
require '../admin_header.php';
require_permission('orgs','read');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$organization_id = isset($_GET['organization_id']) ? (int)$_GET['organization_id'] : 0;
$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$customer_id = null;
if ($id) {
    require_permission('orgs','update');
    if (!$organization_id) {
        $stmt = $pdo->prepare('SELECT organization_id, customer_id FROM module_agency WHERE id = :id');
        $stmt->execute([':id'=>$id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $organization_id = (int)$row['organization_id'];
            $customer_id = (int)$row['customer_id'];
        }
    } else {
        $stmt = $pdo->prepare('SELECT customer_id FROM module_agency WHERE id = :id');
        $stmt->execute([':id'=>$id]);
        $customer_id = (int)$stmt->fetchColumn();
    }
} else {
    require_permission('orgs','create');
    if (!$organization_id) { die('Organization ID required'); }
}

$orgStmt = $pdo->prepare('SELECT c.name FROM module_organization o JOIN module_customer c ON o.customer_id = c.id WHERE o.id = :id');
$orgStmt->execute([':id'=>$organization_id]);
$organization = $orgStmt->fetch(PDO::FETCH_ASSOC);
if (!$organization) { die('Organization not found'); }

$name = '';
$main_person = null;
$status = null;
$message = '';
$btnClass = $id ? 'btn-warning' : 'btn-success';

if ($id && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $stmt = $pdo->prepare('SELECT c.name, c.main_person, c.status FROM module_agency a JOIN module_customer c ON a.customer_id = c.id WHERE a.id = :id');
    $stmt->execute([':id'=>$id]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $name = $row['name'];
        $main_person = $row['main_person'];
        $status = $row['status'];
    } else {
        die('Agency not found');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($token, $_POST['csrf_token'] ?? '')) { die('Invalid CSRF token'); }
    $name = trim($_POST['name'] ?? '');
    $main_person = $_POST['main_person'] !== '' ? (int)$_POST['main_person'] : null;
    $status = $_POST['status'] !== '' ? (int)$_POST['status'] : null;
    if ($id) {
        $stmt = $pdo->prepare('UPDATE module_customer SET name=:name, main_person=:main_person, status=:status, user_updated=:uid WHERE id=:cid');
        $stmt->execute([':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':uid'=>$this_user_id, ':cid'=>$customer_id]);
        admin_audit_log($pdo,$this_user_id,'module_customer',$customer_id,'UPDATE',null,json_encode(['name'=>$name,'main_person'=>$main_person,'status'=>$status]),'Updated customer');
        $stmt = $pdo->prepare('UPDATE module_agency SET user_updated=:uid WHERE id=:id');
        $stmt->execute([':uid'=>$this_user_id, ':id'=>$id]);
        admin_audit_log($pdo,$this_user_id,'module_agency',$id,'UPDATE',null,json_encode(['customer_id'=>$customer_id,'organization_id'=>$organization_id]),'Updated agency');
        $message = 'Agency updated.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO module_customer (user_id,user_updated,name,main_person,status) VALUES (:uid,:uid,:name,:main_person,:status)');
        $stmt->execute([':uid'=>$this_user_id, ':name'=>$name, ':main_person'=>$main_person, ':status'=>$status]);
        $customer_id = $pdo->lastInsertId();
        admin_audit_log($pdo,$this_user_id,'module_customer',$customer_id,'CREATE',null,json_encode(['name'=>$name,'main_person'=>$main_person,'status'=>$status]),'Created customer');

        $stmt = $pdo->prepare('INSERT INTO module_agency (user_id,user_updated,organization_id,customer_id) VALUES (:uid,:uid,:org,:cid)');
        $stmt->execute([':uid'=>$this_user_id, ':org'=>$organization_id, ':cid'=>$customer_id]);
        $id = $pdo->lastInsertId();
        admin_audit_log($pdo,$this_user_id,'module_agency',$id,'CREATE',null,json_encode(['organization_id'=>$organization_id,'customer_id'=>$customer_id]),'Created agency');
        header('Location: agency.php?id='.$id);
        exit;
    }
}

$statusStmt = $pdo->prepare("SELECT li.id, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'AGENCY_STATUS' ORDER BY li.sort_order, li.label");
$statusStmt->execute();
$statuses = $statusStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch divisions for display
$agencyDivisions = [];
if ($id) {
    $divStmt = $pdo->prepare('SELECT d.id, c.name FROM module_division d JOIN module_customer c ON d.customer_id = c.id WHERE d.agency_id = :id ORDER BY c.name');
    $divStmt->execute([':id'=>$id]);
    $agencyDivisions = $divStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<h2 class="mb-4"><?= $id ? 'Edit Agency' : 'Add Agency'; ?> for <?= htmlspecialchars($organization['name']); ?></h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<form method="post" class="mb-4">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <?php include __DIR__.'/forms/customer_fields.php'; ?>
  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Back</a>
</form>
<?php if ($id): ?>
  <h3 class="mb-3">Divisions</h3>
  <a href="division.php?agency_id=<?= $id; ?>" class="btn btn-sm btn-success mb-3">Add Division</a>
  <?php if ($agencyDivisions): ?>
    <ul class="list-unstyled">
      <?php foreach ($agencyDivisions as $d): ?>
        <li><a href="division.php?id=<?= $d['id']; ?>"><?= htmlspecialchars($d['name']); ?></a></li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-muted">No divisions yet.</p>
  <?php endif; ?>
<?php endif; ?>
<?php require '../admin_footer.php'; ?>
