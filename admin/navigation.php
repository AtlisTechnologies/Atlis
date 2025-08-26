<?php
require 'admin_header.php';
require_permission('navigation_links','read');

$token = generate_csrf_token();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }
    if (isset($_POST['create_nav_link'])) {
        require_permission('navigation_links','create');
        $title = trim($_POST['name'] ?? '');
        $path  = trim($_POST['path'] ?? '');
        $icon  = trim($_POST['icon'] ?? '');
        if ($title !== '' && $path !== '') {
            $sort_order = $pdo->query('SELECT COALESCE(MAX(sort_order),0)+1 FROM admin_navigation_links')->fetchColumn();
            $stmt = $pdo->prepare('INSERT INTO admin_navigation_links (title, path, icon, sort_order, user_id, user_updated) VALUES (:title,:path,:icon,:sort,:uid,:uid)');
            $stmt->execute([
                ':title' => $title,
                ':path' => $path,
                ':icon' => $icon,
                ':sort' => $sort_order,
                ':uid'  => $this_user_id
            ]);
            $message = 'Navigation link created.';
        }
    } else {
        require_permission('navigation_links','update');
        $order = isset($_POST['order']) ? explode(',', $_POST['order']) : [];
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('UPDATE admin_navigation_links SET sort_order = :sort WHERE id = :id');
        foreach ($order as $index => $id) {
            $id = (int)$id;
            if ($id > 0) {
                $stmt->execute([':sort' => $index, ':id' => $id]);
            }
        }
        $pdo->commit();
        $message = 'Navigation order updated.';
    }
}

$stmt = $pdo->query('SELECT id, title, path FROM admin_navigation_links ORDER BY sort_order');
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<h2 class="mb-4">Navigation Links</h2>
<?php if ($message): ?>
  <div class="alert alert-success"><?= e($message); ?></div>
<?php endif; ?>
<button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createNavModal">Create Nav Link</button>
<form method="post" id="navForm">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="order" id="navOrder">
  <ul id="navList" class="list-group">
    <?php foreach ($links as $link): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center" data-id="<?= $link['id']; ?>">
        <span><?= e($link['title']); ?></span>
        <small class="text-muted"><?= e($link['path']); ?></small>
      </li>
    <?php endforeach; ?>
  </ul>
  <button type="submit" class="btn btn-primary mt-3">Save Order</button>
</form>
<div class="modal fade" id="createNavModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Nav Link</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <div class="mb-3">
          <label for="navName" class="form-label">Name</label>
          <input type="text" id="navName" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="navPath" class="form-label">Path</label>
          <input type="text" id="navPath" name="path" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="navIcon" class="form-label">Feather Icon</label>
          <input type="text" id="navIcon" name="icon" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="create_nav_link">Create</button>
      </div>
    </form>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function(){
  $('#navList').sortable();
  $('#navForm').on('submit', function(){
    var order = $('#navList').sortable('toArray', {attribute: 'data-id'});
    $('#navOrder').val(order.join(','));
  });
});
</script>
<?php require 'admin_footer.php'; ?>
