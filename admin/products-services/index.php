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

// Filter dropdown data
$types = get_lookup_items($pdo, 'PRODUCT_SERVICE_TYPE');
$statuses = get_lookup_items($pdo, 'PRODUCT_SERVICE_STATUS');
$catStmt = $pdo->query('SELECT DISTINCT li.id, li.label FROM module_products_services_person mpsp JOIN lookup_list_items li ON mpsp.skill_id = li.id ORDER BY li.label');
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch product/service records with related info
$stmt = $pdo->query("SELECT ps.id, ps.name, ps.price,
                            ps.type_id, t.label AS type_label,
                            ps.status_id, s.label AS status_label,
                            GROUP_CONCAT(DISTINCT cat_li.id SEPARATOR '||') AS category_ids,
                            GROUP_CONCAT(DISTINCT cat_li.label SEPARATOR '||') AS category_labels,
                            GROUP_CONCAT(DISTINCT CONCAT(pe.first_name,' ',pe.last_name) SEPARATOR '||') AS people
                      FROM module_products_services ps
                      JOIN lookup_list_items t ON ps.type_id = t.id
                      JOIN lookup_list_items s ON ps.status_id = s.id
                      LEFT JOIN module_products_services_person mpsp ON ps.id = mpsp.product_service_id
                      LEFT JOIN lookup_list_items cat_li ON mpsp.skill_id = cat_li.id
                      LEFT JOIN person pe ON mpsp.person_id = pe.id
                      GROUP BY ps.id, ps.name, ps.price, ps.type_id, type_label, ps.status_id, status_label
                      ORDER BY ps.name");
$itemsRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);
$items = [];
foreach($itemsRaw as $row){
  $row['category_ids'] = $row['category_ids'] ? explode('||', $row['category_ids']) : [];
  $row['category_labels'] = $row['category_labels'] ? explode('||', $row['category_labels']) : [];
  $row['people'] = $row['people'] ? explode('||', $row['people']) : [];
  $items[] = $row;
}
?>
<h2 class="mb-4">Products &amp; Services</h2>
<?php if($message): ?><div class="alert alert-success"><?= h($message); ?></div><?php endif; ?>
<div id="psList" data-list='{"valueNames":["ps-name",{"data":["type","status","category"]}],"page":12,"pagination":true}'>
  <div class="row g-3 justify-content-between mb-4">
    <div class="col-auto">
      <?php if(user_has_permission('products_services','create')): ?>
      <a class="btn btn-success" href="edit.php"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></a>
      <?php endif; ?>
    </div>
    <div class="col">
      <div class="row g-2">
        <div class="col-md">
          <select class="form-select" id="filterType">
            <option value="">All Types</option>
            <?php foreach($types as $t): ?>
              <option value="<?= $t['id']; ?>"><?= h($t['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md">
          <select class="form-select" id="filterStatus">
            <option value="">All Statuses</option>
            <?php foreach($statuses as $s): ?>
              <option value="<?= $s['id']; ?>"><?= h($s['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md">
          <select class="form-select" id="filterCategory">
            <option value="">All Categories</option>
            <?php foreach($categories as $c): ?>
              <option value="<?= $c['id']; ?>"><?= h($c['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-auto">
          <div class="search-box">
            <form class="position-relative">
              <input class="form-control search-input search" type="search" placeholder="Search" aria-label="Search" />
              <span class="fas fa-search search-box-icon"></span>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row list row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <?php foreach($items as $i): ?>
    <div class="col" data-type="<?= $i['type_id']; ?>" data-status="<?= $i['status_id']; ?>" data-category="<?= implode('|',$i['category_ids']); ?>">
      <div class="card h-100">
        <div class="card-body d-flex flex-column">
          <h5 class="mb-2 ps-name"><?= h($i['name']); ?></h5>
          <p class="mb-1"><span class="badge bg-secondary"><?= h($i['type_label']); ?></span></p>
          <p class="mb-1"><span class="badge bg-primary"><?= h($i['status_label']); ?></span></p>
          <div class="mb-2 ps-category">
            <?php foreach($i['category_labels'] as $cl): ?>
              <span class="badge bg-info text-dark me-1"><?= h($cl); ?></span>
            <?php endforeach; ?>
          </div>
          <p class="fw-semibold mb-2 ps-price"><?= $i['price'] !== null ? '$'.number_format($i['price'],2) : ''; ?></p>
          <div class="mt-auto ps-people">
            <?php foreach($i['people'] as $p): ?>
              <span class="badge bg-secondary me-1"><?= h($p); ?></span>
            <?php endforeach; ?>
          </div>
          <div class="pt-2">
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
        </div>
      </div>
    </div>
    <?php endforeach; ?>
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
  if(el){
    var options=window.phoenix.utils.getData(el,'list');
    var list=new window.List(el,options);
    var t=document.getElementById('filterType');
    var s=document.getElementById('filterStatus');
    var c=document.getElementById('filterCategory');
    function update(){
      var tv=t.value, sv=s.value, cv=c.value;
      list.filter(function(item){
        var match=true;
        if(tv && item.values().type!==tv) match=false;
        if(sv && item.values().status!==sv) match=false;
        if(cv){
          var cats=item.values().category?item.values().category.split('|'):[];
          if(cats.indexOf(cv)===-1) match=false;
        }
        return match;
      });
    }
    t.addEventListener('change',update);
    s.addEventListener('change',update);
    c.addEventListener('change',update);
  }
});
</script>
<?php require '../admin_footer.php'; ?>
