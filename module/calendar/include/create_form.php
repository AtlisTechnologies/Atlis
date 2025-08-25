<h2>Create Calendar</h2>
<form id="createCalendarForm">
  <div class="mb-3">
    <label class="form-label" for="name">Name</label>
    <input class="form-control" type="text" name="name" id="name" required>
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_private" id="is_private" value="1">
    <label class="form-check-label" for="is_private">Private</label>
  </div>
  <button class="btn btn-primary" type="submit">Save</button>
  <a class="btn btn-secondary" href="index.php">Cancel</a>
</form>

<script>
document.getElementById('createCalendarForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  fetch('functions/create_calendar.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      window.location.href = 'index.php?action=my';
    } else {
      alert('Error creating calendar');
    }
  });
});
</script>
