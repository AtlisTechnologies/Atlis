<?php
require '../admin_header.php';

$token = generate_csrf_token();
$list_id = (int)($_GET['list_id'] ?? 0);
$message = $error = '';

$stmt = $pdo->prepare('SELECT * FROM lookup_lists WHERE id=:id');
$stmt->execute([':id'=>$list_id]);
$list = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$list){
  echo flash_message('Lookup list not found.', 'danger');
  require '../admin_footer.php';
  exit;
}

if($_SERVER['REQUEST_METHOD']==='POST'){
  if(!verify_csrf_token($_POST['csrf_token'] ?? '')){ die('Invalid CSRF token'); }
  if(isset($_POST['delete_id'])){
    $delId=(int)$_POST['delete_id'];
    $pdo->prepare('DELETE FROM lookup_list_items WHERE id=:id')->execute([':id'=>$delId]);
    audit_log($pdo,$this_user_id,'lookup_list_items',$delId,'DELETE','Deleted lookup list item');
    $message='Item deleted.';
  }else{
    $item_id=(int)($_POST['id'] ?? 0);
    $label=trim($_POST['label'] ?? '');
    $value=trim($_POST['value'] ?? '');
    $active_from=$_POST['active_from'] ?? date('Y-m-d');
    $active_to=$_POST['active_to'] ?? null;
    $sort=(int)($_POST['sort_order'] ?? 0);
    if($label===''){$error='Label is required.';}
    if(!$error){
      if($item_id){
        $stmt=$pdo->prepare('UPDATE lookup_list_items SET label=:label, value=:value, active_from=:active_from, active_to=:active_to, sort_order=:sort, user_updated=:uid WHERE id=:id');
        $stmt->execute([':label'=>$label, ':value'=>$value, ':active_from'=>$active_from, ':active_to'=>$active_to, ':sort'=>$sort, ':uid'=>$this_user_id, ':id'=>$item_id]);
        audit_log($pdo,$this_user_id,'lookup_list_items',$item_id,'UPDATE','Updated lookup list item');
        $message='Item updated.';
      }else{
        $stmt=$pdo->prepare('INSERT INTO lookup_list_items (user_id,user_updated,list_id,label,value,active_from,active_to,sort_order) VALUES (:uid,:uid,:list_id,:label,:value,:active_from,:active_to,:sort)');
        $stmt->execute([':uid'=>$this_user_id, ':list_id'=>$list_id, ':label'=>$label, ':value'=>$value, ':active_from'=>$active_from, ':active_to'=>$active_to, ':sort'=>$sort]);
        $item_id=$pdo->lastInsertId();
        audit_log($pdo,$this_user_id,'lookup_list_items',$item_id,'CREATE','Created lookup list item');
        $message='Item added.';
      }
    }
  }
}

$stmt=$pdo->prepare('SELECT * FROM lookup_list_items WHERE list_id=:list_id AND active_from <= CURDATE() AND (active_to IS NULL OR active_to >= CURDATE()) ORDER BY sort_order,label');
$stmt->execute([':list_id'=>$list_id]);
$items=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Items for <?= htmlspecialchars($list['name']); ?></h2>
<?= flash_message($error, 'danger'); ?>
<?= flash_message($message); ?>
<form method="post" class="row g-2 mb-3">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="id" value="<?= htmlspecialchars($_POST['id'] ?? ''); ?>">
  <div class="col-md-3"><input class="form-control" name="label" placeholder="Label" value="<?= htmlspecialchars($_POST['label'] ?? ''); ?>" required></div>
  <div class="col-md-2"><input class="form-control" name="value" placeholder="Value" value="<?= htmlspecialchars($_POST['value'] ?? ''); ?>"></div>
  <div class="col-md-2"><input class="form-control" type="date" name="active_from" value="<?= htmlspecialchars($_POST['active_from'] ?? date('Y-m-d')); ?>" required></div>
  <div class="col-md-2"><input class="form-control" type="date" name="active_to" value="<?= htmlspecialchars($_POST['active_to'] ?? ''); ?>"></div>
  <div class="col-md-1"><input class="form-control" type="number" name="sort_order" placeholder="Sort" value="<?= htmlspecialchars($_POST['sort_order'] ?? 0); ?>"></div>
  <div class="col-md-1"><button class="btn btn-success w-100" type="submit" id="saveBtn">Save</button></div>
  <div class="col-md-1"><a class="btn btn-secondary w-100" href="index.php">Back</a></div>
</form>
<div id="items" data-list='{"valueNames":["label","value","active_from","active_to","sort_order"],"page":10,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm mb-0">
      <thead>
        <tr><th class="sort" data-sort="label">Label</th><th class="sort" data-sort="value">Value</th><th class="sort" data-sort="active_from">Active From</th><th class="sort" data-sort="active_to">Active To</th><th class="sort" data-sort="sort_order">Sort</th><th>Attributes</th><th>Actions</th></tr>
      </thead>
      <tbody class="list">
        <?php foreach($items as $it): ?>
          <tr>
            <td class="label"><?= htmlspecialchars($it['label']); ?></td>
            <td class="value"><?= htmlspecialchars($it['value']); ?></td>
            <td class="active_from"><?= htmlspecialchars($it['active_from']); ?></td>
            <td class="active_to"><?= htmlspecialchars($it['active_to']); ?></td>
            <td class="sort_order"><?= htmlspecialchars($it['sort_order']); ?></td>
            <td><a class="btn btn-sm btn-info" href="attributes.php?item_id=<?= $it['id']; ?>&list_id=<?= $list_id; ?>">Attributes</a></td>
            <td>
              <button class="btn btn-sm btn-warning" onclick="fillForm(<?= $it['id']; ?>,'<?= htmlspecialchars($it['label'],ENT_QUOTES); ?>','<?= htmlspecialchars($it['value'],ENT_QUOTES); ?>','<?= htmlspecialchars($it['active_from']); ?>','<?= htmlspecialchars($it['active_to']); ?>',<?= (int)$it['sort_order']; ?>);return false;">Edit</button>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_id" value="<?= $it['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete item?');">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-between align-items-center mt-3">
    <p class="mb-0" data-list-info></p>
    <ul class="pagination mb-0"></ul>
  </div>
</div>
<script>
function fillForm(id,label,value,active_from,active_to,sort){
  const f=document.forms[0];
  f.id.value=id;
  f.label.value=label;
  f.value.value=value;
  f.active_from.value=active_from;
  f.active_to.value=active_to;
  f.sort_order.value=sort;
  const btn=document.getElementById('saveBtn');
  btn.classList.remove('btn-success');
  btn.classList.add('btn-warning');
}
</script>
<?php require '../admin_footer.php'; ?>
