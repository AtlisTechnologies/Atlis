<?php
require '../admin_header.php';
require_permission('contractors', 'read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  require_permission('contractors', 'delete');
  $delId = (int)$_POST['delete_id'];
  $stmt = $pdo->prepare('DELETE FROM module_contractors WHERE id = :id');
  $stmt->execute([':id' => $delId]);
  admin_audit_log($pdo, $this_user_id, 'module_contractors', $delId, 'DELETE', null, null, 'Deleted contractor');
  $message = 'Contractor deleted.';
}

$statusItems = get_lookup_items($pdo, 'CONTRACTOR_STATUS');
$statusMap   = array_column($statusItems, null, 'id');

$sql = "SELECT mc.id,
               p.first_name,
               p.last_name,
               p.email,
               mc.start_date,
               s.label AS status_label,
               COALESCE(sa.attr_value, 'secondary') AS status_color,
               t.label AS contractor_type,
               upp.file_path
        FROM module_contractors mc
        LEFT JOIN person p ON mc.person_id = p.id
        LEFT JOIN lookup_list_items s ON mc.status_id = s.id
        LEFT JOIN lookup_list_item_attributes sa ON s.id = sa.item_id AND sa.attr_code = 'COLOR-CLASS'
        LEFT JOIN lookup_list_items t ON mc.contractor_type_id = t.id
        LEFT JOIN users u ON p.user_id = u.id
        LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id
        ORDER BY p.last_name, p.first_name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$contractors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Contractors</h2>
<?php if($message){ echo '<div class="alert alert-success">'.h($message).'</div>'; } ?>
<div id="contractorsList" data-list='{"valueNames":["id","name","email","status","start"],"page":25,"pagination":true}'>
  <div class="row g-3 justify-content-between mb-4">
    <div class="col-auto">
      <?php if (user_has_permission('contractors','create')): ?>
        <a href="contractor.php" class="btn btn-success"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></a>
      <?php endif; ?>
      <button class="btn btn-link text-body px-0"><span class="fa-solid fa-file-export fs-9 me-2"></span>Export</button>
    </div>
    <div class="col-auto">
      <div class="search-box">
        <form class="position-relative">
          <input class="form-control search-input search" type="search" placeholder="Search by name" aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
    </div>
  </div>
  <div class="bg-body-emphasis border-top border-bottom border-translucent position-relative top-1 mx-n4 px-4 mx-lg-n6 px-lg-6">
    <div class="row g-0 text-body-tertiary fw-bold fs-10 py-2">
      <div class="col-auto px-2" style="width:120px;">Actions</div>
      <div class="col px-2 sort" data-sort="id">Contractor ID</div>
      <div class="col px-2 sort" data-sort="name">Name</div>
      <div class="col px-2 sort" data-sort="email">Email</div>
      <div class="col px-2 sort" data-sort="status">Status</div>
      <div class="col px-2 sort" data-sort="start">Start Date</div>
    </div>
    <div class="list" id="contractor-table-body">
      <?php foreach($contractors as $c): ?>
        <?php $fullName = trim(($c['first_name'] ?? '') . ' ' . ($c['last_name'] ?? '')); ?>
        <?php $pic = !empty($c['file_path']) ? $c['file_path'] : 'assets/img/team/avatar.webp'; ?>
        <div class="row g-0 align-items-center border-bottom py-2">
          <div class="col-auto px-2" style="width:120px;">
            <?php if (user_has_permission('contractors','update')): ?>
              <a class="btn btn-warning btn-sm me-1" href="contractor.php?id=<?= $c['id']; ?>" title="Edit">
                <span class="fa-solid fa-pen"></span><span class="visually-hidden">Edit</span>
              </a>
            <?php endif; ?>
            <?php if (user_has_permission('contractors','delete')): ?>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_id" value="<?= $c['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this contractor?');" title="Delete">
                  <span class="fa-solid fa-trash"></span><span class="visually-hidden">Delete</span>
                </button>
              </form>
            <?php endif; ?>
          </div>
          <div class="col px-2 id"><?= h($c['id']); ?></div>
          <div class="col px-2 name">
            <div class="d-flex align-items-center">
              <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir() . h($pic); ?>">
                <img class="rounded-circle avatar avatar-m me-2" src="<?php echo getURLDir() . h($pic); ?>" alt="" />
              </a>
              <a class="text-body" href="contractor.php?id=<?= $c['id']; ?>"><?= h($fullName ?: 'Unknown Person'); ?></a>
            </div>
          </div>
          <div class="col px-2 email"><a href="mailto:<?= h($c['email'] ?? ''); ?>"><?= h($c['email'] ?? ''); ?></a></div>
          <div class="col px-2 phone"><?= h($c['phone'] ?? ''); ?></div>
          <div class="col px-2 status">
            <?php if (!empty($c['status_label'])): ?>
              <span class="badge badge-phoenix-<?= h($c['status_color'] ?? 'secondary'); ?>">
                <?= h($c['status_label']); ?>
              </span>
            <?php endif; ?>
          </div>
          <div class="col px-2 start"><?= !empty($c['start_date']) ? h(date('M jS, Y', strtotime($c['start_date']))) : ''; ?></div>
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
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-body p-0"><img src="" alt="" class="img-fluid w-100 rounded-top" /></div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var contractorsEl = document.getElementById('contractorsList');
  if (contractorsEl) {
    var options = window.phoenix.utils.getData(contractorsEl, 'list');
    new window.List(contractorsEl, options);
  }
  var imageModal = document.getElementById('imageModal');
  if (imageModal) {
    imageModal.addEventListener('show.bs.modal', function (event) {
      var img = imageModal.querySelector('img');
      var src = event.relatedTarget.getAttribute('data-img-src');
      img.src = src;
    });
  }
});
</script>
<?php require '../admin_footer.php'; ?>
