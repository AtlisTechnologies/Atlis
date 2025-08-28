<?php
require '../../admin_header.php';
require_permission('admin_strategy','read');
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
      </select>
    </div>
    <div class="col-md-3">
      <select class="form-select" id="filterPriority">
        <option value="">All Priorities</option>
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
      <div id="objectivesTree" class="mt-3"></div>
    </div>
    <div class="tab-pane fade p-3" id="collaborators" role="tabpanel">Collaborators content</div>
    <div class="tab-pane fade p-3" id="notes" role="tabpanel">Notes content</div>
    <div class="tab-pane fade p-3" id="files" role="tabpanel">Files content</div>
    <div class="tab-pane fade p-3" id="kpi" role="tabpanel">KPI Dashboard content</div>
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
          <select id="strategyStatus" name="status" class="form-select"></select>
        </div>
        <div class="mb-3">
          <label for="strategyPriority" class="form-label">Priority</label>
          <select id="strategyPriority" name="priority" class="form-select"></select>
        </div>
        <div class="mb-3">
          <label for="strategyTags" class="form-label">Tags</label>
          <input type="text" class="form-control" id="strategyTags" name="tags">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
$(function() {
  // Load strategies with filters
  function loadStrategies() {
    $.getJSON('functions/read_strategies.php', {
      status: $('#filterStatus').val(),
      priority: $('#filterPriority').val(),
      tags: $('#filterTags').val()
    }, function(resp) {
      if (resp.success) {
        $('#strategyList').html(resp.html);
      }
    });
  }
  $('#filterStatus, #filterPriority').on('change', loadStrategies);
  $('#filterTags').on('keyup', debounce(loadStrategies, 300));

  // Add strategy
  $('#addStrategyForm').on('submit', function(e) {
    e.preventDefault();
    $.post('functions/create_strategy.php', $(this).serialize(), function(resp) {
      if (resp.success) {
        if (window.phoenix && phoenix.toast) { phoenix.toast.success('Strategy added'); } else { alert('Strategy added'); }
        $('#addStrategyModal').modal('hide');
        loadStrategies();
      } else {
        if (window.phoenix && phoenix.toast) { phoenix.toast.error(resp.error || 'Error'); } else { alert(resp.error || 'Error'); }
      }
    }, 'json');
  });

  // Objectives tree loading
  function loadObjectives(strategyId) {
    $.getJSON('functions/read_objectives.php', {strategy_id: strategyId}, function(resp) {
      if (resp.success) {
        const treeHtml = buildObjectivesTree(resp.objectives);
        $('#objectivesTree').html(treeHtml);
        $('#objectivesTree ul').sortable({
          connectWith: '#objectivesTree ul',
          placeholder: 'sortable-placeholder',
          update: function(event, ui) {
            const hierarchy = collectHierarchy($('#objectivesTree > ul'));
            $.post('functions/reorder_objectives.php', {hierarchy: JSON.stringify(hierarchy)}, function(r) {
              if (r.success) {
                if (window.phoenix && phoenix.toast) { phoenix.toast.success('Objectives reordered'); }
              }
            }, 'json');
          }
        });
      }
    });
  }

  function buildObjectivesTree(items, parent = 0) {
    let html = '<ul class="list-unstyled" data-parent="'+parent+'">';
    items.filter(o => +o.parent_id === parent).forEach(o => {
      html += '<li data-id="'+o.id+'">'+
        '<div class="d-flex align-items-center mb-2"><span class="flex-grow-1">'+o.title+'</span>'+
        '<div class="progress flex-grow-1 ms-2" style="height:4px;">
          <div class="progress-bar" style="width:'+ (o.progress||0) +'%"></div>
        </div></div>'+
        buildObjectivesTree(items, o.id) +
      '</li>';
    });
    html += '</ul>';
    return html;
  }

  function collectHierarchy($ul) {
    const arr = [];
    $ul.children('li').each(function(index) {
      const id = $(this).data('id');
      const children = collectHierarchy($(this).children('ul'));
      arr.push({id: id, parent_id: $ul.data('parent'), sort: index, children: children});
    });
    return arr;
  }

  function debounce(fn, delay) {
    let timer; return function() { clearTimeout(timer); timer = setTimeout(fn, delay); };
  }

  loadStrategies();
});
</script>
<?php require '../../admin_footer.php'; ?>
