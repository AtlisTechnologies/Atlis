<?php
require '../admin_header.php';
require_permission('products_services','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';
if(isset($_GET['msg'])){
  if($_GET['msg'] === 'deleted') $message = 'Record deleted.';
  if($_GET['msg'] === 'saved') $message = 'Record saved.';
}

$stmt = $pdo->query('SELECT id, name FROM module_products_services ORDER BY name');
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Products &amp; Services</h2>
<?php if($message): ?><div class="alert alert-success"><?= h($message); ?></div><?php endif; ?>
<div id="psList" data-list='{"valueNames":["id","name"],"page":25,"pagination":true}'>
  <div class="row g-3 justify-content-between mb-4">
    <div class="col-auto">
      <?php if(user_has_permission('products_services','create')): ?>
      <a class="btn btn-success" href="edit.php"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></a>
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
  <div class="bg-body-emphasis border-top border-bottom border-translucent position-relative top-1 mx-n4 px-4 mx-lg-n6 px-lg-6">
    <div class="row g-0 text-body-tertiary fw-bold fs-10 py-2">
      <div class="col-auto px-2" style="width:120px;">Actions</div>
      <div class="col px-2 sort" data-sort="id">ID</div>
      <div class="col px-2 sort" data-sort="name">Name</div>
    </div>
    <div class="list">
      <?php foreach($items as $i): ?>
      <div class="row g-0 align-items-center border-bottom py-2">
        <div class="col-auto px-2" style="width:120px;">
          <?php if(user_has_permission('products_services','update')): ?>
          <a class="btn btn-warning btn-sm me-1" href="edit.php?id=<?= $i['id']; ?>" title="Edit"><span class="fa-solid fa-pen"></span></a>
          <?php endif; ?>
          <?php if(user_has_permission('products_services','delete')): ?>
          <form method="post" action="functions/delete.php" class="d-inline">
            <input type="hidden" name="id" value="<?= $i['id']; ?>">
            <input type="hidden" name="csrf_token" value="<?= $token; ?>">
            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this record?');" title="Delete"><span class="fa-solid fa-trash"></span></button>
          </form>
          <?php endif; ?>
        </div>
        <div class="col px-2 id"><?= h($i['id']); ?></div>
        <div class="col px-2 name"><?= h($i['name']); ?></div>
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
<script>
document.addEventListener('DOMContentLoaded',function(){
  var el=document.getElementById('psList');
  if(el){ var options=window.phoenix.utils.getData(el,'list'); new window.List(el,options); }
});
</script>
<?php require '../admin_footer.php'; ?>
