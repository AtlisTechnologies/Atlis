<form method="post" action="<?= $actionUrl ?>" enctype="multipart/form-data">
  <?php if ($editing): ?>
    <input type="hidden" name="id" value="<?= (int)$conference['id'] ?>">
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="<?= h($conference['title'] ?? '') ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Type</label>
    <input type="text" name="type" class="form-control" value="<?= h($conference['type'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Topic</label>
    <input type="text" name="topic" class="form-control" value="<?= h($conference['topic'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Mode</label>
    <input type="text" name="mode" class="form-control" value="<?= h($conference['mode'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Venue</label>
    <input type="text" name="venue" class="form-control" value="<?= h($conference['venue'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Schedule</label>
    <input type="datetime-local" name="schedule" class="form-control" value="<?= !empty($conference['schedule']) ? date('Y-m-d\\TH:i', strtotime($conference['schedule'])) : '' ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4"><?= h($conference['description'] ?? '') ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Organizers</label>
    <textarea name="organizers" class="form-control" rows="2"><?= h($conference['organizers'] ?? '') ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Sponsors</label>
    <textarea name="sponsors" class="form-control" rows="2"><?= h($conference['sponsors'] ?? '') ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Tags</label>
    <input type="text" name="tags" class="form-control" value="<?= h($conference['tags'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Ticket Options</label>
    <textarea name="ticket_options" class="form-control" rows="2"><?= h($conference['ticket_options'] ?? '') ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Custom Fields</label>
    <textarea name="custom_fields" class="form-control" rows="2"><?= h($conference['custom_fields'] ?? '') ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Images</label>
    <input type="file" name="images[]" class="form-control" multiple>
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="privacy" value="1" id="privacyCheck" <?= !empty($conference['privacy']) ? 'checked' : '' ?>>
    <label class="form-check-label" for="privacyCheck">Private</label>
  </div>
  <button class="btn btn-success" type="submit"><?= $editing ? 'Update' : 'Create' ?></button>
</form>
