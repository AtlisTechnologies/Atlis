<?php
require_once __DIR__ . '/../../admin_header.php';
require_permission('minder_reminder','read');

$token = generate_csrf_token();
$userStmt = $pdo->query('SELECT id, email FROM users ORDER BY email');
$users = $userStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Reminders</h2>
<?= flash_message($_SESSION['message'] ?? '', 'success'); ?>
<?= flash_message($_SESSION['error_message'] ?? '', 'danger'); ?>
<?php unset($_SESSION['message'], $_SESSION['error_message']); ?>
<?php if (user_has_permission('minder_reminder','create')): ?>
<button class="btn btn-sm btn-primary mb-3" id="addReminderBtn">Add Reminder</button>
<?php endif; ?>
<div class="calendar-outline mt-6 mb-9" id="appCalendar"></div>
<div class="modal fade" id="reminderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="reminderForm">
      <div class="modal-header">
        <h5 class="modal-title" id="reminderModalLabel">Add Reminder</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="reminderAlert"></div>
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <input type="hidden" name="id" id="reminder-id">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" name="title" id="reminder-title" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" id="reminder-description" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Remind At</label>
          <input type="text" name="remind_at" id="reminder-remind-at" class="form-control datetimepicker" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":true,"dateFormat":"Y-m-d H:i"}' required>
        </div>
        <div class="mb-3">
          <label class="form-label">Repeat</label>
          <select name="repeat_type" id="reminder-repeat-type" class="form-select">
            <option value="">None</option>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Assign Users</label>
          <select name="assignments[]" id="reminder-assignments" class="form-select" multiple>
            <?php foreach ($users as $u): ?>
            <option value="<?= $u['id']; ?>"><?= e($u['email']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger me-auto d-none" id="deleteReminderBtn">Delete</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
const canCreate = <?= user_has_permission('minder_reminder','create') ? 'true' : 'false'; ?>;
const canUpdate = <?= user_has_permission('minder_reminder','update') ? 'true' : 'false'; ?>;
const canDelete = <?= user_has_permission('minder_reminder','delete') ? 'true' : 'false'; ?>;
document.addEventListener('DOMContentLoaded', function() {
  const calendarEl = document.getElementById('appCalendar');
  const reminderModalEl = document.getElementById('reminderModal');
  const reminderModal = new bootstrap.Modal(reminderModalEl);
  const form = document.getElementById('reminderForm');
  flatpickr('.datetimepicker', JSON.parse(form.querySelector('.datetimepicker').dataset.options));
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: 'functions/list.php',
    eventClick: function(info) {
      if (!canUpdate) return;
      const ev = info.event;
      form.reset();
      document.getElementById('reminderModalLabel').textContent = 'Edit Reminder';
      form.id.value = ev.id;
      form.title.value = ev.title;
      form.description.value = ev.extendedProps.description || '';
      form.remind_at.value = ev.start.toISOString().slice(0,16).replace('T',' ');
      form.repeat_type.value = ev.extendedProps.repeat_type || '';
      const assigned = ev.extendedProps.assigned_users || [];
      for (const opt of form['assignments[]'].options) {
        opt.selected = assigned.includes(parseInt(opt.value));
      }
      document.getElementById('deleteReminderBtn').classList.toggle('d-none', !canDelete);
      reminderModal.show();
    }
  });
  calendar.render();
  const addBtn = document.getElementById('addReminderBtn');
  if (addBtn) {
    addBtn.addEventListener('click', () => {
      form.reset();
      document.getElementById('reminderModalLabel').textContent = 'Add Reminder';
      form.id.value = '';
      document.getElementById('deleteReminderBtn').classList.add('d-none');
      reminderModal.show();
    });
  }
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(form);
    const isEdit = formData.get('id');
    fetch('functions/' + (isEdit ? 'update.php' : 'create.php'), {
      method: 'POST',
      body: formData,
      headers: {'X-Requested-With':'XMLHttpRequest'}
    }).then(resp => resp.json()).then(data => {
      if (data.success) {
        reminderModal.hide();
        calendar.refetchEvents();
      } else {
        document.getElementById('reminderAlert').innerHTML = '<div class="alert alert-danger">'+(data.error||'Error')+'</div>';
      }
    });
  });
  document.getElementById('deleteReminderBtn').addEventListener('click', function() {
    const id = form.id.value;
    if (!id || !confirm('Delete this reminder?')) return;
    const fd = new FormData();
    fd.append('id', id);
    fd.append('csrf_token', form.csrf_token.value);
    fetch('functions/delete.php', {
      method:'POST',
      body: fd,
      headers: {'X-Requested-With':'XMLHttpRequest'}
    }).then(resp=>resp.json()).then(data=>{
      if (data.success) {
        reminderModal.hide();
        calendar.refetchEvents();
      } else {
        document.getElementById('reminderAlert').innerHTML = '<div class="alert alert-danger">'+(data.error||'Error')+'</div>';
      }
    });
  });
});
</script>
<?php require_once __DIR__ . '/../../admin_footer.php'; ?>
