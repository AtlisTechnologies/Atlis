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

    // UPDATE THE LOOKUP LIST date_updated
    $stmt=$pdo->prepare('UPDATE lookup_lists SET date_updated=NOW(), user_updated = :uid  WHERE id = :id');
    $stmt->execute([':id'=>$list_id, ':uid'=>$this_user_id]);

    audit_log($pdo,$this_user_id,'lookup_list_items',$delId,'DELETE','Deleted lookup list item');
    $message='Item deleted.';

  }elseif(isset($_POST['attr_delete_id'])){
    $delId=(int)$_POST['attr_delete_id'];
    $pdo->prepare('DELETE FROM lookup_list_item_attributes WHERE id=:id')->execute([':id'=>$delId]);

    // UPDATE THE LOOKUP LIST date_updated
    $stmt=$pdo->prepare('UPDATE lookup_lists SET date_updated=NOW(), user_updated = :uid  WHERE id = :id');
    $stmt->execute([':id'=>$list_id, ':uid'=>$this_user_id]);

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

          // UPDATE THE LOOKUP LIST date_updated
          $stmt=$pdo->prepare('UPDATE lookup_lists SET date_updated=NOW(), user_updated = :uid  WHERE id = :id');
          $stmt->execute([':id'=>$list_id, ':uid'=>$this_user_id]);

          audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$attr_id,'UPDATE','Updated item attribute');
          $message='Attribute updated.';
        }catch(PDOException $e){
          error_log($e->getMessage());
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

          // UPDATE THE LOOKUP LIST date_updated
          $stmt=$pdo->prepare('UPDATE lookup_lists SET date_updated=NOW(), user_updated = :uid  WHERE id = :id');
          $stmt->execute([':id'=>$list_id, ':uid'=>$this_user_id]);

          $attr_id=$pdo->lastInsertId();
          audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$attr_id,'CREATE','Created item attribute');
          $message='Attribute added.';
        }catch(PDOException $e){
          error_log($e->getMessage());
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
    $code = strtoupper(str_replace(' ', '_', trim($_POST['code'] ?? '')));
    $active_from = $_POST['active_from'] ?? date('Y-m-d', strtotime('-1 day'));
    $active_to=$_POST['active_to'] ?? null;
    if($active_to==='' || $active_to==='0000-00-00'){
      $active_to=null;
    }
    if($code===''){
      $error='Code is required.';
    }elseif($label===''){
      $error='Label is required.';
    }
    if(!$error){
      if($item_id){
        $stmt=$pdo->prepare('SELECT id FROM lookup_list_items WHERE list_id=:list_id AND (label=:label OR code=:code) AND id<>:id');
        $stmt->execute([':list_id'=>$list_id,':label'=>$label,':code'=>$code,':id'=>$item_id]);
      }else{
        $stmt=$pdo->prepare('SELECT id FROM lookup_list_items WHERE list_id=:list_id AND (label=:label OR code=:code)');
        $stmt->execute([':list_id'=>$list_id,':label'=>$label,':code'=>$code]);
      }
      if($stmt->fetch()){
        $error='Label or code already exists.';
      }
    }
    if(!$error){
      if($item_id){
        $stmt=$pdo->prepare('UPDATE lookup_list_items SET label=:label, code=:code, active_from=:active_from, active_to=:active_to, user_updated=:uid WHERE id=:id');
        $stmt->execute([':label'=>$label, ':code'=>$code, ':active_from'=>$active_from, ':active_to'=>$active_to, ':uid'=>$this_user_id, ':id'=>$item_id]);

        // UPDATE THE LOOKUP LIST date_updated
        $stmt=$pdo->prepare('UPDATE lookup_lists SET date_updated=NOW(), user_updated = :uid  WHERE id = :id');
        $stmt->execute([':id'=>$list_id, ':uid'=>$this_user_id]);

        audit_log($pdo,$this_user_id,'lookup_list_items',$item_id,'UPDATE','Updated lookup list item');
        $message='Item updated.';
      }else{
        $stmt=$pdo->prepare('INSERT INTO lookup_list_items (user_id,user_updated,list_id,label,code,active_from,active_to) VALUES (:uid,:uid,:list_id,:label,:code,:active_from,:active_to)');
        $stmt->execute([':uid'=>$this_user_id, ':list_id'=>$list_id, ':label'=>$label, ':code'=>$code, ':active_from'=>$active_from, ':active_to'=>$active_to]);

        // UPDATE THE LOOKUP LIST date_updated
        $stmt=$pdo->prepare('UPDATE lookup_lists SET date_updated=NOW(), user_updated = :uid  WHERE id = :id');
        $stmt->execute([':id'=>$list_id, ':uid'=>$this_user_id]);

        $item_id=$pdo->lastInsertId();
        audit_log($pdo,$this_user_id,'lookup_list_items',$item_id,'CREATE','Created lookup list item');
        $message='Item added.';
      }
    }
  }
}

$stmt=$pdo->prepare('SELECT id,label,code,sort_order,active_from,active_to FROM lookup_list_items WHERE list_id=:list_id AND active_from <= CURDATE() AND (active_to IS NULL OR active_to >= CURDATE()) ORDER BY sort_order,label');
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
  <div class="col-md-2"><input class="form-control" name="code" placeholder="Code" value="<?= h($_POST['code'] ?? ''); ?>" required></div>
  <div class="col-md-3"><input class="form-control" name="label" placeholder="Label" value="<?= h($_POST['label'] ?? ''); ?>" required></div>
  <div class="col-md-2"><input class="form-control" type="date" name="active_from" value="<?= h($_POST['active_from'] ?? date('Y-m-d', strtotime('-1 day'))); ?>" required></div>
  <div class="col-md-2"><input class="form-control" type="date" name="active_to" value="<?= h($_POST['active_to'] ?? ''); ?>"></div>
  <div class="col-md-2"><button class="btn btn-success w-100" type="submit" id="saveBtn">Save</button></div>
</form>
<div id="items" data-list='{"valueNames":["sort_order","code","label"],"page":25,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm mb-0">
      <thead>
        <tr><th class="sort" data-sort="sort_order">Order</th><th class="sort" data-sort="code">Code</th><th class="sort" data-sort="label">Label</th><th>Attributes</th><th>Actions</th></tr>
      </thead>
      <tbody class="list">
        <?php foreach($items as $it): ?>
          <tr data-id="<?= $it['id']; ?>">
            <td class="sort_order"><span class="drag-handle bi bi-list"></span></td>
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
              <button class="btn btn-sm btn-info" data-id="<?= $it['id']; ?>" data-label="<?= h($it['label']); ?>" onclick="openRelationsModal(this.dataset.id,this.dataset.label);return false;">Relations</button>
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

<div class="modal fade" id="relationsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Item Relations</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul id="relationsList" class="list-group mb-3"></ul>
        <div class="input-group">
          <select id="relationSelect" class="form-select"></select>
          <button class="btn btn-success" id="addRelationBtn">Add</button>
        </div>
      </div>
    </div>
  </div>
</div>
  <script src="../../vendors/sortablejs/Sortable.min.js"></script>
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
const tbody=document.querySelector('#items tbody');
new Sortable(tbody,{
  handle:'.drag-handle',
  animation:150,
  onEnd:()=>[...tbody.children].forEach((row,idx)=>{
    fetch('../api/lookup-lists.php',{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:new URLSearchParams({
        entity:'item',
        action:'update_sort',
        id:row.dataset.id,
        sort_order:idx+1,
        csrf_token:'<?= $token; ?>'
      })
    });
  })
});

let allItems=[];
fetch('../api/lookup-lists.php?entity=item&action=all').then(r=>r.json()).then(d=>{ if(d.success){ allItems=d.items; }});
const relationsModal=new bootstrap.Modal(document.getElementById('relationsModal'));
let currentItem=0;

function openRelationsModal(id,label){
  currentItem=id;
  document.querySelector('#relationsModal .modal-title').textContent='Relations for '+label;
  loadRelationOptions();
  loadRelations();
  relationsModal.show();
}

function loadRelationOptions(){
  const select=document.getElementById('relationSelect');
  select.innerHTML='';
  allItems.forEach(it=>{ if(it.id!=currentItem){ const opt=document.createElement('option'); opt.value=it.id; opt.text=`${it.list_name} - ${it.label}`; select.appendChild(opt); }});
}

function loadRelations(){
  fetch(`../api/lookup-lists.php?entity=relation&action=list&item_id=${currentItem}`).then(r=>r.json()).then(d=>{
    const list=document.getElementById('relationsList');
    list.innerHTML='';
    if(d.success){
      d.relations.forEach(rel=>{
        const li=document.createElement('li');
        li.className='list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML=`<span>${rel.list_name} - ${rel.label}</span><button class="btn btn-sm btn-danger">Remove</button>`;
        li.querySelector('button').addEventListener('click',()=>removeRelation(rel.id));
        list.appendChild(li);
      });
    }
  });
}

document.getElementById('addRelationBtn').addEventListener('click',()=>{
  const select=document.getElementById('relationSelect');
  const rid=parseInt(select.value);
  if(!rid) return;
  fetch('../api/lookup-lists.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:new URLSearchParams({entity:'relation',action:'create',item_id:currentItem,related_item_id:rid,csrf_token:'<?= $token; ?>'})}).then(r=>r.json()).then(d=>{
    if(d.success){ loadRelations(); } else { alert(d.error||'Error'); }
  });
});

function removeRelation(rid){
  fetch('../api/lookup-lists.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:new URLSearchParams({entity:'relation',action:'delete',item_id:currentItem,related_item_id:rid,csrf_token:'<?= $token; ?>'})}).then(r=>r.json()).then(d=>{
    if(d.success){ loadRelations(); } else { alert(d.error||'Error'); }
  });
}
</script>
<?php require '../admin_footer.php'; ?>
