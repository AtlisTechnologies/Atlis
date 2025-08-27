<?php
?>
<div class="container py-4">
  <div class="card">
    <div class="card-body">
      <h2 class="mb-3"><?= h($conference['name'] ?? '') ?></h2>
      <p>
        <?php if (!empty($conference['start_datetime'])): ?>
          <span class="fas fa-calendar me-2"></span>
          <?= h(date('l, F j, Y g:i A', strtotime($conference['start_datetime']))) ?>
          <?php if (!empty($conference['end_datetime'])): ?>
            &ndash; <?= h(date('l, F j, Y g:i A', strtotime($conference['end_datetime']))) ?>
          <?php endif; ?>
        <?php endif; ?>
      </p>
      <?php if (!empty($conference['venue'])): ?>
        <p><span class="fas fa-location-dot me-2"></span><?= h($conference['venue']) ?></p>
      <?php endif; ?>
      <?php if (!empty($conference['type'])): ?><p><strong>Type:</strong> <?= h($conference['type']) ?></p><?php endif; ?>
      <?php if (!empty($conference['topic'])): ?><p><strong>Topic:</strong> <?= h($conference['topic']) ?></p><?php endif; ?>
      <?php if (!empty($conference['mode'])): ?><p><strong>Mode:</strong> <?= h($conference['mode']) ?></p><?php endif; ?>
      <?php if (!empty($conference['organizers'])): ?><p><strong>Organizers:</strong> <?= nl2br(h($conference['organizers'])) ?></p><?php endif; ?>
      <?php if (!empty($conference['sponsors'])): ?><p><strong>Sponsors:</strong> <?= nl2br(h($conference['sponsors'])) ?></p><?php endif; ?>
      <?php if (!empty($conference['tags'])): ?><p><strong>Tags:</strong> <?= h($conference['tags']) ?></p><?php endif; ?>
      <?php if (!empty($conference['ticket_options'])): ?><p><strong>Ticket Options:</strong> <?= nl2br(h($conference['ticket_options'])) ?></p><?php endif; ?>
      <?php if (!empty($conference['custom_fields'])): ?><p><strong>Custom Fields:</strong> <?= nl2br(h($conference['custom_fields'])) ?></p><?php endif; ?>
      <div><?= nl2br(h($conference['description'] ?? '')) ?></div>
    </div>
  </div>
</div>
