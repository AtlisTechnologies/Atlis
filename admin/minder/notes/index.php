<?php
require_once __DIR__ . '/../../admin_header.php';
require_permission('minder_note', 'read');

$notesStmt = $pdo->query("SELECT n.id, n.title, n.body, n.date_created, u.email AS user_email
                           FROM admin_minder_notes n
                           LEFT JOIN users u ON n.user_id = u.id
                           ORDER BY n.date_created DESC");
$notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Minder Notes</h2>
<?php if (user_has_permission('minder_note','create')): ?>
  <a href="note.php" class="btn btn-success mb-3"><span class="fa-solid fa-plus"></span><span class="visually-hidden">Add</span></a>
<?php endif; ?>
<div class="timeline-basic mb-9">
  <?php foreach ($notes as $note): ?>
  <div class="timeline-item">
    <div class="row g-3">
      <div class="col-auto">
        <div class="timeline-item-bar position-relative">
          <div class="icon-item icon-item-md rounded-7 border border-translucent"><span class="fa-solid fa-note-sticky text-info fs-9"></span></div><span class="timeline-bar border-end border-dashed"></span>
        </div>
      </div>
      <div class="col">
        <div class="d-flex justify-content-between">
          <div class="d-flex mb-2">
            <h6 class="lh-sm mb-0 me-2 text-body-secondary timeline-item-title"><a class="text-body" href="note.php?id=<?= $note['id']; ?>"><?= e($note['title']); ?></a></h6>
          </div>
          <p class="text-body-quaternary fs-9 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span><?= e(date('M j, Y g:i a', strtotime($note['date_created']))); ?></p>
        </div>
        <h6 class="fs-10 fw-normal mb-3">by <a class="fw-semibold" href="#">"><?= e($note['user_email'] ?? ''); ?></a></h6>
        <p class="fs-9 text-body-secondary w-sm-60 mb-5"><?= nl2br(e($note['body'])); ?></p>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/../../admin_footer.php'; ?>
