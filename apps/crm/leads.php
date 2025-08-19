<?php
require '../../includes/php_header.php';
require_permission('person','read');

$stmt = $pdo->query('SELECT id, first_name, last_name, email FROM person WHERE user_id IS NULL ORDER BY last_name, first_name');
$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php // require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <h2 class="mb-4">Leads</h2>
    <div id="leads" data-list='{"valueNames":["name","email"],"page":20,"pagination":true}'>
      <div class="row justify-content-between g-2 mb-3">
        <div class="col-auto">
          <input class="form-control form-control-sm search" placeholder="Search" />
        </div>
      </div>
      <div class="row g-3 list">
        <?php foreach($leads as $p): ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column justify-content-between">
              <div>
                <h5 class="name mb-1"><?= htmlspecialchars(trim(($p['first_name'] ?? '') . ' ' . ($p['last_name'] ?? ''))); ?></h5>
                <?php if($p['email']): ?>
                  <p class="email text-muted small mb-2"><?= htmlspecialchars($p['email']); ?></p>
                <?php endif; ?>
              </div>
              <div>
                <a class="btn btn-sm btn-warning" href="../../admin/person/edit.php?id=<?= $p['id']; ?>">Edit</a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="mb-0" data-list-info></p>
        <ul class="pagination mb-0"></ul>
      </div>
    </div>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
