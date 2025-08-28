<?php
require '../../admin_header.php';
require_permission('admin_finances_statements_of_work','read');

$sowStmt = $pdo->query('SELECT s.id,s.title,s.status_id,l.name AS status,s.start_date,s.end_date FROM admin_finances_statements_of_work s LEFT JOIN lookup_list_items l ON s.status_id=l.id ORDER BY s.date_created DESC');
$sows = $sowStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Statements of Work</h2>
<div id="sowList" data-list='{"valueNames":["title","status","start_date","end_date"],"page":25,"pagination":true}'>
  <div class="row g-3 justify-content-between mb-4">
    <div class="col-auto">
      <?php if (user_has_permission('admin_finances_statements_of_work','create')): ?>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sowCreate"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></button>
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
      <div class="col px-2 sort" data-sort="title">Title</div>
      <div class="col px-2 sort" data-sort="status">Status</div>
      <div class="col px-2 sort" data-sort="start_date">Start</div>
      <div class="col px-2 sort" data-sort="end_date">End</div>
      <div class="col px-2">Actions</div>
    </div>
    <div class="list">
      <?php foreach($sows as $sow): ?>
        <?php
          $invStmt = $pdo->prepare('SELECT i.id,i.invoice_number FROM admin_finances_invoice_sow isw JOIN admin_finances_invoices i ON isw.invoice_id=i.id WHERE isw.statement_id=:sid');
          $invStmt->execute([':sid'=>$sow['id']]);
          $invoices = $invStmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="row g-0 border-bottom py-2">
          <div class="col px-2 title"><?= h($sow['title']); ?></div>
          <div class="col px-2 status"><?= h($sow['status']); ?></div>
          <div class="col px-2 start_date"><?= h($sow['start_date']); ?></div>
          <div class="col px-2 end_date"><?= h($sow['end_date']); ?></div>
          <div class="col px-2"><button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editSow<?= $sow['id']; ?>">Edit</button></div>
        </div>
        <div class="modal fade" id="editSow<?= $sow['id']; ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Statement of Work <?= h($sow['title']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="sow-edit-form" data-id="<?= $sow['id']; ?>">
                  <input type="hidden" name="id" value="<?= $sow['id']; ?>">
                  <div class="mb-3"><label class="form-label">Title<input class="form-control" name="title" value="<?= h($sow['title']); ?>" required></label></div>
                  <div class="mb-3"><label class="form-label">Status ID<input class="form-control" name="status_id" value="<?= h($sow['status_id']); ?>"></label></div>
                  <div class="mb-3"><label class="form-label">Start Date<input class="form-control" type="date" name="start_date" value="<?= h($sow['start_date']); ?>"></label></div>
                  <div class="mb-3"><label class="form-label">End Date<input class="form-control" type="date" name="end_date" value="<?= h($sow['end_date']); ?>"></label></div>
                  <div class="mb-3"><label class="form-label">File<input class="form-control" type="file" name="file"></label></div>
                  <button class="btn btn-primary" type="submit">Save</button>
                </form>
                <hr/>
                <h6>Invoices</h6>
                <ul class="list-group mb-3" id="invList<?= $sow['id']; ?>">
                  <?php foreach($invoices as $inv): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span><?= h($inv['invoice_number']); ?></span>
                      <button class="btn btn-sm btn-outline-danger unlink-invoice" data-sow="<?= $sow['id']; ?>" data-invoice="<?= $inv['id']; ?>">Detach</button>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <form class="link-invoice-form" data-sow="<?= $sow['id']; ?>">
                  <input type="hidden" name="statement_id" value="<?= $sow['id']; ?>">
                  <div class="input-group mb-3">
                    <input class="form-control" name="invoice_id" type="number" placeholder="Invoice ID">
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

<div class="modal fade" id="sowCreate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Statement of Work</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="sowCreateForm">
          <div class="mb-3"><label class="form-label">Title<input class="form-control" name="title" required></label></div>
          <div class="mb-3"><label class="form-label">Status ID<input class="form-control" name="status_id" type="number"></label></div>
          <div class="mb-3"><label class="form-label">Start Date<input class="form-control" type="date" name="start_date"></label></div>
          <div class="mb-3"><label class="form-label">End Date<input class="form-control" type="date" name="end_date"></label></div>
          <div class="mb-3"><label class="form-label">File<input class="form-control" type="file" name="file"></label></div>
          <button class="btn btn-primary" type="submit">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var listEl=document.getElementById('sowList');
  if(listEl){
    var opts=window.phoenix.utils.getData(listEl,'list');
    new window.List(listEl,opts);
  }
  var createForm=document.getElementById('sowCreateForm');
  if(createForm){
    createForm.addEventListener('submit',function(e){
      e.preventDefault();
      var fd=new FormData(createForm);
      fetch('functions/create.php',{method:'POST',body:fd}).then(r=>r.json()).then(data=>{if(data.success){location.reload();}else{alert(data.error||'Error');}});
    });
  }
  document.querySelectorAll('.sow-edit-form').forEach(f=>{
    f.addEventListener('submit',function(e){
      e.preventDefault();
      var fd=new FormData(f);
      fetch('functions/update.php',{method:'POST',body:fd}).then(r=>r.json()).then(data=>{if(data.success){location.reload();}else{alert(data.error||'Error');}});
    });
  });
  document.querySelectorAll('.link-invoice-form').forEach(f=>{
    f.addEventListener('submit',e=>{
      e.preventDefault();
      var fd=new FormData(f);
      fetch('functions/link_invoice.php',{method:'POST',body:fd}).then(r=>r.json()).then(()=>location.reload());
    });
  });
  document.querySelectorAll('.unlink-invoice').forEach(btn=>{
    btn.addEventListener('click',()=>{
      var fd=new FormData();
      fd.append('statement_id',btn.dataset.sow);
      fd.append('invoice_id',btn.dataset.invoice);
      fetch('functions/unlink_invoice.php',{method:'POST',body:fd}).then(r=>r.json()).then(()=>location.reload());
    });
  });
});
</script>
<?php require '../../admin_footer.php'; ?>
