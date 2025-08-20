<?php
// Expects $board from index.php
$board_id = $board['id'] ?? null;
$name = $board['name'] ?? '';
?>
<div class="container py-4">
  <h2 class="mb-4"><?= $board_id ? 'Edit Board' : 'Create Board' ?></h2>
  <form method="post" action="index.php?action=save">
    <input type="hidden" name="id" value="<?= htmlspecialchars($board_id) ?>">
    <div class="mb-3">
      <label class="form-label">Board Name</label>
      <input class="form-control" name="name" value="<?= htmlspecialchars($name) ?>" required>
    </div>
    <button class="btn btn-falcon-primary" type="submit">Save</button>
    <a class="btn btn-falcon-secondary" href="index.php">Cancel</a>
  </form>
</div>
