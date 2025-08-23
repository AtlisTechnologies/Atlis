<div class="container-fluid py-4">
  <div class="row mb-3">
    <div class="col">
      <h2><?php echo h($meeting['title'] ?? 'Meeting'); ?></h2>
      <?php if (!empty($meeting['description'])): ?>
      <p class="text-body-secondary mb-1"><?php echo h($meeting['description']); ?></p>
      <?php endif; ?>
      <p class="mb-0"><strong>Start:</strong> <?php echo !empty($meeting['start_time']) ? h(date('l, F j, Y g:i A', strtotime($meeting['start_time']))) : ''; ?></p>
      <?php if (!empty($meeting['end_time'])): ?>
      <p class="mb-0"><strong>End:</strong> <?php echo h(date('l, F j, Y g:i A', strtotime($meeting['end_time']))); ?></p>
      <?php endif; ?>
      <p class="mb-0"><strong>Recurs:</strong> <?php
        $recur = [];
        if (!empty($meeting['recur_daily'])) $recur[] = 'Daily';
        if (!empty($meeting['recur_weekly'])) $recur[] = 'Weekly';
        if (!empty($meeting['recur_monthly'])) $recur[] = 'Monthly';
        echo $recur ? h(implode(', ', $recur)) : 'No';
      ?></p>
      <?php if (user_has_permission('meeting','create')): ?>
      <div class="mt-3">
        <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#taskModal">Create Task</button>
        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#projectModal">Create Project</button>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <div class="card mb-3">
        <div class="card-header">Agenda</div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush" id="agendaList"></ul>
        </div>
      </div>
      <div class="card mb-3">
        <div class="card-header">Questions</div>
        <div class="card-body" id="questionsList"></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card mb-3">
        <div class="card-header">Attendees</div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush" id="attendeesList"></ul>
        </div>
      </div>
      <div class="card mb-3">
        <div class="card-header">Attachments</div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush" id="attachmentsList"></ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="taskForm">
      <div class="modal-header">
        <h5 class="modal-title">Create Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="projectForm">
      <div class="modal-header">
        <h5 class="modal-title">Create Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<script src="<?php echo getURLDir(); ?>vendors/sortablejs/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var meetingId = <?php echo (int)$meeting['id']; ?>;
  var baseUrl = '<?php echo getURLDir(); ?>';
  var agendaList = document.getElementById('agendaList');
  new Sortable(agendaList, {handle: '.drag-handle', animation:150, onEnd: updateOrder});

  function renderAgenda(items){
    agendaList.innerHTML = '';
    if(items.length){
      items.forEach(function(item){
        var li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.dataset.id = item.id;
        li.dataset.statusId = item.status_id || '';
        li.dataset.taskId = item.linked_task_id || '';
        li.dataset.projectId = item.linked_project_id || '';
        var left = '<span><span class="drag-handle me-2 fas fa-grip-vertical"></span><span class="agenda-title">'+esc(item.title)+'</span>';
        var meta = [];
        if(item.status_id){ meta.push('Status '+esc(item.status_id)); }
        if(item.linked_task_id){ meta.push('<a href="'+baseUrl+'module/task/index.php?id='+item.linked_task_id+'">Task '+esc(item.linked_task_id)+'</a>'); }
        if(item.linked_project_id){ meta.push('<a href="'+baseUrl+'module/project/index.php?id='+item.linked_project_id+'">Project '+esc(item.linked_project_id)+'</a>'); }
        if(meta.length){ left += ' <small class="text-body-secondary">'+meta.join(' | ')+'</small>'; }
        left += '</span>';
        li.innerHTML = left + '<div class="btn-group btn-group-sm"><button class="btn btn-outline-secondary edit-agenda-item">Edit</button><button class="btn btn-outline-danger delete-agenda-item">Delete</button></div>';
        agendaList.appendChild(li);
      });
    } else {
      agendaList.innerHTML = '<li class="list-group-item">No agenda items.</li>';
    }
  }

  function fetchAgenda(){
    var params = new URLSearchParams({meeting_id: meetingId});
    fetch('functions/add_agenda_item.php', {method:'POST', body: params})
      .then(r => r.json())
      .then(function(data){
        if(data.success){
          renderAgenda(data.items);
        }
      });
  }

  function updateOrder(){
    var items = agendaList.querySelectorAll('li[data-id]');
    items.forEach(function(li, idx){
      var params = new URLSearchParams({id: li.dataset.id, meeting_id: meetingId, order_index: idx+1, title: li.querySelector('.agenda-title').textContent, status_id: li.dataset.statusId, linked_task_id: li.dataset.taskId, linked_project_id: li.dataset.projectId});
      fetch('functions/update_agenda_item.php', {method:'POST', body: params});
    });
  }

  agendaList.addEventListener('click', function(e){
    var li = e.target.closest('li[data-id]');
    if(!li) return;
    if(e.target.closest('.delete-agenda-item')){
      var params = new URLSearchParams({id: li.dataset.id, meeting_id: meetingId});
      fetch('functions/delete_agenda_item.php', {method:'POST', body: params})
        .then(r=>r.json())
        .then(function(res){ if(res.success) renderAgenda(res.items); });
    } else if(e.target.closest('.edit-agenda-item')){
      var newTitle = prompt('Title', li.querySelector('.agenda-title').textContent);
      if(newTitle !== null){
        var newStatus = prompt('Status ID', li.dataset.statusId);
        var newTask = prompt('Task ID', li.dataset.taskId);
        var newProject = prompt('Project ID', li.dataset.projectId);
        var params = new URLSearchParams({id: li.dataset.id, meeting_id: meetingId, order_index: Array.from(agendaList.children).indexOf(li)+1, title: newTitle, status_id: newStatus, linked_task_id: newTask, linked_project_id: newProject});
        fetch('functions/update_agenda_item.php', {method:'POST', body: params})
          .then(r=>r.json())
          .then(function(res){ if(res.success) renderAgenda(res.items); });
      }
    }
  });

  fetchAgenda();

  fetch('functions/get_questions.php?meeting_id=' + meetingId)
    .then(r=>r.json())
    .then(function(data){
      var container = document.getElementById('questionsList');
      if(data.success && data.questions.length){
        data.questions.forEach(function(q){
          var div = document.createElement('div');
          div.className = 'mb-3';
          div.innerHTML = '<p class="fw-bold mb-1">' + esc(q.question) + '</p><p class="mb-0">' + esc(q.answer || '') + '</p>';
          container.appendChild(div);
        });
      } else {
        container.innerHTML = '<p class="text-body-secondary mb-0">No questions.</p>';
      }
    });

  fetch('functions/get_attendees.php?meeting_id=' + meetingId)
    .then(r=>r.json())
    .then(function(data){
      var list = document.getElementById('attendeesList');
      if(data.success && data.attendees.length){
        data.attendees.forEach(function(a){
          var li = document.createElement('li');
          li.className = 'list-group-item';
          li.textContent = a.name;
          list.appendChild(li);
        });
      } else {
        list.innerHTML = '<li class="list-group-item">No attendees.</li>';
      }
    });

  fetch('functions/get_attachments.php?meeting_id=' + meetingId)
    .then(r=>r.json())
    .then(function(data){
      var list = document.getElementById('attachmentsList');
      if(data.success && data.files.length){
        data.files.forEach(function(f){
          var li = document.createElement('li');
          li.className = 'list-group-item';
          li.innerHTML = '<a href="' + esc(f.url) + '" target="_blank">' + esc(f.name) + '</a>';
          list.appendChild(li);
        });
      } else {
        list.innerHTML = '<li class="list-group-item">No attachments.</li>';
      }
    });

  document.getElementById('taskForm').addEventListener('submit', function(e){
    e.preventDefault();
    var form = this;
    fetch('functions/create_task.php', {method:'POST', body:new FormData(form)})
      .then(r=>r.json())
      .then(function(res){
        if(res.success){
          bootstrap.Modal.getInstance(document.getElementById('taskModal')).hide();
          form.reset();
        } else {
          alert(res.message || 'Failed to create task');
        }
      });
  });

  document.getElementById('projectForm').addEventListener('submit', function(e){
    e.preventDefault();
    var form = this;
    fetch('functions/create_project.php', {method:'POST', body:new FormData(form)})
      .then(r=>r.json())
      .then(function(res){
        if(res.success){
          bootstrap.Modal.getInstance(document.getElementById('projectModal')).hide();
          form.reset();
        } else {
          alert(res.message || 'Failed to create project');
        }
      });
  });

  function esc(str){
    return str ? str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;') : '';
  }
});
</script>
