<?php
require '../../admin_header.php';
require_permission('asset_policies','read');

$token = generate_csrf_token();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = $_GET['action'] ?? '';
$editing = $id > 0;

if(!$editing && $action !== 'add'){
    $policies = $pdo->query('SELECT id,version,effective_date,active FROM module_asset_policies ORDER BY effective_date DESC')->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h2 class="mb-4">Asset Policies</h2>
    <?= flash_message($_SESSION['message'] ?? '', 'success'); ?>
    <?= flash_message($_SESSION['error_message'] ?? '', 'danger'); ?>
    <?php unset($_SESSION['message'], $_SESSION['error_message']); ?>
    <?php if(user_has_permission('asset_policies','update')): ?>
    <a class="btn btn-sm btn-success mb-3" href="policy.php?action=add">Add Policy</a>
    <?php endif; ?>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead><tr><th>Version</th><th>Effective Date</th><th>Status</th><th></th></tr></thead>
        <tbody>
          <?php foreach($policies as $p): ?>
          <tr>
            <td><?= e($p['version']); ?></td>
            <td><?= e($p['effective_date']); ?></td>
            <td><?= $p['active'] ? 'Active' : 'Inactive'; ?></td>
            <td>
              <?php if(user_has_permission('asset_policies','update')): ?>
              <a class="btn btn-sm btn-primary" href="policy.php?id=<?= $p['id']; ?>">Edit</a>
              <form method="post" action="functions/policy-delete.php" class="d-inline" onsubmit="return confirm('Deactivate policy?');">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <input type="hidden" name="id" value="<?= $p['id']; ?>">
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php
    require '../admin_footer.php';
    exit;
}

require_permission('asset_policies','update');
$policy = ['version'=>'','effective_date'=>'','content'=>''];
if($editing){
    $stmt = $pdo->prepare('SELECT * FROM module_asset_policies WHERE id=:id');
    $stmt->execute([':id'=>$id]);
    $policy = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$policy){
        $_SESSION['error_message'] = 'Policy not found';
        header('Location: policy.php');
        exit;
    }
}
?>
<h2 class="mb-4"><?= $editing ? 'Edit' : 'Add'; ?> Policy</h2>
<form method="post" action="functions/policy-save.php">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <?php if($editing): ?><input type="hidden" name="id" value="<?= $id; ?>"><?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Version</label>
    <input type="text" name="version" class="form-control" value="<?= e($policy['version']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Effective Date</label>
    <input type="text" name="effective_date" class="form-control" data-flatpickr value="<?= e($policy['effective_date']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Content</label>
    <textarea name="content" id="policyContent" class="form-control" rows="10" required><?= e($policy['content']); ?></textarea>
  </div>
  <button class="btn btn-primary" type="submit">Save</button>
  <a class="btn btn-secondary" href="policy.php">Cancel</a>
</form>
<link rel="stylesheet" href="../vendors/flatpickr/flatpickr.min.css">
<script src="../vendors/flatpickr/flatpickr.min.js"></script>
<script src="../vendors/tinymce/tinymce.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('[data-flatpickr]').forEach(el=>flatpickr(el,{}));
    tinymce.init({ selector:'#policyContent', height:300 });
  });
</script>
<?php require '../admin_footer.php'; ?>
