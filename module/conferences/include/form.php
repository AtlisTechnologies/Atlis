<?php
  $eventTypes = get_lookup_items($pdo, 'CONFERENCE_TYPE');
  $topics     = get_lookup_items($pdo, 'CONFERENCE_TOPIC');
  $existingTags = [];
  $ticketOptions = [];
  if ($editing) {
    $tagStmt = $pdo->prepare('SELECT tag FROM module_conference_tags WHERE conference_id=?');
    $tagStmt->execute([$conference['id']]);
    $existingTags = $tagStmt->fetchAll(PDO::FETCH_COLUMN);
    $optStmt = $pdo->prepare('SELECT option_name, price FROM module_conference_ticket_options WHERE conference_id=?');
    $optStmt->execute([$conference['id']]);
    $ticketOptions = $optStmt->fetchAll(PDO::FETCH_ASSOC);
  }

?>
<form method="post" action="<?= $actionUrl ?>" enctype="multipart/form-data">
  <?php if ($editing): ?>
    <input type="hidden" name="id" value="<?= (int)$conference['id'] ?>">
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= h($conference['name'] ?? '') ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Type</label>
    <select name="conference_type_id" class="form-select">
      <option value="">Select type</option>
      <?php foreach ($conferenceTypes as $type): ?>
        <option value="<?= h($type['id']); ?>" <?= (!empty($conference['conference_type_id']) && $conference['conference_type_id'] == $type['id']) ? 'selected' : ''; ?>><?= h($type['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Topic</label>
    <select name="topic_id" class="form-select">
      <option value="">Select topic</option>
      <?php foreach ($topics as $topic): ?>
        <option value="<?= h($topic['id']); ?>" <?= (!empty($conference['topic_id']) && $conference['topic_id'] == $topic['id']) ? 'selected' : ''; ?>><?= h($topic['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Mode</label>
    <select name="mode" class="form-select">
      <?php $modes = ['ONLINE' => 'Online', 'OFFLINE' => 'Offline', 'BOTH' => 'Both']; ?>
      <?php foreach ($modes as $val => $label): ?>
        <option value="<?= h($val); ?>" <?= (!empty($conference['mode']) && $conference['mode'] === $val) ? 'selected' : ''; ?>><?= h($label); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Venue</label>
    <input type="text" name="venue" class="form-control" value="<?= h($conference['venue'] ?? '') ?>">
  </div>
  <div class="row g-3">
    <div class="col-md-4">
      <label class="form-label">Country</label>
      <input type="text" name="country_id" class="form-control" value="<?= h($conference['country_id'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">State</label>
      <input type="text" name="state_id" class="form-control" value="<?= h($conference['state_id'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">City</label>
      <input type="text" name="city" class="form-control" value="<?= h($conference['city'] ?? '') ?>">
    </div>
  </div>
  <div class="row g-3 mt-0">
    <div class="col-md-6">
      <label class="form-label">Latitude</label>
      <input type="text" name="latitude" class="form-control" value="<?= h($conference['latitude'] ?? '') ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Longitude</label>
      <input type="text" name="longitude" class="form-control" value="<?= h($conference['longitude'] ?? '') ?>">
    </div>
  </div>
  <div class="row g-3 mt-0">
    <div class="col-md-6">
      <label class="form-label">Start Date &amp; Time</label>
      <input type="datetime-local" name="start_datetime" class="form-control" value="<?= !empty($conference['start_datetime']) ? date('Y-m-d\\TH:i', strtotime($conference['start_datetime'])) : '' ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">End Date &amp; Time</label>
      <input type="datetime-local" name="end_datetime" class="form-control" value="<?= !empty($conference['end_datetime']) ? date('Y-m-d\\TH:i', strtotime($conference['end_datetime'])) : '' ?>">
    </div>
  </div>
  <div class="row g-3 mt-0">
    <div class="col-md-4">
      <label class="form-label">Timezone</label>
      <input type="text" name="timezone" class="form-control" value="<?= h($conference['timezone'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Registration Deadline</label>
      <input type="date" name="registration_deadline" class="form-control" value="<?= !empty($conference['registration_deadline']) ? h($conference['registration_deadline']) : '' ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Show Ticket Count</label>
      <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" name="show_ticket_count" value="1" <?= !empty($conference['show_ticket_count']) ? 'checked' : '' ?>>
      </div>
    </div>
  </div>
  <div class="mb-3 mt-3">
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
    <select name="tags[]" class="form-select" multiple>
      <?php foreach ($existingTags as $tag): ?>
        <option value="<?= h($tag) ?>" selected><?= h($tag) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Ticket Options</label>
    <div class="d-flex mb-2">
      <input type="text" id="ticketOptionName" class="form-control me-2" placeholder="Name">
      <input type="number" step="0.01" id="ticketOptionPrice" class="form-control me-2" placeholder="Price">
      <button class="btn btn-outline-secondary" type="button" id="addTicketOptionBtn">Add</button>
    </div>
    <ul id="ticketOptionsList" class="list-unstyled">
      <?php foreach ($ticketOptions as $opt): ?>
        <li><?= h($opt['option_name']) ?><?= $opt['price'] ? ' ($'.h($opt['price']).')' : '' ?></li>
      <?php endforeach; ?>
    </ul>

  </div>
  <div class="mb-3">
    <label class="form-label">Images</label>
    <input type="file" name="images[]" multiple class="form-control">
    <div class="mt-2">
      <label class="form-label">Banner Image Index</label>
      <input type="number" name="banner_image_index" class="form-control" min="0">
    </div>
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_private" value="1" id="privacyCheck" <?= !empty($conference['is_private']) ? 'checked' : '' ?>>
    <label class="form-check-label" for="privacyCheck">Private</label>
  </div>
  <button class="btn btn-success" type="submit"><?= $editing ? 'Update Conference' : 'Create Conference' ?></button>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const confIdField = document.querySelector('input[name="id"]');
  const ticketBtn = document.getElementById('addTicketOptionBtn');
  if (ticketBtn) {
    ticketBtn.addEventListener('click', function() {
      const id = confIdField ? confIdField.value : '';
      const name = document.getElementById('ticketOptionName').value.trim();
      const price = document.getElementById('ticketOptionPrice').value.trim();
      if (!id || !name) return;
      const params = new URLSearchParams({conference_id:id});
      params.append('ticket_option[name]', name);
      if (price) params.append('ticket_option[price]', price);
      fetch('functions/add_ticket_option.php', {method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body:params})
        .then(r=>r.json()).then(res=>{

          if(res.success){
            const li = document.createElement('li');
            li.textContent = name + (price ? ' ($'+price+')' : '');
            document.getElementById('ticketOptionsList').appendChild(li);
            document.getElementById('ticketOptionName').value='';
            document.getElementById('ticketOptionPrice').value='';
          }
        });
    });
  }
});
</script>
