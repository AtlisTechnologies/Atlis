<?php
require '../admin_header.php';
require_permission('products_services','read');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$item = null;
if($id){
  $stmt = $pdo->prepare('SELECT * FROM module_products_services WHERE id = :id');
  $stmt->execute([':id'=>$id]);
  $item = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$item){ $id = 0; }
}

$stmt = $pdo->query('SELECT p.id, CONCAT(p.first_name," ",p.last_name) AS name, GROUP_CONCAT(li.label ORDER BY li.label SEPARATOR ", ") AS skills FROM person p LEFT JOIN person_skills ps ON p.id = ps.person_id LEFT JOIN lookup_list_items li ON ps.skill_id = li.id GROUP BY p.id ORDER BY p.first_name, p.last_name');
$people = $stmt->fetchAll(PDO::FETCH_ASSOC);
$assigned = [];
if($id){
  $stmt = $pdo->prepare('SELECT person_id FROM module_products_services_person WHERE product_service_id = :id');
  $stmt->execute([':id'=>$id]);
  $assigned = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';
if(isset($_GET['msg']) && $_GET['msg']==='saved'){ $message='Record saved.'; }
?>
<nav class="mb-3" aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="index.php">Products &amp; Services</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $id ? 'Edit' : 'Add'; ?></li>
  </ol>
</nav>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Product/Service</h2>
<?php if($message): ?><div class="alert alert-success"><?= h($message); ?></div><?php endif; ?>
<form method="post" action="functions/save.php" class="row g-3">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <?php if($id): ?><input type="hidden" name="id" value="<?= $id; ?>"><?php endif; ?>
  <div class="col-12">
    <div class="form-floating">
      <input class="form-control" id="psName" type="text" name="name" placeholder="Name" value="<?= h($item['name'] ?? ''); ?>" required>
      <label for="psName">Name</label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating">
      <textarea class="form-control" id="psDesc" name="description" placeholder="Description" style="height:100px"><?= h($item['description'] ?? ''); ?></textarea>
      <label for="psDesc">Description</label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating form-floating-advance-select">
      <label for="personSelect">Assign People</label>
      <select class="form-select" id="personSelect" name="persons[]" multiple data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>
        <?php foreach($people as $p): ?>
          <option value="<?= $p['id']; ?>" <?= in_array($p['id'],$assigned) ? 'selected' : ''; ?>><?= h($p['name'] . ($p['skills'] ? ' - '.$p['skills'] : '')); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating">
      <textarea class="form-control" id="psMemo" name="memo" placeholder="Memo" style="height:100px"><?= h($item['memo'] ?? ''); ?></textarea>
      <label for="psMemo">Memo</label>
    </div>
  </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit">Save</button>
    <a class="btn btn-secondary" href="index.php">Cancel</a>
  </div>
</form>
<?php require '../admin_footer.php'; ?>
