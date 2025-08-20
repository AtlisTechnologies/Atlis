<?php $modules = require __DIR__ . '/modules.php'; ?>
<nav class="navbar navbar-vertical navbar-expand-lg">
  <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <div class="navbar-vertical-content">
      <ul class="navbar-nav flex-column" id="navbarVerticalNav">
        <?php foreach ($modules as $module): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo getURLDir(); ?>admin/<?= htmlspecialchars($module['path']); ?>">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span data-feather="<?= htmlspecialchars($module['icon']); ?>"></span></span><span class="nav-link-text"><?= htmlspecialchars($module['title']); ?></span></div>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <div class="navbar-vertical-footer">
    <button class="btn btn-secondary navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center"><span class="uil uil-left-arrow-to-left fs-8"></span><span class="uil uil-arrow-from-right fs-8"></span><span class="navbar-vertical-footer-text ms-2">Collapsed View</span></button>
  </div>
</nav>
