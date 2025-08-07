<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$first_name = $last_name = '';
$user_id = null;
$existing = null;
$btnClass = $id ? 'btn-phoenix-warning' : 'btn-phoenix-success';

if ($id) {
  require_permission('person','update');
  $stmt = $pdo->prepare('SELECT user_id, first_name, last_name FROM person WHERE id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $existing = $row;
    $user_id = $row['user_id'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
  }
} else {
  require_permission('person','create');
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

if ($user_id) {
  $userStmt = $pdo->prepare('SELECT id, username FROM users WHERE id = :id');
  $userStmt->execute([':id' => $user_id]);
  $userOptions = $userStmt->fetchAll(PDO::FETCH_KEY_PAIR);
} else {
  $userStmt = $pdo->query('SELECT u.id, u.username FROM users u LEFT JOIN person p ON u.id = p.user_id WHERE p.user_id IS NULL ORDER BY u.username');
  $userOptions = $userStmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $first_name = trim($_POST['first_name'] ?? '');
  $last_name = trim($_POST['last_name'] ?? '');
  $posted_user_id = $_POST['user_id'] !== '' ? (int)$_POST['user_id'] : null;
  if ($id) {
    $stmt = $pdo->prepare('UPDATE person SET first_name=:first_name, last_name=:last_name, user_updated=:uid WHERE id=:id');
    $stmt->execute([':first_name'=>$first_name, ':last_name'=>$last_name, ':uid'=>$this_user_id, ':id'=>$id]);
    admin_audit_log($pdo, $this_user_id, 'person', $id, 'UPDATE', json_encode($existing), json_encode(['user_id'=>$user_id,'first_name'=>$first_name,'last_name'=>$last_name]), 'Updated person');
  } else {
    $stmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, user_updated) VALUES (:user_id, :first_name, :last_name, :uid)');
    $stmt->execute([':user_id'=>$posted_user_id, ':first_name'=>$first_name, ':last_name'=>$last_name, ':uid'=>$this_user_id]);
    $id = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'person', $id, 'CREATE', null, json_encode(['user_id'=>$posted_user_id,'first_name'=>$first_name,'last_name'=>$last_name]), 'Created person');
  }
  header('Location: index.php');
  exit;
}
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Person</h2>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">User Account</label>
    <select name="user_id" class="form-select" <?= $user_id ? 'disabled' : ''; ?>>
      <option value="">-- None --</option>
      <?php foreach($userOptions as $uid => $uname): ?>
        <option value="<?= $uid; ?>" <?= (int)$uid === (int)$user_id ? 'selected' : ''; ?>><?= htmlspecialchars($uname); ?></option>
      <?php endforeach; ?>
    </select>
    <?php if($user_id): ?><input type="hidden" name="user_id" value="<?= $user_id; ?>"><?php endif; ?>
  </div>
  <div class="mb-3">
    <label class="form-label">First Name</label>
    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($first_name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Last Name</label>
    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($last_name); ?>" required>
  </div>
  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-phoenix-secondary">Cancel</a>
</form>
<?php require '../admin_footer.php'; ?>
