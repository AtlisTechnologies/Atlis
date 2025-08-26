<?php
require '../admin_header.php';
require_permission('system_properties','read');

$token = generate_csrf_token();

$stmt = $pdo->query('SELECT sp.id, sp.name, sp.value, sp.memo, c.label AS category, t.label AS type FROM system_properties sp JOIN lookup_list_items c ON sp.category_id = c.id AND c.active_from <= CURDATE() AND (c.active_to IS NULL OR c.active_to >= CURDATE()) JOIN lookup_list_items t ON sp.type_id = t.id AND t.active_from <= CURDATE() AND (t.active_to IS NULL OR t.active_to >= CURDATE()) ORDER BY sp.name');
$props = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">System Properties</h2>
<a href="edit.php" class="btn btn-sm btn-success mb-3">Add Property</a>
<div id="properties" data-list='{"valueNames":["id","name","category","type"],"page":25,"pagination":true}'>
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
        <?php $isPassword = stripos($p['type'],'password') !== false || stripos($p['name'],'password') !== false; ?>
        <tr data-id="<?= e($p['id']); ?>">
          <td class="id"><?= e($p['id']); ?></td>
          <td class="name"><?= e($p['name']); ?></td>
          <td class="category"><?= e($p['category']); ?></td>
          <td class="type"><?= e($p['type']); ?></td>
          <td>
            <?php if($isPassword): ?>
            <div class="d-flex align-items-center">
              <input type="password" class="form-control-plaintext form-control-sm w-auto" value="<?= e($p['value'], ENT_QUOTES); ?>" readonly>
              <button type="button" class="btn btn-sm btn-phoenix-secondary ms-2 toggle-password"><span class="fa-solid fa-eye"></span></button>
            </div>
            <?php else: ?>
            <?= e($p['value']); ?>
            <?php endif; ?>
          </td>
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
  $('#properties').on('click','.toggle-password',function(){
    var btn = $(this);
    var input = btn.closest('div').find('input');
    if(input.attr('type') === 'password'){
      input.attr('type','text');
      btn.find('span').removeClass('fa-eye').addClass('fa-eye-slash');
    }else{
      input.attr('type','password');
      btn.find('span').removeClass('fa-eye-slash').addClass('fa-eye');
    }
  });
});
</script>
<?php require '../admin_footer.php'; ?>
