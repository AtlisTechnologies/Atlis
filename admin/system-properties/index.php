<?php
require '../admin_header.php';
require_permission('system_properties','read');

$token = generate_csrf_token();

$stmt = $pdo->query('SELECT sp.id, sp.name, sp.value, sp.memo, c.label AS category, t.label AS type FROM system_properties sp JOIN lookup_list_items c ON sp.category_id = c.id AND c.active_from <= CURDATE() AND (c.active_to IS NULL OR c.active_to >= CURDATE()) JOIN lookup_list_items t ON sp.type_id = t.id AND t.active_from <= CURDATE() AND (t.active_to IS NULL OR t.active_to >= CURDATE()) ORDER BY sp.name');
$props = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">System Properties</h2>
<a href="edit.php" class="btn btn-sm btn-success mb-3">Add Property</a>
<div id="properties" data-list='{"valueNames":["id","name","category","type"],"page":10,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto"><input class="form-control form-control-sm search" placeholder="Search" /></div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm mb-0">
      <thead>
        <tr>
          <th class="sort" data-sort="id">ID</th>
          <th class="sort" data-sort="name">Name</th>
          <th class="sort" data-sort="category">Category</th>
          <th class="sort" data-sort="type">Type</th>
          <th>Value</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="list">
        <?php foreach($props as $p): ?>
        <tr data-id="<?= htmlspecialchars($p['id']); ?>">
          <td class="id"><?= htmlspecialchars($p['id']); ?></td>
          <td class="name"><?= htmlspecialchars($p['name']); ?></td>
          <td class="category"><?= htmlspecialchars($p['category']); ?></td>
          <td class="type"><?= htmlspecialchars($p['type']); ?></td>
          <td><?= htmlspecialchars($p['value']); ?></td>
          <td>
            <a href="edit.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="version-history.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-info">Versions</a>
            <button class="btn btn-sm btn-danger delete-property" data-id="<?= $p['id']; ?>">Delete</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
  var csrfToken = '<?= $token; ?>';
  $('#properties').on('click','.delete-property',function(){
    if(!confirm('Delete this property?')) return;
    var id = $(this).data('id');
    $.post('../api/system-properties.php',{action:'delete',id:id,csrf_token:csrfToken},function(res){
      if(res.success){
        $('tr[data-id="'+id+'"]').remove();
      }else{
        alert(res.error);
      }
    },'json');
  });
});
</script>
<?php require '../admin_footer.php'; ?>
