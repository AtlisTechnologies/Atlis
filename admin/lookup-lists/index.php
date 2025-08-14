<?php
require '../admin_header.php';

$token = generate_csrf_token();
$stmt = $pdo->query('SELECT id, name, description, memo FROM lookup_lists ORDER BY id DESC');
$lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Lookup Lists</h2>
<button id="addListBtn" class="btn btn-sm btn-success mb-3">Add Lookup List</button>
<div id="lookup-lists" data-list='{"valueNames":["id","name","description"],"page":50,"pagination":true}'>
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
              <a class="btn btn-sm btn-info" href="items.php?list_id=<?= $l['id']; ?>">Items</a>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
  var csrfToken = '<?= $token; ?>';
  var listModal = new bootstrap.Modal(document.getElementById('listModal'));

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
              +'<a class="btn btn-sm btn-info" href="items.php?list_id='+l.id+'">Items</a> '
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
});

</script>
<?php require '../admin_footer.php'; ?>
