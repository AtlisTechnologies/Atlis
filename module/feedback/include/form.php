<?php
// Feedback creation form using Phoenix floating labels
?>
<form id="feedbackForm" method="post" action="index.php?action=save" class="row g-3">
  <div class="col-12">
    <div class="form-floating mb-3">
      <input class="form-control" id="fbTitle" type="text" name="title" placeholder="Title" required>
      <label for="fbTitle">Title</label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating mb-3">
      <textarea class="form-control" id="fbDescription" name="description" placeholder="Description" style="height:100px"></textarea>
      <label for="fbDescription">Description</label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating mb-3">
      <select class="form-select" id="fbType" name="type" required>
        <option value="">Select type</option>
        <?php foreach ($types as $t): ?>
          <option value="<?php echo $t['id']; ?>"><?php echo h($t['label']); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="fbType">Type</label>
    </div>
  </div>
  <div class="col-12 text-end">
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</form>
