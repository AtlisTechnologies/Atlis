<?php
require_once __DIR__ . '/../../../includes/helpers.php';
$token = generate_csrf_token();
$isEdit = isset($feedbackItem['id']);
$action = $isEdit ? 'update' : 'save';
$titleVal = h($feedbackItem['title'] ?? '');
$descVal = h($feedbackItem['description'] ?? '');
$typeVal = $feedbackItem['type'] ?? '';
?>
<form id="feedbackForm" method="post" action="index.php?action=<?= $action; ?>" class="row g-3">
  <div class="col-12">
    <div class="form-floating mb-3">
      <input class="form-control" id="fbTitle" type="text" name="title" placeholder="Title" value="<?= $titleVal; ?>" required>
      <label for="fbTitle">Title</label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating mb-3">
      <textarea class="form-control" id="fbDescription" name="description" placeholder="Description" style="height:100px"><?= $descVal; ?></textarea>
      <label for="fbDescription">Description</label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating mb-3">
      <select class="form-select" id="fbType" name="type" required>
        <option value="">Select type</option>
        <?php foreach ($types as $t): ?>
          <option value="<?php echo $t['id']; ?>" <?= ($typeVal == $t['id']) ? 'selected' : ''; ?>><?php echo h($t['label']); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="fbType">Type</label>
    </div>
  </div>
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?= (int)$feedbackItem['id']; ?>">
  <?php endif; ?>
  <div class="col-12 text-end">
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</form>
