<?php
// Fetch admin navigation links for dashboard quick access
$stmt = $pdo->query('SELECT title, path, icon FROM admin_navigation_links ORDER BY sort_order');
$navLinks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="mb-2 lh-sm" data-anchor="data-anchor">Atlisware | 4.0</h2>
<p class="text-body-tertiary lead mb-2">Welcome to Atlisware, Atlis Technologies' all-in-one platform for managing projects, tasks, people, agencies and finances.</p>

<div class="jumbotron mt-4">
  <h1 class="display-4">Dashboard</h1>
  <p class="lead">Review recent activity and quickly jump to the modules that keep your work moving.</p>
  <hr class="my-4">
  <p>Use the navigation to explore projects, assign tasks, update contacts and monitor finances.</p>

  <?php if (!empty($navLinks)): ?>
  <div class="row g-3 mt-4">
    <?php foreach ($navLinks as $link): ?>
    <div class="col-6 col-md-4 col-lg-3">
      <a class="btn btn-outline-primary w-100 text-start d-flex align-items-center" href="<?= getURLDir(); ?>admin/<?= e($link['path']); ?>">
        <span data-feather="<?= e($link['icon'] ?: 'circle'); ?>" class="me-2"></span>
        <span><?= e($link['title']); ?></span>
      </a>
      <small class="text-body-secondary d-block ms-4"><?= e($link['path']); ?></small>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  if (window.feather) {
    window.feather.replace();
  }
});
</script>

