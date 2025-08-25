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
$categories = get_lookup_items($pdo, 'PRODUCT_SERVICE_CATEGORY');

// Fetch product/service records with related info
$stmt = $pdo->query("SELECT ps.id, ps.name, ps.price,
                            ps.type_id, t.label AS type_label,
                            ps.status_id, s.label AS status_label,
                            GROUP_CONCAT(DISTINCT cat_li.id SEPARATOR '||') AS category_ids,
                            GROUP_CONCAT(DISTINCT cat_li.label SEPARATOR '||') AS category_labels
                      FROM module_products_services ps
                      JOIN lookup_list_items t ON ps.type_id = t.id
                      JOIN lookup_list_items s ON ps.status_id = s.id
                      LEFT JOIN module_products_services_category mpsc ON ps.id = mpsc.product_service_id
                      LEFT JOIN lookup_list_items cat_li ON mpsc.category_id = cat_li.id
                      GROUP BY ps.id, ps.name, ps.price, ps.type_id, type_label, ps.status_id, status_label
                      ORDER BY ps.name");
$itemsRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);
$items = [];
foreach($itemsRaw as $row){
  $row['category_ids'] = $row['category_ids'] ? explode('||', $row['category_ids']) : [];
  $row['category_labels'] = $row['category_labels'] ? explode('||', $row['category_labels']) : [];
  $items[] = $row;
}
?>
<h2 class="mb-4">Products &amp; Services</h2>
<?php if($message): ?><div class="alert alert-success"><?= h($message); ?></div><?php endif; ?>
<div id="products" data-list='{"valueNames":["product","price","category","type","status"],"page":10,"pagination":true}'>
  <div class="mb-4 d-flex flex-wrap gap-3">
    <div class="search-box">
      <form class="position-relative">
        <input class="form-control search-input search" type="search" placeholder="Search products" aria-label="Search" />
        <span class="fas fa-search search-box-icon"></span>
      </form>
    </div>
    <div class="btn-group">
      <button class="btn btn-phoenix-secondary px-7 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Category
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item filter-category" data-category="" href="#">All</a></li>
        <?php foreach($categories as $c): ?>
          <li><a class="dropdown-item filter-category" data-category="<?= $c['id']; ?>" href="#"><?= h($c['label']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="ms-auto">
      <?php if(user_has_permission('products_services','create')): ?>
      <a class="btn btn-primary" id="addBtn" href="edit.php"><span class="fas fa-plus me-2"></span>Add product</a>
      <?php endif; ?>
    </div>
  </div>
  <div class="table-responsive scrollbar">
    <table class="table fs-9 mb-0">
      <thead>
        <tr>
          <th class="sort" scope="col" data-sort="product">PRODUCT NAME</th>
          <th class="sort text-end" scope="col" data-sort="price" style="width:150px;">PRICE</th>
          <th class="sort" scope="col" data-sort="category" style="width:200px;">CATEGORIES</th>
          <th class="sort" scope="col" data-sort="type" style="width:150px;">TYPE</th>
          <th class="sort" scope="col" data-sort="status" style="width:150px;">STATUS</th>
          <th class="text-end" scope="col"></th>
        </tr>
      </thead>
      <tbody class="list">
        <?php foreach($items as $i): ?>
        <tr data-category="<?= implode('|',$i['category_ids']); ?>">
          <td class="product fw-semibold text-body-emphasis"><?= h($i['name']); ?></td>
          <td class="price text-end"><?= $i['price'] !== null ? '$'.number_format($i['price'],2) : ''; ?></td>
          <td class="category">
            <?php foreach($i['category_labels'] as $cl): ?>
              <span class="badge bg-info text-dark me-1"><?= h($cl); ?></span>
            <?php endforeach; ?>
          </td>
          <td class="type"><?= h($i['type_label']); ?></td>
          <td class="status"><?= h($i['status_label']); ?></td>
          <td class="text-end">
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
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
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
  var el=document.getElementById('products');
  if(el){
    var list=new window.List(el,window.phoenix.utils.getData(el,'list'));
    document.querySelectorAll('.filter-category').forEach(function(link){
      link.addEventListener('click',function(e){
        e.preventDefault();
        var cat=this.getAttribute('data-category');
        list.filter(function(item){
          if(!cat) return true;
          var cats=item.elm.getAttribute('data-category');
          return cats && cats.split('|').indexOf(cat)!==-1;
        });
      });
    });
  }
});
</script>
<?php require '../admin_footer.php'; ?>
