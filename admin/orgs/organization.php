<?php
require '../admin_header.php';
require_permission('orgs','read');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$customer_id = null;
$name = '';
$main_person = null;
$status = null;
$message = '';
$btnClass = $id ? 'btn-warning' : 'btn-success';

if ($id) {
    require_permission('orgs','update');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $stmt = $pdo->prepare('SELECT o.customer_id, c.name, c.main_person, c.status FROM module_organization o JOIN module_customer c ON o.customer_id = c.id WHERE o.id = :id');
        $stmt->execute([':id'=>$id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $customer_id = $row['customer_id'];
            $name = $row['name'];
            $main_person = $row['main_person'];
            $status = $row['status'];
        } else {
            die('Organization not found');
        }
    }
} else {
    require_permission('orgs','create');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }
    $name = trim($_POST['name'] ?? '');
    $main_person = $_POST['main_person'] !== '' ? (int)$_POST['main_person'] : null;
    $status = $_POST['status'] !== '' ? (int)$_POST['status'] : null;
    if ($id) {
        $stmt = $pdo->prepare('UPDATE module_customer SET name=:name, main_person=:main_person, status=:status, user_updated=:uid WHERE id=:cid');
        $stmt->execute([':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':uid'=>$this_user_id, ':cid'=>$customer_id]);
        admin_audit_log($pdo,$this_user_id,'module_customer',$customer_id,'UPDATE',null,json_encode(['name'=>$name,'main_person'=>$main_person,'status'=>$status]),'Updated customer');
        $stmt = $pdo->prepare('UPDATE module_organization SET user_updated=:uid WHERE id=:id');
        $stmt->execute([':uid'=>$this_user_id, ':id'=>$id]);
        admin_audit_log($pdo,$this_user_id,'module_organization',$id,'UPDATE',null,json_encode(['customer_id'=>$customer_id]),'Linked organization to customer');
        $message = 'Organization updated.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO module_customer (user_id,user_updated,name,main_person,status) VALUES (:uid,:uid,:name,:main_person,:status)');
        $stmt->execute([':uid'=>$this_user_id, ':name'=>$name, ':main_person'=>$main_person, ':status'=>$status]);
        $customer_id = $pdo->lastInsertId();
        admin_audit_log($pdo,$this_user_id,'module_customer',$customer_id,'CREATE',null,json_encode(['name'=>$name,'main_person'=>$main_person,'status'=>$status]),'Created customer');

        $stmt = $pdo->prepare('INSERT INTO module_organization (user_id,user_updated,customer_id) VALUES (:uid,:uid,:cid)');
        $stmt->execute([':uid'=>$this_user_id, ':cid'=>$customer_id]);
        $id = $pdo->lastInsertId();
        admin_audit_log($pdo,$this_user_id,'module_organization',$id,'CREATE',null,json_encode(['customer_id'=>$customer_id]),'Created organization');
        header('Location: organization.php?id='.$id);
        exit;
    }
}

$statusStmt = $pdo->prepare("SELECT li.id, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'ORGANIZATION_STATUS' ORDER BY li.sort_order, li.label");
$statusStmt->execute();
$statuses = $statusStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch agencies for display when editing
$orgAgencies = [];
if ($id) {
    $agStmt = $pdo->prepare('SELECT a.id, c.name FROM module_agency a JOIN module_customer c ON a.customer_id = c.id WHERE a.organization_id = :id ORDER BY c.name');
    $agStmt->execute([':id'=>$id]);
    $orgAgencies = $agStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<h2 class="mb-4"><?= $id ? 'Edit Organization' : 'Add Organization'; ?></h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<form method="post" class="mb-4">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <?php include __DIR__.'/forms/customer_fields.php'; ?>
  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Back</a>
</form>
<?php if ($id): ?>
  <h3 class="mb-3">Agencies</h3>
  <a href="agency.php?organization_id=<?= $id; ?>" class="btn btn-sm btn-success mb-3">Add Agency</a>
  <?php if ($orgAgencies): ?>
    <ul class="list-unstyled">
      <?php foreach ($orgAgencies as $a): ?>
        <li><a href="agency.php?id=<?= $a['id']; ?>"><?= htmlspecialchars($a['name']); ?></a></li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-muted">No agencies yet.</p>
  <?php endif; ?>
<?php endif; ?>
<?php require '../admin_footer.php'; ?>
