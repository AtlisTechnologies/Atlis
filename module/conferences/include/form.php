<form method="post" action="<?= $actionUrl ?>">
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
    <div class="input-group mb-2">
      <input type="text" id="ticketOptionName" class="form-control" placeholder="Option name">
      <input type="number" step="0.01" id="ticketOptionPrice" class="form-control" placeholder="Price">
      <button class="btn btn-outline-secondary" type="button" id="addTicketOptionBtn">Add</button>
    </div>
    <ul id="ticketOptionsList" class="list-unstyled"></ul>
  </div>
  <div class="mb-3">
    <label class="form-label">Custom Fields</label>
    <div class="input-group mb-2">
      <input type="text" id="fieldName" class="form-control" placeholder="Name">
      <select id="fieldType" class="form-select">
        <option value="text">Text</option>
        <option value="number">Number</option>
        <option value="select">Select</option>
      </select>
      <input type="text" id="fieldOptions" class="form-control" placeholder="Options">
      <button class="btn btn-outline-secondary" type="button" id="addCustomFieldBtn">Add</button>
    </div>
    <ul id="customFieldsList" class="list-unstyled"></ul>
  </div>
  <div class="mb-3">
    <label class="form-label">Images</label>
    <input type="file" id="conferenceImage" class="form-control">
    <button class="btn btn-outline-secondary mt-2" type="button" id="uploadImageBtn">Upload</button>
    <ul id="imageList" class="list-unstyled mt-2"></ul>
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="privacy" value="1" id="privacyCheck" <?= !empty($conference['privacy']) ? 'checked' : '' ?>>
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
