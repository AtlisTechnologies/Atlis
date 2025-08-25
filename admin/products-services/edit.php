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

$types = get_lookup_items($pdo, 'PRODUCT_SERVICE_TYPE');
$statuses = get_lookup_items($pdo, 'PRODUCT_SERVICE_STATUS');

// Load people and their skills
$stmt = $pdo->query('SELECT p.id, CONCAT(p.first_name, " ", p.last_name) AS name FROM person p ORDER BY p.first_name, p.last_name');
$people = $stmt->fetchAll(PDO::FETCH_ASSOC);

$ps = $pdo->query('SELECT ps.person_id, ps.skill_id, li.label FROM person_skills ps JOIN lookup_list_items li ON ps.skill_id = li.id ORDER BY ps.person_id, li.label');
$personSkills = [];
while($row = $ps->fetch(PDO::FETCH_ASSOC)){
  $personSkills[$row['person_id']][] = ['skill_id'=>$row['skill_id'], 'label'=>$row['label']];
}
foreach($people as &$p){
  $labels = array_column($personSkills[$p['id']] ?? [], 'label');
  $p['skills'] = $labels ? implode(', ', $labels) : '';
}
unset($p);

$assigned = [];
if($id){
  $stmt = $pdo->prepare('SELECT person_id, skill_id FROM module_products_services_person WHERE product_service_id = :id');
  $stmt->execute([':id'=>$id]);
  $assigned = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
  <div class="col-md-6">
    <div class="form-floating">
      <select class="form-select" id="psType" name="type_id" required>
        <?php foreach($types as $t): ?>
          <option value="<?= $t['id']; ?>" <?= ($item['type_id'] ?? '') == $t['id'] ? 'selected' : ''; ?>><?= h($t['label']); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="psType">Type</label>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-floating">
      <select class="form-select" id="psStatus" name="status_id" required>
        <?php foreach($statuses as $s): ?>
          <option value="<?= $s['id']; ?>" <?= ($item['status_id'] ?? '') == $s['id'] ? 'selected' : ''; ?>><?= h($s['label']); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="psStatus">Status</label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating">
      <textarea class="form-control" id="psDesc" name="description" placeholder="Description" style="height:100px"><?= h($item['description'] ?? ''); ?></textarea>
      <label for="psDesc">Description</label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating">
      <input class="form-control" id="psPrice" type="number" step="0.01" min="0" name="price" placeholder="Price" value="<?= h($item['price'] ?? ''); ?>">
      <label for="psPrice">Price</label>
    </div>
  </div>
  <div class="col-12">
    <label class="form-label">Assign People</label>
    <div id="assignmentContainer"></div>
    <button class="btn btn-sm btn-secondary mt-2" type="button" id="addAssignment">Add Person</button>
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
<script>
const personSkills = <?= json_encode($personSkills); ?>;
const peopleOptions = `<?php foreach($people as $p){ echo '<option value="'.$p['id'].'">'.h($p['name'] . ($p['skills'] ? ' - '.$p['skills'] : '')).'</option>'; } ?>`;
const existingAssignments = <?= json_encode($assigned); ?>;
function createRow(data){
  const idx = document.querySelectorAll('#assignmentContainer .assignment-row').length;
  const row = document.createElement('div');
  row.className = 'row g-2 mb-2 assignment-row';
  row.innerHTML = `
    <div class="col-md-6">
      <select class="form-select person-select" name="assignments[${idx}][person_id]" required>
        <option value="">Select Person</option>${peopleOptions}
      </select>
    </div>
    <div class="col-md-4">
      <select class="form-select skill-select" name="assignments[${idx}][skill_id]" required>
        <option value="">Select Skill</option>
      </select>
    </div>
    <div class="col-md-2">
      <button type="button" class="btn btn-danger remove-assignment">&times;</button>
    </div>`;
  document.getElementById('assignmentContainer').appendChild(row);
  const personSelect = row.querySelector('.person-select');
  const skillSelect = row.querySelector('.skill-select');
  personSelect.addEventListener('change', () => {
    const pid = personSelect.value;
    skillSelect.innerHTML = '<option value="">Select Skill</option>';
    if(personSkills[pid]){
      personSkills[pid].forEach(s => {
        const opt = document.createElement('option');
        opt.value = s.skill_id;
        opt.textContent = s.label;
        skillSelect.appendChild(opt);
      });
    }
    if(data && pid == data.person_id){
      skillSelect.value = data.skill_id;
    }
  });
  row.querySelector('.remove-assignment').addEventListener('click', () => row.remove());
  if(data){
    personSelect.value = data.person_id;
    personSelect.dispatchEvent(new Event('change'));
    skillSelect.value = data.skill_id;
  }
}
existingAssignments.forEach(a => createRow(a));
if(existingAssignments.length === 0){ createRow(); }
document.getElementById('addAssignment').addEventListener('click', () => createRow());
</script>
<?php require '../admin_footer.php'; ?>
