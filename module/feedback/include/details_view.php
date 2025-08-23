<?php
// Details view for a feedback item
?>
<div class="card">
  <div class="card-header">
    <h5 class="mb-0"><?php echo h($feedbackItem['title'] ?? 'Feedback'); ?></h5>
  </div>
  <div class="card-body">
    <p><strong>Type:</strong> <?php echo h($typeMap[$feedbackItem['type']]['label'] ?? ''); ?></p>
    <p><?php echo nl2br(h($feedbackItem['description'] ?? '')); ?></p>
  </div>
</div>
