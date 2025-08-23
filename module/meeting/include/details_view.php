<?php
if (empty($current_meeting)) {
    echo '<div class="p-4"><p class="text-danger">Meeting not found.</p></div>';
    return;
}
?>
<div class="px-4 px-lg-6 py-4">
  <h2 class="text-body-highlight fw-bold mb-3"><?= h($current_meeting['name'] ?? 'Meeting') ?></h2>
</div>
<div class="px-4 px-lg-6">
  <h3 class="text-body-highlight fw-bold">Files</h3>
</div>
<?php if (user_has_permission('meeting','create|update|delete')): ?>
<div class="px-4 px-lg-6 py-4">
  <form action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="mb-3">
    <input type="hidden" name="meeting_id" value="<?= (int)$current_meeting['id'] ?>">
    <div class="input-group">
      <input class="form-control" type="file" name="file[]" multiple required>
      <button class="btn btn-success" type="submit">Upload</button>
    </div>
  </form>
</div>
<?php endif; ?>
<?php if (!empty($meetingFiles)): ?>
  <?php foreach ($meetingFiles as $f): ?>
    <div class="border-top px-4 px-lg-6 py-4">
      <div class="d-flex flex-between-center">
        <div class="d-flex mb-1"><span class="fa-solid <?= strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file' ?> me-2 text-body-tertiary fs-9"></span>
          <p class="text-body-highlight mb-0 lh-1">
            <?php if (strpos($f['file_type'], 'image/') === 0): ?>
              <a class="text-body-highlight" href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
            <?php else: ?>
              <a class="text-body-highlight" href="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
            <?php endif; ?>
          </p>
        </div>
        <?php if ($is_admin || ($f['user_id'] ?? 0) == $this_user_id): ?>
        <form action="functions/delete_file.php" method="post" onsubmit="return confirm('Delete this file?');">
          <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
          <input type="hidden" name="meeting_id" value="<?= (int)$current_meeting['id'] ?>">
          <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-trash"></span></button>
        </form>
        <?php endif; ?>
      </div>
      <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap"><span><?= h($f['file_size']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['file_type']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['date_created']) ?></span><?php if (!empty($f['type_label'])): ?><span class="text-body-quaternary mx-1">| </span><span class="badge text-bg-<?= h($f['type_color_class'] ?? 'secondary') ?>"><?= h($f['type_label']) ?></span><?php endif; ?></div>
      <?php if (strpos($f['file_type'], 'image/') === 0): ?>
        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>">
          <img class="rounded-2 mt-2" src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>" alt="" style="width:320px" />
        </a>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="border-top px-4 px-lg-6 py-4">
    <p class="fs-9 text-body-secondary mb-0">No files uploaded.</p>
  </div>
<?php endif; ?>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Image preview</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <img class="img-fluid" src="" alt="" id="imageModalSrc">
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('show.bs.modal', function(e){
  if(e.target.id === 'imageModal'){
    var src = e.relatedTarget.getAttribute('data-img-src');
    document.getElementById('imageModalSrc').src = src;
  }
});
</script>
