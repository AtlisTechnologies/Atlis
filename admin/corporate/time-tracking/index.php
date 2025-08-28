<?php
require '../../admin_header.php';
require_permission('admin_time_tracking','read');

$filter = $_GET['filter'] ?? 'all';

$invoiceStmt = $pdo->query('SELECT id, invoice_number FROM admin_finances_invoices ORDER BY invoice_number');
$invoices = $invoiceStmt->fetchAll(PDO::FETCH_ASSOC);
$personStmt = $pdo->query("SELECT id, CONCAT(first_name,' ',last_name) AS name FROM person ORDER BY last_name");
$persons = $personStmt->fetchAll(PDO::FETCH_ASSOC);
$projectStmt = $pdo->query('SELECT id, name FROM module_projects ORDER BY name');
$projects = $projectStmt->fetchAll(PDO::FETCH_ASSOC);

switch($filter){
  case 'billed':
    $entryStmt = $pdo->query("SELECT t.id,t.memo,t.hours,t.person_id,t.project_id,p.first_name,p.last_name,i.invoice_number FROM admin_time_tracking_entries t JOIN person p ON t.person_id=p.id LEFT JOIN admin_finances_invoices i ON t.invoice_id=i.id WHERE t.invoice_id IS NOT NULL ORDER BY t.date_created DESC");
    break;
  case 'unbilled':
    $entryStmt = $pdo->query("SELECT t.id,t.memo,t.hours,t.person_id,t.project_id,p.first_name,p.last_name,i.invoice_number FROM admin_time_tracking_entries t JOIN person p ON t.person_id=p.id LEFT JOIN admin_finances_invoices i ON t.invoice_id=i.id WHERE t.invoice_id IS NULL ORDER BY t.date_created DESC");
    break;
  default:
    $entryStmt = $pdo->query("SELECT t.id,t.memo,t.hours,t.person_id,t.project_id,p.first_name,p.last_name,i.invoice_number FROM admin_time_tracking_entries t JOIN person p ON t.person_id=p.id LEFT JOIN admin_finances_invoices i ON t.invoice_id=i.id ORDER BY t.date_created DESC");
}
$entries = $entryStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Time Tracking</h2>
<ul class="nav nav-pills mb-3">
  <li class="nav-item"><a class="nav-link<?= $filter==='all'?' active':'' ?>" href="?filter=all">All</a></li>
  <li class="nav-item"><a class="nav-link<?= $filter==='unbilled'?' active':'' ?>" href="?filter=unbilled">Unbilled</a></li>
  <li class="nav-item"><a class="nav-link<?= $filter==='billed'?' active':'' ?>" href="?filter=billed">Billed</a></li>
</ul>
<div class="mb-3 text-end">
  <?php if (user_has_permission('admin_time_tracking','create')): ?>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#entryModal" id="addEntryBtn"><span class="fa-solid fa-plus"></span></button>
  <?php endif; ?>
</div>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr><th>Description</th><th>Person</th><th>Hours</th><th>Invoice</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach($entries as $e): ?>
        <tr>
          <td><?= h($e['memo']); ?></td>
          <td><?= h($e['first_name'].' '.$e['last_name']); ?></td>
          <td><?= h($e['hours']); ?></td>
          <td><?= h($e['invoice_number'] ?? 'Unbilled'); ?></td>
          <td>
            <?php if (user_has_permission('admin_time_tracking','update')): ?>
              <button class="btn btn-sm btn-primary edit-entry" data-id="<?= $e['id']; ?>" data-bs-toggle="modal" data-bs-target="#entryModal">Edit</button>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="entryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Time Entry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="entryForm">
          <input type="hidden" name="id" id="entry_id" />
          <div class="mb-3">
            <label class="form-label" for="person_id">Person</label>
            <select class="form-select" name="person_id" id="person_id" required>
              <option value="">-- select --</option>
              <?php foreach($persons as $p): ?>
                <option value="<?= $p['id']; ?>"><?= h($p['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="project_id">Project</label>
            <select class="form-select" name="project_id" id="project_id">
              <option value="">-- none --</option>
              <?php foreach($projects as $p): ?>
                <option value="<?= $p['id']; ?>"><?= h($p['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="work_date">Work Date</label>
            <input class="form-control" type="date" name="work_date" id="work_date" required />
          </div>
          <div class="mb-3">
            <label class="form-label" for="hours">Hours</label>
            <input class="form-control" type="number" step="0.01" name="hours" id="hours" required />
          </div>
          <div class="mb-3">
            <label class="form-label" for="rate">Rate</label>
            <input class="form-control" type="number" step="0.01" name="rate" id="rate" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="memo">Memo</label>
            <textarea class="form-control" name="memo" id="memo" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label" for="invoice_id">Invoice</label>
            <select class="form-select" name="invoice_id" id="invoice_id">
              <option value="">Unbilled</option>
              <?php foreach($invoices as $i): ?>
                <option value="<?= $i['id']; ?>"><?= h($i['invoice_number']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <?php if (user_has_permission('admin_time_tracking','create')): ?>
          <button type="button" class="btn btn-primary" id="saveEntryBtn">Save</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<script>
function loadEntry(id){
  fetch('functions/read.php?id='+id)
    .then(r=>r.json())
    .then(res=>{
      if(res.success){
        var d=res.data;
        document.getElementById('entry_id').value=d.id;
        document.getElementById('person_id').value=d.person_id;
        document.getElementById('project_id').value=d.project_id || '';
        document.getElementById('work_date').value=d.work_date;
        document.getElementById('hours').value=d.hours;
        document.getElementById('rate').value=d.rate;
        document.getElementById('memo').value=d.memo;
        document.getElementById('invoice_id').value=d.invoice_id || '';
      }
    });
}

document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.edit-entry').forEach(function(btn){
    btn.addEventListener('click',function(){
      loadEntry(this.dataset.id);
    });
  });
  document.getElementById('addEntryBtn')?.addEventListener('click',function(){
    document.getElementById('entryForm').reset();
    document.getElementById('entry_id').value='';
  });
  document.getElementById('saveEntryBtn')?.addEventListener('click',function(){
    var fd=new FormData(document.getElementById('entryForm'));
    var id=document.getElementById('entry_id').value;
    var url=id?'functions/update.php':'functions/create.php';
    fetch(url,{method:'POST',body:fd}).then(r=>r.json()).then(data=>{if(data.success){location.reload();}else{alert(data.error||'Error');}});
  });
  var params=new URLSearchParams(window.location.search);
  if(params.get('id')){
    loadEntry(params.get('id'));
    var modal=new bootstrap.Modal(document.getElementById('entryModal'));
    modal.show();
  }
});
</script>
<?php require '../../admin_footer.php'; ?>

