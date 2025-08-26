<?php
// Expects $board, $projects, $selectedProjects from index.php
$board_id = $board['id'] ?? null;
$name = $board['name'] ?? '';
$selProjects = $selectedProjects ?? [];
?>
<div class="container py-4">
  <h2 class="mb-4"><?= $board_id ? 'Edit Board' : 'Create Board' ?></h2>
  <form method="post" action="index.php?action=save">
    <input type="hidden" name="id" value="<?= e($board_id) ?>">
    <div class="mb-3">
      <label class="form-label">Board Name</label>
      <input class="form-control" name="name" value="<?= e($name) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Projects</label>
      <select class="form-select" name="projects[]" multiple>
        <?php foreach ($projects as $p): ?>
          <option value="<?= $p['id'] ?>" <?= in_array($p['id'], $selProjects) ? 'selected' : '' ?>><?= e($p['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <button class="btn btn-falcon-primary" type="submit">Save</button>
    <a class="btn btn-falcon-secondary" href="index.php">Cancel</a>
  </form>
</div>
