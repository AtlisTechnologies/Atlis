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

  }elseif(isset($_POST['id']) && !isset($_POST['label']) && !isset($_POST['code']) && !isset($_POST['attr_code'])){
    $delId=(int)$_POST['id'];
    $pdo->prepare('DELETE FROM lookup_list_item_attributes WHERE id=:id')->execute([':id'=>$delId]);

    // UPDATE THE LOOKUP LIST date_updated
    $stmt=$pdo->prepare('UPDATE lookup_lists SET date_updated=NOW(), user_updated = :uid  WHERE id = :id');
    $stmt->execute([':id'=>$list_id, ':uid'=>$this_user_id]);

    audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$delId,'DELETE','Deleted item attribute');
    $message='Attribute deleted.';
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

<div class="row align-items-center mb-4">
  <div class="col-auto">
    <a class="btn btn-secondary" href="index.php">
      <i class="fa-solid fa-arrow-left me-1"></i>Back to All Lookup Lists
    </a>
  </div>
  <div class="col text-center">
    <h2 class="mb-0">Items for <?= h($list['name']); ?></h2>
  </div>
  <div class="col-auto"></div>
</div>

<?= flash_message($error, 'danger'); ?>
<?= flash_message($message); ?>
<form id="itemForm" class="row g-2 mb-3">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="list_id" value="<?= $list_id; ?>">
  <input type="hidden" name="id" value="<?= h($_POST['id'] ?? ''); ?>">
  <div class="col-md-2"><input class="form-control" name="code" placeholder="Code" value="<?= h($_POST['code'] ?? ''); ?>" required></div>
  <div class="col-md-3"><input class="form-control" name="label" placeholder="Label" value="<?= h($_POST['label'] ?? ''); ?>" required></div>
  <div class="col-md-2"><input class="form-control" type="date" name="active_from" value="<?= h($_POST['active_from'] ?? date('Y-m-d', strtotime('-1 day'))); ?>" required></div>
  <div class="col-md-2"><input class="form-control" type="date" name="active_to" value="<?= h($_POST['active_to'] ?? ''); ?>"></div>
  <div class="col-md-2"><button class="btn btn-success w-100" type="submit" id="saveBtn">Save</button></div>
</form>
<div class="row align-items-center g-2 mb-3">
  <div class="col-auto">
    <button class="btn btn-sm btn-phoenix-primary" type="button" data-bs-toggle="modal" data-bs-target="#bulkItemsModal">
      Bulk Add Items
    </button>
  </div>
  <div class="col-auto">
    <select id="statusFilter" class="form-select form-select-sm">
      <option value="active" selected>Active</option>
      <option value="inactive">Inactive</option>
      <option value="future">Future</option>
      <option value="all">All</option>
    </select>
  </div>
  <div class="col d-flex justify-content-center">
    <input class="form-control form-control-sm search w-75" placeholder="Search" />
  </div>
</div>
<div id="items" data-list='{"valueNames":["sort_order","code","label"],"page":25,"pagination":true}'>
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
                  <form class="d-inline attr-form">
                    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                    <input type="hidden" name="item_id" value="<?= $it['id']; ?>">
                    <input type="hidden" name="id" value="<?= $a['id']; ?>">
                    <input class="form-control form-control-sm d-inline w-auto" name="attr_code" value="<?= h($a['attr_code']); ?>" required>
                    <input class="form-control form-control-sm d-inline w-auto" name="attr_value" value="<?= h($a['attr_value']); ?>">
                    <button class="btn btn-sm btn-warning">Update</button>
                  </form>
                  <form class="d-inline attr-delete-form">
                    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                    <input type="hidden" name="id" value="<?= $a['id']; ?>">
                    <button class="btn btn-sm btn-danger">Delete</button>
                  </form>
                </div>
              <?php endforeach; ?>
              <form class="d-inline attr-form">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <input type="hidden" name="item_id" value="<?= $it['id']; ?>">
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

<div class="modal fade" id="bulkItemsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Bulk Add Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <div class="form-text">Format: code|label|active_from|active_to</div>
          <textarea class="form-control" name="items" rows="10"></textarea>
        </div>
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <input type="hidden" name="list_id" value="<?= $list_id; ?>">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Add Items</button>
      </div>
    </form>
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
const listId=<?= $list_id; ?>;
const csrfToken='<?= $token; ?>';

function fillForm(id,code,label,active_from,active_to){
  const f=document.getElementById('itemForm');
  f.id.value=id;
  f.code.value=code;
  f.label.value=label;
  f.active_from.value=active_from;
  f.active_to.value=active_to;
  const btn=document.getElementById('saveBtn');
  btn.classList.remove('btn-success');
  btn.classList.add('btn-warning');
}

let sortable;
function initSortable(){
  if(sortable){ sortable.destroy(); }
  sortable = new Sortable(document.querySelector('#items tbody'), {
    handle: '.drag-handle',
    animation: 150,
    onEnd: function(){
      const requests=[];
      document.querySelectorAll('#items tbody tr').forEach((row, index) => {
        row.querySelector('.order-number').textContent = index + 1;
        requests.push(fetch('../api/lookup-lists.php',{
          method:'POST',
          headers:{'Content-Type':'application/x-www-form-urlencoded'},
          body:new URLSearchParams({entity:'item',action:'update_sort',id:row.dataset.id,sort_order:index+1,csrf_token:csrfToken})
        }).then(r=>r.json()));
      });
      Promise.all(requests).then(rs=>{ if(rs.some(x=>!x.success)){ alert('Failed to update order'); }});
    }
  });
}

function esc(str){
  return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function renderAttrs(it){
  let html='';
  (it.attrs||[]).forEach(a=>{
    html+=`<div class="mb-1"><form class="d-inline attr-form">
      <input type="hidden" name="csrf_token" value="${csrfToken}">
      <input type="hidden" name="item_id" value="${it.id}">
      <input type="hidden" name="id" value="${a.id}">
      <input class="form-control form-control-sm d-inline w-auto" name="attr_code" value="${esc(a.attr_code)}" required>
      <input class="form-control form-control-sm d-inline w-auto" name="attr_value" value="${esc(a.attr_value||'')}">
      <button class="btn btn-sm btn-warning">Update</button>
    </form>
    <form class="d-inline attr-delete-form">
      <input type="hidden" name="csrf_token" value="${csrfToken}">
      <input type="hidden" name="id" value="${a.id}">
      <button class="btn btn-sm btn-danger">Delete</button>
    </form></div>`;
  });
  html+=`<form class="d-inline attr-form">
    <input type="hidden" name="csrf_token" value="${csrfToken}">
    <input type="hidden" name="item_id" value="${it.id}">
    <input class="form-control form-control-sm d-inline w-auto" name="attr_code" placeholder="Code" required>
    <input class="form-control form-control-sm d-inline w-auto" name="attr_value" placeholder="Value">
    <button class="btn btn-sm btn-success">Add</button>
  </form>`;
  return html;
}

function renderItem(it){
  const tr=document.createElement('tr');
  tr.dataset.id=it.id;
  tr.innerHTML=`
    <td class="sort_order"><span class="drag-handle bi bi-list"></span><span class="order-number ms-2">${it.sort_order}</span></td>
    <td class="code">${esc(it.code)}</td>
    <td class="label">${esc(it.label)}</td>
    <td>${renderAttrs(it)}</td>
    <td>
      <button class="btn btn-sm btn-info" data-id="${it.id}" data-label="${esc(it.label)}" onclick="openRelationsModal(this.dataset.id,this.dataset.label);return false;">Relations</button>
      <button class="btn btn-sm btn-warning" onclick="fillForm(${it.id},'${esc(it.code)}','${esc(it.label)}','${it.active_from}','${it.active_to}');return false;">Edit</button>
      <form method="post" class="d-inline">
        <input type="hidden" name="delete_id" value="${it.id}">
        <input type="hidden" name="csrf_token" value="${csrfToken}">
        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete item?');">Delete</button>
      </form>
    </td>`;
  return tr;
}

function loadItems(){
  const status=document.getElementById('statusFilter').value;
  fetch(`../api/lookup-lists.php?entity=item&action=list&list_id=${listId}&status=${status}`).then(r=>r.json()).then(d=>{
    if(d.success){
      const tbody=document.querySelector('#items tbody');
      tbody.innerHTML='';
      d.items.forEach(it=>tbody.appendChild(renderItem(it)));
      initSortable();
    }
  });
}

document.getElementById('itemForm').addEventListener('submit',function(e){
  e.preventDefault();
  const data=new FormData(e.target);
  const action=data.get('id')? 'update':'create';
  data.append('entity','item');
  data.append('action',action);
  fetch('../api/lookup-lists.php',{method:'POST',body:new URLSearchParams(data)}).then(r=>r.json()).then(d=>{
    if(d.success){
      loadItems();
      e.target.reset();
      const btn=document.getElementById('saveBtn');
      btn.classList.remove('btn-warning');
      btn.classList.add('btn-success');
    }else{
      alert(d.error||'Error');
    }
  });
});

document.getElementById('items').addEventListener('submit',function(e){
  const f=e.target;
  if(f.classList.contains('attr-form')){
    e.preventDefault();
    const data=new FormData(f);
    const action=data.get('id')? 'update':'create';
    data.append('entity','attribute');
    data.append('action',action);
    fetch('../api/lookup-lists.php',{method:'POST',body:new URLSearchParams(data)}).then(r=>r.json()).then(d=>{
      if(d.success){ loadItems(); } else { alert(d.error||'Error'); }
    });
}else if(f.classList.contains('attr-delete-form')){
    e.preventDefault();
    if(!confirm('Delete attribute?')) return;
    const data=new FormData(f);
    data.append('entity','attribute');
    data.append('action','delete');
    fetch('../api/lookup-lists.php',{method:'POST',body:new URLSearchParams(data)}).then(r=>r.json()).then(d=>{
      if(d.success){ loadItems(); } else { alert(d.error||'Error'); }
    });
  }
});

document.getElementById('statusFilter').addEventListener('change',loadItems);
loadItems();


let allItems=[];
fetch('../api/lookup-lists.php?entity=item&action=all').then(r=>r.json()).then(d=>{ if(d.success){ allItems=d.items; }});
const bulkModalEl=document.getElementById('bulkItemsModal');
const bulkItemsModal=new bootstrap.Modal(bulkModalEl);
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

bulkModalEl.addEventListener('submit',function(e){
  e.preventDefault();
  const textarea=bulkModalEl.querySelector('textarea');
  const lines=textarea.value.split('\n');
  const yesterday=new Date(Date.now()-86400000).toISOString().slice(0,10);
  const items=[];
  lines.forEach(line=>{
    if(!line.trim()) return;
    const parts=line.split('|');
    const code=(parts[0]||'').trim();
    const label=(parts[1]||'').trim();
    const active_from=(parts[2]||'').trim()||yesterday;
    const active_to=(parts[3]||'').trim();
    items.push({code,label,active_from,active_to});
  });
  fetch('../api/lookup-lists.php?entity=item&action=bulk_create',{
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body:JSON.stringify({csrf_token:csrfToken,list_id:listId,items})
  }).then(r=>r.json()).then(d=>{
    if(d.success){
      bulkItemsModal.hide();
      textarea.value='';
      loadItems();
    }else{
      alert(d.error||'Error');
    }
  });
});

document.getElementById('addRelationBtn').addEventListener('click',()=>{
  const select=document.getElementById('relationSelect');
  const rid=parseInt(select.value);
  if(!rid) return;
  fetch('../api/lookup-lists.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:new URLSearchParams({entity:'relation',action:'create',item_id:currentItem,related_item_id:rid,csrf_token:csrfToken})}).then(r=>r.json()).then(d=>{
    if(d.success){ loadRelations(); } else { alert(d.error||'Error'); }
  });
});

function removeRelation(rid){
  fetch('../api/lookup-lists.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:new URLSearchParams({entity:'relation',action:'delete',item_id:currentItem,related_item_id:rid,csrf_token:csrfToken})}).then(r=>r.json()).then(d=>{
    if(d.success){ loadRelations(); } else { alert(d.error||'Error'); }
  });
}
</script>
<?php require '../admin_footer.php'; ?>
