<?php
  $eventTypes = get_lookup_items($pdo, 'CONFERENCE_TYPE');
  $topics     = get_lookup_items($pdo, 'CONFERENCE_TOPIC');
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
    <select name="event_type_id" class="form-select">
      <option value="">Select type</option>
      <?php foreach ($eventTypes as $type): ?>
        <option value="<?= h($type['id']); ?>" <?= (!empty($conference['event_type_id']) && $conference['event_type_id'] == $type['id']) ? 'selected' : ''; ?>><?= h($type['label']); ?></option>
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
  <div class="mb-3">
    <label class="form-label">Start Date &amp; Time</label>
    <input type="datetime-local" name="start_datetime" class="form-control" value="<?= !empty($conference['start_datetime']) ? date('Y-m-d\\TH:i', strtotime($conference['start_datetime'])) : '' ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">End Date &amp; Time</label>
    <input type="datetime-local" name="end_datetime" class="form-control" value="<?= !empty($conference['end_datetime']) ? date('Y-m-d\\TH:i', strtotime($conference['end_datetime'])) : '' ?>">
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
    <label class="form-label">Tags (comma separated)</label>
    <input type="text" name="tags" class="form-control" value="">
  </div>
  <div class="mb-3">
    <label class="form-label">Ticket Options (JSON)</label>
    <textarea name="ticket_options" class="form-control" rows="2"></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Custom Fields (JSON)</label>
    <textarea name="custom_fields" class="form-control" rows="2"></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Images</label>
    <input type="file" id="conferenceImage" class="form-control">
    <button class="btn btn-outline-secondary mt-2" type="button" id="uploadImageBtn">Upload</button>
    <ul id="imageList" class="list-unstyled mt-2"></ul>
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_private" value="1" id="privacyCheck" <?= !empty($conference['is_private']) ? 'checked' : '' ?>>
    <label class="form-check-label" for="privacyCheck">Private</label>
  </div>
  <button class="btn btn-success" type="submit"><?= $editing ? 'Update' : 'Create' ?></button>
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
      fetch('functions/add_ticket_option.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: new URLSearchParams({conference_id:id, option_name:name, price:price})
      }).then(r=>r.json()).then(res=>{
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

  const fieldBtn = document.getElementById('addCustomFieldBtn');
  if (fieldBtn) {
    fieldBtn.addEventListener('click', function() {
      const id = confIdField ? confIdField.value : '';
      const name = document.getElementById('fieldName').value.trim();
      const type = document.getElementById('fieldType').value;
      const opts = document.getElementById('fieldOptions').value.trim();
      if (!id || !name) return;
      fetch('functions/add_custom_field.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:new URLSearchParams({conference_id:id, name:name, field_type:type, field_options:opts})
      }).then(r=>r.json()).then(res=>{
        if(res.success){
          const li = document.createElement('li');
          li.textContent = name + ' (' + type + ')';
          document.getElementById('customFieldsList').appendChild(li);
          document.getElementById('fieldName').value='';
          document.getElementById('fieldOptions').value='';
        }
      });
    });
  }

  const imageBtn = document.getElementById('uploadImageBtn');
  if (imageBtn) {
    imageBtn.addEventListener('click', function() {
      const id = confIdField ? confIdField.value : '';
      const file = document.getElementById('conferenceImage').files[0];
      if (!id || !file) return;
      const fd = new FormData();
      fd.append('conference_id', id);
      fd.append('image', file);
      fetch('functions/upload_image.php', {method:'POST', body: fd})
        .then(r=>r.json())
        .then(res=>{
          if(res.success){
            const li = document.createElement('li');
            li.textContent = res.file_name;
            document.getElementById('imageList').appendChild(li);
            document.getElementById('conferenceImage').value='';
          }
        });
    });
  }
});
</script>
