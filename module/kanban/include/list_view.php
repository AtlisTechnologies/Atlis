<?php
// Expects $boards from index.php
?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Kanban Boards</h2>
    <a class="btn btn-falcon-primary" href="index.php?action=create">Create Board</a>
  </div>
  <div class="row g-3">
    <?php foreach ($boards as $b): ?>
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($b['name']) ?></h5>
            <div class="mt-auto">
              <a class="btn btn-sm btn-falcon-primary" href="index.php?action=board&id=<?= $b['id'] ?>">Open</a>
              <a class="btn btn-sm btn-falcon-secondary" href="index.php?action=edit&id=<?= $b['id'] ?>">Edit</a>
              <a class="btn btn-sm btn-falcon-danger" href="index.php?action=delete&id=<?= $b['id'] ?>" onclick="return confirm('Delete board?');">Delete</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
