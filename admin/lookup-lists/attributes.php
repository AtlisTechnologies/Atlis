<?php
require '../admin_header.php';

$token = generate_csrf_token();
$item_id = (int)($_GET['item_id'] ?? 0);
$list_id = (int)($_GET['list_id'] ?? 0);
$message = $error = '';

$stmt = $pdo->prepare('SELECT i.*, l.name AS list_name FROM lookup_list_items i JOIN lookup_lists l ON i.list_id = l.id WHERE i.id = :id AND i.active_from <= CURDATE() AND (i.active_to IS NULL OR i.active_to >= CURDATE())');
$stmt->execute([':id'=>$item_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$item){
  echo flash_message('Item not found.', 'danger');
  require '../admin_footer.php';
  exit;
}

if($_SERVER['REQUEST_METHOD']==='POST'){
  if(!verify_csrf_token($_POST['csrf_token'] ?? '')){ die('Invalid CSRF token'); }
  if(isset($_POST['delete_id'])){
    $delId=(int)$_POST['delete_id'];
    $pdo->prepare('DELETE FROM lookup_list_item_attributes WHERE id=:id')->execute([':id'=>$delId]);

    // UPDATE THE LOOKUP LIST date_updated
    $stmt=$pdo->prepare('UPDATE lookup_lists SET date_updated=NOW() WHERE id = :id');
    $stmt->execute([':id'=>$list_id]);

    audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$delId,'DELETE','Deleted item attribute');
    $message='Attribute deleted.';
  }else{
    $attr_id=(int)($_POST['id'] ?? 0);
    $key=trim($_POST['attr_code'] ?? '');
    $value=trim($_POST['attr_value'] ?? '');
    if($key===''){$error='Key is required.';}
    if(!$error){
      if($attr_id){
        $stmt=$pdo->prepare('UPDATE lookup_list_item_attributes SET attr_code=:k, attr_value=:v, user_updated=:uid WHERE id=:id');
        $stmt->execute([':k'=>$key, ':v'=>$value, ':uid'=>$this_user_id, ':id'=>$attr_id]);

        // UPDATE THE LOOKUP LIST date_updated
        $stmt=$pdo->prepare('UPDATE lookup_lists SET date_updated=NOW(), user_updated = :uid  WHERE id = :id');
        $stmt->execute([':id'=>$list_id, ':uid'=>$this_user_id]);

        audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$attr_id,'UPDATE','Updated item attribute');
        $message='Attribute updated.';
      }else{
        $stmt=$pdo->prepare('INSERT INTO lookup_list_item_attributes (user_id,user_updated,item_id,attr_code,attr_value) VALUES (:uid,:uid,:item_id,:k,:v)');
        $stmt->execute([':uid'=>$this_user_id, ':item_id'=>$item_id, ':k'=>$key, ':v'=>$value]);

        // UPDATE THE LOOKUP LIST date_updated
        $stmt=$pdo->prepare('UPDATE lookup_lists SET date_updated=NOW(), user_updated = :uid  WHERE id = :id');
        $stmt->execute([':id'=>$list_id, ':uid'=>$this_user_id]);

        $attr_id=$pdo->lastInsertId();
        audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$attr_id,'CREATE','Created item attribute');
        $message='Attribute added.';
      }
    }
  }
}

$stmt=$pdo->prepare('SELECT * FROM lookup_list_item_attributes WHERE item_id=:item_id');
$stmt->execute([':item_id'=>$item_id]);
$attrs=$stmt->fetchAll(PDO::FETCH_ASSOC);
$attrItems = get_lookup_items($pdo, 'LOOKUP_LIST_ITEM_ATTRIBUTES');
$selectedAttrCode = $_POST['attr_code'] ?? '';
?>

<div class="row">
  <div class="col-12">
    <h2 class="mb-4">Attributes for <?= htmlspecialchars($item['label']); ?>
      <br />
      <a class="btn btn-secondary" href="index.php">Back</a>
    </h2>
  </div>
</div>

<?= flash_message($error, 'danger'); ?>
<?= flash_message($message); ?>
<form method="post" class="row g-2 mb-3">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="id" value="<?= htmlspecialchars($_POST['id'] ?? ''); ?>">
  <div class="col-md-4">
    <select class="form-select" name="attr_code" required>
      <?php foreach ($attrItems as $attrItem): ?>
        <option value="<?= h($attrItem['code']); ?>" <?= $selectedAttrCode === $attrItem['code'] ? 'selected' : ''; ?>>
          <?= h($attrItem['label']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
    <div class="col-md-4"><input class="form-control" name="attr_value" placeholder="Value" value="<?= htmlspecialchars($_POST['attr_value'] ?? ''); ?>"></div>
  <div class="col-md-2"><button class="btn btn-success" type="submit" id="saveBtn">Save</button></div>
</form>
  <div id="attrs" data-list='{"valueNames":["attr_code","attr_value"],"page":25,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="table-responsive">
      <table class="table table-striped table-sm mb-0">
        <thead><tr><th class="sort" data-sort="attr_code">Key</th><th class="sort" data-sort="attr_value">Value</th><th>Actions</th></tr></thead>
      <tbody class="list">
        <?php foreach($attrs as $a): ?>
          <tr>
            <td class="attr_code"><?= htmlspecialchars($a['attr_code']); ?></td>
            <td class="attr_value"><?= htmlspecialchars($a['attr_value']); ?></td>
            <td>
              <button class="btn btn-sm btn-warning" onclick="fillAttr(<?= $a['id']; ?>,'<?= htmlspecialchars($a['attr_code'],ENT_QUOTES); ?>','<?= htmlspecialchars($a['attr_value'],ENT_QUOTES); ?>');return false;">Edit</button>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_id" value="<?= $a['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete attribute?');">Delete</button>
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
function fillAttr(id,key,value){
  const f=document.forms[0];
  f.id.value=id;
  f.attr_code.value=key;
  f.attr_value.value=value;
  const btn=document.getElementById('saveBtn');
  btn.classList.remove('btn-success');
  btn.classList.add('btn-warning');
}
</script>
<?php require '../admin_footer.php'; ?>
