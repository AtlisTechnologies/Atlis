<?php
require '../admin_header.php';

$token = generate_csrf_token();
$stmt = $pdo->query('SELECT id, name, description, memo FROM lookup_lists ORDER BY name');
$lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Lookup Lists</h2>
<button id="addListBtn" class="btn btn-sm btn-success mb-3">Add Lookup List</button>
<div id="lookup-lists" data-list='{"valueNames":["id","name","description"],"page":10,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm mb-0">
      <thead>
        <tr>
          <th class="sort" data-sort="id">ID</th>
          <th class="sort" data-sort="name">Name</th>
          <th class="sort" data-sort="description">Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="list">
        <?php foreach($lists as $l): ?>
          <tr data-id="<?= htmlspecialchars($l['id']); ?>">
            <td class="id"><?= htmlspecialchars($l['id']); ?></td>
            <td class="name"><?= htmlspecialchars($l['name']); ?></td>
            <td class="description"><?= htmlspecialchars($l['description']); ?></td>
            <td>
              <button class="btn btn-sm btn-warning edit-list" data-id="<?= $l['id']; ?>" data-name="<?= htmlspecialchars($l['name'], ENT_QUOTES); ?>" data-description="<?= htmlspecialchars($l['description'], ENT_QUOTES); ?>" data-memo="<?= htmlspecialchars($l['memo'], ENT_QUOTES); ?>">Edit</button>
              <button class="btn btn-sm btn-info items-list" data-id="<?= $l['id']; ?>" data-name="<?= htmlspecialchars($l['name'], ENT_QUOTES); ?>">Items</button>
              <button class="btn btn-sm btn-danger delete-list" data-id="<?= $l['id']; ?>">Delete</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-between align-items-center mt-3">
    <p class="mb-0" data-list-info></p>
    <ul class="pagination mb-0"></ul>
  </div>
</div>
<div class="modal fade" id="listModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="listForm">
      <div class="modal-header">
        <h5 class="modal-title" id="listModalLabel">Add Lookup List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="listAlert"></div>
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <input type="hidden" name="id" id="list-id">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" class="form-control" name="name" id="list-name" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea class="form-control" name="description" id="list-description"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Memo</label>
          <textarea class="form-control" name="memo" id="list-memo"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="listSaveBtn">
          <span class="spinner-border spinner-border-sm d-none" id="listLoading"></span>
          Save
        </button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="itemModalLabel">Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="itemAlert"></div>
        <form id="itemForm" class="row g-2 mb-3">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <input type="hidden" name="list_id" id="item-list-id">
          <input type="hidden" name="id" id="item-id">
          <div class="col-md-3"><input class="form-control" name="label" id="item-label" placeholder="Label" required></div>
          <div class="col-md-2"><input class="form-control" name="value" id="item-value" placeholder="Value"></div>
          <div class="col-md-2"><input class="form-control" type="date" name="active_from" id="item-active-from" value="<?= date('Y-m-d'); ?>" required></div>
          <div class="col-md-2"><input class="form-control" type="date" name="active_to" id="item-active-to"></div>
          <div class="col-md-1"><input class="form-control" type="number" name="sort_order" id="item-sort" placeholder="Sort"></div>
          <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit" id="itemSaveBtn">
              <span class="spinner-border spinner-border-sm d-none" id="itemLoading"></span>
              Save
            </button>
          </div>
        </form>
        <table class="table table-striped table-sm" id="itemsTable">
          <thead><tr><th>Label</th><th>Value</th><th>Active From</th><th>Active To</th><th>Sort</th><th>Attributes</th><th>Actions</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="attrModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="attrModalLabel">Attributes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="attrAlert"></div>
        <form id="attrForm" class="row g-2 mb-3">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <input type="hidden" name="item_id" id="attr-item-id">
          <input type="hidden" name="id" id="attr-id">
          <div class="col-md-4"><input class="form-control" name="attr_key" id="attr-key" placeholder="Key" required></div>
          <div class="col-md-4"><input class="form-control" name="attr_value" id="attr-value" placeholder="Value"></div>
          <div class="col-md-4">
            <button class="btn btn-primary w-100" type="submit" id="attrSaveBtn">
              <span class="spinner-border spinner-border-sm d-none" id="attrLoading"></span>
              Save
            </button>
          </div>
        </form>
        <table class="table table-striped table-sm" id="attrsTable">
          <thead><tr><th>Key</th><th>Value</th><th>Actions</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
  var csrfToken = '<?= $token; ?>';
  var listModal = new bootstrap.Modal(document.getElementById('listModal'));
  var itemModal = new bootstrap.Modal(document.getElementById('itemModal'));
  var attrModal = new bootstrap.Modal(document.getElementById('attrModal'));

  $('#addListBtn').on('click', function(){
    $('#listForm')[0].reset();
    $('#list-id').val('');
    $('#listModalLabel').text('Add Lookup List');
    $('#listAlert').html('');
    listModal.show();
  });

  $('#lookup-lists').on('click', '.edit-list', function(){
    var btn = $(this);
    $('#list-id').val(btn.data('id'));
    $('#list-name').val(btn.data('name'));
    $('#list-description').val(btn.data('description'));
    $('#list-memo').val(btn.data('memo'));
    $('#listModalLabel').text('Edit Lookup List');
    $('#listAlert').html('');
    listModal.show();
  });

    $('#listForm').on('submit', function(e){
      e.preventDefault();
      $('#listLoading').removeClass('d-none');
      var action = $('#list-id').val() ? 'update' : 'create';
      var memoVal = $('#list-memo').val();
      $.post('../api/lookup-lists.php', $(this).serialize() + '&entity=list&action=' + action, function(res){
        $('#listLoading').addClass('d-none');
        if(res.success){
          $('#listAlert').html('<div class="alert alert-success">'+res.message+'</div>');
          var l = res.list;
          var row = $('#lookup-lists tbody tr').filter(function(){ return $(this).data('id') == l.id; });
          if(row.length){
            row.find('.name').text(l.name);
            row.find('.description').text(l.description);
            row.find('.edit-list').data('name', l.name).data('description', l.description).data('memo', memoVal);
          }else{
            var html = '<tr data-id="'+l.id+'">'
              +'<td class="id">'+l.id+'</td>'
              +'<td class="name">'+l.name+'</td>'
              +'<td class="description">'+l.description+'</td>'
              +'<td>'
              +'<button class="btn btn-sm btn-warning edit-list" data-id="'+l.id+'" data-name="'+l.name+'" data-description="'+l.description+'">Edit</button> '
              +'<button class="btn btn-sm btn-info items-list" data-id="'+l.id+'" data-name="'+l.name+'">Items</button> '
              +'<button class="btn btn-sm btn-danger delete-list" data-id="'+l.id+'">Delete</button>'
              +'</td></tr>';
            var $new = $(html);
            $new.find('.edit-list').data('memo', memoVal);
            $('#lookup-lists tbody').append($new);
          }
        }else{
          $('#listAlert').html('<div class="alert alert-danger">'+res.error+'</div>');
        }
      }, 'json').fail(function(){
        $('#listLoading').addClass('d-none');
        $('#listAlert').html('<div class="alert alert-danger">Server error.</div>');
      });
    });

  $('#lookup-lists').on('click', '.delete-list', function(){
    if(!confirm('Delete this list?')) return;
    var row = $(this).closest('tr');
    var id = $(this).data('id');
    $.post('../api/lookup-lists.php', {entity:'list', action:'delete', id:id, csrf_token:csrfToken}, function(res){
      if(res.success){
        row.remove();
      }else{
        $('#listAlert').html('<div class="alert alert-danger">'+res.error+'</div>');
        listModal.show();
      }
    }, 'json').fail(function(){
      $('#listAlert').html('<div class="alert alert-danger">Server error.</div>');
      listModal.show();
    });
  });

  $('#lookup-lists').on('click', '.items-list', function(){
    var btn = $(this);
    var listId = btn.data('id');
    $('#itemModalLabel').text('Items for ' + btn.data('name'));
    $('#itemForm')[0].reset();
    $('#item-list-id').val(listId);
    $('#item-id').val('');
    $('#itemAlert').html('');
    loadItems(listId);
    itemModal.show();
  });

  function loadItems(listId){
    $('#itemsTable tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
    $.getJSON('../api/lookup-lists.php', {entity:'item', action:'list', list_id:listId}, function(res){
      if(res.success){
        var rows='';
        $.each(res.items, function(i,it){
          rows+='<tr data-id="'+it.id+'"><td class="label">'+it.label+'</td><td class="value">'+it.value+'</td><td class="active_from">'+(it.active_from||'')+'</td><td class="active_to">'+(it.active_to||'')+'</td><td class="sort_order">'+it.sort_order+'</td><td><button class="btn btn-sm btn-secondary attributes-item">Attributes</button></td><td><button class="btn btn-sm btn-warning edit-item">Edit</button> <button class="btn btn-sm btn-danger delete-item">Delete</button></td></tr>';
        });
        $('#itemsTable tbody').html(rows);
      }else{
        $('#itemsTable tbody').html('<tr><td colspan="7" class="text-center">'+res.error+'</td></tr>');
      }
    });
  }

  $('#itemForm').on('submit', function(e){
    e.preventDefault();
    $('#itemLoading').removeClass('d-none');
    var action = $('#item-id').val() ? 'update':'create';
    $.post('../api/lookup-lists.php', $(this).serialize() + '&entity=item&action='+action, function(res){
      $('#itemLoading').addClass('d-none');
      if(res.success){
        $('#itemAlert').html('<div class="alert alert-success">'+res.message+'</div>');
        $('#itemForm')[0].reset();
        loadItems($('#item-list-id').val());
      }else{
        $('#itemAlert').html('<div class="alert alert-danger">'+res.error+'</div>');
      }
    }, 'json').fail(function(){
      $('#itemLoading').addClass('d-none');
      $('#itemAlert').html('<div class="alert alert-danger">Server error.</div>');
    });
  });

  $('#itemsTable').on('click', '.edit-item', function(){
    var tr = $(this).closest('tr');
    $('#item-id').val(tr.data('id'));
    $('#item-label').val(tr.find('.label').text());
    $('#item-value').val(tr.find('.value').text());
    $('#item-active-from').val(tr.find('.active_from').text());
    $('#item-active-to').val(tr.find('.active_to').text());
    $('#item-sort').val(tr.find('.sort_order').text());
  });

  $('#itemsTable').on('click', '.delete-item', function(){
    if(!confirm('Delete item?')) return;
    var tr = $(this).closest('tr');
    var id = tr.data('id');
    $.post('../api/lookup-lists.php', {entity:'item', action:'delete', id:id, csrf_token:csrfToken}, function(res){
      if(res.success){
        tr.remove();
      }else{
        $('#itemAlert').html('<div class="alert alert-danger">'+res.error+'</div>');
      }
    }, 'json').fail(function(){
      $('#itemAlert').html('<div class="alert alert-danger">Server error.</div>');
    });
  });

  $('#itemsTable').on('click', '.attributes-item', function(){
    var tr = $(this).closest('tr');
    var itemId = tr.data('id');
    $('#attrModalLabel').text('Attributes for ' + tr.find('.label').text());
    $('#attrForm')[0].reset();
    $('#attr-item-id').val(itemId);
    $('#attr-id').val('');
    $('#attrAlert').html('');
    loadAttrs(itemId);
    attrModal.show();
  });

  function loadAttrs(itemId){
    $('#attrsTable tbody').html('<tr><td colspan="3" class="text-center">Loading...</td></tr>');
    $.getJSON('../api/lookup-lists.php', {entity:'attribute', action:'list', item_id:itemId}, function(res){
      if(res.success){
        var rows='';
        $.each(res.attrs, function(i,a){
          rows+='<tr data-id="'+a.id+'"><td class="attr_key">'+a.attr_key+'</td><td class="attr_value">'+a.attr_value+'</td><td><button class="btn btn-sm btn-warning edit-attr">Edit</button> <button class="btn btn-sm btn-danger delete-attr">Delete</button></td></tr>';
        });
        $('#attrsTable tbody').html(rows);
      }else{
        $('#attrsTable tbody').html('<tr><td colspan="3" class="text-center">'+res.error+'</td></tr>');
      }
    });
  }

  $('#attrForm').on('submit', function(e){
    e.preventDefault();
    $('#attrLoading').removeClass('d-none');
    var action = $('#attr-id').val() ? 'update':'create';
    $.post('../api/lookup-lists.php', $(this).serialize() + '&entity=attribute&action='+action, function(res){
      $('#attrLoading').addClass('d-none');
      if(res.success){
        $('#attrAlert').html('<div class="alert alert-success">'+res.message+'</div>');
        $('#attrForm')[0].reset();
        loadAttrs($('#attr-item-id').val());
      }else{
        $('#attrAlert').html('<div class="alert alert-danger">'+res.error+'</div>');
      }
    }, 'json').fail(function(){
      $('#attrLoading').addClass('d-none');
      $('#attrAlert').html('<div class="alert alert-danger">Server error.</div>');
    });
  });

  $('#attrsTable').on('click', '.edit-attr', function(){
    var tr = $(this).closest('tr');
    $('#attr-id').val(tr.data('id'));
    $('#attr-key').val(tr.find('.attr_key').text());
    $('#attr-value').val(tr.find('.attr_value').text());
  });

  $('#attrsTable').on('click', '.delete-attr', function(){
    if(!confirm('Delete attribute?')) return;
    var tr = $(this).closest('tr');
    var id = tr.data('id');
    $.post('../api/lookup-lists.php', {entity:'attribute', action:'delete', id:id, csrf_token:csrfToken}, function(res){
      if(res.success){
        tr.remove();
      }else{
        $('#attrAlert').html('<div class="alert alert-danger">'+res.error+'</div>');
      }
    }, 'json').fail(function(){
      $('#attrAlert').html('<div class="alert alert-danger">Server error.</div>');
    });
  });
});
</script>
<?php require '../admin_footer.php'; ?>
