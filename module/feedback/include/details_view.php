<?php
// Details view for a feedback item
?>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><?php echo h($feedbackItem['title'] ?? 'Feedback'); ?></h5>
    <div>
      <?php if (user_has_permission('feedback', 'update')): ?>
        <a href="?action=edit&id=<?= (int)$feedbackItem['id']; ?>" class="btn btn-warning btn-sm me-1">Edit</a>
      <?php endif; ?>
      <?php if (user_has_permission('feedback', 'delete')): ?>
        <form action="functions/delete.php" method="post" class="d-inline" onsubmit="return confirm('Delete this feedback?');">
          <input type="hidden" name="id" value="<?= (int)$feedbackItem['id']; ?>">
          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
  <div class="card-body">
    <p><strong>Type:</strong> <?php echo h($typeMap[$feedbackItem['type']]['label'] ?? ''); ?></p>
    <p><?php echo nl2br(h($feedbackItem['description'] ?? '')); ?></p>
  </div>
</div>
