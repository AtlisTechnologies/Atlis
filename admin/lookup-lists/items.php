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
  }elseif(isset($_POST['attr_delete_id'])){
    $delId=(int)$_POST['attr_delete_id'];
    $pdo->prepare('DELETE FROM lookup_list_item_attributes WHERE id=:id')->execute([':id'=>$delId]);
    audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$delId,'DELETE','Deleted item attribute');
    $message='Attribute deleted.';
  }elseif(isset($_POST['attr_item_id'])){
    $attr_id=(int)($_POST['attr_id'] ?? 0);
    $item_id=(int)$_POST['attr_item_id'];
    $key=trim($_POST['attr_code'] ?? '');
    $value=trim($_POST['attr_value'] ?? '');
    if($key===''){ $error='Key is required.'; }
    if(!$error){
      if($attr_id){
        try{
          $stmt=$pdo->prepare('UPDATE lookup_list_item_attributes SET attr_code=:k, attr_value=:v, user_updated=:uid WHERE id=:id');
          $stmt->execute([':k'=>$key,':v'=>$value,':uid'=>$this_user_id,':id'=>$attr_id]);
          audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$attr_id,'UPDATE','Updated item attribute');
          $message='Attribute updated.';
        }catch(PDOException $e){
          if($e->getCode()==='23000'){
            $error='Attribute already exists for this item.';
          }else{
            $error='Database error.';
          }
        }
      }else{
        try{
          $stmt=$pdo->prepare('INSERT INTO lookup_list_item_attributes (user_id,user_updated,item_id,attr_code,attr_value) VALUES (:uid,:uid,:item_id,:k,:v)');
          $stmt->execute([':uid'=>$this_user_id,':item_id'=>$item_id,':k'=>$key,':v'=>$value]);
          $attr_id=$pdo->lastInsertId();
          audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$attr_id,'CREATE','Created item attribute');
          $message='Attribute added.';
        }catch(PDOException $e){
          if($e->getCode()==='23000'){
            $error='Attribute already exists for this item.';
          }else{
            $error='Database error.';
          }
        }
      }
    }
  }else{
    $item_id=(int)($_POST['id'] ?? 0);
    $label=trim($_POST['label'] ?? '');
    $code=trim($_POST['code'] ?? '');
    $active_from=$_POST['active_from'] ?? date('Y-m-d');
    $active_to=$_POST['active_to'] ?? null;
    if($active_to==='' || $active_to==='0000-00-00'){
      $active_to=null;
    }
    if($label===''){$error='Label is required.';}
    if(!$error){
      if($item_id){
        $stmt=$pdo->prepare('UPDATE lookup_list_items SET label=:label, code=:code, active_from=:active_from, active_to=:active_to, user_updated=:uid WHERE id=:id');
        $stmt->execute([':label'=>$label, ':code'=>$code, ':active_from'=>$active_from, ':active_to'=>$active_to, ':uid'=>$this_user_id, ':id'=>$item_id]);
        audit_log($pdo,$this_user_id,'lookup_list_items',$item_id,'UPDATE','Updated lookup list item');
        $message='Item updated.';
      }else{
        $stmt=$pdo->prepare('INSERT INTO lookup_list_items (user_id,user_updated,list_id,label,code,active_from,active_to) VALUES (:uid,:uid,:list_id,:label,:code,:active_from,:active_to)');
        $stmt->execute([':uid'=>$this_user_id, ':list_id'=>$list_id, ':label'=>$label, ':code'=>$code, ':active_from'=>$active_from, ':active_to'=>$active_to]);
        $item_id=$pdo->lastInsertId();
        audit_log($pdo,$this_user_id,'lookup_list_items',$item_id,'CREATE','Created lookup list item');
        $message='Item added.';
      }
    }
  }
}

$stmt=$pdo->prepare('SELECT id,label,code,active_from,active_to FROM lookup_list_items WHERE list_id=:list_id AND active_from <= CURDATE() AND (active_to IS NULL OR active_to >= CURDATE()) ORDER BY label');
$stmt->execute([':list_id'=>$list_id]);
$items=$stmt->fetchAll(PDO::FETCH_ASSOC);
if($items){
  $ids=array_column($items,'id');
  $placeholders=rtrim(str_repeat('?,',count($ids)),',');
  $aStmt=$pdo->prepare("SELECT item_id,id,attr_code,attr_value FROM lookup_list_item_attributes WHERE item_id IN ($placeholders)");
  $aStmt->execute($ids);
  $map=[];
  foreach($aStmt->fetchAll(PDO::FETCH_ASSOC) as $a){
    $map[$a['item_id']][]=$a;
  }
  foreach($items as &$it){
    $it['attrs']=$map[$it['id']]??[];
  }
  unset($it);
}
?>

<div class="row">
  <div class="col-12">
    <h2 class="mb-4">Items for <?= h($list['name']); ?>
      <br />
      <a class="btn btn-secondary" href="index.php">Back</a>
    </h2>
  </div>
</div>

<?= flash_message($error, 'danger'); ?>
<?= flash_message($message); ?>
<form method="post" class="row g-2 mb-3">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="id" value="<?= h($_POST['id'] ?? ''); ?>">
  <div class="col-md-2"><input class="form-control" name="code" placeholder="Code" required></div>
  <div class="col-md-3"><input class="form-control" name="label" placeholder="Label" required></div>
  <div class="col-md-2"><input class="form-control" type="date" name="active_from" value="<?= h($_POST['active_from'] ?? date('Y-m-d')); ?>" required></div>
  <div class="col-md-2"><input class="form-control" type="date" name="active_to"></div>
  <div class="col-md-2"><button class="btn btn-success w-100" type="submit" id="saveBtn">Save</button></div>
</form>
<div id="items" data-list='{"valueNames":["code","label"],"page":25,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm mb-0">
      <thead>
        <tr><th class="sort" data-sort="code">Code</th><th class="sort" data-sort="label">Label</th><th>Attributes</th><th>Actions</th></tr>
      </thead>
      <tbody class="list">
        <?php foreach($items as $it): ?>
          <tr>
            <td class="code"><?= h($it['code']); ?></td>
            <td class="label"><?= h($it['label']); ?></td>
            <td>
              <?php foreach(($it['attrs'] ?? []) as $a): ?>
                <div class="mb-1">
                  <form method="post" class="d-inline">
                    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                    <input type="hidden" name="attr_item_id" value="<?= $it['id']; ?>">
                    <input type="hidden" name="attr_id" value="<?= $a['id']; ?>">
                    <input class="form-control form-control-sm d-inline w-auto" name="attr_code" value="<?= h($a['attr_code']); ?>" required>
                    <input class="form-control form-control-sm d-inline w-auto" name="attr_value" value="<?= h($a['attr_value']); ?>">
                    <button class="btn btn-sm btn-warning">Update</button>
                  </form>
                  <form method="post" class="d-inline">
                    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                    <input type="hidden" name="attr_delete_id" value="<?= $a['id']; ?>">
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete attribute?');">Delete</button>
                  </form>
                </div>
              <?php endforeach; ?>
              <form method="post" class="d-inline">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <input type="hidden" name="attr_item_id" value="<?= $it['id']; ?>">
                <input class="form-control form-control-sm d-inline w-auto" name="attr_code" placeholder="Code" required>
                <input class="form-control form-control-sm d-inline w-auto" name="attr_value" placeholder="Value">
                <button class="btn btn-sm btn-success">Add</button>
              </form>
            </td>
            <td>
              <button class="btn btn-sm btn-warning" onclick="fillForm(<?= $it['id']; ?>,'<?= h($it['code']); ?>','<?= h($it['label']); ?>','<?= h($it['active_from']); ?>','<?= h($it['active_to']); ?>');return false;">Edit</button>
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
function fillForm(id,code,label,active_from,active_to){
  const f=document.forms[0];
  f.id.value=id;
  f.code.value=code;
  f.label.value=label;
  f.active_from.value=active_from;
  f.active_to.value=active_to;
  const btn=document.getElementById('saveBtn');
  btn.classList.remove('btn-success');
  btn.classList.add('btn-warning');
}
</script>
<?php require '../admin_footer.php'; ?>
