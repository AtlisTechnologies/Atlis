<?php
require '../../../admin_header.php';
require_permission('admin_finances_statements_of_work','read');

$sowStmt = $pdo->query('SELECT id, title, status_id FROM admin_finances_statements_of_work ORDER BY date_created DESC');
$sows = $sowStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Statements of Work</h2>
<div id="sowList" data-list='{"valueNames":["id","title"],"page":25,"pagination":true}'>
  <div class="row g-3 justify-content-between mb-4">
    <div class="col-auto">
      <?php if (user_has_permission('admin_finances_statements_of_work','create')): ?>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sowModal"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></button>
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
      <div class="col px-2 sort" data-sort="id">ID</div>
      <div class="col px-2 sort" data-sort="title">Title</div>
    </div>
    <div class="list">
      <?php foreach($sows as $sow): ?>
        <div class="row g-0 border-bottom py-2">
          <div class="col px-2 id"><?= h($sow['id']); ?></div>
          <div class="col px-2 title"><?= h($sow['title']); ?></div>
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

<div class="modal fade" id="sowModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Statement of Work</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="sowForm">
          <div class="mb-3">
            <label class="form-label" for="title">Title</label>
            <input class="form-control" id="title" name="title" type="text" required />
          </div>
          <div class="mb-3">
            <label class="form-label" for="details">Details</label>
            <textarea class="form-control" id="details" name="details"></textarea>
          </div>
          <button class="btn btn-primary" type="submit">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var listEl = document.getElementById('sowList');
  if (listEl) {
    var options = window.phoenix.utils.getData(listEl, 'list');
    new window.List(listEl, options);
  }
  var sowForm = document.getElementById('sowForm');
  if (sowForm) {
    sowForm.addEventListener('submit', function(e){
      e.preventDefault();
      var fd = new FormData(sowForm);
      fetch('functions/create.php', {method:'POST', body:fd})
        .then(r=>r.json())
        .then(data=>{ if(data.success){ location.reload(); } else { alert(data.error||'Error'); } });
    });
  }
});
</script>
<?php require '../../../admin_footer.php'; ?>
