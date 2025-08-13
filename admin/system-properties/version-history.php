<?php
require '../admin_header.php';
require_permission('system_properties','read');

$id = (int)($_GET['id'] ?? 0);
$token = generate_csrf_token();

$stmt = $pdo->prepare('SELECT name FROM system_properties WHERE id=:id');
$stmt->execute([':id'=>$id]);
$name = $stmt->fetchColumn();

$versions = [];
if($id){
  $stmt = $pdo->prepare('SELECT id, value, user_id, date_created FROM system_property_versions WHERE property_id=:id ORDER BY date_created DESC');
  $stmt->execute([':id'=>$id]);
  $versions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<h2 class="mb-4">Version History: <?= htmlspecialchars($name); ?></h2>
<table class="table table-striped table-sm">
  <thead><tr><th>Date</th><th>User</th><th>Value</th><th>Action</th></tr></thead>
  <tbody>
  <?php foreach($versions as $v): ?>
    <tr data-id="<?= $v['id']; ?>">
      <td><?= htmlspecialchars($v['date_created']); ?></td>
      <td><?= htmlspecialchars($v['user_id']); ?></td>
      <td><pre class="mb-0"><?= htmlspecialchars($v['value']); ?></pre></td>
      <td><button class="btn btn-sm btn-warning restore" data-id="<?= $v['id']; ?>">Restore</button></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
  var csrfToken = '<?= $token; ?>';
  $('.restore').on('click', function(){
    if(!confirm('Restore this version?')) return;
    var vid = $(this).data('id');
    $.post('../api/system-properties.php',{action:'restore',version_id:vid,csrf_token:csrfToken},function(res){
      if(res.success){
        alert('Version restored');
        window.location = 'index.php';
      }else{
        alert(res.error);
      }
    },'json');
  });
});
</script>
<?php require '../admin_footer.php'; ?>
