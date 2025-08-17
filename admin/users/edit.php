<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$username = $email = '';
$memo = [];
$profile_pic = '';

if ($id) {
  require_permission('users','update');
  $stmt = $pdo->prepare('SELECT username, email, profile_pic, memo FROM users WHERE id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $username = $row['username'];
    $email = $row['email'];
    $profile_pic = $row['profile_pic'];
    $memo = json_decode($row['memo'] ?? '{}', true);
  }
} else {
  require_permission('users','create');
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>
<h2 class="mb-4"><?php echo $id ? 'Edit' : 'Create'; ?> User</h2>
<form id="userForm" action="functions/save.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
  <?php if ($id): ?>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" <?php echo $id ? '' : 'required'; ?>>
  </div>
  <div class="mb-3">
    <label class="form-label">Billing Address</label>
    <input type="text" name="billing_address" class="form-control" value="<?php echo htmlspecialchars($memo['billing_address'] ?? ''); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Billing City</label>
    <input type="text" name="billing_city" class="form-control" value="<?php echo htmlspecialchars($memo['billing_city'] ?? ''); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Billing State</label>
    <input type="text" name="billing_state" class="form-control" value="<?php echo htmlspecialchars($memo['billing_state'] ?? ''); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Billing ZIP</label>
    <input type="text" name="billing_zip" class="form-control" value="<?php echo htmlspecialchars($memo['billing_zip'] ?? ''); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Billing Card</label>
    <input type="text" name="billing_card" class="form-control" value="">
  </div>
  <div class="mb-3">
    <label class="form-label">Profile Picture</label>
    <div class="dropzone" id="profilePicDropzone"></div>
  </div>
  <button class="btn btn-success" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
<script src="../../vendors/dropzone/dropzone-min.js"></script>
<script>
Dropzone.autoDiscover = false;
var dz = new Dropzone('#profilePicDropzone', {
  url: 'functions/save.php',
  paramName: 'profile_pic',
  maxFilesize: 0.4,
  acceptedFiles: 'image/jpeg,image/png',
  maxFiles: 1,
  autoProcessQueue: false,
  addRemoveLinks: true,
  accept: function(file, done) {
    var reader = new FileReader();
    reader.onload = function(e) {
      var img = new Image();
      img.onload = function() {
        if (img.width === 300 && img.height === 300) { done(); } else { done('Image must be 300x300'); }
      };
      img.src = e.target.result;
    };
    reader.readAsDataURL(file);
  },
  init: function() {
    var myDropzone = this;
    document.getElementById('userForm').addEventListener('submit', function(e) {
      e.preventDefault();
      e.stopPropagation();
      if (myDropzone.getQueuedFiles().length > 0) {
        myDropzone.processQueue();
      } else {
        e.target.submit();
      }
    });
    this.on('sending', function(file, xhr, formData) {
      var form = document.getElementById('userForm');
      Array.from(form.elements).forEach(function(el) {
        if (el.name && el.type !== 'file') {
          formData.append(el.name, el.value);
        }
      });
    });
    this.on('success', function(file, response) {
      window.location.href = 'index.php';
    });
  }
});
</script>
<?php require '../admin_footer.php'; ?>
