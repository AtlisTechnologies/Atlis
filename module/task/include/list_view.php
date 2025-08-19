<?php
// Task list view using project layout
?>
<div class="p-4" id="taskList" data-list='{"valueNames":["task-name","task-status","task-priority","task-due"],"page":10,"pagination":true}'>
  <h2 class="mb-4">Tasks<span class="text-body-tertiary fw-normal">(<?= count($tasks) ?>)</span></h2>
  <div class="row align-items-center g-3 mb-3">
    <div class="col-sm-auto">
      <div class="search-box">
        <form class="position-relative">
          <input class="form-control search-input search" type="search" placeholder="Search tasks" aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
    </div>
    <div class="col-sm-auto">
      <div class="d-flex"><a class="btn btn-link p-0 ms-sm-3 fs-9 text-body-tertiary fw-bold" href="#!"><span class="fas fa-filter me-1 fw-extra-bold fs-10"></span><?= count($tasks) ?> tasks</a><a class="btn btn-link p-0 ms-3 fs-9 text-body-tertiary fw-bold" href="#!"><span class="fas fa-sort me-1 fw-extra-bold fs-10"></span>Sorting</a></div>
    </div>
  </div>
  <form id="taskQuickAdd" class="d-flex mb-3">
    <input class="form-control me-2" type="text" name="name" placeholder="Quick add task" required>
    <button class="btn btn-success" type="submit">Add</button>
  </form>
  <div class="mb-4 todo-list list" id="taskListContainer">
    <?php if (!empty($tasks)): ?>
      <?php foreach ($tasks as $t): ?>
        <?php $overdue = (!empty($t['due_date']) && strtotime($t['due_date']) < time() && empty($t['completed'])); ?>
        <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top task-row" data-task-id="<?= (int)$t['id'] ?>">
          <div class="col-12 col-md-auto flex-1">
            <div>
              <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 position-relative" style="z-index:1;">
                <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2" type="checkbox" id="checkbox-todo-<?= (int)$t['id'] ?>" data-task-id="<?= (int)$t['id'] ?>" <?= !empty($t['completed']) ? 'checked' : '' ?> />
                <span class="me-2 badge badge-phoenix fs-10 task-status badge-phoenix-<?= h($t['status_color']) ?>" data-value="<?= (int)$t['status'] ?>"><?= h($t['status_label']) ?></span>
                <span class="me-2 badge badge-phoenix fs-10 task-priority badge-phoenix-<?= h($t['priority_color']) ?>" data-value="<?= (int)$t['priority'] ?>"><?= h($t['priority_label']) ?></span>
                <?php if (!empty($t['assignees'])): ?>
                  <?php foreach ($t['assignees'] as $a): ?>
                    <?php $tpic = !empty($a['file_path']) ? $a['file_path'] : 'assets/img/team/avatar.webp'; ?>
                    <img src="<?php echo getURLDir() . h($tpic); ?>" class="avatar avatar-m me-1 rounded-circle" title="<?= h($a['name']) ?>" alt="<?= h($a['name']) ?>" />
                  <?php endforeach; ?>
                <?php else: ?>
                  <span class="fa-regular fa-user text-body-tertiary me-1"></span>
                <?php endif; ?>
                <a class="mb-0 fw-bold fs-8 me-2 line-clamp-1 flex-grow-1 flex-md-grow-0 task-name<?= !empty($t['completed']) ? ' text-decoration-line-through' : '' ?>" href="index.php?action=details&id=<?= (int)$t['id'] ?>"><?= h($t['name']) ?></a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-auto">
            <div class="d-flex ms-4 lh-1 align-items-center">
              <button class="btn btn-link p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span><?= (int)($t['attachment_count'] ?? 0) ?></button>
              <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 mb-0 task-due<?= $overdue ? ' text-danger' : '' ?>"><?= !empty($t['due_date']) ? h(date('d M, Y', strtotime($t['due_date']))) : '' ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="fs-9 text-body-secondary mb-0">No tasks found.</p>
    <?php endif; ?>
  </div>
  <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
    <div class="col-auto d-flex">
      <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
    </div>
    <div class="col-auto d-flex">
      <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
      <ul class="mb-0 pagination"></ul>
      <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var taskList = new List('taskList', { valueNames: ['task-name','task-status','task-priority','task-due'], page: 10, pagination: true });

  var statusOptions = <?= json_encode($taskStatusItems ?? []) ?>;
  var priorityOptions = <?= json_encode($taskPriorityItems ?? []) ?>;

  function htmlToElement(html){ var div=document.createElement('div'); div.innerHTML=html.trim(); return div.firstChild; }

  function renderTask(t){
    var overdue = t.due_date && !t.completed && new Date(t.due_date) < new Date();
    var assignees = '';
    if(t.assignees){ t.assignees.forEach(function(a){ var pic = a.file_path ? '<?php echo getURLDir(); ?>'+a.file_path : '<?php echo getURLDir(); ?>assets/img/team/avatar.webp'; assignees += `<img src="${pic}" class="avatar avatar-m me-1 rounded-circle" title="${a.name}" alt="${a.name}" />`; }); }
    if(!assignees){ assignees = '<span class="fa-regular fa-user text-body-tertiary me-1"></span>'; }
    var due = t.due_date ? new Date(t.due_date).toLocaleDateString('en-US',{day:'2-digit',month:'short',year:'numeric'}) : '';
    return `<div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top task-row" data-task-id="${t.id}">
      <div class="col-12 col-md-auto flex-1">
        <div>
          <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 position-relative" style="z-index:1;">
            <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2" type="checkbox" data-task-id="${t.id}" ${t.completed ? 'checked' : ''} />
            <span class="me-2 badge badge-phoenix fs-10 task-status badge-phoenix-${t.status_color}" data-value="${t.status}">${t.status_label}</span>
            <span class="me-2 badge badge-phoenix fs-10 task-priority badge-phoenix-${t.priority_color}" data-value="${t.priority}">${t.priority_label}</span>
            ${assignees}
            <a class="mb-0 fw-bold fs-8 me-2 line-clamp-1 flex-grow-1 flex-md-grow-0 task-name${t.completed ? ' text-decoration-line-through' : ''}" href="index.php?action=details&id=${t.id}">${t.name}</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-auto">
        <div class="d-flex ms-4 lh-1 align-items-center">
          <button class="btn btn-link p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>${t.attachment_count || 0}</button>
          <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 mb-0 task-due${overdue ? ' text-danger' : ''}">${due}</p>
        </div>
      </div>
    </div>`;
  }

  function attachTaskEvents(row){
    var cb = row.querySelector('input[type="checkbox"][data-task-id]');
    if(cb){
      cb.addEventListener('change', function(){
        var params = new URLSearchParams({id: cb.dataset.taskId, completed: cb.checked ? 1 : 0});
        fetch('functions/toggle_complete.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:params})
          .then(r=>r.json()).then(d=>{
            var isChecked = cb.checked;
            if(d.success){
              if(d.task){
                row = updateRow(row, d.task);
                cb = row.querySelector('input[type="checkbox"][data-task-id]');
                isChecked = d.task.completed == 1;
              }
            } else {
              isChecked = !cb.checked;
            }
            if(cb){ cb.checked = isChecked; }
            var link = row.querySelector('.task-name');
            if(link){ link.classList.toggle('text-decoration-line-through', isChecked); }
          }).catch(()=>{ if(cb){ cb.checked = !cb.checked; } });
      });
    }
    row.querySelectorAll('.task-status,.task-priority').forEach(function(b){
      b.addEventListener('click', function(){
        var field = b.classList.contains('task-status') ? 'status':'priority';
        var opts = field==='status'?statusOptions:priorityOptions;
        var select=document.createElement('select');
        select.className='form-select form-select-sm';
        opts.forEach(function(o){ var op=document.createElement('option'); op.value=o.id; op.textContent=o.label; if(o.id==b.dataset.value) op.selected=true; select.appendChild(op); });
        b.replaceWith(select);
        select.focus();
        select.addEventListener('change', function(){
          var params=new URLSearchParams({id: row.dataset.taskId, field: field, value: this.value});
          fetch('functions/update_field.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:params})
            .then(r=>r.json()).then(d=>{ if(d.success && d.task){ updateRow(row,d.task); } });
        });
        select.addEventListener('blur', function(){
          var span=document.createElement('span');
          span.className=b.className;
          span.dataset.value=b.dataset.value;
          span.textContent=b.textContent;
          select.replaceWith(span);
          attachTaskEvents(row);
        });
      });
    });
  }

  function updateRow(oldRow, task){
    if(task && task.id){
      var newEl = htmlToElement(renderTask(task));
      oldRow.replaceWith(newEl);
      attachTaskEvents(newEl);
      return newEl;
    }
    return oldRow;
  }

  document.querySelectorAll('.task-row').forEach(attachTaskEvents);

  var addForm = document.getElementById('taskQuickAdd');
  if(addForm){
    addForm.addEventListener('submit', function(e){
      e.preventDefault();
      var fd = new FormData(addForm); fd.append('ajax',1);
      fetch('functions/create.php',{method:'POST',body:fd}).then(r=>r.json()).then(d=>{
        if(d.success && d.task){
          var el = htmlToElement(renderTask(d.task));
          document.getElementById('taskListContainer').prepend(el);
          attachTaskEvents(el);
          addForm.reset();
          taskList.add({ 'task-name': d.task.name, 'task-status': d.task.status_label, 'task-priority': d.task.priority_label, 'task-due': d.task.due_date ? d.task.due_date : '' }, el);
        }
      });
    });
  }
});
</script>

