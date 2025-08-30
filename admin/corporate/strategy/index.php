<?php
require '../../admin_header.php';
require_permission('admin_strategy','read');
require_once __DIR__ . '/../../../includes/lookup_helpers.php';

$statusItems   = get_lookup_items($pdo,'CORPORATE_STRATEGY_STATUS');
$priorityItems = get_lookup_items($pdo,'CORPORATE_STRATEGY_PRIORITY');
$categoryItems = get_lookup_items($pdo,'CORPORATE_STRATEGY_CATEGORY');
?>
<div class="container-fluid px-0" id="strategy-app">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="mb-0">Corporate Strategy</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStrategyModal">Add Strategy</button>
  </div>

  <!-- Filters -->
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <select class="form-select" id="filterStatus">
        <option value="">All Statuses</option>
        <?php foreach($statusItems as $s): ?>
        <option value="<?= $s['id']; ?>"><?= e($s['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <select class="form-select" id="filterPriority">
        <option value="">All Priorities</option>
        <?php foreach($priorityItems as $p): ?>
        <option value="<?= $p['id']; ?>"><?= e($p['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <select class="form-select" id="filterCategory">
        <option value="">All Categories</option>
        <?php foreach($categoryItems as $c): ?>
        <option value="<?= $c['id']; ?>"><?= e($c['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <input class="form-control" id="filterTags" placeholder="Tags" />
    </div>
  </div>

  <div id="strategyList" class="mb-5">
    <!-- strategies will be loaded here -->
    <div class="text-center text-body-tertiary py-5">No strategies found.</div>
  </div>

  <!-- Tabs for selected strategy -->
  <ul class="nav nav-tabs" id="strategyTabs" role="tablist">
    <li class="nav-item" role="presentation"><button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="objectives-tab" data-bs-toggle="tab" data-bs-target="#objectives" type="button" role="tab">Objectives</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="collaborators-tab" data-bs-toggle="tab" data-bs-target="#collaborators" type="button" role="tab">Collaborators</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">Notes</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">Files</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="kpi-tab" data-bs-toggle="tab" data-bs-target="#kpi" type="button" role="tab">KPI Dashboard</button></li>
  </ul>
  <div class="tab-content" id="strategyTabsContent">
    <div class="tab-pane fade show active p-3" id="overview" role="tabpanel">Select a strategy to see details.</div>
    <div class="tab-pane fade p-3" id="objectives" role="tabpanel">
      <div class="d-flex justify-content-end">
        <?php if (user_has_permission('admin_strategy','create')): ?>
        <button class="btn btn-sm btn-primary" id="addObjectiveBtn" data-bs-toggle="modal" data-bs-target="#addObjectiveModal">Add Objective</button>
        <?php endif; ?>
      </div>
      <div id="objectivesTree" class="mt-3"></div>
    </div>
    <div class="tab-pane fade p-3" id="collaborators" role="tabpanel">
      <div class="d-flex justify-content-end mb-2">
        <?php if (user_has_permission('admin_strategy','create')): ?>
        <button class="btn btn-sm btn-primary" id="addCollaboratorBtn" data-bs-toggle="modal" data-bs-target="#addCollaboratorModal">Add Collaborator</button>
        <?php endif; ?>
      </div>
      <ul class="list-group" id="collaboratorsList"></ul>
    </div>
    <div class="tab-pane fade p-3" id="notes" role="tabpanel">
      <div class="d-flex justify-content-end mb-2">
        <?php if (user_has_permission('admin_strategy','create')): ?>
        <button class="btn btn-sm btn-primary" id="addNoteBtn" data-bs-toggle="modal" data-bs-target="#addNoteModal">Add Note</button>
        <?php endif; ?>
      </div>
      <ul class="list-group" id="notesList"></ul>
    </div>
    <div class="tab-pane fade p-3" id="files" role="tabpanel">
      <div class="d-flex justify-content-end mb-2">
        <?php if (user_has_permission('admin_strategy','create')): ?>
        <button class="btn btn-sm btn-primary" id="addFileBtn" data-bs-toggle="modal" data-bs-target="#addFileModal">Upload File</button>
        <?php endif; ?>
      </div>
      <ul class="list-group" id="filesList"></ul>
    </div>
    <div class="tab-pane fade p-3" id="kpi" role="tabpanel">
      <div class="d-flex justify-content-end mb-2">
        <?php if (user_has_permission('admin_strategy','create')): ?>
        <button class="btn btn-sm btn-primary" id="addKpiBtn" data-bs-toggle="modal" data-bs-target="#addKpiModal">Add KPI</button>
        <?php endif; ?>
      </div>
      <ul class="list-group" id="kpiList"></ul>
    </div>
  </div>
</div>

<!-- Add Strategy Modal -->
<div class="modal fade" id="addStrategyModal" tabindex="-1" aria-labelledby="addStrategyLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addStrategyForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStrategyLabel">Add Strategy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="strategyTitle" class="form-label">Title</label>
          <input type="text" class="form-control" id="strategyTitle" name="title" required>
        </div>
        <div class="mb-3">
          <label for="strategyStatus" class="form-label">Status</label>
          <select id="strategyStatus" name="status" class="form-select">
            <option value="">--</option>
            <?php foreach($statusItems as $s): ?>
            <option value="<?= $s['id']; ?>"><?= e($s['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="strategyPriority" class="form-label">Priority</label>
          <select id="strategyPriority" name="priority" class="form-select">
            <option value="">--</option>
            <?php foreach($priorityItems as $p): ?>
            <option value="<?= $p['id']; ?>"><?= e($p['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="strategyCategory" class="form-label">Category</label>
          <select id="strategyCategory" name="category_id" class="form-select">
            <option value="">--</option>
            <?php foreach($categoryItems as $c): ?>
            <option value="<?= $c['id']; ?>"><?= e($c['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="strategyDescription" class="form-label">Description</label>
          <textarea id="strategyDescription" name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
          <label for="strategyTargetStart" class="form-label">Target Start</label>
          <input type="date" class="form-control" id="strategyTargetStart" name="target_start">
        </div>
        <div class="mb-3">
          <label for="strategyTargetEnd" class="form-label">Target End</label>
          <input type="date" class="form-control" id="strategyTargetEnd" name="target_end">
        </div>
        <div class="mb-3">
          <label for="strategyTags" class="form-label">Tags</label>
          <input type="text" class="form-control" id="strategyTags" name="tags">
        </div>
        <?= csrf_field(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<?php require 'includes/objective_modal.php'; ?>
<?php require 'includes/collaborator_modal.php'; ?>
<?php require 'includes/note_modal.php'; ?>
<?php require 'includes/file_modal.php'; ?>
<?php require 'includes/kpi_modal.php'; ?>

<script>
$(function(){
  let strategiesCache = [];
  let currentStrategyId = null;
  function escapeHtml(text=""){ return $('<div>').text(text).html(); }
  function updateStrategyIdInputs(id){ $('.strategy-id-input').val(id); }
  function initChoices($el){
    if(window.Choices){
      const existing = $el.data('choices-instance');
      if(existing) existing.destroy();
      const inst = new Choices($el[0], {searchEnabled:true});
      $el.data('choices-instance', inst);
    }
  }
  function populateSelect($el, url, placeholder){
    $.getJSON(url, function(resp){
      if(resp.success){
        const items = resp.items || resp.people || resp.roles || resp.objectives || [];
        let html = `<option value="">${placeholder}</option>`;
        items.forEach(i=>{ const label = i.label || i.name; html += `<option value="${i.id}">${escapeHtml(label)}</option>`; });
        $el.html(html);
        initChoices($el);
      }
    });
  }
  function loadStrategies(){
    $.getJSON('functions/read_strategies.php',{
      status: $('#filterStatus').val(),
      priority: $('#filterPriority').val(),
      category: $('#filterCategory').val(),
      tags: $('#filterTags').val()
    }, function(resp){
      if(resp.success){
        strategiesCache = resp.strategies;
        if(resp.strategies.length){
          let html='';
          resp.strategies.forEach(s=>{
            const statusBadge   = s.status_label   ? `<span class="badge badge-phoenix badge-phoenix-${s.status_color} me-1"><span class="badge-label">${escapeHtml(s.status_label)}</span></span>` : '';
            const priorityBadge = s.priority_label ? `<span class="badge badge-phoenix badge-phoenix-${s.priority_color} me-1"><span class="badge-label">${escapeHtml(s.priority_label)}</span></span>` : '';
            const categoryBadge = s.category_label ? `<span class="badge badge-phoenix badge-phoenix-${s.category_color}"><span class="badge-label">${escapeHtml(s.category_label)}</span></span>` : '';
            html += `<div class="card mb-2 strategy-item" data-id="${s.id}"><div class="card-body d-flex justify-content-between"><div>${escapeHtml(s.title)}</div><div class="text-nowrap">${statusBadge}${priorityBadge}${categoryBadge}</div></div></div>`;
          });
          $('#strategyList').html(html);
        } else {
          $('#strategyList').html('<div class="text-center text-body-tertiary py-5">No strategies found.</div>');
        }
      }
    });
  }
  $('#filterStatus, #filterPriority, #filterCategory').on('change', loadStrategies);
  $('#filterTags').on('keyup', debounce(loadStrategies,300));
  $('#strategyList').on('click','.strategy-item',function(){
    const id = $(this).data('id');
    currentStrategyId = id;
    const strategy = strategiesCache.find(s => s.id == id);
    $('.strategy-item').removeClass('active');
    $(this).addClass('active');
    updateStrategyIdInputs(id);
    if(strategy){
      $('#overview').html('<h4>'+escapeHtml(strategy.title)+'</h4>');
    }
    loadObjectives(id);
    $('#collaboratorsList, #notesList, #filesList, #kpiList').html('');
  });
  $('#strategyTabs button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e){
    if(!currentStrategyId) return;
    const target = $(e.target).attr('data-bs-target');
    if(target === '#collaborators') loadCollaborators(currentStrategyId);
    if(target === '#notes') loadNotes(currentStrategyId);
    if(target === '#files') loadFiles(currentStrategyId);
    if(target === '#kpi') loadKpi(currentStrategyId);
    if(target === '#objectives') loadObjectives(currentStrategyId);
  });
  $('#addStrategyForm').on('submit', function(e){
    e.preventDefault();
    $.post('functions/create_strategy.php', $(this).serialize(), function(resp){
      if(resp.success){
        if(window.phoenix && phoenix.toast){ phoenix.toast.success('Strategy added'); } else { alert('Strategy added'); }
        $('#addStrategyModal').modal('hide');
        loadStrategies();
      } else {
        if(window.phoenix && phoenix.toast){ phoenix.toast.error(resp.error || 'Error'); } else { alert(resp.error || 'Error'); }
      }
    }, 'json');
  });
  $('#addObjectiveForm').on('submit', function(e){
    e.preventDefault();
    $.post('functions/add_objective.php', $(this).serialize(), function(resp){
      if(resp.success){
        if(window.phoenix && phoenix.toast){ phoenix.toast.success('Objective added'); } else { alert('Objective added'); }
        $('#addObjectiveModal').modal('hide');
        loadObjectives(currentStrategyId);
      } else {
        if(window.phoenix && phoenix.toast){ phoenix.toast.error(resp.error || 'Error'); } else { alert(resp.error || 'Error'); }
      }
    },'json');
  });
  $('#addCollaboratorForm').on('submit', function(e){
    e.preventDefault();
    $.post('functions/add_collaborator.php', $(this).serialize(), function(resp){
      if(resp.success){
        if(window.phoenix && phoenix.toast){ phoenix.toast.success('Collaborator added'); } else { alert('Collaborator added'); }
        $('#addCollaboratorModal').modal('hide');
        loadCollaborators(currentStrategyId);
      } else {
        if(window.phoenix && phoenix.toast){ phoenix.toast.error(resp.error || 'Error'); } else { alert(resp.error || 'Error'); }
      }
    },'json');
  });
  $('#addNoteForm').on('submit', function(e){
    e.preventDefault();
    $.post('functions/add_note.php', $(this).serialize(), function(resp){
      if(resp.success){
        if(window.phoenix && phoenix.toast){ phoenix.toast.success('Note added'); } else { alert('Note added'); }
        $('#addNoteModal').modal('hide');
        loadNotes(currentStrategyId);
      } else {
        if(window.phoenix && phoenix.toast){ phoenix.toast.error(resp.error || 'Error'); } else { alert(resp.error || 'Error'); }
      }
    },'json');
  });
  $('#uploadFileForm').on('submit', function(e){
    e.preventDefault();
    const fd = new FormData(this);
    $.ajax({
      url:'functions/upload_file.php',
      method:'POST',
      data:fd,
      processData:false,
      contentType:false,
      dataType:'json',
      success:function(resp){
        if(resp.success){
          if(window.phoenix && phoenix.toast){ phoenix.toast.success('File uploaded'); } else { alert('File uploaded'); }
          $('#addFileModal').modal('hide');
          loadFiles(currentStrategyId);
        } else {
          if(window.phoenix && phoenix.toast){ phoenix.toast.error(resp.error || 'Error'); } else { alert(resp.error || 'Error'); }
        }
      }
    });
  });
  $('#addKpiForm').on('submit', function(e){
    e.preventDefault();
    $.post('functions/add_key_result.php', $(this).serialize(), function(resp){
      if(resp.success){
        if(window.phoenix && phoenix.toast){ phoenix.toast.success('KPI added'); } else { alert('KPI added'); }
        $('#addKpiModal').modal('hide');
        loadKpi(currentStrategyId);
      } else {
        if(window.phoenix && phoenix.toast){ phoenix.toast.error(resp.error || 'Error'); } else { alert(resp.error || 'Error'); }
      }
    },'json');
  });
  $('#addObjectiveModal').on('show.bs.modal', function(){
    const $sel = $('#objectiveParent');
    $sel.html('<option value="">Top Level</option>');
    $('#objectivesTree li > div span.flex-grow-1').each(function(){
      const li = $(this).closest('li');
      $sel.append('<option value="'+li.data('id')+'">'+escapeHtml($(this).text().trim())+'</option>');
    });
    populateSelect($('#objectiveOwner'),'functions/read_people.php','Select Owner');
  });
  $('#addCollaboratorModal').on('show.bs.modal', function(){
    populateSelect($('#collaboratorPerson'),'functions/read_people.php','Select Person');
    populateSelect($('#collaboratorRole'),'functions/read_roles.php','Select Role');
  });
  $('#addKpiModal').on('show.bs.modal', function(){
    if(currentStrategyId){
      populateSelect($('#kpiObjective'),'functions/read_objectives.php?strategy_id='+currentStrategyId,'Select Objective');
    }
  });
  function loadObjectives(strategyId){
    $.getJSON('functions/read_objectives.php',{strategy_id:strategyId},function(resp){
      if(resp.success){
        const treeHtml = buildObjectivesTree(resp.objectives);
        $('#objectivesTree').html(treeHtml);
        $('#objectivesTree ul').sortable({
          connectWith:'#objectivesTree ul',
          placeholder:'sortable-placeholder',
          update:function(event,ui){
            const hierarchy = collectHierarchy($('#objectivesTree > ul'));
            $.post('functions/reorder_objectives.php',{hierarchy: JSON.stringify(hierarchy)},function(r){
              if(r.success && window.phoenix && phoenix.toast){ phoenix.toast.success('Objectives reordered'); }
            },'json');
          }
        });
      }
    });
  }
  function loadCollaborators(strategyId){
    $.getJSON('functions/read_collaborators.php',{strategy_id:strategyId},function(resp){
      if(resp.success){
        if(resp.collaborators && resp.collaborators.length){
          let html='';
          resp.collaborators.forEach(c=>{
            html += `<li class="list-group-item d-flex justify-content-between"><span>${escapeHtml(c.name || '')}</span><span class="text-body-secondary">${escapeHtml(c.role || '')}</span></li>`;
          });
          $('#collaboratorsList').html(html);
        } else {
          $('#collaboratorsList').html('<li class="list-group-item text-body-tertiary">No collaborators</li>');
        }
      }
    });
  }
  function loadNotes(strategyId){
    $.getJSON('functions/read_notes.php',{strategy_id:strategyId},function(resp){
      if(resp.success){
        if(resp.notes && resp.notes.length){
          let html='';
          resp.notes.forEach(n=>{ html += `<li class="list-group-item">${escapeHtml(n.note)}</li>`; });
          $('#notesList').html(html);
        } else {
          $('#notesList').html('<li class="list-group-item text-body-tertiary">No notes</li>');
        }
      }
    });
  }
  function loadFiles(strategyId){
    $.getJSON('functions/read_files.php',{strategy_id:strategyId},function(resp){
      if(resp.success){
        if(resp.files && resp.files.length){
          let html='';
          resp.files.forEach(f=>{ html += `<li class="list-group-item"><a href="${escapeHtml(f.file_path)}" target="_blank">${escapeHtml(f.file_name)}</a></li>`; });
          $('#filesList').html(html);
        } else {
          $('#filesList').html('<li class="list-group-item text-body-tertiary">No files</li>');
        }
      }
    });
  }
  function loadKpi(strategyId){
    $.getJSON('functions/read_key_results.php',{strategy_id:strategyId},function(resp){
      if(resp.success){
        if(resp.key_results && resp.key_results.length){
          let html='';
          resp.key_results.forEach(k=>{ html += `<li class="list-group-item">${escapeHtml(k.title || k.name || '')}</li>`; });
          $('#kpiList').html(html);
        } else {
          $('#kpiList').html('<li class="list-group-item text-body-tertiary">No KPIs</li>');
        }
      }
    });
  }
  function buildObjectivesTree(items, parent=0){
    let html = '<ul class="list-unstyled" data-parent="'+parent+'">';
    items.filter(o => +o.parent_id === parent).forEach(o => {
      html += '<li data-id="'+o.id+'">'+
        '<div class="d-flex align-items-center mb-2"><span class="flex-grow-1">'+escapeHtml(o.title)+'</span>'+
        '<div class="progress flex-grow-1 ms-2" style="height:4px;"><div class="progress-bar" style="width:'+(o.progress||0)+'%"></div></div></div>'+
        buildObjectivesTree(items, o.id)+
      '</li>';
    });
    html += '</ul>';
    return html;
  }
  function collectHierarchy($ul){
    const arr=[];
    $ul.children('li').each(function(index){
      const id=$(this).data('id');
      const children=collectHierarchy($(this).children('ul'));
      arr.push({id:id,parent_id:$ul.data('parent'),sort:index,children:children});
    });
    return arr;
  }
  function debounce(fn,delay){
    let timer; return function(){ clearTimeout(timer); timer=setTimeout(fn,delay); };
  }
  loadStrategies();
});
</script>
<?php require '../../admin_footer.php'; ?>
