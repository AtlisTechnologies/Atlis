<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_note','read');

$search = trim($_POST['search'] ?? '');
$category = $_POST['category'] !== '' ? (int)$_POST['category'] : null;
$status = $_POST['status'] !== '' ? (int)$_POST['status'] : null;

$sql = "SELECT n.id, n.title, n.body, n.date_created, u.email AS user_email
        FROM admin_minder_notes n
        LEFT JOIN users u ON n.user_id = u.id";
$conds = [];
$params = [];
if ($search !== '') {
  $conds[] = '(n.title LIKE :search OR n.body LIKE :search)';
  $params[':search'] = '%'.$search.'%';
}
if ($category) {
  $conds[] = 'n.category_id = :category';
  $params[':category'] = $category;
}
if ($status) {
  $conds[] = 'n.status_id = :status';
  $params[':status'] = $status;
}
if ($conds) {
  $sql .= ' WHERE '.implode(' AND ', $conds);
}
$sql .= ' ORDER BY n.date_created DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($notes as $note) {
  echo '<div class="timeline-item"><div class="row g-3"><div class="col-auto"><div class="timeline-item-bar position-relative"><div class="icon-item icon-item-md rounded-7 border border-translucent"><span class="fa-solid fa-note-sticky text-info fs-9"></span></div><span class="timeline-bar border-end border-dashed"></span></div></div><div class="col"><div class="d-flex justify-content-between"><div class="d-flex mb-2"><h6 class="lh-sm mb-0 me-2 text-body-secondary timeline-item-title"><a class="text-body" href="note.php?id=' . $note['id'] . '">' . e($note['title']) . '</a></h6></div><p class="text-body-quaternary fs-9 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>' . e(date('M j, Y g:i a', strtotime($note['date_created']))) . '</p></div><h6 class="fs-10 fw-normal mb-3">by <a class="fw-semibold" href="#">' . e($note['user_email'] ?? '') . '</a></h6><p class="fs-9 text-body-secondary w-sm-60 mb-5">' . $note['body'] . '</p></div></div></div>';
}
?>
