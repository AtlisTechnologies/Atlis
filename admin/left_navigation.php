<?php
$stmt = $pdo->query('SELECT title, path, icon FROM admin_navigation_links ORDER BY sort_order');
$navLinks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Determine the current request path relative to /admin/
$requestUri = $_SERVER['SCRIPT_NAME'];

// Normalize a path by removing any base directory and trailing /index.php
$normalize = function(string $path): string {
    $path = preg_replace('#^.*?/admin/#', '', $path); // strips any base directory plus /admin/
    $path = preg_replace('#/index\\.php$#', '', $path);
    return trim($path, '/');
};

$currentPath = $normalize($requestUri);
?>
<nav class="navbar navbar-vertical navbar-expand-lg">
  <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <div class="navbar-vertical-content">
      <ul class="navbar-nav flex-column" id="navbarVerticalNav">
<?php foreach ($navLinks as $link): ?>
<?php
        $linkPath = $normalize($link['path']);
        $linkDir = trim(dirname($linkPath), '/');
        if ($linkDir === '') {
            $linkDir = $linkPath;
        }
        $isActive = $currentPath === $linkPath || str_starts_with($currentPath, $linkDir . '/');
        ?>
        <li class="nav-item">
          <a class="nav-link<?= $isActive ? ' active' : ''; ?>"
             href="<?= getURLDir(); ?>admin/<?= e($link['path']); ?>"
             <?= $isActive ? 'aria-current="page"' : ''; ?>>
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span data-feather="<?= e($link['icon']); ?>"></span></span><span class="nav-link-text"><?= e($link['title']); ?></span></div>
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
