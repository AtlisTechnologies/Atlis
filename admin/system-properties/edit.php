<?php
require '../admin_header.php';

$id = (int)($_GET['id'] ?? 0);
$token = generate_csrf_token();

function fetchLookupItems($name){
  global $pdo;
  $stmt = $pdo->prepare('SELECT lli.id, lli.label FROM lookup_lists ll JOIN lookup_list_items lli ON ll.id = lli.list_id WHERE ll.name = :name AND lli.active_from <= CURDATE() AND (lli.active_to IS NULL OR lli.active_to >= CURDATE()) ORDER BY lli.label');
  $stmt->execute([':name'=>$name]);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$categories = fetchLookupItems('SYSTEM_PROPERTIES_CATEGORIES');
$types = fetchLookupItems('SYSTEM_PROPERTIES_TYPES');

if($id){
  require_permission('system_properties','update');
  $stmt = $pdo->prepare('SELECT * FROM system_properties WHERE id=:id');
  $stmt->execute([':id'=>$id]);
  $prop = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$prop){ echo '<div class="alert alert-danger">Property not found</div>'; require '../admin_footer.php'; exit; }
}else{
  require_permission('system_properties','create');
  $prop = ['category_id'=>'','type_id'=>'','name'=>'','value'=>'','memo'=>''];
}

$isPasswordType = false;
foreach($types as $t){
  if((int)$t['id'] === (int)($prop['type_id'] ?? 0) && stripos($t['label'], 'password') !== false){
    $isPasswordType = true;
    break;
  }
}
?>
<h2 class="mb-4"><?= $id?'Edit':'Add'; ?> System Property</h2>
<form id="propertyForm">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="id" value="<?= e($id); ?>">
  <div class="mb-3">
    <label class="form-label">Category</label>
    <select class="form-select" data-choices name="category_id">
      <option value="">Select Category</option>
      <?php foreach($categories as $c): ?>
        <option value="<?= $c['id']; ?>" <?= $prop['category_id']==$c['id']?'selected':''; ?>><?= e($c['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Type</label>
    <select class="form-select" data-choices name="type_id">
      <option value="">Select Type</option>
      <?php foreach($types as $t): ?>
        <option value="<?= $t['id']; ?>" <?= $prop['type_id']==$t['id']?'selected':''; ?>><?= e($t['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" name="name" value="<?= e($prop['name']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Value</label>
    <?php if($isPasswordType): ?>
    <div class="input-group" data-password="data-password">
      <input type="password" class="form-control" name="value" value="<?= e($prop['value']); ?>" data-password-input="data-password-input" required>
      <button class="btn btn-outline-secondary" type="button" data-password-toggle="data-password-toggle"><span class="uil uil-eye show"></span><span class="uil uil-eye-slash hide"></span></button>
    </div>
    <?php else: ?>
    <textarea class="form-control" name="value" required><?= e($prop['value']); ?></textarea>
    <?php endif; ?>

  </div>
  <div class="mb-3">
    <label class="form-label">Memo</label>
    <textarea class="form-control" name="memo"><?= e($prop['memo'] ?? ''); ?></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
  // Choices.js hides the original select elements, so ensure
  // they're not marked as required to avoid browser validation
  // errors when the hidden inputs are unfocusable.
  $('select[name="category_id"],select[name="type_id"]').prop('required', false);
  $('#propertyForm').on('submit', function(e){
    e.preventDefault();
    var category = $('select[name="category_id"]').val();
    var type = $('select[name="type_id"]').val();
    if(!category || !type){
      alert('Please select both a category and a type.');
      return;
    }
    var action = <?= $id ? json_encode('update') : json_encode('create'); ?>;
    $.post('../api/system-properties.php', $(this).serialize() + '&action=' + action, function(res){
      if(res.success){
        window.location = 'index.php';
      }else{
        alert(res.error);
      }
    },'json');
  });
});
</script>
<?php require '../admin_footer.php'; ?>
