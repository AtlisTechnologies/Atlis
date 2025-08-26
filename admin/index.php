<?php
require 'admin_header.php';
$modules = require __DIR__ . '/modules.php';
?>
<h2 class="mb-4">Admin Dashboard</h2>
<div class="row g-3">
  <?php foreach ($modules as $module): ?>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title"><span class="me-2" data-feather="<?= e($module['icon']); ?>"></span><?= e($module['title']); ?></h5>
          <p class="card-text"><?php if(isset($module['memo'])){ e($module['memo']); } ?></p>
          <a href="<?= e($module['path']); ?>" class="btn btn-primary btn-sm">Manage</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php require 'admin_footer.php'; ?>
