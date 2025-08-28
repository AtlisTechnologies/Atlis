<?php
require '../../admin_header.php';
require_permission('admin_time_tracking','read');

$invoiceStmt = $pdo->query('SELECT id, invoice_number FROM admin_finances_invoices ORDER BY invoice_number');
$invoices = $invoiceStmt->fetchAll(PDO::FETCH_ASSOC);
$entryStmt = $pdo->query('SELECT t.id, t.memo, t.hours, i.invoice_number AS invoice_number FROM admin_time_tracking_entries t LEFT JOIN admin_finances_invoices i ON t.invoice_id = i.id ORDER BY t.date_created DESC');
$entries = $entryStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Time Tracking</h2>
<div class="row g-3">
  <div class="col-lg-4">
    <form id="timeEntryForm">
      <div class="mb-3">
        <label class="form-label" for="memo">Description</label>
        <input class="form-control" id="memo" name="memo" type="text" required />
      </div>
      <div class="mb-3">
        <label class="form-label" for="hours">Hours</label>
        <input class="form-control" id="hours" name="hours" type="number" step="0.01" required />
      </div>
      <div class="mb-3">
        <label class="form-label" for="person_id">Person ID</label>
        <input class="form-control" id="person_id" name="person_id" type="number" required />
      </div>
      <div class="mb-3">
        <label class="form-label" for="work_date">Work Date</label>
        <input class="form-control" id="work_date" name="work_date" type="date" required />
      </div>
      <div class="mb-3">
        <label class="form-label" for="rate">Rate</label>
        <input class="form-control" id="rate" name="rate" type="number" step="0.01" />
      </div>
      <div class="mb-3">
        <label class="form-label" for="invoice_id">Invoice</label>
        <select class="form-select" id="invoice_id" name="invoice_id">
          <option value="">-- none --</option>
          <?php foreach($invoices as $i): ?>
            <option value="<?= $i['id']; ?>"><?= h($i['invoice_number']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php if (user_has_permission('admin_time_tracking','create')): ?>
        <button class="btn btn-primary" type="submit">Add Entry</button>
      <?php endif; ?>
    </form>
  </div>
  <div class="col-lg-8">
    <div id="timeEntryList" data-list='{"valueNames":["memo","hours","invoice"],"page":25,"pagination":true}'>
      <div class="bg-body-emphasis border-top border-bottom border-translucent position-relative top-1 mx-n4 px-4">
        <div class="row g-0 text-body-tertiary fw-bold fs-10 py-2">
          <div class="col px-2 sort" data-sort="memo">Description</div>
          <div class="col px-2 sort" data-sort="hours">Hours</div>
          <div class="col px-2 sort" data-sort="invoice">Invoice</div>
        </div>
        <div class="list">
          <?php foreach($entries as $e): ?>
            <div class="row g-0 border-bottom py-2">
              <div class="col px-2 memo"><?= h($e['memo']); ?></div>
              <div class="col px-2 hours"><?= h($e['hours']); ?></div>
              <div class="col px-2 invoice"><?= h($e['invoice_number'] ?? ''); ?></div>
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
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var listEl = document.getElementById('timeEntryList');
  if (listEl) {
    var options = window.phoenix.utils.getData(listEl, 'list');
    new window.List(listEl, options);
  }
  var form = document.getElementById('timeEntryForm');
  if (form) {
    form.addEventListener('submit', function(e){
      e.preventDefault();
      var fd = new FormData(form);
      fetch('functions/create.php', {method:'POST', body:fd})
        .then(r=>r.json())
        .then(data=>{ if(data.success){ location.reload(); } else { alert(data.error||'Error'); } });
    });
  }
});
</script>
<?php require '../../admin_footer.php'; ?>
