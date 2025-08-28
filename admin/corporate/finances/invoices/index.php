<?php
require '../../../admin_header.php';
require_permission('admin_finances_invoices','read');

$invoiceStmt = $pdo->query('SELECT id, invoice_number, total_amount FROM admin_finances_invoices ORDER BY date_created DESC');
$invoices = $invoiceStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Invoices</h2>
<div id="invoiceList" data-list='{"valueNames":["id","invoice_number","total_amount"],"page":25,"pagination":true}'>
  <div class="row g-3 justify-content-between mb-4">
    <div class="col-auto">
      <?php if (user_has_permission('admin_finances_invoices','create')): ?>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#invoiceModal"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></button>
      <?php endif; ?>
    </div>
    <div class="col-auto">
      <div class="search-box">
        <form class="position-relative">
          <input class="form-control search-input search" type="search" placeholder="Search invoices" aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
    </div>
  </div>
  <div class="bg-body-emphasis border-top border-bottom border-translucent position-relative top-1 mx-n4 px-4">
    <div class="row g-0 text-body-tertiary fw-bold fs-10 py-2">
      <div class="col px-2 sort" data-sort="id">ID</div>
      <div class="col px-2 sort" data-sort="invoice_number">Invoice #</div>
      <div class="col px-2 sort" data-sort="total_amount">Total Amount</div>
      <div class="col px-2">Entries</div>
    </div>
    <div class="list">
      <?php foreach($invoices as $inv): ?>
        <?php
          $timeStmt = $pdo->prepare('SELECT id, memo, hours FROM admin_time_tracking_entries WHERE invoice_id = :iid');
          $timeStmt->execute([':iid' => $inv['id']]);
          $timeEntries = $timeStmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="row g-0 border-bottom py-2">
          <div class="col px-2 id"><?= h($inv['id']); ?></div>
          <div class="col px-2 invoice_number"><?= h($inv['invoice_number']); ?></div>
          <div class="col px-2 total_amount"><?= h($inv['total_amount']); ?></div>
          <div class="col px-2">
            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#timeEntries<?= $inv['id']; ?>">View</button>
          </div>
        </div>
        <div class="modal fade" id="timeEntries<?= $inv['id']; ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
              <div class="modal-header">
                <h5 class="modal-title">Time Entries for Invoice <?= h($inv['id']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <?php if($timeEntries): ?>
                  <ul class="list-group">
                    <?php foreach($timeEntries as $te): ?>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="../../time-tracking/index.php?id=<?= $te['id']; ?>" class="text-decoration-none">
                          <?= h($te['memo']); ?>
                        </a>
                        <span class="badge bg-primary rounded-pill"><?= h($te['hours']); ?>h</span>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php else: ?>
                  <p class="mb-0">No time entries linked.</p>
                <?php endif; ?>
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

<div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Invoice</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="invoiceForm">
          <div class="mb-3">
            <label class="form-label" for="invoice_number">Invoice #</label>
            <input class="form-control" id="invoice_number" name="invoice_number" type="text" required />
          </div>
          <div class="mb-3">
            <label class="form-label" for="status_id">Status ID</label>
            <input class="form-control" id="status_id" name="status_id" type="number" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="bill_to">Bill To</label>
            <input class="form-control" id="bill_to" name="bill_to" type="text" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="invoice_date">Invoice Date</label>
            <input class="form-control" id="invoice_date" name="invoice_date" type="date" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="due_date">Due Date</label>
            <input class="form-control" id="due_date" name="due_date" type="date" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="total_amount">Total Amount</label>
            <input class="form-control" id="total_amount" name="total_amount" type="number" step="0.01" />
          </div>
          <button class="btn btn-primary" type="submit">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var invoiceList = document.getElementById('invoiceList');
  if (invoiceList) {
    var options = window.phoenix.utils.getData(invoiceList, 'list');
    new window.List(invoiceList, options);
  }
  var invoiceForm = document.getElementById('invoiceForm');
  if (invoiceForm) {
    invoiceForm.addEventListener('submit', function(e){
      e.preventDefault();
      var fd = new FormData(invoiceForm);
      fetch('functions/create.php', {method: 'POST', body: fd})
        .then(r => r.json())
        .then(data => { if(data.success){ location.reload(); } else { alert(data.error || 'Error'); } });
    });
  }
});
</script>
<?php require '../../../admin_footer.php'; ?>
