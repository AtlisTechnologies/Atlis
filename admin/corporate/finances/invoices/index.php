<?php
require '../../admin_header.php';
require_permission('admin_finances_invoices','read');

$invoiceStmt = $pdo->query('SELECT i.id,i.invoice_number,i.status_id,l.name AS status,i.bill_to,i.invoice_date,i.due_date,i.total_amount FROM admin_finances_invoices i LEFT JOIN lookup_list_items l ON i.status_id=l.id ORDER BY i.invoice_date DESC');
$invoices = $invoiceStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Invoices</h2>
<div id="invoiceList" data-list='{"valueNames":["invoice_number","status","bill_to","invoice_date","due_date","total_amount"],"page":25,"pagination":true}'>
  <div class="row g-3 justify-content-between mb-4">
    <div class="col-auto">
      <?php if (user_has_permission('admin_finances_invoices','create')): ?>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#invoiceCreate"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></button>
      <?php endif; ?>
    </div>
    <div class="col-auto">
      <div class="search-box">
        <form class="position-relative">
          <input class="form-control search-input search" type="search" placeholder="Search" aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
    </div>
  </div>
  <div class="bg-body-emphasis border-top border-bottom border-translucent position-relative top-1 mx-n4 px-4">
    <div class="row g-0 text-body-tertiary fw-bold fs-10 py-2">
      <div class="col px-2 sort" data-sort="invoice_number">Invoice #</div>
      <div class="col px-2 sort" data-sort="status">Status</div>
      <div class="col px-2 sort" data-sort="bill_to">Bill To</div>
      <div class="col px-2 sort" data-sort="invoice_date">Invoice Date</div>
      <div class="col px-2 sort" data-sort="due_date">Due Date</div>
      <div class="col px-2 sort" data-sort="total_amount">Total</div>
      <div class="col px-2">Actions</div>
    </div>
    <div class="list">
      <?php foreach($invoices as $inv): ?>
        <?php
          $projStmt = $pdo->prepare('SELECT p.id,p.name FROM admin_finances_invoice_projects ip JOIN module_projects p ON ip.project_id=p.id WHERE ip.invoice_id=:iid');
          $projStmt->execute([':iid'=>$inv['id']]);
          $projects = $projStmt->fetchAll(PDO::FETCH_ASSOC);
          $sowStmt = $pdo->prepare('SELECT s.id,s.title FROM admin_finances_invoice_sow isw JOIN admin_finances_statements_of_work s ON isw.statement_id=s.id WHERE isw.invoice_id=:iid');
          $sowStmt->execute([':iid'=>$inv['id']]);
          $sows = $sowStmt->fetchAll(PDO::FETCH_ASSOC);
          $timeStmt = $pdo->prepare('SELECT id,memo,hours FROM admin_time_tracking_entries WHERE invoice_id=:iid');
          $timeStmt->execute([':iid'=>$inv['id']]);
          $times = $timeStmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="row g-0 border-bottom py-2">
          <div class="col px-2 invoice_number"><?= h($inv['invoice_number']); ?></div>
          <div class="col px-2 status"><?= h($inv['status']); ?></div>
          <div class="col px-2 bill_to"><?= h($inv['bill_to']); ?></div>
          <div class="col px-2 invoice_date"><?= h($inv['invoice_date']); ?></div>
          <div class="col px-2 due_date"><?= h($inv['due_date']); ?></div>
          <div class="col px-2 total_amount"><?= h($inv['total_amount']); ?></div>
          <div class="col px-2">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editInvoice<?= $inv['id']; ?>">Edit</button>
          </div>
        </div>
        <div class="modal fade" id="editInvoice<?= $inv['id']; ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Invoice <?= h($inv['invoice_number']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="invoice-edit-form" data-id="<?= $inv['id']; ?>">
                  <input type="hidden" name="id" value="<?= $inv['id']; ?>">
                  <div class="mb-3"><label class="form-label">Invoice #<input class="form-control" name="invoice_number" value="<?= h($inv['invoice_number']); ?>" required></label></div>
                  <div class="mb-3"><label class="form-label">Status ID<input class="form-control" name="status_id" value="<?= h($inv['status_id']); ?>"></label></div>
                  <div class="mb-3"><label class="form-label">Bill To<input class="form-control" name="bill_to" value="<?= h($inv['bill_to']); ?>"></label></div>
                  <div class="mb-3"><label class="form-label">Invoice Date<input class="form-control" type="date" name="invoice_date" value="<?= h($inv['invoice_date']); ?>"></label></div>
                  <div class="mb-3"><label class="form-label">Due Date<input class="form-control" type="date" name="due_date" value="<?= h($inv['due_date']); ?>"></label></div>
                  <div class="mb-3"><label class="form-label">Total<input class="form-control" type="number" step="0.01" name="total_amount" value="<?= h($inv['total_amount']); ?>"></label></div>
                  <div class="mb-3"><label class="form-label">File<input class="form-control" type="file" name="file"></label></div>
                  <button class="btn btn-primary" type="submit">Save</button>
                </form>
                <hr/>
                <h6>Projects</h6>
                <ul class="list-group mb-3" id="projList<?= $inv['id']; ?>">
                  <?php foreach($projects as $p): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span><?= h($p['name']); ?></span>
                      <button class="btn btn-sm btn-outline-danger unlink-project" data-invoice="<?= $inv['id']; ?>" data-project="<?= $p['id']; ?>">Detach</button>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <form class="link-project-form" data-invoice="<?= $inv['id']; ?>">
                  <input type="hidden" name="invoice_id" value="<?= $inv['id']; ?>">
                  <div class="input-group mb-3">
                    <input class="form-control" name="project_id" type="number" placeholder="Project ID">
                    <button class="btn btn-outline-primary" type="submit">Attach</button>
                  </div>
                </form>
                <h6>Statements of Work</h6>
                <ul class="list-group mb-3" id="sowList<?= $inv['id']; ?>">
                  <?php foreach($sows as $s): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span><?= h($s['title']); ?></span>
                      <button class="btn btn-sm btn-outline-danger unlink-sow" data-invoice="<?= $inv['id']; ?>" data-sow="<?= $s['id']; ?>">Detach</button>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <form class="link-sow-form" data-invoice="<?= $inv['id']; ?>">
                  <input type="hidden" name="invoice_id" value="<?= $inv['id']; ?>">
                  <div class="input-group mb-3">
                    <input class="form-control" name="statement_id" type="number" placeholder="SoW ID">
                    <button class="btn btn-outline-primary" type="submit">Attach</button>
                  </div>
                </form>
                <h6>Time Entries</h6>
                <ul class="list-group mb-3" id="timeList<?= $inv['id']; ?>">
                  <?php foreach($times as $t): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span><?= h($t['memo']); ?> (<?= h($t['hours']); ?>h)</span>
                      <button class="btn btn-sm btn-outline-danger unlink-time" data-time="<?= $t['id']; ?>">Detach</button>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <form class="link-time-form" data-invoice="<?= $inv['id']; ?>">
                  <input type="hidden" name="invoice_id" value="<?= $inv['id']; ?>">
                  <div class="input-group mb-3">
                    <input class="form-control" name="time_entry_id" type="number" placeholder="Time Entry ID">
                    <button class="btn btn-outline-primary" type="submit">Attach</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="row align-items-center justify-content-end py-3 pe-0 fs-9">
    <div class="col-auto d-flex">
      <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info></p>
    </div>
    <div class="col-auto d-flex">
      <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
      <ul class="mb-0 pagination"></ul>
      <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
    </div>
  </div>
</div>

<div class="modal fade" id="invoiceCreate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Invoice</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="invoiceCreateForm">
          <div class="mb-3"><label class="form-label">Invoice #<input class="form-control" name="invoice_number" required></label></div>
          <div class="mb-3"><label class="form-label">Status ID<input class="form-control" name="status_id" type="number"></label></div>
          <div class="mb-3"><label class="form-label">Bill To<input class="form-control" name="bill_to"></label></div>
          <div class="mb-3"><label class="form-label">Invoice Date<input class="form-control" type="date" name="invoice_date"></label></div>
          <div class="mb-3"><label class="form-label">Due Date<input class="form-control" type="date" name="due_date"></label></div>
          <div class="mb-3"><label class="form-label">Total<input class="form-control" type="number" step="0.01" name="total_amount"></label></div>
          <div class="mb-3"><label class="form-label">File<input class="form-control" type="file" name="file"></label></div>
          <button class="btn btn-primary" type="submit">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var listEl = document.getElementById('invoiceList');
  if(listEl){
    var opts = window.phoenix.utils.getData(listEl,'list');
    new window.List(listEl,opts);
  }
  var createForm = document.getElementById('invoiceCreateForm');
  if(createForm){
    createForm.addEventListener('submit',function(e){
      e.preventDefault();
      var fd = new FormData(createForm);
      fetch('functions/create.php',{method:'POST',body:fd}).then(r=>r.json()).then(data=>{if(data.success){location.reload();}else{alert(data.error||'Error');}});
    });
  }
  document.querySelectorAll('.invoice-edit-form').forEach(f=>{
    f.addEventListener('submit',function(e){
      e.preventDefault();
      var fd = new FormData(f);
      fetch('functions/update.php',{method:'POST',body:fd}).then(r=>r.json()).then(data=>{if(data.success){location.reload();}else{alert(data.error||'Error');}});
    });
  });
  document.querySelectorAll('.link-project-form').forEach(f=>{
    f.addEventListener('submit',e=>{
      e.preventDefault();
      var fd=new FormData(f);
      fetch('functions/link_project.php',{method:'POST',body:fd}).then(r=>r.json()).then(()=>location.reload());
    });
  });
  document.querySelectorAll('.unlink-project').forEach(btn=>{
    btn.addEventListener('click',e=>{
      var fd=new FormData();
      fd.append('invoice_id',btn.dataset.invoice);
      fd.append('project_id',btn.dataset.project);
      fetch('functions/unlink_project.php',{method:'POST',body:fd}).then(r=>r.json()).then(()=>location.reload());
    });
  });
  document.querySelectorAll('.link-sow-form').forEach(f=>{
    f.addEventListener('submit',e=>{
      e.preventDefault();
      var fd=new FormData(f);
      fetch('functions/link_sow.php',{method:'POST',body:fd}).then(r=>r.json()).then(()=>location.reload());
    });
  });
  document.querySelectorAll('.unlink-sow').forEach(btn=>{
    btn.addEventListener('click',()=>{
      var fd=new FormData();
      fd.append('invoice_id',btn.dataset.invoice);
      fd.append('statement_id',btn.dataset.sow);
      fetch('functions/unlink_sow.php',{method:'POST',body:fd}).then(r=>r.json()).then(()=>location.reload());
    });
  });
  document.querySelectorAll('.link-time-form').forEach(f=>{
    f.addEventListener('submit',e=>{
      e.preventDefault();
      var fd=new FormData(f);
      fetch('functions/link_time.php',{method:'POST',body:fd}).then(r=>r.json()).then(()=>location.reload());
    });
  });
  document.querySelectorAll('.unlink-time').forEach(btn=>{
    btn.addEventListener('click',()=>{
      var fd=new FormData();
      fd.append('time_entry_id',btn.dataset.time);
      fetch('functions/unlink_time.php',{method:'POST',body:fd}).then(r=>r.json()).then(()=>location.reload());
    });
  });
});
</script>
<?php require '../../admin_footer.php'; ?>
