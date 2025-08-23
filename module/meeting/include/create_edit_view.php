<?php $isEdit = !empty($meeting); ?>
<div class="container-fluid py-4">
  <h2 class="mb-4"><?php echo $isEdit ? 'Edit Meeting' : 'Create Meeting'; ?></h2>
  <form id="meetingForm" method="post" action="functions/<?php echo $isEdit ? 'update.php' : 'create.php'; ?>">
    <?php if ($isEdit): ?>
      <input type="hidden" name="id" value="<?php echo (int)$meeting['id']; ?>">
    <?php endif; ?>
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Title</label>
        <input type="text" name="name" class="form-control" value="<?php echo h($meeting['name'] ?? ''); ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Date &amp; Time</label>
        <input type="datetime-local" name="meeting_date" class="form-control" value="<?php echo !empty($meeting['meeting_date']) ? h(date('Y-m-d\TH:i', strtotime($meeting['meeting_date']))) : ''; ?>" required>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Agenda</label>
      <ul id="agendaList" class="list-group"></ul>
      <button type="button" class="btn btn-sm btn-primary mt-2" id="addAgendaItem">Add Agenda Item</button>
    </div>
    <div class="mb-3">
      <label class="form-label">Questions</label>
      <div id="questionsContainer"></div>
      <button type="button" class="btn btn-sm btn-secondary mt-2" id="addQuestion">Add Question</button>
    </div>
    <div class="mb-3">
      <label class="form-label">Upload Files</label>
      <input type="file" name="file" id="meetingFile" class="form-control">
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
  </form>
</div>
<script src="<?php echo getURLDir(); ?>vendors/sortablejs/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var agendaList = document.getElementById('agendaList');
  new Sortable(agendaList, {handle: '.drag-handle', animation:150});
  document.getElementById('addAgendaItem').addEventListener('click', function(){
    fetch('include/agenda_item.php').then(r=>r.text()).then(function(html){
      agendaList.insertAdjacentHTML('beforeend', html);
    });
  });
  agendaList.addEventListener('click', function(e){
    if(e.target.closest('.remove-agenda-item')){
      e.target.closest('li').remove();
    }
  });
  document.getElementById('addQuestion').addEventListener('click', function(){
    var div = document.createElement('div');
    div.className = 'border rounded p-3 mb-2';
    div.innerHTML = '<input type="text" name="questions[]" class="form-control mb-2" placeholder="Question" required><textarea name="answers[]" class="form-control" placeholder="Answer"></textarea>';
    document.getElementById('questionsContainer').appendChild(div);
  });
});
</script>
