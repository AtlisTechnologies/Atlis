<?php
require '../admin_header.php';
require_permission('navigation_links','read');

$token = generate_csrf_token();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }
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

$stmt = $pdo->query('SELECT id, title, url FROM admin_navigation_links ORDER BY sort_order');
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<h2 class="mb-4">Navigation Links</h2>
<?php if ($message): ?>
  <div class="alert alert-success"><?= htmlspecialchars($message); ?></div>
<?php endif; ?>
<form method="post" id="navForm">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <input type="hidden" name="order" id="navOrder">
  <ul id="navList" class="list-group">
    <?php foreach ($links as $link): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center" data-id="<?= $link['id']; ?>">
        <span><?= htmlspecialchars($link['title']); ?></span>
        <small class="text-muted"><?= htmlspecialchars($link['url']); ?></small>
      </li>
    <?php endforeach; ?>
  </ul>
  <button type="submit" class="btn btn-primary mt-3">Save Order</button>
</form>
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
<?php require '../admin_footer.php'; ?>
